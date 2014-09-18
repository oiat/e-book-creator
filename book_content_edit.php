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
    $q = "SELECT a.*, b.uid, b.title as booktitle, b.ebooks FROM " . TBL_BOOKS_STRUCTURE . " as a, " . TBL_BOOKS. " as b WHERE a.id='$chapter_id' and a.book_id=b.id";
		$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$chapter_id = $row['id'];
			$book_owner = $row['uid'];
			$book_title = $row['booktitle'];
			$book_id = $row['book_id'];
			$title = $row['content'];
			$ebooks = $row['ebooks'];
		}
	?>
    <input id="chapter_id" name="chapter_id" type="hidden" value="<?php echo $chapter_id;?>" />
    
    <p><a href="/myebooks.php">Meine E-books</a> -> <a href="/ebook_edit.php?id=<?php echo $book_id;?>"><?php echo $book_title;?></a></p>
    <p>&nbsp;</p>
    <?php 
	$structure_selected = true;
	include_once("templates/book_tabs.php"); ?>
    <div style="position: relative; width: 1000px; min-height: 400px;">
    <div class="book" style="width: 754px; "><h1><?php echo $title;?></h1><div class="circle-top"></div><div class="circle-bottom"></div><div class="content-area">
    <div id="widgetArea">
    <?php
    $q = "SELECT * FROM " . TBL_BOOKS_WIDGETS . " WHERE chapter_id='$chapter_id' and bin='0' ORDER BY sort ASC";
	$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$widget_id = $row['id'];
			$widget_content = $row['content'];
			$widget_content2 = $row['content2'];
			$widget_pic = $row['image'];
			$widget_type = $row['type'];
			include("templates/widgets/content/$widget_type.php");
		}
	?>
    </div>
    
    </div></div><!-- bookdesign close -->

    <div id="contentConsole" class="widgetsConsole">
    	<h3 class="toggle">Vorlagen <i class="fa fa-caret-right fa-rotate-90"></i></h3>
        <div style="display: block;">
			<div class="textarea"><i class="fa fa-font"></i> Text</div>
			<div class="image"><i class="fa fa-file-image-o"></i> Bild / Grafik</div>
            <div class="video"><i class="fa fa-file-video-o"></i> Video</div>
            <div class="quiz"><i class="fa fa-check-square-o "></i> Quiz</div>
        	<div class="headline1"><i class="fa fa-header"></i> Überschrift 1</div>
            <div class="headline2"><i class="fa fa-header"></i> Überschrift 2</div>
            <div class="pagebreak"><i class="fa fa-file-o"></i> Seitenumbruch</div>
        </div>
        <h3 class="toggle closed">Eigene Vorlagen <i class="fa fa-caret-right"></i></h3>
        <div id="widgetUser"></div>
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
        <h3 class="toggle closed">Papierkorb <i class="fa fa-caret-right"></i></h3>
        <div id="widgetBin"></div>
        <h3 class="closed"><a href="/books/11/57/Output/website/book.html#6-buch-bearbeiten-inhalt-kapitel-einleitung" target="_blank">Hilfe</a></h3>
    </div>
</div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>