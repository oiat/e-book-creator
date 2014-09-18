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
			$chapterlabels = $row['chapterlabels'];
		}
	?>
    <p><a href="/myebooks.php">Meine E-books</a> -> <a href="/ebook_edit.php?id=<?php echo $book_id;?>"><?php echo $title;?></a></p>
	<p>&nbsp;</p>
    <?php 
	$publication_selected = true;
	include_once("templates/book_tabs.php"); ?>
    <div style="position: relative; width: 1000px; min-height: 400px;">
    <div class="book" style="width: 754px; "><h1>Einstellungen zur Veröffentlichung des E-Books</h1><div class="circle-top"></div><div class="circle-bottom"></div><div class="content-area">
    <input id="book_id" name="book_id" type="hidden" value="<?php echo $book_id;?>" />
    <div id="book_chapterlabels" class="editBox">
		<div class="widget-header-long">
        	<label>Nummerierung Kapitel</label>
            <select id="chapterlabels" name="chapterlabels" class="saveSelect">
            <?php
				$labelarray = array("Keine","1, 2, 3","I, II, III","A, B, C");
				$i = 0;
				foreach($labelarray as $label) {
					if ($i == $chapterlabels) {
						$selected = " selected = \"selected\"";
					} else {
						$selected = "";
					}
					echo("<option value=\"" . $i . "\"" . $selected . ">" . $label . "</option>");
					$i++;
				}
				?>
            </select>
        </div>
	</div>
    <div id="book_license" class="editBox">
    	<div class="widget-header">Lizenz</div>
		<div rel="license" class="field settings" style="background:#fff; padding: 5px;">
		    <p><i class="fa <?php if($license == 0) { echo 'fa-circle'; } else { echo 'fa-circle-thin'; } ?>" rel="0"></i> <strong>nicht im Katalog<br>
		    </strong>Das E-Book wird nur unter „Meine-E-Books“, nicht aber im Gesamtkatalog des E-Book-Creators aufgelistet. Achtung!!! Auch wenn &quot;nicht im Katalog&quot; eingestellt wurde, werden die E-Books in den vier Formaten (epub, mobi, pdf, html) in einem öffentlich zugänglichen Bereich gespeichert. Wenn der Direktlink bekannt ist, bzw. per Suchmaschine können die E-Books gefunden werden. Durch Klicken der Schaltfläche &quot;Ausgaben löschen&quot; können die E-Book-Ausgaben wieder vom Server gelöscht werden.</p>
<p><i class="fa <?php if($license == 1) { echo 'fa-circle'; } else { echo 'fa-circle-thin'; } ?>" rel="1"></i> <strong>CC by SA</strong> <br>
    Das E-Book wird unter „Meine-E-Books“ und im Gesamtkatalog des  E-Book-Creators angezeigt. Es steht unter der Creative-Commons-Lizenz  CC-BY-SA 4.0 (Teilen - Bearbeiten - Namensnennung – Weitergabe unter  gleichen Bedingungen) - <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.de" target="_blank">https://creativecommons.org/licenses/by-sa/4.0/deed.de</a></p>
		    <p><i class="fa <?php if($license == 2) { echo 'fa-circle'; } else { echo 'fa-circle-thin'; } ?>" rel="2"></i> <strong>CC 0</strong> <br>
		        Das E-Book wird unter „Meine-E-Books“ und im Gesamtkatalog des  E-Book-Creators angezeigt. Es steht unter der Creative-Commons-Lizenz  CC0 1.0 (Public Domain - Kopieren, Verändern, Verbreiten und Aufführen) - <a href="http://creativecommons.org/publicdomain/zero/1.0/deed.de" target="_blank">http://creativecommons.org/publicdomain/zero/1.0/deed.de</a></p>
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
        <h3 class="closed"><a href="/books/11/57/Output/website/book.html#buch-bearbeiten-veroffentlichung" target="_blank">Hilfe</a></h3>
    </div>
        
        
        </div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>