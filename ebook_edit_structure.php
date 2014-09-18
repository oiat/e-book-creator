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
$id = $_GET['id'];
?>
<div id="content">
	<p><a href="/myebooks.php">Meine E-books</a></p>
	<p>&nbsp;</p>
    <?php 
	$structure_selected = true;
	include_once("templates/book_tabs.php"); ?>
    <?php
    $q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$id' and uid='$session->uid'";
		$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$id = $row['id'];
			$title = $row['title'];
			$author = $row['author'];
			if($author == "") {
				$author = $session->firstname . ' ' . $session->surname;
			}
			$edition = $row['edition'];
			$ebooks = $row['ebooks'];
			$published = $row['published'];
			$description = $row['description'];
			$book_image = '/img/placeholder-square-1.png';
			if($row['image'] != '') {
				$book_image = '/books/' . $session->uid. '/uploads/'.$row['image'];
			}
		}
	?>
    <h1>Buch Struktur</h1>
    <div style="position: relative;">
    <div id="widgetAreaStructure">
	<?php
    $q = "SELECT * FROM " . TBL_BOOKS_STRUCTURE . " WHERE book_id='$id' ORDER BY sort ASC";
		$result = mysql_query($q, $database->connection);
		$i = 1;
		while($row = mysql_fetch_array($result)) {
			$widget_id = $row['id'];
			//$title = $row['title'];
			$widget_content = $row['content'];
			$widget_type = $row['type'];
			//echo '<div><a href="book_content_edit.php?id=' . $chapter_id . '">Kapitel ' . $i . ': ' . $title. '</a></div>';
			include("templates/widgets/$widget_type.php");
			$i++;
		}
	?>
    </div>
    <div id="structureConsole">
       <h3>Vorlagen</h3>
        <div>
			<div class="toc">Inhaltsangabe</div>
       		<div class="chapter">Kapitel</div>
        </div>
        <h3>Eigene Vorlagen</h3>
        <div id="widgetUser"></div>
        <h3>Papierkorb</h3>
        <div id="widgetBin"></div>
    </div>
    <input id="book_id" name="book_id" type="hidden" value="<?php echo $id;?>" />
    </div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>