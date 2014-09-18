<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_GET['book_id'];
$uid = $session->uid;

$q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$book_id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$title = $row['title'];
$subtitle = $row['subtitle'];
$license = $row['license'];

$q = "UPDATE " . TBL_BOOKS . " SET bin='0' WHERE id='$book_id'";
$result = mysql_query($q, $database->connection);

$id = $book_id;
$book_owner = $uid;
$book_image = '/img/placeholder_catalog_cover.png';
if(is_file(CO_PATH.'/books/'.$uid.'/uploads/cover_'.$book_id.'.jpg')) {
	$time = time();
	$book_image = '/books/' . $uid. '/uploads/cover_'.$book_id.'.jpg?'.$time;
}

ob_start();
	include(CO_PATH . "/templates/widgets/book.php");
	$html = ob_get_contents();
ob_end_clean();

echo $html;
?>