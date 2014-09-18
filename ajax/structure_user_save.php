<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];
$title = $_GET['title'];
$uid = $session->uid;
$book_owner = $session->getBookOwnerFromStructure($id);

$q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$type = $row['type'];
$content = $row['content'];

$q = "INSERT INTO " . TBL_BOOKS_STRUCTURE_USERS . " SET uid='$uid', type='$type', title='$title', content='$content'";
$result = mysql_query($q, $database->connection);
$template_id = mysql_insert_id();

// copy cover
if($type == 'cover') {
	$image = $content;
	$img_expl = explode('.', $image);
	$ext = end($img_expl);
	$image_new = 't_c_'.$template_id.'.'.$ext;
	if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image)) {
		$upload_dir = CO_PATH . '/books/' . $uid . '/uploads';
		// check if user upload dir exists
		if(!is_dir($upload_dir))  {
			mkdir($upload_dir,0755,true);
		}
		if (!copy(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image, CO_PATH.'/books/'.$uid.'/uploads/'.$image_new)) {
			echo "copy $file schlug fehl...\n";
		}
		$q = "UPDATE " . TBL_BOOKS_STRUCTURE_USERS . " SET content='$image_new' WHERE id='$template_id'";
		$result = mysql_query($q, $database->connection);
	}
}

// then go through widgets
$qw = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$id' and bin='0'";
$resultw = mysql_query($qw, $database->connection);
while($row = mysql_fetch_array($resultw)) {
	
	$type = $row['type'];
	$content = $row['content'];
	$image = $row['image'];
	
	$q = "INSERT INTO " . TBL_BOOKS_WIDGETS_USERS . " SET structure_temp_id='$template_id', type='$type', title='$title', content='$content', image='$image'";
	$result = mysql_query($q, $database->connection);
	$widget_template_id = mysql_insert_id();
	
	// if type is image
	// update filemname and copy as vorlage
	if($type == 'image') {
		$img_expl = explode('.', $image);
		$ext = end($img_expl);
		$image_new = 't_'.$widget_template_id.'.'.$ext;
		if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image)) {
			$upload_dir = CO_PATH . '/books/' . $uid . '/uploads';
			// check if user upload dir exists
			if(!is_dir($upload_dir))  {
				mkdir($upload_dir,0755,true);
			}
			if (!copy(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image, CO_PATH.'/books/'.$uid.'/uploads/'.$image_new)) {
				echo "copy $file schlug fehl...\n";
			}
			$q = "UPDATE " . TBL_BOOKS_WIDGETS_USERS . " SET image='$image_new' WHERE id='$widget_template_id'";
			$result = mysql_query($q, $database->connection);
		}
	}
}
	
echo "true";
?>