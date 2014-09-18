<?php include("includes/session.php"); ?>
<?php include("includes/ebooks.php"); ?>
<?php include_once("templates/header.php"); 
// all books
	$q = "SELECT * FROM " . TBL_BOOKS . " WHERE license > '0'";
	
	if(isset($_GET['category']) && $_GET['category'] != 0) {
		$cat_id = $_GET['category'];
		$q = "SELECT a.* FROM " . TBL_BOOKS . " as a, books_to_categories as b WHERE a.license > '0' and a.id = b.book_id and b.cat_id = '$cat_id'";
	}
	if(isset($_GET['target']) && $_GET['target'] != 0) {
		$target_id = $_GET['target'];
		$q = "SELECT a.* FROM " . TBL_BOOKS . " as a, books_to_targets as b WHERE a.license > '0' and a.id = b.book_id and b.target_id = '$target_id'";
	}
	$s = '';
	if(isset($_GET['s']) && $_GET['s'] != '') {
		$s = $_GET['s'];
		// search books
		//$q = "SELECT * FROM " . TBL_BOOKS . " WHERE license > '0' and (title LIKE '%$s%' || subtitle LIKE '%$s%' || author LIKE '%$s%' || description LIKE '%$s%')";
		//$q = "SELECT a.* FROM " . TBL_BOOKS . " as a, books_structure as b, books_widgets as c WHERE a.license > '0' and ((a.title LIKE '%$s%' || a.subtitle LIKE '%$s%' || a.author LIKE '%$s%' || a.description LIKE '%$s%') or  ()";
																																																									  $q = "SELECT c.* FROM books_widgets as a, books_structure as b, books as c WHERE a.bin='0' and b.bin='0' and c.bin='0' and c.license > '0' and a.chapter_id = b.id and b.book_id = c.id and (a.content LIKE '%$s%' || b.content LIKE '%$s%' || c.title LIKE '%$s%' || c.subtitle LIKE '%$s%' || c.author LIKE '%$s%' || c.description LIKE '%$s%') GROUP BY c.id";
	}
	
	$result = mysql_query($q, $database->connection);


?>
<div id="content">
	<h1>E-Book Katalog</h1>
	<p>Im E-Book-Katalog sind alle mit dem E-Book-Creator erstellten und veröffentlichten E-Books aufgelistet. Die E-Books sind mit den CreativeCommons-Lizenzen „CC BY SA“ oder „CC 0“, dürfen also entsprechend der Lizenzen frei verwendet und weiterverbreitet werden.<br><br>
    Für die Inhalte der E-Books ist der/die jeweilige Autor/in verantwortlich!</p>
	<p>&nbsp;</p>
    <form name="search" method="GET" action="/ebooks.php">
	<table border="0">
	    <tr>
	        <td width="25%">
            <div class="rahmen">
	            <div class="rahmen-loch-oben"></div>
	            <div class="rahmen-loch-unten"></div>
	            <div class="rahmen-content" style="min-width: 100px; padding: 0;">
            <select id="filterCat">
            <option value="0">Alle Kategorien</option>
            <?php
				$q_cats = "SELECT * FROM categories ORDER BY category ASC";
				$result_cats = mysql_query($q_cats, $database->connection);
				while($cat = mysql_fetch_array($result_cats)) {
					$cate_id = $cat['id'];
					$selected = '';
					if($cat_id == $cate_id) {
						$selected = ' selected="selected"';
					}
					$category = $cat['category'];
					?>
                    <option value="<?php echo $cate_id;?>" <?php echo $selected;?>><?php echo $category;?></option>
                <?php	
				}
			?>
            </select>
            </div>
	            </div>
            </td>
            <td width="40%">
            <div class="rahmen">
	            <div class="rahmen-loch-oben"></div>
	            <div class="rahmen-loch-unten"></div>
	            <div class="rahmen-content" style="min-width: 100px; padding: 0;">
            <select id="filterTarget">
            <option value="0">Alle Zielgruppen</option>
            <?php
				$q_targets = "SELECT * FROM targets ORDER BY sort ASC";
				$result_targets = mysql_query($q_targets, $database->connection);
				while($tar = mysql_fetch_array($result_targets)) {
					$targets_id = $tar['id'];
					$selected = '';
					if($target_id == $targets_id) {
						$selected = ' selected="selected"';
					}
					$target = $tar['target'];
					?>
                    <option value="<?php echo $targets_id;?>" <?php echo $selected;?>><?php echo $target;?></option>
                <?php	
				}
			?>
            </select>
            </div>
	            </div>
            </td>
	        <td width="30%" height="70"><div class="rahmen">
	            <div class="rahmen-loch-oben"></div>
	            <div class="rahmen-loch-unten"></div>
	            <div class="rahmen-content" style="min-width: 100px; padding: 0;">
	                <input type="text" name="s" maxlength="30" value="<?php echo $s;?>" class="ebook-input">
	                </div>
	            </div></td>
	        <td><input name="a" type="submit" value="Suchen"></td>
        </tr>
    </table></form>
	<p>&nbsp;</p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="40" class="tbl-fst"><strong>Titelbild</strong></td>
            <td class="tbl-sec"><strong>Titel</strong></td>
            <td class="tbl-thi"><strong>Autor/in</strong></td>
            <td class="tbl-fou"><strong>Land</strong></td>
        </tr>
    </table>
	<?php
	if(mysql_num_rows($result) < 1) {
		echo 'Keine E-Books vorhanden.';
	}
	$i = 0;
	while($row = mysql_fetch_array($result)) { 
		if($i % 2) {
			$selection_class = 'class="even"';
		} else {
			$selection_class = 'class="odd"';
		}
		$id = $row['id'];
		$uid = $row['uid'];
		$book_owner = $uid;
		$title = $row['title'];
		$subtitle = $row['subtitle'];
		$author = $row['author'];
		$book_image = '/img/placeholder_catalog_cover.png';
		if($row['image'] != '') {
			$time = time();
			$book_image = '/books/' . $uid. '/uploads/cover_'.$id.'.jpg?'.$time;
		}
		$license = $row['license'];
		//$url = "/books/$session->uid/$id/Output/"; 
		switch($row['country']) {
			case 0:		$country = "*";				break;
			case 1:		$country = "Österreich";	break;
			case 2:		$country = "Deutschland";				break;
			case 3:		$country = "Schweiz";				break;
			case 4:		$country = "Liechtenstein";				break;
			case 5:		$country = "Andere";				break;
		}
	?>
    <section <?php echo $selection_class;?>>
        <div class="tbl-fst"><a href="/ebook.php?id=<?php echo $id;?>"><img src="<?php echo $book_image;?>" style="max-width: 80px; max-height: 80px;" /></a></div>
        <div class="tbl-sec"><a href="/ebook.php?id=<?php echo $id;?>"><?php echo $title;?></a><br /><?php echo $subtitle;?></div>
        <div class="tbl-thi"><?php echo $author;?></div>
        <div class="tbl-fou"><?php echo $country;?></div>
    </section>
    <?php 
	$i++;
	} ?>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>