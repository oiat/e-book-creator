<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];

$q = "SELECT type,image FROM " . TBL_BOOKS_WIDGETS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_row($result);
if($row[0] == 'image') {
	$book_owner = $session->getBookOwnerFromWidget($id);
	if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$row[1])) {
		@unlink(CO_PATH.'/books/'.$book_owner.'/uploads/'.$row[1]);
	}
}

$q = "DELETE FROM " . TBL_BOOKS_WIDGETS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);

echo "true";
?>