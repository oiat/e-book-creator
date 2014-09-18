<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_POST['id'];
$owner_id = $session->uid;
$sharer_id = 0;
$sharer_email = $_POST['email'];
$message = $_POST['message'];

// first check if user has an account
$q = "SELECT uid FROM users WHERE email='$sharer_email'";
$result = mysql_query($q, $database->connection);
if(mysql_fetch_row($result) < 1) {
	$q = "INSERT INTO books_shared SET book_id='$book_id', owner_id='$owner_id', sharer_email='$sharer_email'";
	$result = mysql_query($q, $database->connection);
	$mailer->sendInvitationNew($session->firstname . ' ' . $session->surname, $session->useremail,$sharer_email, $message);
} else {
	$sharer_id = mysql_result($result,0);
	$q = "INSERT INTO books_shared SET book_id='$book_id', owner_id='$owner_id', sharer_id='$sharer_id'";
	$result = mysql_query($q, $database->connection);
	$mailer->sendInvitation($session->firstname . ' ' . $session->surname, $session->useremail,$sharer_email, $message);
}
echo "true";
?>