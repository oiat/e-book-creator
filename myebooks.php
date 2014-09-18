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
} ?>
<div id="content">
	<p>Meine E-Books</p>
	<p>&nbsp;</p>
    <div style="position: relative; width: 1000px; min-height: 400px;">
    <div class="book" style="width: 754px; "><div class="circle-top"></div><div class="circle-bottom"></div><div class="content-area">
    <div id="widgetAreaBook">
	<?php
   //$q = "SELECT * FROM " . TBL_BOOKS . " WHERE uid='$session->uid' ORDER BY title ASC";
   //$q = "SELECT a.* FROM " . TBL_BOOKS . " as a, books_shared as b WHERE a.uid='$session->uid' or (b.sharer_id='$session->uid' and a.id=b.book_id) ORDER BY a.title ASC";
   $q = "SELECT id,uid,title,subtitle,image,license,'shareid' FROM books WHERE uid='$session->uid' and bin='0' UNION ALL SELECT a.id,a.uid,a.title,a.subtitle,a.image,a.license,b.id as shareid FROM books as a, books_shared as b WHERE b.sharer_id='$session->uid' and a.id=b.book_id and a.bin='0'";
		$result = mysql_query($q, $database->connection);
		while($row = mysql_fetch_array($result)) {
			$id = $row['id'];
			$uid = $row['uid'];
			$book_owner = $uid;
			$title = $row['title'];
			$subtitle = $row['subtitle'];
			$book_image = '/img/placeholder_catalog_cover.png';
			if($row['image'] != '') {
				$time = time();
				$book_image = '/books/' . $uid. '/uploads/cover_'.$id.'.jpg?'.$time;
			}
			$license = $row['license'];
			$shareid = $row['shareid'];
			$url = "/books/$session->uid/$id/Output/"; 
			include(CO_PATH . "/templates/widgets/book.php");
			 } ?>
        </div>
  </div></div><!-- bookdesign close -->
  
  <div id="bookConsole" class="widgetsConsole">
        <h3 class="closed"><a href="#" id="newBook">Neues Buch</a></h3>
        <!--<h3 class="toggle">Vorlagen <i class="fa fa-caret-right fa-rotate-90"></i></h3>
        <div id="bookTemplates" style="display: block;"></div>-->
        <h3 class="toggle closed">Eigene Vorlagen <i class="fa fa-caret-right"></i></h3>
        <div id="bookUser"></div>
        <h3 class="toggle closed">Papierkorb  <i class="fa fa-caret-right"></i></h3>
        <div id="bookBin"></div>
        <h3 class="closed"><a href="/books/11/57/Output/website/book.html#3-meine-e-books" target="_blank">Hilfe</h3>
    </div>
  
  </div>
</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>