<?php
$showSaving = true;
$showEdit = true;
$editUrl = 'book_content_edit.php';
?>
<!-- textarea -->
<div id="widget_<?php echo $widget_id;?>" class="editBox">
	<div class="widget-header-long"><label>Kapitel</label><h3 class="inlineSingle structure" placeholder="Überschrift Kapitel"><?php echo $widget_content;?></h3><?php include(CO_PATH . '/templates/widgets/structure_actions.php');?></div>
</div>