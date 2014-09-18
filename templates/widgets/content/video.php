<?php
$showSaving = true;
$showToggle = true;
$showBin = true;
$showDelete = false;
$showSave = true;
?>
<!-- textarea -->
<div id="widget_<?php echo $widget_id;?>" class="editBox">
	<div class="widget-header-long"><label>Video</label><h3 class="inlineSingle content" placeholder="http://youtu.be/K-lzPedMBuQ"><?php echo $widget_content;?></h3></div>
    <div class="widget-header-long"><label>Beschreibung</label><h3 class="inlineSingle content2"><?php echo $widget_content2;?></h3><?php include(CO_PATH . '/templates/widgets/widget_actions.php');?></div>
</div>