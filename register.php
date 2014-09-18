<?php include("includes/session.php"); ?>
<?php include_once("templates/header.php"); ?>
<div id="content">
	<?php
/**
 * The user is already logged in, not allowed to register.
 */
if($session->logged_in){?>

<h1><?php echo(ALLREADY_REGISTERED);?></h1>
  <?php
   echo "<p>" . ALLREADY_REGISTERED_TEXT . "</p>";
}
/**
 * The user has submitted the registration form and the
 * results have been processed.
 */
else if(isset($_SESSION['regsuccess'])){ ?>
  <?php
   /* Registration was successful */
   if($_SESSION['regsuccess']){ ?>
<h1><?php echo REGISTRATION_SUCCESS;?></h1><p>&nbsp;</p>
      <?php echo "<p>" . REGISTRATION_SUCCESS_TEXT . "</p>";
   }
   /* Registration failed */
   else{ ?>
<h1><?php echo REGISTRATION_FAILED;?></h1><p>&nbsp;</p>
  <?php echo "<p>" . REGISTRATION_FAILED_TEXT . "</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);

/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
} else{ ?>
  <h1><?php echo(REG_TITLE);?></h1>
  <p>&nbsp;</p>
  <p>Nur ein paar Angaben und Sie können den E-Book-Creator nutzen.
Nach dem Absenden Ihrer Daten erhalten Sie eine E-Mail mit einem Freischaltlink. Nach Bestätigung dieses Links können Sie sich <a href="/login.php">zum E-Book-Creator anmelden</a>.</p>
  <p>&nbsp;</p>
            <form name="signup" action="process.php" method="POST">
  <input type="hidden" name="subjoin" value="1">
  <input type="hidden" name="language" value="<?php echo($lang);?>">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="20%" height="70"><?php echo(FIRSTNAME);?></td>
  <td width="30%">
  	<div class="rahmen" style="mar"><div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div><div class="rahmen-content" style="min-width: 100px; padding: 0;">
    <input name="firstname" type="text" class="ebook-input" id="firstname" value="<?php echo $form->value("firstname"); ?>" /></div></div></td>
  <td width="20%"><?php echo(SURNAME);?></td>
  <td width="30%">
  <div class="rahmen" style="mar"><div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div><div class="rahmen-content" style="min-width: 100px; padding: 0;">
  <input name="surname" type="text" class="ebook-input" id="surname" value="<?php echo $form->value("surname"); ?>" /></div></div></td>
  </tr>
  <tr>
  <td height="70"><?php echo(USERNAME);?> <?php echo $form->error("user"); ?></td>
  <td>
  <div class="rahmen" style="mar"><div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div><div class="rahmen-content" style="min-width: 100px; padding: 0;">
  <input name="user" type="text" class="ebook-input" id="user" value="<?php echo $form->value("user"); ?>" maxlength="30" /></div></div></td>
  <td><?php echo(EMAIL);?> <?php echo $form->error("email"); ?></td>
  <td>
  <div class="rahmen" style="mar"><div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div><div class="rahmen-content" style="min-width: 100px; padding: 0;">
  <input type="text" name="email" maxlength="50" value="<?php echo $form->value("email"); ?>" class="ebook-input" /></div></div></td>
  </tr>
  <tr>
  <td height="70"><?php echo(PASSWORD);?> <?php echo $form->error("pass"); ?></td>
  <td>
  <div class="rahmen" style="mar"><div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div><div class="rahmen-content" style="min-width: 100px; padding: 0;">
  <input class="ebook-input" type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>" /></div></div></td>
  <td><?php echo(PASSWORD_CONFIRM);?> <?php echo $form->error("pass2"); ?></td>
  <td>
  <div class="rahmen" style="mar"><div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div><div class="rahmen-content" style="min-width: 100px; padding: 0;">
  <input type="password" name="pass2" maxlength="30" value="<?php echo $form->value("pass2"); ?>" class="ebook-input" /></div></div></td>
  </tr>
  <tr>
      <td>&nbsp;</td>
      <td><em><?php echo(PASSWORD_LETTERS);?></em></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
  
<tr>
  <td height="50">
      <p>&nbsp;</p></td>
  <td colspan="3"><input type="checkbox" name="agree" id="agree" value="1" style="margin: 0; padding: 0;" /> 
      <?php echo TERMS_CONFIRM;?>
      <?php echo $form->error("agree"); ?></td>
  </tr>
<tr><td>&nbsp;</td>
    <td><input name="Anmelden" type="submit" value="Registrieren"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
          

<?php
}
?>

</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>