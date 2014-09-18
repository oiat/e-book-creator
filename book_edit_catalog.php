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
?>
<div id="content">
    <?php
    $q = "SELECT * FROM " . TBL_BOOKS . " WHERE id='$book_id' and uid='$session->uid'";
		$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$book_id = $row['id'];
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
    <p><a href="/myebooks.php">Meine E-books</a> -> <a href="/ebook_edit.php?id=<?php echo $book_id;?>"><?php echo $title;?></a></p>
	<p>&nbsp;</p>
    <?php 
	$catalog_selected = true;
	include_once("templates/book_tabs.php"); ?>
    <h1>E-Book-Creator Katalog</h1>
    <div id="book_description" class="editBox">
    	<div class="widget-header">Beschreibung 
        	<div style="position: absolute; right: 0; top: 0;">
            	<span class="widgetSaving" title="Speicherstatus"></span>
            </div>
         </div>
		<div rel="description" class="textarea settings" style="background:#fff; padding: 5px;"><?php echo $description;?></div>
       
	</div>
	<div id="book_image" class="editBox">
		<div class="widget-header">Cover/Vorschaubild
        	<div style="position: absolute; right: 0; top: 0;">
            	<span class="widgetSaving" title="Speicherstatus"></span>
            </div>
        </div>
		<div class="image">
			<div class="image_display"><img src="<?php echo $book_image;?>" /></div>
			<div id="image_<?php echo $widget_id;?>" class="user-image-uploader">		
				<noscript>			
				<p>Please enable JavaScript to use file uploader.</p>
				<!-- or put a simple form for upload here -->
				</noscript>
			</div>
		</div>
	</div>
    Zielgruppe (checkboxen), Kategorie (checkboxen), Land (dropdown)
  <br><br>

    </div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>