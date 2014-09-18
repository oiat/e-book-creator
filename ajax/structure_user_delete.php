<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];

// first do the widgets
$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS_USERS . " WHERE structure_temp_id='$id'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$widget_id = $row['id'];
	if($row['type'] == 'image') {
		if(is_file(CO_PATH.'/books/'.$session->uid.'/uploads/'.$row['image'])) {
			@unlink(CO_PATH.'/books/'.$session->uid.'/uploads/'.$row['image']);
		}
	}
	
	$qd = "DELETE FROM " . TBL_BOOKS_WIDGETS_USERS . " WHERE id='$widget_id'";
	$resultd = mysql_query($qd, $database->connection);
}

// structure
$q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE_USERS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$structure_type = $row['type'];
$structure_content = $row['content'];
if($structure_type == 'cover') {
	if(is_file(CO_PATH.'/books/'.$session->uid.'/uploads/'.$row['content'])) {
		@unlink(CO_PATH.'/books/'.$session->uid.'/uploads/'.$row['content']);
	}
}

// then delete the structure
$q = "DELETE FROM " . TBL_BOOKS_STRUCTURE_USERS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);

echo "true";
?>