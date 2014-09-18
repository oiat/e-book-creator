<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$book_id = $_GET['book_id'];
$structure_id = $_GET['widget_id'];
$uid = $session->uid;
$book_owner = $session->getBookOwnerFromBook($book_id);

$q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE_USERS . " WHERE id='$structure_id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$structure_type = $row['type'];
$data['type'] = $structure_type;
$structure_content = $row['content'];

$q = "INSERT INTO " . TBL_BOOKS_STRUCTURE . " SET book_id='$book_id', type='$structure_type', content='$structure_content'";
$result = mysql_query($q, $database->connection);
$chapter_id = mysql_insert_id();
$data['id'] = $chapter_id;

if($structure_type == 'cover') {
$image = $structure_content;
$img_expl = explode('.', $image);
$ext = end($img_expl);
	$image_new = 'c_'.$chapter_id.'.'.$ext;
	if(is_file(CO_PATH.'/books/'.$uid.'/uploads/'.$image)) {
		if (!copy(CO_PATH.'/books/'.$uid.'/uploads/'.$image, CO_PATH.'/books/'.$book_owner.'/uploads/'.$image_new)) {
			echo "copy $file schlug fehl...\n";
		}
		$q = "UPDATE " . TBL_BOOKS_STRUCTURE . " SET content='$image_new' WHERE id='$chapter_id'";
		$result = mysql_query($q, $database->connection);
	}
}


// then go through widgets
$qw = "SELECT * FROM " . TBL_BOOKS_WIDGETS_USERS . " WHERE structure_temp_id='$structure_id'";
$resultw = mysql_query($qw, $database->connection);
while($row = mysql_fetch_array($resultw)) {
	
	$widget_type = $row['type'];
	$data['type'] = $widget_type;
	$widget_content = $row['content'];
	$widget_pic = $row['image'];
	
	$q = "INSERT INTO " . TBL_BOOKS_WIDGETS . " SET chapter_id='$chapter_id', type='$widget_type', content='$widget_content', image='$widget_pic'";
	$result = mysql_query($q, $database->connection);
	$widget_id = mysql_insert_id();
	$data['id'] = $widget_id;
	
	if($widget_type == 'image') {
		$img_expl = explode('.', $widget_pic);
		$ext = end($img_expl);
		$image_new = $widget_id.'.'.$ext;
		if(is_file(CO_PATH.'/books/'.$uid.'/uploads/'.$widget_pic)) {
			if (!copy(CO_PATH.'/books/'.$uid.'/uploads/'.$widget_pic, CO_PATH.'/books/'.$book_owner.'/uploads/'.$image_new)) {
				echo "copy $file schlug fehl...\n";
			}
			$q = "UPDATE " . TBL_BOOKS_WIDGETS . " SET image='$image_new' WHERE id='$widget_id'";
			$result = mysql_query($q, $database->connection);
		}
	}
}

$widget_id = $chapter_id;
$widget_content = $structure_content;

ob_start();
	include(CO_PATH . "/templates/widgets/structure/$structure_type.php");
	$data['html'] = ob_get_contents();
ob_end_clean();
echo json_encode($data);
?>