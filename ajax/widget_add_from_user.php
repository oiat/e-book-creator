<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$chapter_id = $_GET['chapter_id'];
$widget_id = $_GET['widget_id'];
$uid = $session->uid;
$book_owner = $session->getBookOwnerFromStructure($chapter_id);

$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS_USERS . " WHERE id='$widget_id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$widget_type = $row['type'];
$data['type'] = $widget_type;
$widget_content = $row['content'];
$widget_content2 = $row['content2'];
$widget_pic = $row['image'];

$q = "INSERT INTO " . TBL_BOOKS_WIDGETS . " SET chapter_id='$chapter_id', type='$widget_type', content='$widget_content', content2='$widget_content2', image='$widget_pic'";
$result = mysql_query($q, $database->connection);
$widget_id = mysql_insert_id();
$data['id'] = $widget_id;

if($widget_type == 'image') {
	$img_expl = explode('.', $widget_pic);
	$ext = end($img_expl);
	$image_new = $widget_id.'.'.$ext;
	if(is_file(CO_PATH.'/books/'.$uid.'/uploads/'.$widget_pic)) {
		if (!copy(CO_PATH.'/books/'.$uid.'/uploads/'.$widget_pic, CO_PATH.'/books/'.$book_owner.'/uploads/'.$image_new)) {
			echo "copy $file schlug fehl...\n";
		}
		$q = "UPDATE " . TBL_BOOKS_WIDGETS . " SET image='$image_new' WHERE id='$widget_id'";
		$result = mysql_query($q, $database->connection);
		$widget_pic = $image_new;
	}
}

ob_start();
	include(CO_PATH . "/templates/widgets/content/$widget_type.php");
	$data['html'] = ob_get_contents();
ob_end_clean();
echo json_encode($data);
?>