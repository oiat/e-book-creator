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
$chapter_id = $_GET['id'];
?>
<div id="content">
	<?php
    $q = "SELECT a.*, b.title as booktitle, b.ebooks, b.uid FROM " . TBL_BOOKS_STRUCTURE . " as a, " . TBL_BOOKS. " as b WHERE a.id='$chapter_id' and a.book_id=b.id";
		$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$chapter_id = $row['id'];
			$book_title = $row['booktitle'];
			$book_id = $row['book_id'];
			$uid = $row['uid'];
			$title = $row['content'];
			$ebooks = $row['ebooks'];
			$cover_image = '/img/placeholder-square-1.png';
			if($title != '') {
				//$cover_image = '/books/' . $uid. '/'.$book_id.'/Resources/Templates/ebook/'.$title;
				$cover_image = '/books/' . $uid. '/uploads/'.$title;
			}
		}
	?>
    <input id="chapter_id" name="chapter_id" type="hidden" value="<?php echo $chapter_id;?>" />
    
    <p><a href="/myebooks.php">Meine E-books</a> -> <a href="/ebook_edit.php?id=<?php echo $book_id;?>"><?php echo $book_title;?></a></p>
    <p>&nbsp;</p>
    <?php 
	$structure_selected = true;
	include_once("templates/book_tabs.php"); ?>
    <div style="position: relative; width: 1000px; min-height: 400px;">
    <div class="book" style="width: 754px; "><h1>Deckblatt</h1><div class="circle-top"></div><div class="circle-bottom"></div><div class="content-area">
    <div id="widgetArea">
    <div id="book_image" class="editBox">
		<div class="widget-header">Bild</div>
		<div class="image">
			<div class="image_display"><img src="<?php echo $cover_image;?>" /></div>
			<div id="image_<?php echo $chapter_id;?>" class="user-image-uploader cover">		
				<noscript>			
				<p>Please enable JavaScript to use file uploader.</p>
				<!-- or put a simple form for upload here -->
				</noscript>
			</div>
		</div>
        <div style="clear: both;"></div>
	</div>
    <?php
    /*$q = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$chapter_id' and bin='0' ORDER BY sort ASC";
	$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$widget_id = $row['id'];
			$widget_content = $row['content'];
			$widget_pic = $row['image'];
			$widget_type = $row['type'];
			include("templates/widgets/$widget_type.php");
		}*/
	?>
    </div>
    
    </div></div><!-- bookdesign close -->

    <div id="contentConsole" class="widgetsConsole">
        <h3 class="toggle closed">E-Book Ausgabe <i class="fa fa-caret-right"></i></h3>
        <div>
        	<?php 
			$url = "/books/$session->uid/$book_id/Output";
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
        <h3 class="closed"><a href="/books/11/57/Output/website/book.html#5-buch-bearbeiten-inhalt" target="_blank">Hilfe</a></h3>
    </div>
</div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>