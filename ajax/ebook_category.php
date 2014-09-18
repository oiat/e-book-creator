<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_POST['book_id'];
$cat_id = $_POST['cat_id'];
$status = $_POST['status'];
if($status == 1) {
	$q = "INSERT INTO books_to_categories SET book_id='$book_id', cat_id='$cat_id'";
} else {
	$q = "DELETE FROM books_to_categories WHERE book_id='$book_id' and cat_id='$cat_id'";
}
$result = mysql_query($q, $database->connection);

echo 'true';
?>