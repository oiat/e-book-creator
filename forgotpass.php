<?php include("includes/session.php"); ?>
<?php include_once("templates/header.php"); ?>
<div id="content">
	<h1><?php echo(FORGOTTEN_PASSWORD);?></h1>
            <p>&nbsp;</p>
<?php
/**
 * Forgot Password form has been submitted and no errors
 * were found with the form (the username is in the database)
 */
if(isset($_SESSION['forgotpass'])){
   /**
    * New password was generated for user and sent to user's
    * email address.
    */
   if($_SESSION['forgotpass']){
      echo NEW_PASSWORD_GENERATED . "<br /><br />";
   }
   /**
    * Email could not be sent, therefore password was not
    * edited in the database.
    */
   else{
      echo "There was an error sending you the email with the new password,<br> so your password has not been changed.";
   }
       
   unset($_SESSION['forgotpass']);
}
else{

/**
 * Forgot password form is displayed, if error found
 * it is displayed.
 */
?>
<?php echo(FORGOTTEN_PASSWORD_TEXT);?><br><br>

<form name="fpwprd" action="process.php" method="POST">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="20%" height="70"><?php echo(USERNAME);?> <?php echo $form->error("user"); ?></td>
        <td width="30%"><div class="rahmen" style="mar">
            <div class="rahmen-loch-oben"></div>
            <div class="rahmen-loch-unten"></div>
            <div class="rahmen-content" style="min-width: 100px; padding: 0;">
                <input type="text" name="user" maxlength="70" value="<?php echo $form->value("user"); ?>" class="ebook-input">
                </div>
            </div></td>
        <td width="20%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="Anmelden2" type="submit" value="Absenden">
            <input type="hidden" name="subedit" value="1">
            <div id="ee-responseEdit">&nbsp;</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<br />

<input type="hidden" name="subforgot" value="1">
</form>

<?php
}
?>

</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>