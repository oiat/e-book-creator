<div id="book_<?php echo $id;?>" class="editBox" style="position: relative;">
    <img src="<?php echo $book_image;?>" style="max-width: 46px; max-height: 46px; position: absolute; top: 0; left: 0; margin: 5px;" />
    <div class="widget-header-long" style="margin: 0 270px 0 50px;">
        <b><?php echo $title;?></b><br>
        <?php echo $subtitle;?>
        <div style="position: absolute; right: 155px; top: 12px;">
            <?php echo $LICENSE[$license];?>
        </div>
        <div style="position: absolute; right: 0; top: 10px;">
            <a href="ebook_edit.php?id=<?php echo $id;?>" title="Bearbeiten"><i class="fa fa-pencil fa-border fa-fw"></i></a>
           <?php if($session->uid == $book_owner) { ?><a href="<?php echo $id;?>" class="shareWidget" title="E-Book teilen"><i class="fa fa-users fa-border fa-fw"></i></a>
            <a href="<?php echo $id;?>" class="binWidget" title="in den Papierkorb verschieben"><i class="fa fa-trash-o fa-border fa-fw"></i></a><?php } else { ?>
            <a href="<?php echo $shareid;?>" rel="<?php echo $id;?>" class="shareWidgetRemove" title="E-Book entfernen"><i class="fa fa-users fa-border fa-fw"></i></a><?php } ?>
            <a href="<?php echo $id;?>" class="saveWidget" title="als eigene Vorlage speichern"><i class="fa fa-plus-square-o fa-border fa-fw"></i></a>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>