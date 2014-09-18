<?php
$showSaving = true;
$showEdit = false;
$editUrl = 'book_edit_cover.php';
?>
<!-- textarea -->
<div id="widget_<?php echo $widget_id;?>" class="editBox">
	<div class="widget-header-long"><label>Bilderverzeichnis</label><h3 class="inlineSingle structure" placeholder="Überschrift Bilderverzeichnis"><?php echo $widget_content;?></h3><?php include(CO_PATH . '/templates/widgets/structure_actions.php');?></div>
</div>