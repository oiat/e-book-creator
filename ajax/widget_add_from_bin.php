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

$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE id='$widget_id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$data['id'] = $widget_id;
$widget_type = $row['type'];
$data['type'] = $widget_type;
$widget_content = $row['content'];
$widget_content2 = $row['content2'];
$widget_pic = $row['image'];
ob_start();
	include(CO_PATH . "/templates/widgets/content/$widget_type.php");
	$data['html'] = ob_get_contents();
ob_end_clean();

$q = "UPDATE " . TBL_BOOKS_WIDGETS . " SET chapter_id='$chapter_id', bin='0' WHERE id='$widget_id'";
$result = mysql_query($q, $database->connection);

echo json_encode($data);
?>