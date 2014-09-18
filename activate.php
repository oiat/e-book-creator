<?php include("includes/session.php"); ?>
<?php include_once("templates/header.php"); ?>
<?php
if(isset($_GET['hash']) && isset($_GET['stamp'])) {
	$retval = $session->activate($_GET['hash'],$_GET['stamp']);
	
	if($retval == 0){
		$message = ACTIVATION_SUCCESS;
	}
	/* Error found with form */
	else if($retval == 1){
		$message = ACTIVATION_ERROR;
	}
} else {
	$message = ACTIVATION_ERROR;
}

?>
<div id="content">
	    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="">
        <tr>
          <td valign="top" class="td-main"><?php echo($message);?><br /></td>
		</tr>
	</table>

</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>