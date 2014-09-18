<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$html = '';
$q = "SELECT * FROM " . TBL_BOOKS_USERS . " WHERE uid='$session->uid'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$widget_id = $row['id'];
	$widget_title = strip_tags($row['temp_title']);
	if(strlen($widget_title) > 17) {
		$widget_title = substr($widget_title,0,17) . '...';
	}
	if($widget_title == "") {
		$widget_title = 'Kein Titel';
	}
	$html .= '<div class="userwidget" rel="'.$widget_id.'">' . $widget_title . '</div>';
	}
echo $html;
?>