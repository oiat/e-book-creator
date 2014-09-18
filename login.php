<?php include("includes/session.php"); ?>
<?php include_once("templates/header.php"); ?>
<div id="content">
    <?php
        if($_SERVER['SCRIPT_NAME'] != "/register.php" && $_SERVER['SCRIPT_NAME'] != "/activate.php") {
        if($session->logged_in){ ?>
		Loged in as:<br /><strong><?php echo($session->username);?></strong><br>
           <?php
		   /*if($session->userlevel == 1) {
		   	$today = time();
			$enddate = $session->usersubend;
			$diff    =   $enddate - $today;
			$days = intval((floor($diff/86400)));
			if($days>0) {
		   	echo "<b>Your subscription is " . $arrangaPackages[$session->userlevel-1]["name"] . "<br />You have " .$days." day(s) left</b>";
			} else {
			echo "<b>Your " . $arrangaPackages[$session->userlevel-1]["name"] . " expired<br />please subscribe</b>";
			}
		   }
		   if($session->userlevel > 1 && $session->userlevel < 6) {
		    echo "<b>Your subscription is " . $arrangaPackages[$session->userlevel-1]["name"] . "</b>";
		   } */?>
<?php 
		if($session->isAdmin()){
              echo "<div style=\"position: absolute; margin-top: 2px; margin-left: -50px;\" class=\"adminlink\"><a href=\"/admin/admin.php\" class=\"adminlink\">Admin</a></div>";
           }
		?><!--<a href="/editaccount.php">Your Account</a> <a href="/process.php">Logout</a>-->
<?php
           
           
        }
        else{
        if($form->num_errors > 0){
           //echo "<font size=\"1\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
        }
        ?>
        <h1>Anmelden</h1>
        <p>Schon registriert? Dann melden Sie sich mit Ihren Benutzerdaten zur Ihrem Benutzerkonto an. Wenn nicht, können Sie sich <br>
        <a href="/register.php">hier kostenfrei registrieren</a>.</p>
        <p>&nbsp;</p>
    <form action="process.php" id="loginform" name="loginform" method="POST">
        <input type="hidden" name="sublogin" value="1">
        <?php if($form->error("user") != "" || $form->error("pass") != "") { echo("<font color='#f44121' class='small-text'>" . INVALID_LOGIN . "</font>"); } ?>
        <table border="0">
  <tr>
    <td width="200"><?php echo(USERNAME);?></td>
    <td height="70">
    <div class="rahmen">
		<div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
			<div class="rahmen-content" style="min-width: 100px; padding: 0;"><input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>" class="ebook-input"></div>
		</div></td>
  </tr>
  <tr>
    <td height="70"><?php echo(PASSWORD);?></td>
    <td>
    <div class="rahmen">
		<div class="rahmen-loch-oben"></div><div class="rahmen-loch-unten"></div>
			<div class="rahmen-content" style="min-width: 100px; padding: 0;"><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>" class="ebook-input"></div>
		</div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>> <?php echo(REMEMBER_ME);?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="50"><input name="Anmelden" type="submit" value="Anmelden"></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><a href="forgotpass.php" class="small-text"><?php echo(FORGOTTEN_PASSWORD);?></a></td>
    </tr>
</table>
        </form>
		<?php
        } 
        } ?>

</div>
<?php include_once("templates/footer.php"); ?>
</body>
</html>
