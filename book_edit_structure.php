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
				$book_image = '/books/' . $session->uid. '/uploads/'.$row['image'];
			}
		}
	?>
    <p><a href="/myebooks.php">Meine E-books</a> -> <a href="/ebook_edit.php?id=<?php echo $book_id;?>"><?php echo $title;?></a></p>
	<p>&nbsp;</p>
    <?php 
	$structure_selected = true;
	include_once("templates/book_tabs.php"); ?>
    <div style="position: relative; width: 1000px; min-height: 400px;">
    <div class="book" style="width: 754px; "><h1>Buch Struktur</h1><div class="circle-top"></div><div class="circle-bottom"></div><div class="content-area">
     <div id="widgetAreaStructure">
	<?php
    $q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE . " WHERE book_id='$book_id' and bin='0' ORDER BY sort ASC";
		$result = mysql_query($q, $database->connection);
		$i = 1;
		while($row = mysql_fetch_array($result)) {
			$widget_id = $row['id'];
			//$title = $row['title'];
			$widget_content = $row['content'];
			$widget_type = $row['type'];
			//echo '<div><a href="book_content_edit.php?id=' . $chapter_id . '">Kapitel ' . $i . ': ' . $title. '</a></div>';
			include("templates/widgets/structure/$widget_type.php");
			$i++;
		}
	?>
    </div>
    
    </div></div><!-- bookdesign close -->
    
    <div id="structureConsole" class="widgetsConsole">
       <h3 class="toggle">Vorlagen <i class="fa fa-caret-right fa-rotate-90"></i></h3>
        <div style="display: block;">
			<div class="cover">Deckblatt</div>
            <div class="toc">Inhaltsverzeichnis</div>
            <div class="introduction">Einleitung</div>
       		<div class="chapter">Kapitel</div>
            <div class="lof">Bilderverzeichnis</div>
            <div class="license">Lizenz</div>
        </div>
        <h3 class="toggle closed">Eigene Vorlagen <i class="fa fa-caret-right"></i></h3>
        <div id="structureUser"></div>
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
        <div id="structureBin"></div>
        <h3 class="closed"><a href="/books/11/57/Output/website/book.html#5-buch-bearbeiten-inhalt" target="_blank">Hilfe</a></h3>
    </div>
    <input id="book_id" name="book_id" type="hidden" value="<?php echo $book_id;?>" />
    </div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>