<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$chapter_id = $_GET['chapter_id'];
$html = '';
$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$chapter_id' and bin='1'";
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
		case 'textarea':
			$icon = '<i class="fa fa-font"></i>';
		break;
		case 'image':
			$icon = '<i class="fa fa-file-image-o"></i>';
			$widget_content = 'Bild / Grafik';
		break;
		case 'video':
			$icon = '<i class="fa fa-file-video-o"></i>';
		break;
		case 'quiz':
			$icon = '<i class="fa fa-check-square-o"></i>';
		break;
		case 'headline1':
			$icon = '<i class="fa fa-header"></i>';
		break;
		case 'headline2':
			$icon = '<i class="fa fa-header"></i>';
		break;
	}
	$html .= '<div class="bin" rel="'.$widget_id.'">' . $icon . ' ' . $widget_content . '</div>';
	}
echo $html;
?>