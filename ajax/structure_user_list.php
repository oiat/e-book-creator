<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$html = '';
$q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE_USERS . " WHERE uid='$session->uid'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$widget_id = $row['id'];
	$widget_title = strip_tags($row['title']);
	$widget_type = $row['type'];
	switch($widget_type) {
		case 'chapter':
			$widget_name = 'Kapitel';
		break;
		case 'cover':
			$widget_name = 'Deckblatt';
		break;
		case 'toc':
			$widget_name = 'Inhaltsverzeichnis';
		break;
		case 'introduction':
			$widget_name = 'Einleitung';
		break;
		case 'lof':
			$widget_name = 'Bilderverzeichnis';
		break;
		case 'license':
			$widget_name = 'Lizenz';
		break;
	}
	
	if($widget_title != "") {
		$widget_name = $widget_title;
	}
	
	$html .= '<div class="userwidget" rel="'.$widget_id.'">' . $widget_name . '</div>';
	}
echo $html;
?>