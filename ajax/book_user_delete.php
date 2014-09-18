<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];

// structures loop
$qs = "SELECT * FROM " . TBL_BOOKS_STRUCTURE_USERS . " WHERE book_temp_id='$id'";
$results = mysql_query($qs, $database->connection);
while($rows = mysql_fetch_array($results)) {
	$structure_id = $rows['id'];
	// delete structure
	$type = $rows['type'];
	$content = $rows['content'];
	if($type == 'cover') {
		if(is_file(CO_PATH.'/books/'.$session->uid.'/uploads/'.$content)) {
			@unlink(CO_PATH.'/books/'.$session->uid.'/uploads/'.$content);
		}
	}
	
	$qd = "DELETE FROM " . TBL_BOOKS_STRUCTURE_USERS . " WHERE id='$structure_id'";
	$resultd = mysql_query($qd, $database->connection);
	
	// widgets
	$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS_USERS . " WHERE structure_temp_id='$structure_id'";
	$result = mysql_query($q, $database->connection);
	while($row = mysql_fetch_array($result)) {
		$widget_id = $row['id'];
		$type = $row['type'];
		$image = $row['image'];
		if($type == 'image') {
			if(is_file(CO_PATH.'/books/'.$session->uid.'/uploads/'.$image)) {
				@unlink(CO_PATH.'/books/'.$session->uid.'/uploads/'.$image);
			}
		}
		$qw = "DELETE FROM " . TBL_BOOKS_WIDGETS_USERS . " WHERE id='$widget_id'";
		$resultw = mysql_query($qw, $database->connection);
	}
}

//
function emptyDirectory($dirname,$self_delete=false) {
   if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            @unlink($dirname."/".$file);
         else
            emptyDirectory($dirname.'/'.$file,true);    
      }
   }
   closedir($dir_handle);
   if ($self_delete){
        @rmdir($dirname);
   }   
   return true;
}

$book_dir = CO_PATH . '/books/' . $session->uid . '/' . $id;
if(is_dir($book_dir)) {
	emptyDirectory($book_dir,true);
}

// check for a cover
if(is_file(CO_PATH.'/books/'.$session->uid.'/uploads/t_cover_'.$id.'.jpg')) {
	@unlink(CO_PATH.'/books/'.$session->uid.'/uploads/t_cover_'.$id.'.jpg');
}

$qs = "DELETE FROM " . TBL_BOOKS_USERS . " WHERE id='$id'";
$results = mysql_query($qs, $database->connection);

echo "true";
?>