<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$share_id = $_POST['share_id'];
$q = "DELETE FROM books_shared WHERE id='$share_id'";
$result = mysql_query($q, $database->connection);

echo "true";
?>