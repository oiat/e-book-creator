<?php
$showSaving = true;
$showToggle = true;
$showBin = true;
$showDelete = false;
$showSave = true;
?>
<!-- textarea -->
<div id="widget_<?php echo $widget_id;?>" class="editBox">
	<div class="widget-header-long"><label>Quiz</label><h3 class="inlineSingle content" placeholder="http://learningapps.org"><?php echo $widget_content;?></h3><?php include(CO_PATH . '/templates/widgets/widget_actions.php');?></div>
</div>