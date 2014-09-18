<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_GET['id'];
$html = '';
$q = "SELECT * FROM books_shared WHERE book_id='$book_id'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$id = $row['id'];
	$sharer_id = $row['sharer_id'];
	$sharer_email = $row['sharer_email'];
	if($sharer_email == "" && $sharer_id != 0) {
		$qu = "SELECT email FROM users WHERE uid='$sharer_id'";
		$resultu = mysql_query($qu, $database->connection);
		$sharer_email = mysql_result($resultu,0);
	}
	$html .= '<p><span>' . $sharer_email . '</span> <i class="fa fa-times fa-border fa-fw removeShare" rel="' . $id . '"></i></p>';
}
echo $html;
?>