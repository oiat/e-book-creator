<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$uid = $session->uid;
$book_owner = $uid;
$author = $session->firstname . ' ' . $session->surname;
$title = 'Neues Buch';
$subtitle = '';
$book_image = '/img/placeholder_catalog_cover.png';

$upload_dir = CO_PATH . '/books/' . $session->uid . '/uploads';
// check if book folder exists
if(!is_dir($upload_dir))  {
	mkdir($upload_dir,0755,true);
}

$q = "INSERT INTO " . TBL_BOOKS . " SET uid='$uid', title='$title', author='$author'";
$result = mysql_query($q, $database->connection);
$id = mysql_insert_id();

/*$q = "INSERT INTO " . TBL_BOOKS_STRUCTURE . " SET book_id='$id', title='Erstes Kapitel'";
$result = mysql_query($q, $database->connection);*/

$book_dir = CO_PATH . '/books/' . $session->uid . '/' . $id;
// check if book folder exists
if(!is_dir($book_dir))  {
	mkdir($book_dir,0755,true);
}

$license = 0;
ob_start();
	include(CO_PATH . "/templates/widgets/book.php");
	$html = ob_get_contents();
ob_end_clean();

echo $html;

?>