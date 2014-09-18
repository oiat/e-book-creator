<?php
class Mailer
{
   /**
    * sendWelcome - Sends a welcome message to the newly
    * registered user, also supplying the username and
    * password.
    */
   function sendWelcome($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
	  $from .= "MIME-Version: 1.0\n";
	  $from .= "Content-Type: text/plain; charset=utf-8\r\n" .
        	 "Content-Transfer-Encoding: 8bit\r\n\r\n"; 
      $subject = "Jpmaster77's Site - Welcome!";
      $body = $user.",\n\n"
             ."Welcome! You've just registered at Jpmaster77's Site "
             ."with the following information:\n\n"
             ."Username: ".$user."\n"
             ."Password: ".$pass."\n\n"
             ."If you ever lose or forget your password, a new "
             ."password will be generated for you and sent to this "
             ."email address, if you would like to change your "
             ."email address you can do so by going to the "
             ."My Account page after signing in.\n\n"
             ."- Jpmaster77's Site";

      return mail($email,$subject,$body,$from);
   }
   
   
    /**
    * sendActivation - Sends a activation message to the newly
    * registered user to activate the account
    * password.
    */
   
function sendActivation($user, $email, $pass, $time){
	$url = CO_WEBSITE_URL . '/activate.php?hash='.md5($pass).'&stamp='.base64_encode($time);
	$from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\n";
	$from .= "MIME-Version: 1.0\n";
	$from .= "Content-Type: text/plain; charset=utf-8\n" .
        	 "Content-Transfer-Encoding: 8bit\n\n"; 
	$subject = ACTIVATION_EMAIL_SUBJECT;
	$body = sprintf(ACTIVATION_EMAIL_TEXT, $url, $user);
	return mail($email,$subject,$body,$from);
}

function sendInvitation($sendername, $sender, $to, $message){
	$url = CO_WEBSITE_URL . '/register.php';
	$from = "From: ".$sendername." <".$sender.">\n";
	$from .= "MIME-Version: 1.0\n";
	$from .= "Content-Type: text/plain; charset=utf-8\n" .
        	 "Content-Transfer-Encoding: 8bit\n\n"; 
	$subject = $sendername . " ladet Sie zur Mitarbeit an einem E-Book ein";
	$body = $message;
	$body .= sprintf(INVITATION_EMAIL_TEXT, $sendername, $to);
	return mail($to,$subject,$body,$from);
}
function sendInvitationNew($sendername, $sender, $to, $message){
	$url = CO_WEBSITE_URL . '/register.php';
	$from = "From: ".$sendername." <".$sender.">\n";
	$from .= "MIME-Version: 1.0\n";
	$from .= "Content-Type: text/plain; charset=utf-8\n" .
        	 "Content-Transfer-Encoding: 8bit\n\n"; 
	$subject = $sendername . " ladet Sie zur Mitarbeit an einem E-Book ein";
	$body = $message;
	$body .= sprintf(NEW_INVITATION_EMAIL_TEXT, $sendername, $to);
	return mail($to,$subject,$body,$from);
}

   
   /**
    * sendNewPass - Sends the newly generated password
    * to the user's email address that was specified at
    * sign-up.
    */
   function sendNewPass($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\n";
	  $from .= "MIME-Version: 1.0\n";
	  $from .= "Content-Type: text/plain; charset=utf-8\n" .
        	   "Content-Transfer-Encoding: 8bit\n\n"; 
      $subject = CO_WEBSITE_NAME . " " . FORGOTTEN_PW_EMAIL_SUBJECT;
	  $body = sprintf(FORGOTTEN_PW_EMAIL_TEXT, $user, $pass);
             
      return mail($email,$subject,$body,$from);
   }
   
};

/* Initialize mailer object */
$mailer = new Mailer;
 
?>
