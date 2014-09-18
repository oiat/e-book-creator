<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_POST['id'];
$field = $_POST['field'];
$value = mysql_real_escape_string($_POST['value']);

$q = "UPDATE " . TBL_BOOKS . " SET $field='$value' WHERE id='$id'";
$result = mysql_query($q, $database->connection);

echo 'true';
?>