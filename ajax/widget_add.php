<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$chapter_id = $_GET['chapter_id'];
$widget_type = $_GET['type'];
$widget_content = '';
$widget_content2 = '';
$widget_pic = '';

$q = "INSERT INTO " . TBL_BOOKS_WIDGETS . " SET chapter_id='$chapter_id', type='$widget_type'";
$result = mysql_query($q, $database->connection);
$widget_id = mysql_insert_id();
$data['id'] = $widget_id;

ob_start();
	include(CO_PATH . "/templates/widgets/content/$widget_type.php");
	$data['html'] = ob_get_contents();
ob_end_clean();
echo json_encode($data);
?>