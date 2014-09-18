<div class="widgetActions">
	<!--<?php if($showSaving) { ?><span class="widgetSaving" title="Speicherstatus"></span><?php } ?>-->
    <a title="Sortieren"><i class="handle fa fa-arrows-v fa-border fa-fw"></i></a>
    <!--<?php if($showToggle) { ?><a href="widget_<?php echo $widget_id;?>" class="toggleWidget" title="toggle widget"><i class="fa fa-angle-double-up fa-border fa-fw"></i></a><?php } ?>-->
    <?php if($showBin) { ?><a href="<?php echo $widget_id;?>" class="binWidget" title="in den Papierkorb verschieben"><i class="fa fa-trash-o fa-border fa-fw"></i></a><?php } ?>
    <?php if($showDelete) { ?><a href="<?php echo $widget_id;?>" class="deleteWidget" title="endgültig löschen"><i class="fa fa-times fa-border fa-fw"></i></a><?php } ?>
    <?php if($showSave) { ?><a href="<?php echo $widget_id;?>" class="saveWidget" title="als eigene Vorlage speichern"><i class="fa fa-plus-square-o fa-border fa-fw"></i></a><?php } ?>
</div>