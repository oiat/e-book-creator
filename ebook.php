<?php
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: /");
}?>
<?php include("includes/session.php"); ?>
<?php include("includes/ebooks.php"); ?>
<?php include_once("templates/header.php"); ?>
<?php
$id = $_GET['id'];
$q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$id' and license > '0'";
	$result = mysql_query($q, $database->connection);
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
		$description = $row['description'];
		$author = $row['author'];
		$book_image = '/img/placeholder_catalog_cover.png';
		if($row['image'] != '') {
			$time = time();
			$book_image = '/books/' . $uid. '/uploads/cover_'.$id.'.jpg?'.$time;
		}
		$license = $row['license'];
		$url = "/books/$book_owner/$id/Output";
		switch($row['country']) {
			case 0:		$country = "*";				break;
			case 1:		$country = "Österreich";	break;
			case 2:		$country = "Deutschland";				break;
			case 3:		$country = "Schweiz";				break;
			case 4:		$country = "Liechtenstein";				break;
			case 5:		$country = "Andere";				break;
		}
	}
	?>

<div id="content">
	<h1><?php echo $title;?></h1>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	        <td><img src="<?php echo $book_image;?>" style="width: 170px; height: auto;" /></td>
	        <td valign="top">
                <p><?php echo $subtitle;?></p>
                <p>&nbsp;</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="21%"><p><strong>Autor</strong></p>
            <p><strong>Land</strong></p>
            <p><strong>Kategorie</strong></p>
            <p><strong>Zielgruppe</strong></p></td>
        <td width="61%"><p><?php echo $author;?></p>
            <p><?php echo $country;?></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            </td>
        <td width="9%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
    </tr>
</table>
            
            </td>
        </tr>
    </table>
	<p>&nbsp;</p>
    
	<p><?php echo $description;?></p>
	<p>&nbsp;</p>
                    <div class="rahmen-reihe">
        <a href="<?php echo $url;?>/ebook/book.epub" target="_blank"><div class="rahmen">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px;"><p><strong>epub</strong></p></div>
            </div></a>
            <a href="<?php echo $url;?>/kindle/book.mobi" target="_blank"><div class="rahmen">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px;"><p><strong>mobi</strong></p></div>
            </div></a>
            <a href="<?php echo $url;?>/print/book.pdf" target="_blank"><div class="rahmen">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px;"><p><strong>PDF</strong></p></div>
            </div></a>
            <a href="<?php echo $url;?>/website/book.html" target="_blank"><div style="margin-right: 0;" class="rahmen">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px;"><p><strong>html</strong></p></div>
            </div></a>
    </div>
    <br><br>
    <div class="rahmen-reihe">
        <a href="#" onclick="history.go(-1);return false;"><div class="rahmen" style="float: right;">
                <div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px;">
                    <p><strong>zurück zum Katalog</strong></p></div>
            </div></a>
    </div>
    <p>&nbsp;</p>      
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>