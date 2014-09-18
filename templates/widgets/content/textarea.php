<?php
$showSaving = true;
$showToggle = true;
$showBin = true;
$showDelete = false;
$showSave = true;
?>
<!-- textarea -->
<div id="widget_<?php echo $widget_id;?>" class="editBox">
    <div class="widget-header">Text<br /><?php include(CO_PATH . '/templates/widgets/widget_actions.php');?></div>
	<div class="textarea content"><?php echo $widget_content;?></div>
    <div style="clear: both;"></div>
</div>