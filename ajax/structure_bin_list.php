<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_GET['book_id'];
$html = '';
$q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE . " WHERE book_id='$book_id' and bin='1'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$widget_id = $row['id'];
	$widget_content = strip_tags($row['content']);
	if(strlen($widget_content) > 17) {
		$widget_content = substr($widget_content,0,17) . '...';
	}
	if($widget_content == "") {
		$widget_content = 'Kein Inhalt';
	}
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
	$html .= '<div class="bin" rel="'.$widget_id.'">' . $widget_name . '</div>';
	}
echo $html;
?>