<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$html = '';
$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS_USERS . " WHERE uid='$session->uid'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$widget_id = $row['id'];
	$widget_title = $row['title'];
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
	
	$html .= '<div class="userwidget" rel="'.$widget_id.'">' . $icon . ' ' . $widget_title . '</div>';
	}
echo $html;
?>