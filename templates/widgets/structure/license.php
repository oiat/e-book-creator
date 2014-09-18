<?php
$showSaving = false;
$showEdit = false;
$editUrl = 'book_edit_cover.php';
?>
<!-- textarea -->
<div id="widget_<?php echo $widget_id;?>" class="editBox">
	<div class="widget-header-long"><label>Lizenz</label><h3 class="inlineSingle structure" placeholder="Überschrift Lizenz"><?php echo $widget_content;?></h3><?php include(CO_PATH . '/templates/widgets/structure_actions.php');?></div>
</div>