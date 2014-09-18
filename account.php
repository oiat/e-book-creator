<?php include("includes/session.php"); ?>
<?php include_once("templates/header.php"); ?>
<div id="content">
<h1>Mein Konto</h1>
  <p>&nbsp;</p>
  <p>Auf dieser Seite lassen sich die hinterlegten Benutzerdaten einsehen und, mit Ausnahme des Benutzernamens, ändern.</p>
  <p>&nbsp;</p>
<?php
/**
 * User has submitted form without errors and user's
 * account has been edited successfully.
 */
if($session->logged_in){
?>

    <form id="editForm" action="process.php" method="POST">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
            <td width="20%" height="70"><?php echo(USERNAME);?></td>
            <td width="30%"><?php echo $session->username; ?></td>
            <td width="20%"><?php echo(EMAIL);?><?php echo $form->error("email"); ?></td>
            <td width="30%"><div class="rahmen" style="mar">
                <div class="rahmen-loch-oben"></div>
                <div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px; padding: 0;">
                    <input type="text" name="email" maxlength="50" value="<?php if($form->value("email") == ""){
       echo($session->userinfo['email']);
    }else{
       echo($form->value("email"));
    }
    ?>" class="ebook-input" />
                </div>
            </div></td>
        </tr>
        <tr>
            <td height="70"><?php echo(FIRSTNAME);?> <?php echo $form->error("firstname"); ?></td>
            <td><div class="rahmen" style="mar">
                <div class="rahmen-loch-oben"></div>
                <div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px; padding: 0;">
                    <input type="text" name="firstname" maxlength="50" value="<?php if($form->value("firstname") == ""){
       echo $session->userinfo['firstname'];
    }else{
       echo $form->value("firstname");
    }
    ?>" class="ebook-input" />
                </div>
            </div></td>
            <td><?php echo(SURNAME);?> <?php echo $form->error("surname"); ?></td>
            <td><div class="rahmen" style="mar">
                <div class="rahmen-loch-oben"></div>
                <div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px; padding: 0;">
                    <input type="text" name="surname" maxlength="50" value="<?php if($form->value("surname") == ""){
       echo $session->userinfo['surname'];
    }else{
       echo $form->value("surname");
    }
    ?>" class="ebook-input" />
                </div>
            </div></td>
        </tr>
        <tr>
            <td height="70">Aktuelles Passwort <?php echo $form->error("curpass"); ?></td>
            <td><div class="rahmen" style="mar">
                <div class="rahmen-loch-oben"></div>
                <div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px; padding: 0;">
                    <input type="password" name="curpass" maxlength="30" value="<?php echo $form->value("curpass"); ?>" class="ebook-input" />
                </div>
            </div></td>
            <td>Neues Passwort <?php echo $form->error("newpass"); ?></td>
            <td><div class="rahmen" style="mar">
                <div class="rahmen-loch-oben"></div>
                <div class="rahmen-loch-unten"></div>
                <div class="rahmen-content" style="min-width: 100px; padding: 0;">
                    <input type="password" name="newpass" maxlength="30" value="<?php echo $form->value("newpass"); ?>" class="ebook-input" />
                </div>
            </div></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><em><?php echo(PASSWORD_LETTERS);?></em></td>
            <td>&nbsp;</td>
            <td><em><?php echo(PASSWORD_LETTERS);?></em></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input name="Anmelden2" type="submit" value="Speichern"><input type="hidden" name="subedit" value="1"> <div id="ee-responseEdit">&nbsp;</div></td>
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