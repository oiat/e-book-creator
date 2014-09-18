<?php
$showSaving = true;
$showToggle = true;
$showBin = true;
$showDelete = false;
$showSave = true;
?>
<!-- image -->
<?php 
$widget_image = '/img/placeholder-square-1.png';
if($widget_pic != '') {
	$widget_image = '/books/' . $book_owner. '/uploads/'.$widget_pic;
}
?>
<div id="widget_<?php echo $widget_id;?>" class="editBox">
	<div class="widget-header">Bild / Grafik<?php include(CO_PATH . '/templates/widgets/widget_actions.php');?></div>
	<div class="image">
		<div class="image_display"><img src="<?php echo $widget_image;?>" /></div>
    	<div id="image_<?php echo $widget_id;?>" class="user-image-uploader">		
            <noscript>			
            <p>Please enable JavaScript to use file uploader.</p>
            <!-- or put a simple form for upload here -->
            </noscript>
        </div>
    </div>
    <div style="clear: both;"></div>
    <div class="widget-header-full"><label>Bildunterschrift</label><h3 class="inlineSingle content image" style=""><?php echo $widget_content;?></h3></div>
    <div style="clear: both;"></div>
</div>
