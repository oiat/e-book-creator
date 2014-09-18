<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_POST['id'];
$title = $_POST['title'];
$author = $_POST['author'];
$edition = $_POST['edition'];
$q = "UPDATE " . TBL_BOOKS . " SET title='$title', author='$author', edition='$edition' WHERE id='$id'";
$result = mysql_query($q, $database->connection);

echo 'true';
?>