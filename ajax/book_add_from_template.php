<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['book_id'];
$uid = $session->uid;

$q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$title = $row['title'] . ' (von eigener Vorlage)';
$subtitle = $row['subtitle'];
$author = $row['author'];
$description = $row['description'];
$edition = $row['edition'];
$image = $row['image'];
$country = $row['country'];
$chapterlabels = $row['chapterlabels'];
$ebooks = $row['ebooks'];
$license = 0;
$created_date = $row['created_date'];
$edited_date = $row['edited_date'];

$q = "INSERT INTO " . TBL_BOOKS . " SET uid='$uid', title='$title', subtitle='$subtitle', author='$author', description='$description', edition='$edition', image='$image', country='$country', chapterlabels='$chapterlabels', ebooks='$ebooks', license='$license', created_date='$created_date', edited_date='$edited_date'";
$result = mysql_query($q, $database->connection);
$book_id = mysql_insert_id();

// create folder
$book_dir = CO_PATH . '/books/' . $uid . '/' . $book_id;
// check if book folder exists
if(!is_dir($book_dir))  {
	mkdir($book_dir,0755,true);
}

$image_new = '';

if($image != "") {
	$img_expl = explode('.', $image);
	$ext = end($img_expl);
	$image_new = 'cover_'.$book_id.'.'.$ext;
	if(is_file(CO_PATH.'/books/'.$session->uid.'/uploads/'.$image)) {
		if (!copy(CO_PATH.'/books/'.$session->uid.'/uploads/'.$image, CO_PATH.'/books/'.$session->uid.'/uploads/'.$image_new)) {
			echo "copy $file schlug fehl...\n";
		}
		$q = "UPDATE " . TBL_BOOKS . " SET image='$image_new' WHERE id='$book_id'";
		$result = mysql_query($q, $database->connection);
	}
}

$qs = "SELECT * FROM " . TBL_BOOKS_STRUCTURE . " WHERE book_id='$id' and bin='0'";
$results = mysql_query($qs, $database->connection);
while($rows = mysql_fetch_array($results)) {
	$structure_id = $rows['id'];
	$types = $rows['type'];
	$contents = $rows['content'];
	
	$q = "INSERT INTO " . TBL_BOOKS_STRUCTURE . " SET book_id='$book_id', type='$types', content='$contents'";
	$result = mysql_query($q, $database->connection);
	$template_id = mysql_insert_id();
	
	if($types == 'cover') {
	$image = $contents;
	$img_expl = explode('.', $image);
	$ext = end($img_expl);
		$image_new = 'c_'.$template_id.'.'.$ext;
		if(is_file(CO_PATH.'/books/'.$uid.'/uploads/'.$image)) {
			if (!copy(CO_PATH.'/books/'.$uid.'/uploads/'.$image, CO_PATH.'/books/'.$uid.'/uploads/'.$image_new)) {
				echo "copy $file schlug fehl...\n";
			}
			$q = "UPDATE " . TBL_BOOKS_STRUCTURE . " SET content='$image_new' WHERE id='$template_id'";
			$result = mysql_query($q, $database->connection);
		}
	}

	// then go through widgets
	$qw = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$structure_id'";
	$resultw = mysql_query($qw, $database->connection);
	while($row = mysql_fetch_array($resultw)) {
		
		$type = $row['type'];
		$content = $row['content'];
		$image = $row['image'];
		
		$q = "INSERT INTO " . TBL_BOOKS_WIDGETS . " SET chapter_id='$template_id', type='$type', title='$title', content='$content', image='$image'";
		$result = mysql_query($q, $database->connection);
		$widget_template_id = mysql_insert_id();
		
		// if type is image
		// update filemname and copy as vorlage
		if($type == 'image') {
			$img_expl = explode('.', $image);
			$ext = end($img_expl);
			$image_new = $widget_template_id.'.'.$ext;
			if(is_file(CO_PATH.'/books/'.$session->uid.'/uploads/'.$image)) {
				if (!copy(CO_PATH.'/books/'.$session->uid.'/uploads/'.$image, CO_PATH.'/books/'.$session->uid.'/uploads/'.$image_new)) {
					echo "copy $file schlug fehl...\n";
				}
				$q = "UPDATE " . TBL_BOOKS_WIDGETS . " SET image='$image_new' WHERE id='$widget_template_id'";
				$result = mysql_query($q, $database->connection);
			}
		}
	}
}
$id = $book_id;
$book_owner = $uid;
$book_image = '/img/placeholder_catalog_cover.png';
if($image_new != '') {
	$time = time();
	$book_image = '/books/' . $uid. '/uploads/cover_'.$book_id.'.jpg?'.$time;
}

ob_start();
	include(CO_PATH . "/templates/widgets/book.php");
	$html = ob_get_contents();
ob_end_clean();

echo $html;

?>