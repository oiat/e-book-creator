<!-- image -->
<?php 
$widget_image = '/img/placeholder-square-1.png';
if($widget_content != '') {
	$widget_image = '/books/' . $session->uid. '/uploads/'.$widget_content;
}
?>
<div id="widget_<?php echo $widget_id;?>" class="editBox">
	<div class="widget-header">Bild <?php include(CO_PATH . '/templates/widgets/widget_actions.php');?></div>
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
</div>