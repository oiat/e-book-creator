<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_GET['book_id'];
$widget_type = $_GET['type'];
$widget_content = '';

$q = "INSERT INTO " . TBL_BOOKS_STRUCTURE . " SET book_id='$book_id', type='$widget_type'";
$result = mysql_query($q, $database->connection);
$widget_id = mysql_insert_id();
$data['id'] = $widget_id;

ob_start();
	include(CO_PATH . "/templates/widgets/structure/$widget_type.php");
	$data['html'] = ob_get_contents();
ob_end_clean();
echo json_encode($data);
?>