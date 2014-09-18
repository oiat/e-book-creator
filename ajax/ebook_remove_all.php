<?php
include("../includes/session.php");
include("../includes/HTML_To_Markdown.php");
if(!$session->logged_in){
header("location:/");
exit();
}

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

$id = $_POST['id'];

// book details
$q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$book_id = $row['id'];
	$book_owner = $row['uid'];
}

$book_dir = CO_PATH . '/books/' . $book_owner . '/' . $book_id;

emptyDirectory($book_dir);

$q = "UPDATE " . TBL_BOOKS . " SET ebooks='0' WHERE id='$book_id'";
$result = mysql_query($q, $database->connection);
if($result) {
	echo 'true';
}
?>