<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];
$title = $_GET['title'];
$uid = $session->uid;
$book_owner = $session->getBookOwnerFromWidget($id);

$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$type = $row['type'];
$content = $row['content'];
$content2 = $row['content2'];
$image = $row['image'];

$q = "INSERT INTO " . TBL_BOOKS_WIDGETS_USERS . " SET uid='$uid', type='$type', title='$title', content='$content', content2='$content2', image='$image'";
echo $q;
$result = mysql_query($q, $database->connection);
$template_id = mysql_insert_id();

// if type is image
// update filemname and copy as vorlage
if($type == 'image') {
	$img_expl = explode('.', $image);
	$ext = end($img_expl);
	$image_new = 't_'.$template_id.'.'.$ext;
	if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image)) {
		$upload_dir = CO_PATH . '/books/' . $uid . '/uploads';
		// check if user upload dir exists
		if(!is_dir($upload_dir))  {
			mkdir($upload_dir,0755,true);
		}
		if (!copy(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image, CO_PATH.'/books/'.$uid.'/uploads/'.$image_new)) {
			echo "copy $file schlug fehl...\n";
		}
		$q = "UPDATE " . TBL_BOOKS_WIDGETS_USERS . " SET image='$image_new' WHERE id='$template_id'";
		$result = mysql_query($q, $database->connection);
	}
}
	
echo "true";
?>