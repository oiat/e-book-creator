<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_POST['book_id'];
$target_id = $_POST['target_id'];
$status = $_POST['status'];
if($status == 1) {
	$q = "INSERT INTO books_to_targets SET book_id='$book_id', target_id='$target_id'";
} else {
	$q = "DELETE FROM books_to_targets WHERE book_id='$book_id' and target_id='$target_id'";
}
$result = mysql_query($q, $database->connection);
echo 'true';
?>