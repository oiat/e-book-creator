<div class="widgetActions">
	<!--<?php if($showSaving) { ?><span class="widgetSaving" title="Speicherstatus"></span><?php } ?>-->
	<?php if($showEdit) { ?><a href="<?php echo $editUrl;?>?id=<?php echo $widget_id;?>" title="Bearbeiten"><i class="fa fa-pencil fa-border fa-fw"></i></a><?php } ?>
    <a title="Sortieren"><i class="handle fa fa-arrows-v fa-border fa-fw"></i></a> 
    <a href="<?php echo $widget_id;?>" class="binWidget" title="in den Papierkorb verschieben"><i class="fa fa-trash-o fa-border fa-fw"></i></a> 
    <a href="<?php echo $widget_id;?>" class="saveWidget" title="als eigene Vorlage speichern"><i class="fa fa-plus-square-o fa-border fa-fw"></i></a>
</div>