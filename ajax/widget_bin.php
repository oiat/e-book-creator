<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];

$q = "UPDATE " . TBL_BOOKS_WIDGETS . " SET bin='1' WHERE id='$id'";
$result = mysql_query($q, $database->connection);

echo "true";
?>