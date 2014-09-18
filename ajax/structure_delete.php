<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];
$book_owner = $session->getBookOwnerFromStructure($id);

$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$id'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$widget_id = $row['id'];
	$type = $row['type'];
	$image = $row['image'];
	if($type == 'image') {
		if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image)) {
			@unlink(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image);
		}
	}
	$qw = "DELETE FROM " . TBL_BOOKS_WIDGETS . " WHERE id='$widget_id'";
	$resultw = mysql_query($qw, $database->connection);
}

$qs = "SELECT type,content FROM " . TBL_BOOKS_STRUCTURE . " WHERE id='$id'";
$results = mysql_query($qs, $database->connection);
$rows = mysql_fetch_row($results);
$type = $rows[0];
$content = $rows[1];
if($type == 'cover') {
	if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$content)) {
		@unlink(CO_PATH.'/books/'.$book_owner.'/uploads/'.$content);
	}
}

$qs = "DELETE FROM " . TBL_BOOKS_STRUCTURE . " WHERE id='$id'";
$results = mysql_query($qs, $database->connection);

echo "true";
?>