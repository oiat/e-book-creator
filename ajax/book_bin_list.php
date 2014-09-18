<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$html = '';
$q = "SELECT * FROM " . TBL_BOOKS . " WHERE uid='$session->uid' and bin='1'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$widget_id = $row['id'];
	$widget_title = strip_tags($row['title']);
	if(strlen($widget_title) > 17) {
		$widget_title = substr($widget_title,0,17) . '...';
	}
	if($widget_title == "") {
		$widget_title = 'Kein Titel';
	}
	$html .= '<div class="bin" rel="'.$widget_id.'">' . $widget_title . '</div>';
	}
echo $html;
?>