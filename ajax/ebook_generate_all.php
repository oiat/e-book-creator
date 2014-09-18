<?php
include("../includes/session.php");
include("../includes/HTML_To_Markdown.php");
if(!$session->logged_in){
header("location:/");
exit();
}


function youtube_id_from_url($url) {
    $pattern = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';
	//$ytid = preg_replace($video_pattern, '$1', $url);
	$result = preg_match($pattern, $url, $matches);
    if (false !== (bool)$result) {
        return $matches[1];
    }
	return false;
}

function romanNumerals($num) {
    $n = intval($num);
    $res = '';
    /*** roman_numerals array  ***/
    $roman_numerals = array(
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1);

    foreach ($roman_numerals as $roman => $number){
        /*** divide to get  matches ***/
        $matches = intval($n / $number);
        /*** assign the roman char * $matches ***/
        $res .= str_repeat($roman, $matches);
        /*** substract from the number ***/
        $n = $n % $number;
    }
    /*** return the res ***/
    return $res;
}

function num_to_letter($num, $uppercase = TRUE) {
	$num -= 1;
	$letter = chr(($num % 26) + 97);
	$letter .= (floor($num/26) > 0) ? str_repeat($letter, floor($num/26)) : '';
	return ($uppercase ? strtoupper($letter) : $letter);
}

function emptyDirectory($dirname,$self_delete=false) {
   if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            @unlink($dirname."/".$file);
         else
            emptyDirectory($dirname.'/'.$file,true);    
      }
   }
   closedir($dir_handle);
   if ($self_delete){
        @rmdir($dirname);
   }   
   return true;
}

$id = $_POST['id'];

// if license is set
if(isset($_POST['publish'])) {
	$pub = $_POST['publish'];
	$q = "UPDATE " . TBL_BOOKS . " SET license='$pub' WHERE id='$id'";
	$result = mysql_query($q, $database->connection);
}

// book details
$q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$id'";
$result = mysql_query($q, $database->connection);
while($row = mysql_fetch_array($result)) {
	$book_id = $row['id'];
	$book_owner = $row['uid'];
	$book_title = $row['title'];
	$book_subtitle = $row['subtitle'];
	$book_author = $row['author'];
	$book_edition = $row['edition'];
	$book_license = $row['license'];
	$book_labels = "            labels:         ~\n";
	$book_chapterlabels = $row['chapterlabels'];
	if($book_chapterlabels > 0) {
		//$book_labels = "            labels:         ['chapter']\n";
	}
}

$book_dir = CO_PATH . '/books/' . $book_owner . '/' . $book_id;

emptyDirectory($book_dir);
mkdir($book_dir.'/Contents/images',0755,true);
mkdir($book_dir.'/Output');
mkdir($book_dir.'/Resources/Templates/ebook',0755,true);
mkdir($book_dir.'/Resources/Templates/kindle',0755,true);
mkdir($book_dir.'/Resources/Templates/print');
mkdir($book_dir.'/Resources/Templates/website');
copy(CO_PATH . '/templates/book/Skeleton/Contents/images/video.jpg',$book_dir.'/Contents/images/video.jpg');
copy(CO_PATH . '/templates/book/Skeleton/Contents/images/quiz.jpg',$book_dir.'/Contents/images/quiz.jpg');
copy(CO_PATH . '/templates/book/Skeleton/Contents/images/cc-by-sa.png',$book_dir.'/Contents/images/cc-by-sa.png');
copy(CO_PATH . '/templates/book/Skeleton/Contents/images/public-domain.png',$book_dir.'/Contents/images/public-domain.png');
copy(CO_PATH . '/templates/book/Skeleton/Resources/Templates/ebook/cover.html',$book_dir.'/Resources/Templates/ebook/cover.html');
copy(CO_PATH . '/templates/book/Skeleton/Resources/Templates/ebook/cover.twig',$book_dir.'/Resources/Templates/ebook/cover.twig');
copy(CO_PATH . '/templates/book/Skeleton/Resources/Templates/ebook/cover.html',$book_dir.'/Resources/Templates/kindle/cover.html');
copy(CO_PATH . '/templates/book/Skeleton/Resources/Templates/ebook/cover.twig',$book_dir.'/Resources/Templates/kindle/cover.twig');
copy(CO_PATH . '/templates/book/Skeleton/Resources/Templates/print/cover.twig',$book_dir.'/Resources/Templates/print/cover.twig');
copy(CO_PATH . '/templates/book/Skeleton/Resources/Templates/website/index.twig',$book_dir.'/Resources/Templates/website/index.twig');
copy(CO_PATH . '/templates/book/Skeleton/Resources/Templates/style.css',$book_dir.'/Resources/Templates/style.css');

$book_contents = '';
$q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE . " WHERE book_id='$book_id' and bin='0' ORDER BY sort ASC";
$result = mysql_query($q, $database->connection);
$i = 1;
$introduction = 1;
while($row = mysql_fetch_array($result)) {
	if($row['type'] == 'chapter') {
		$counter = $i;
		$headline1_counter = 0;
		
		if($book_chapterlabels == 2) {
			$counter = romanNumerals($i);
		}
		if($book_chapterlabels == 3) {
			$counter = num_to_letter($i);
		}
		$book_contents .= "        - { element: chapter, number: $counter, content: chapter$i.md }\n";
		$t = "";
		if($book_chapterlabels > 0) {
			$t = $counter . '. ';
		}
		$title = $row['content'];
		if($title == '') {
			$title = $t.'Kapitel';
		} else {
			$title = $t.$row['content'];
		}
		$content = "<h1>$title</h1>\n\n";
		$id = $row['id'];
		$q_w = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$id' and bin='0' ORDER BY sort ASC";
		$result_w = mysql_query($q_w, $database->connection);
		while($row_w = mysql_fetch_array($result_w)) {
			$widget_content = '';
			switch($row_w['type']) {
				case 'headline1':
					$h1_c = "";
					if($book_chapterlabels > 0) {
						$h1 = $headline1_counter+1;
						$h1_c = $counter.".".$h1." ";
					}
					$widget_content = "\n<h2>".$h1_c.$row_w['content']."</h2>\n";
					$headline1_counter++;
					$headline2_counter = 1;
				break;
				case 'headline2':
					$h2_c = "";
					if($book_chapterlabels > 0) {
						$h2 = $headline1_counter . "." .$headline2_counter . " ";
						$h2_c = $counter.".".$h2." ";
					}
					$widget_content = "\n<h3>".$h2_c.$row_w['content']."</h3>\n";
					$headline2_counter++;
				break;
				case 'textarea':
					$widget_content = $row_w['content'];
				break;
				case 'image':
					$img = $row_w['image'];
					$alt = $row_w['content'];
					if($img != "" && is_file(CO_PATH . '/books/' . $book_owner. '/uploads/' . $img) )
					if(copy(CO_PATH . '/books/' . $book_owner. '/uploads/' . $img, $book_dir.'/Contents/images/' . $img)) {
						$img_url = '<p><img src="' . $img . '" alt="' . $alt . '" /></p>';
						$widget_content = $img_url;
					} else {
						echo "Canot Copy file";
					}
				break;
				case 'pagebreak':
					$widget_content = "{pagebreak}<br />";
				break;
				case 'video':
					$is_youtube = youtube_id_from_url($row_w['content']);
					if($is_youtube) {
						copy('http://img.youtube.com/vi/'.$is_youtube.'/0.jpg', $book_dir.'/Contents/images/' . $is_youtube . '.jpg');
						$widget_content = '<img src="' . $is_youtube . '.jpg" alt="*" /><br />';
					} else {
						$widget_content = '<img src="video.jpg" alt="*" /><br />';
					}
					$widget_content .= '<a href="'.$row_w['content'].'">'.$row_w['content'].'</a><br />';
					if($row_w['content2'] != '') {
						$widget_content .= '<em class="caption">'.$row_w['content2'].'</em>' . "<br />";
					}
					$widget_content .= '<p>&nbsp;</p>';
				break;
				case 'quiz':
					$widget_content = '<br /><p><img src="quiz.jpg" alt="*" /></p>';
					$widget_content .= '<p><a href="'.$row_w['content'].'">'.$row_w['content'].'</a></p>';
					$widget_content .= '<p>&nbsp;</p>';
				break;
			}
			$content .= $widget_content;
		}
		
		$content = new HTML_To_Markdown($content);
		//echo $content;
		$file = CO_PATH . "/books/$book_owner/$book_id/Contents/chapter$i.md";
		$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
		fwrite($handle, $content);
		$i++;
	}
	if($row['type'] == 'introduction') {
		$title = $row['content'];
		if($title == '') {
			$title = 'Einleitung';
		}
		$book_contents .= "        - { element: introduction, content: introduction$introduction.md, title: $title }\n";
		$content = "";
		$id = $row['id'];
		$q_w = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$id' and bin='0' ORDER BY sort ASC";
		$result_w = mysql_query($q_w, $database->connection);
		while($row_w = mysql_fetch_array($result_w)) {
			$widget_content = '';
			switch($row_w['type']) {
				case 'headline1':
					$widget_content = "\n<h2>".$row_w['content']."</h2>\n";
				break;
				case 'headline2':
					$widget_content = "\n<h3>".$row_w['content']."</h3>\n";
				break;
				case 'textarea':
					$widget_content = $row_w['content'];
				break;
				case 'image':
					$img = $row_w['image'];
					$alt = $row_w['content'];
					if(copy(CO_PATH . '/books/' . $book_owner. '/uploads/' . $img, $book_dir.'/Contents/images/' . $img)) {
						$img_url = '<p><img src="' . $img . '" alt="' . $alt . '" /></p>';
						$widget_content = $img_url;
					} else {
						echo "Canot Copy file";
					}
				break;
				case 'pagebreak':
					$widget_content = "{pagebreak}<br />";
				break;
				case 'video':
					$is_youtube = youtube_id_from_url($row_w['content']);
					if($is_youtube) {
						copy('http://img.youtube.com/vi/'.$is_youtube.'/0.jpg', $book_dir.'/Contents/images/' . $is_youtube . '.jpg');
						$widget_content = '<img src="' . $is_youtube . '.jpg" alt="*" /><br />';
					} else {
						$widget_content = '<img src="video.jpg" alt="*" /><br />';
					}	
					$widget_content .= '<a href="'.$row_w['content'].'">'.$row_w['content'].'</a><br />';
					if($row_w['content2'] != '') {
					$widget_content .= '<em class="caption">'.$row_w['content2'].'</em>' . "<br />";
					}
					$widget_content .= '<p>&nbsp;</p>';
				break;
				case 'quiz':
					$widget_content = '<br /><p><img src="quiz.jpg" alt="*" /></p>';
					$widget_content .= '<p><a href="'.$row_w['content'].'">'.$row_w['content'].'</a></p>';
					$widget_content .= '<p>&nbsp;</p>';
				break;
			}
			$content .= $widget_content;
		}
		$content = new HTML_To_Markdown($content);
		$file = CO_PATH . "/books/$book_owner/$book_id/Contents/introduction$introduction.md";
		$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
		fwrite($handle, $content);
		$introduction++;
	}
	if($row['type'] == 'toc') {
		$title = $row['content'];
		if($title == '') {
			$title = 'Inhaltsverzeichnis';
		}
		$book_contents .= "        - { element: toc, title: $title  }\n";
	}
	if($row['type'] == 'cover') {
		$img = $row['content'];
		if($img != "" && is_file(CO_PATH . '/books/' . $book_owner . '/uploads/' . $img)) {
		copy(CO_PATH . '/books/' . $book_owner . '/uploads/' . $img, $book_dir.'/Resources/Templates/ebook/cover.jpg');
		copy(CO_PATH . '/books/' . $book_owner . '/uploads/' . $img, $book_dir.'/Resources/Templates/kindle/cover.jpg');
		// then convert to pdf
		include('../includes/prince.php');
		$prince = new Prince('/usr/bin/prince');
		$prince->setHTML(1);
		$prince->addStyleSheet(CO_PATH . '/default_styles.css');
		$prince->setLog(CO_PATH . "/log.txt");
		$xmlPath = $book_dir.'/Resources/Templates/ebook/cover.html';
		$pdfPath = $book_dir.'/Resources/Templates/print/cover.pdf';
		$prince->convert_file_to_file($xmlPath, $pdfPath);
			/*$errorMessages = array();
			if($prince->convert_file_to_file($xmlPath, $pdfPath, $errorMessages)) {
				echo "true";
			} else {
				echo 'false';
			}
			print_r($errorMessages);*/
		}
		
		$book_contents .= "        - { element: cover }\n";
	}
	if($row['type'] == 'lof') {
		$title = $row['content'];
		if($title == '') {
			$title = 'Bilderverzeichnis';
		}
		$book_contents .= "        - { element: lof, title: $title  }\n";
	}
	if($row['type'] == 'license') {
		$title = $row['content'];
		if($title == '') {
			$title = 'Lizenzbestimmungen';
		}
		switch($book_license) {
			case 0:
				$license_file = 'license-privat.md';
			break;
			case 1:
				$license_file = 'license-ccbysa.md';
			break;
			case 2:
				$license_file = 'license-cc0.md';
			break;
		}
		copy(CO_PATH . '/templates/book/Skeleton/Contents/' . $license_file,$book_dir.'/Contents/' . $license_file);
		$book_contents .= "        - { element: license, title: $title, content: $license_file  }\n";
	}
}

// write config.yml
ob_start();
	include(CO_PATH . '/templates/book/config.php');
	$text = ob_get_contents();
ob_end_clean();

// now update config.yml
$file = CO_PATH . '/books/' . $book_owner . '/' . $book_id . '/config.yml';
$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
fwrite($handle, $text);

// publish!
// pdf
exec('php ../easybook/book publish --dir="'.CO_PATH.'/books/' . $book_owner . '/" ' . $book_id. ' print');
//sleep(1);
// html
exec('php ../easybook/book publish --dir="'.CO_PATH.'/books/' . $book_owner . '/" ' . $book_id. ' website');
//sleep(1);
// epub
exec('php ../easybook/book publish --dir="'.CO_PATH.'/books/' . $book_owner . '/" ' . $book_id. ' ebook');
//sleep(1);
// mobi
exec('php ../easybook/book publish --dir="'.CO_PATH.'/books/' . $book_owner . '/" ' . $book_id. ' kindle');
//sleep(1);

$q = "UPDATE " . TBL_BOOKS . " SET ebooks='1' WHERE id='$book_id'";
$result = mysql_query($q, $database->connection);
if($result) {
	echo 'true';
}
?>