<div id="tabs">
<ul>
			<li <?php if(isset($details_selected)) { echo 'class="selected"'; } ?>><a href="/ebook_edit.php?id=<?php echo $book_id;?>">Allgemeine Daten</a></li>
            <li <?php if(isset($structure_selected)) { echo 'class="selected"'; } ?>><a href="/book_edit_structure.php?id=<?php echo $book_id;?>">Inhalt</a></li>
			<li <?php if(isset($publication_selected)) { echo 'class="selected"'; } ?>><a href="/book_edit_ebooks.php?id=<?php echo $book_id;?>">Veröffentlichung</a></li>
            </ul>
</div>
<div style="height: 0px; clear:both;"></div>