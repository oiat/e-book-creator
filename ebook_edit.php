<?php include("includes/session.php"); ?>
<?php include("includes/ebooks.php"); ?>
<?php include_once("templates/header.php"); ?>
<?php if(!$session->logged_in){ ?>
			<script language="javascript" type="text/javascript">
	<!--
		location.replace("/login.php");
	//-->
	</script>
<?php 
die();
} 
$book_id = $_GET['id'];

// check permission
//$q = "SELECT a.id FROM books as a, books_shared as b WHERE a.id='$book_id' and (a.uid='$session->uid' or (b.sharer_id='$session->uid' and a.id=b.book_id))";
//$q = "SELECT a.id FROM books as a WHERE a.id='$book_id' and a.uid='$session->uid'";
/*$q = "SELECT id FROM books WHERE id='$book_id' and uid='$session->uid' UNION ALL SELECT a.id FROM books as a, books_shared as b WHERE a.id='$book_id' and b.sharer_id='$session->uid' and a.id=b.book_id and a.bin='0'";
$result = mysql_query($q, $database->connection);
if(mysql_num_rows($result) < 1) {
	die('<h1>Sorry, but you do not have permission to access this book</h1>');
}*/
//echo $session->checkBookPermissions($book_id);
if(!$session->checkBookPermissions($book_id)) {
	die('<h1>Sorry, but you do not have permission to access this book</h1>');
}
?>
<div id="content">
    <?php
    $q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$book_id'";
		$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$book_id = $row['id'];
			$book_owner = $row['uid'];
			$title = $row['title'];
			$subtitle = $row['subtitle'];
			$author = $row['author'];
			if($author == "") {
				$author = $session->firstname . ' ' . $session->surname;
			}
			$edition = $row['edition'];
			$ebooks = $row['ebooks'];
			$license = $row['license'];
			$description = $row['description'];
			$book_image = '/img/placeholder-square-1.png';
			if($row['image'] != '') {
				$time = time();
				$book_image = '/books/' . $book_owner. '/uploads/cover_'.$book_id.'.jpg?'.$time;
			}
			$country = $row['country'];
		}
	?>
    <p><a href="/myebooks.php">Meine E-books</a> -> <a href="/ebook_edit.php?id=<?php echo $book_id;?>"><?php echo $title;?></a></p>
	<p>&nbsp;</p>
    <?php 
	$details_selected = true;
	include_once("templates/book_tabs.php"); ?>
    <div style="position: relative; width: 1000px; min-height: 400px;">
    <div class="book" style="width: 754px; "><h1>Details E-Book</h1><div class="circle-top"></div><div class="circle-bottom"></div><div class="content-area">
    <div id="book_title" class="editBox">
		<div class="widget-header-long-singleline"><label>Titel</label><h3 class="inlineSingle settings"><?php echo $title;?></h3></div>
	</div>
    <div id="book_subtitle" class="editBox">
		<div class="widget-header-long-singleline"><label>Untertitel</label><h3 class="inlineSingle settings"><?php echo $subtitle;?></h3></div>
	</div>
    <div id="book_author" class="editBox">
		<div class="widget-header-long-singleline">
		    <label>Autor/in</label><h3 class="inlineSingle settings"><?php echo $author;?></h3></div>
	</div>
    <div id="book_edition" class="editBox">
		<div class="widget-header-long-singleline"><label>Version</label><h3 class="inlineSingle settings"><?php echo $edition;?></h3></div>
	</div>
    </div></div><!-- bookdesign close -->
    
  <br><br>
	<div class="book" style="width: 754px; "><h1>Angaben für den E-Book-Katalog <span style="font-weight: normal; font-size: 12px;">(Diese Angaben erscheinen nur im E-Book-Creator, nicht im E-Book)</span></h1><div class="circle-top"></div><div class="circle-bottom"></div><div class="content-area">
    <div id="book_description" class="editBox">
    	<div class="widget-header">Beschreibung </div>
		<div rel="description" class="textarea settings" style="background:#fff; padding: 5px;"><?php echo $description;?></div>
        <div style="clear: both;"></div>
	</div>
	<div id="book_image" class="editBox">
		<div class="widget-header">Vorschaubild</div>
		<div class="image">
			<div class="image_display"><img src="<?php echo $book_image;?>" /></div>
			<div id="image_<?php echo $book_id;?>" class="user-image-uploader catalog_cover">		
				<noscript>			
				<p>Please enable JavaScript to use file uploader.</p>
				<!-- or put a simple form for upload here -->
				</noscript>
			</div>
		</div>
        <div style="clear: both;"></div>
	</div>
    <div id="book_country" class="editBox">
		<div class="widget-header-long-singleline"><label>Land</label><select id="country">
		    <option value="0"<?php if($country == 0 ) { echo ' selected="selected"';}?>>*</option>
		    <option value="1"<?php if($country == 1 ) { echo ' selected="selected"';}?>>Österreich</option>
		    <option value="2"<?php if($country == 2 ) { echo ' selected="selected"';}?>>Deutschland</option>
		    <option value="3"<?php if($country == 3 ) { echo ' selected="selected"';}?>>Schweiz</option>
		    <option value="4"<?php if($country == 4 ) { echo ' selected="selected"';}?>>Liechtenstein</option>
            <option value="5"<?php if($country == 5 ) { echo ' selected="selected"';}?>>Andere</option>
		</select></div>
	</div>
    <div id="book_targetgroups" class="editBox">
		<div class="widget-header"><label>Zielgruppe(n)</label></div>
        <div rel="targetgroups" class="field settings" style="background:#fff; padding: 5px;">
			<?php
				$book_targets = array();
				$q_btargets = "SELECT target_id FROM books_to_targets WHERE book_id='$book_id'";
				$result_btargets = mysql_query($q_btargets, $database->connection);
				while($btargets = mysql_fetch_array($result_btargets)) {
					$book_targets[] = $btargets['target_id'];
				}
				$q_targets = "SELECT * FROM targets ORDER BY sort ASC";
				$result_targets = mysql_query($q_targets, $database->connection);
				while($tar = mysql_fetch_array($result_targets)) {
					$target_id = $tar['id'];
					$target = $tar['target'];
					$target_status = 'fa-square-o';
					if(in_array($target_id,$book_targets)) {
						$target_status = 'fa-check-square-o';
					}
					?>
                    <span style="display: inline-block; width: 31%;"><i class="fa <?php echo $target_status; ?>" rel="<?php echo $target_id;?>"></i> <?php echo $target;?></span>
                <?php	
				}
			?>
		</div>
        <div style="clear: both;"></div>
	</div>
     <div id="book_categories" class="editBox">
		<div class="widget-header"><label>Kategorie(n)</label></div>
        <div rel="categories" class="field settings" style="background:#fff; padding: 5px;">
            <?php
				$book_cats = array();
				$q_bcats = "SELECT cat_id FROM books_to_categories WHERE book_id='$book_id'";
				$result_bcats = mysql_query($q_bcats, $database->connection);
				while($bcats = mysql_fetch_array($result_bcats)) {
					$book_cats[] = $bcats['cat_id'];
				}
				$q_cats = "SELECT * FROM categories ORDER BY category ASC";
				$result_cats = mysql_query($q_cats, $database->connection);
				while($cat = mysql_fetch_array($result_cats)) {
					$cat_id = $cat['id'];
					$category = $cat['category'];
					$cat_status = 'fa-square-o';
					if(in_array($cat_id,$book_cats)) {
						$cat_status = 'fa-check-square-o';
					}
					?>
                    <span style="display: inline-block; width: 31%;"><i class="fa <?php echo $cat_status; ?>" rel="<?php echo $cat_id;?>"></i> <?php echo $category;?></span>
                <?php	
				}
			?>
		</div>
        <div style="clear: both;"></div>
	</div>
    
    </div></div><!-- bookdesign close -->
    
    <div id="structureConsole" class="widgetsConsole">
        <h3 class="toggle closed">E-Book Ausgabe <i class="fa fa-caret-right"></i></h3>
        <div>
        	<?php 
			$url = "/books/$book_owner/$book_id/Output";
			$editions_show = 'display: inline-block;';
			if($ebooks == 0) { $editions_show = 'display: none;'; }
			?>
				<p><a href="#" id="generateEbook" rel="<?php echo $book_id;?>" title="Vorschau erstellen"><i class="fa fa-book fa-border fa-fw"></i> erstellen/aktualisieren</a></p>
				<span id="editions">
					<span style="display: none;"><i class="fa fa-refresh fa-spin"></i> in Bearbeitung<br /><br /><br /><br /></span>
                    <div style="<?php echo $editions_show;?>"><a href="<?php echo $url;?>/ebook/book.epub" target="_blank">epub</a></div>
					<div style="<?php echo $editions_show;?>"><a href="<?php echo $url;?>/kindle/book.mobi" target="_blank">mobi</a></div>
					<div style="<?php echo $editions_show;?>"><a href="<?php echo $url;?>/print/book.pdf" target="_blank">pdf</a></div>
					<div style="<?php echo $editions_show;?>"><a href="<?php echo $url;?>/website/book.html" target="_blank">html</a></div>
				</span>
                <p><a href="#" id="removeEbooks" style="<?php echo $editions_show;?>" rel="<?php echo $book_id;?>" title="Ebooks löschen"><i class="fa fa-times fa-border fa-fw deleteWidget"></i> Ausgaben löschen</a></p>
        </div>
        <h3 class="closed"><a href="/books/11/57/Output/website/book.html#buch-bearbeiten-allgemeine-daten" target="_blank">Hilfe</a></h3>
    </div>
    </div>
    <input id="book_id" name="book_id" type="hidden" value="<?php echo $book_id;?>" />
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>