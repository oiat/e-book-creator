<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

$id = $_GET['id'];
$temp_title = mysql_real_escape_string($_GET['title']);
$uid = $session->uid;

$q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
$row = mysql_fetch_array($result);
$book_owner = $row['uid'];
$title = $row['title'];
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

$q = "INSERT INTO " . TBL_BOOKS_USERS . " SET uid='$uid', title='$title', subtitle='$subtitle', author='$author', description='$description', edition='$edition', image='$image', country='$country', chapterlabels='$chapterlabels', ebooks='$ebooks', license='$license', created_date='$created_date', edited_date='$edited_date', temp_title='$temp_title'";
$result = mysql_query($q, $database->connection);
$book_id = mysql_insert_id();

if($image != "") {
	$img_expl = explode('.', $image);
	$ext = end($img_expl);
	$image_new = 't_cover_'.$book_id.'.'.$ext;
	if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image)) {
		if (!copy(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image, CO_PATH.'/books/'.$uid.'/uploads/'.$image_new)) {
			echo "copy $file schlug fehl...\n";
		}
		$q = "UPDATE " . TBL_BOOKS_USERS . " SET image='$image_new' WHERE id='$book_id'";
		$result = mysql_query($q, $database->connection);
	}
}

$qs = "SELECT * FROM " . TBL_BOOKS_STRUCTURE . " WHERE book_id='$id' and bin='0'";
$results = mysql_query($qs, $database->connection);
while($rows = mysql_fetch_array($results)) {
	$structure_id = $rows['id'];
	$types = $rows['type'];
	$contents = $rows['content'];
	
	$q = "INSERT INTO " . TBL_BOOKS_STRUCTURE_USERS . " SET book_temp_id='$book_id', type='$types', content='$contents'";
	$result = mysql_query($q, $database->connection);
	$template_id = mysql_insert_id();
	
	// copy cover
	if($types == 'cover') {
		$image = $contents;
		$img_expl = explode('.', $image);
		$ext = end($img_expl);
		$image_new = 't_c_'.$template_id.'.'.$ext;
		if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image)) {
			$upload_dir = CO_PATH . '/books/' . $uid . '/uploads';
			// check if user upload dir exists
			if(!is_dir($upload_dir))  {
				mkdir($upload_dir,0755,true);
			}
			if (!copy(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image, CO_PATH.'/books/'.$uid.'/uploads/'.$image_new)) {
				echo "copy $file schlug fehl...\n";
			}
			$q = "UPDATE " . TBL_BOOKS_STRUCTURE_USERS . " SET content='$image_new' WHERE id='$template_id'";
			$result = mysql_query($q, $database->connection);
		}
	}
	
	// then go through widgets
	$qw = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$structure_id' and bin='0'";
	$resultw = mysql_query($qw, $database->connection);
	while($row = mysql_fetch_array($resultw)) {
		
		$type = $row['type'];
		$content = $row['content'];
		$image = $row['image'];
		
		$q = "INSERT INTO " . TBL_BOOKS_WIDGETS_USERS . " SET structure_temp_id='$template_id', type='$type', title='$title', content='$content', image='$image'";
		$result = mysql_query($q, $database->connection);
		$widget_template_id = mysql_insert_id();
		
		// if type is image
		// update filemname and copy as vorlage
		if($type == 'image') {
			$img_expl = explode('.', $image);
			$ext = end($img_expl);
			$image_new = 't_'.$widget_template_id.'.'.$ext;
			if(is_file(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image)) {
				if (!copy(CO_PATH.'/books/'.$book_owner.'/uploads/'.$image, CO_PATH.'/books/'.$uid.'/uploads/'.$image_new)) {
					echo "copy $file schlug fehl...\n";
				}
				$q = "UPDATE " . TBL_BOOKS_WIDGETS_USERS . " SET image='$image_new' WHERE id='$widget_template_id'";
				$result = mysql_query($q, $database->connection);
			}
		}
	}
}

echo "true";
?>