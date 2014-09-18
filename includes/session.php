<?php
error_reporting(E_ALL);
include("config.php");
include_once("language.php");
$lang = detectLanguage();
include("database.php");
include("mailer.php");
include("form.php");
include("functions.php");
include(CO_PATH . "/language/" . $lang . "/system.php");

class Session
{
   var $username;     //Username given on sign-up
   var $userid;       //Random value generated on current login
   var $userlevel;    //The level to which the user pertains
   var $userlang;    //The level to which the user pertains
   var $time;         //Time user was last active (page loaded)
   var $logged_in;    //True if user is logged in, false otherwise
   var $userinfo = array();  //The array holding all user info
   var $url;          //The page url current being viewed
   var $referrer;     //Last recorded site page viewed
   /**
    * Note: referrer should really only be considered the actual
    * page referrer in process.php, any other time it may be
    * inaccurate.
    */

   /* Class constructor */
   function Session(){
      $this->time = time();
      $this->startSession();
   }

   /**
    * startSession - Performs all the actions necessary to 
    * initialize this session object. Tries to determine if the
    * the user has logged in already, and sets the variables 
    * accordingly. Also takes advantage of this page load to
    * update the active visitors tables.
    */
   function startSession(){
      global $database;  //The database connection
      session_start();   //Tell PHP to start the session

      /* Determine if user is logged in */
      $this->logged_in = $this->checkLogin();

      /**
       * Set guest value to users not logged in, and update
       * active guests table accordingly.
       */
      if(!$this->logged_in){
         $this->username = $_SESSION['username'] = GUEST_NAME;
         $this->userlevel = GUEST_LEVEL;
         $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      }
      /* Update users last active timestamp */
      else{
         $database->addActiveUser($this->username, $this->time);

      }
      
      /* Remove inactive visitors from database */
      $database->removeInactiveUsers();
      $database->removeInactiveGuests();
      
      /* Set referrer page */
      if(isset($_SESSION['url'])){
         $this->referrer = $_SESSION['url'];
      }else{
         $this->referrer = "/";
      }

      /* Set current url */
      $this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
   }

   /**
    * checkLogin - Checks if the user has already previously
    * logged in, and a session with the user has already been
    * established. Also checks to see if user has been remembered.
    * If so, the database is queried to make sure of the user's 
    * authenticity. Returns true if the user has logged in.
    */
   function checkLogin(){
      global $database;  //The database connection
      /* Check if user has been remembered */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
         $this->username = $_SESSION['username'] = $_COOKIE['cookname'];
         $this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];
      }

      /* Username and userid have been set and not guest */
      if(isset($_SESSION['username']) && isset($_SESSION['userid']) &&
         $_SESSION['username'] != GUEST_NAME){
         /* Confirm that username and userid are valid */
         if($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0){
            /* Variables are incorrect, user not logged in */
            unset($_SESSION['username']);
            unset($_SESSION['userid']);
            return false;
         }

         /* User is logged in, set class variables */
         $this->userinfo  = $database->getUserInfo($_SESSION['username']);
         $this->username  = $this->userinfo['username'];
         $this->userid    = $this->userinfo['userid'];
         $this->userlevel = $this->userinfo['userlevel'];
		 $this->useremail = $this->userinfo['email'];
		 $this->firstname = $this->userinfo['firstname'];
		 $this->surname = $this->userinfo['surname'];
		 $this->uid = $this->userinfo['uid'];
		 $this->usersubstart = $this->userinfo['subscribe_start'];
		 $this->usersubend = $this->userinfo['subscribe_end'];
		 $this->userlang = $this->userinfo['language'];
		 $this->freereminder = $this->userinfo['free_reminder'];
         return true;
      }
      /* User not logged in */
      else{
         return false;
      }
   }

   /**
    * login - The user has submitted his username and password
    * through the login form, this function checks the authenticity
    * of that information in the database and creates the session.
    * Effectively logging in the user if all goes well.
    */
   function login($subuser, $subpass, $subremember){
      global $database, $form;  //The database and form object

      /* Username error checking */
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, USERNAME_EMPTY);
      }
      else{
         /* Check if username is not alphanumeric */
         if(!preg_match("/^([0-9a-z])*$/i", $subuser)) {
            $form->setError($field, USERNAME_ALPHANUM);
         }
      }

      /* Password error checking */
      $field = "pass";  //Use field name for password
      if(!$subpass){
         $form->setError($field, "* Password not entered");
      }
      
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return false;
      }

      /* Checks that username is in database and password is correct */
      $subuser = stripslashes($subuser);
      $result = $database->confirmUserPass($subuser, md5($subpass));

      /* Check error codes */
      if($result == 1){
         $field = "user";
         $form->setError($field, "* Username not found");
      }
      else if($result == 2){
         $field = "pass";
         $form->setError($field, "* Invalid password");
      }
	  else if($result == 3){
         $field = "pass";
         $form->setError($field, "* Account not activated");
      }
      
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return false;
      }

      /* Username and password correct, register session variables */
      $this->userinfo  = $database->getUserInfo($subuser);
      $this->username  = $_SESSION['username'] = $this->userinfo['username'];
      $this->userid    = $_SESSION['userid']   = $this->generateRandID();
      $this->userlevel = $this->userinfo['userlevel'];
	  //$this->firstname = $this->userinfo['firstname'];
      
      /* Insert userid into database and update active users table */
      $database->updateUserField($this->username, "userid", $this->userid);
      $database->addActiveUser($this->username, $this->time);
      $database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

      /**
       * This is the cool part: the user has requested that we remember that
       * he's logged in, so we set two cookies. One to hold his username,
       * and one to hold his random value userid. It expires by the time
       * specified in constants.php. Now, next time he comes to our site, we will
       * log him in automatically, but only if he didn't log out before he left.
       */
      if($subremember){
         setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   $this->userid,   time()+COOKIE_EXPIRE, COOKIE_PATH);
      }

      /* Login completed successfully */
      return true;
   }

   /**
    * logout - Gets called when the user wants to be logged out of the
    * website. It deletes any cookies that were stored on the users
    * computer as a result of him wanting to be remembered, and also
    * unsets session variables and demotes his user level to guest.
    */
   function logout(){
      global $database;  //The database connection
      /**
       * Delete cookies - the time must be in the past,
       * so just negate what you added when creating the
       * cookie.
       */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
         setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
      }

      /* Unset PHP session variables */
      unset($_SESSION['username']);
      unset($_SESSION['userid']);

      /* Reflect fact that user has logged out */
      $this->logged_in = false;
      
      /**
       * Remove from active users table and add to
       * active guests tables.
       */
      $database->removeActiveUser($this->username);
      $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      
      /* Set user level to guest */
      $this->username  = GUEST_NAME;
      $this->userlevel = GUEST_LEVEL;
   }

   /**
    * register - Gets called when the user has just submitted the
    * registration form. Determines if there were any errors with
    * the entry fields, if so, it records the errors and returns
    * 1. If no errors were found, it registers the new user and
    * returns 0. Returns 2 if registration failed.
    */
   function register($subfirstname,$subsurname,$subuser, $subpass, $subpass2, $subemail, $subagree, $sublang){
      global $database, $form, $mailer;  //The database, form and mailer object
      
      /* Username error checking */
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, USERNAME_EMPTY);
      }
      else{
         /* Spruce up username, check length */
         $subuser = stripslashes($subuser);
         if(strlen($subuser) < 5){
            $form->setError($field, USERNAME_TOOSHORT);
         }
         else if(strlen($subuser) > 30){
            $form->setError($field, USERNAME_TOOLONG);
         }
         /* Check if username is not alphanumeric */
		 else if(!preg_match("/^([0-9a-z])*$/i", $subuser)) {
            $form->setError($field, USERNAME_ALPHANUM);
         }
         /* Check if username is reserved */
         else if(strcasecmp($subuser, GUEST_NAME) == 0){
            $form->setError($field, "* Username reserved word");
         }
         /* Check if username is already in use */
         else if($database->usernameTaken($subuser)){
            $form->setError($field, USERNAME_INUSE);
         }
         /* Check if username is banned */
         else if($database->usernameBanned($subuser)){
            $form->setError($field, USERNAME_BANNED);
         }
      }

      /* Password error checking */
      $field = "pass";  //Use field name for password
      if(!$subpass){
         $form->setError($field, PASSWORD_EMPTY);
      }
      else{
         /* Spruce up password and check length*/
         $subpass = stripslashes($subpass);
         if(strlen($subpass) < 6){
            $form->setError($field, PASSWORT_TOOSHORT);
         }
         /* Check if password is not alphanumeric */
		 else if(!preg_match("/^([0-9a-z])+$/i", ($subpass = trim($subpass)))){
            $form->setError($field, PASSWORD_ALPHANUM);
         }
         /**
          * Note: I trimmed the password only after I checked the length
          * because if you fill the password field up with spaces
          * it looks like a lot more characters than 4, so it looks
          * kind of stupid to report "password too short".
          */
      }
	  
	  /* Password confirm error checking */
      $field = "pass2";  //Use field name for password
      if(!$subpass2){
         $form->setError($field, PASSWORD_EMPTY);
      }
      else{
         /* Spruce up password and check length*/
         $subpass2 = stripslashes($subpass2);
         if($subpass != $subpass2){
            $form->setError($field, PASSWORT_MATCH);
         }
      }
      
      /* Email error checking */
      $field = "email";  //Use field name for email
      if(!$subemail || strlen($subemail = trim($subemail)) == 0){
         $form->setError($field, EMAIL_EMPTY);
      }
      else{
         /* Check if valid email address */
         $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$/i";
         if(!preg_match($regex,$subemail)){
            $form->setError($field, EMAIL_INVALID);
         }
		 /* Check if email is already in use */
         else if($database->emailTaken($subemail)){
            $form->setError($field, EMAIL_INUSE);
         }
         $subemail = stripslashes($subemail);
      }
	  
	  /* agree to T & C */
      $field = "agree";  //Use field name for password
      if($subagree != 1){
         $form->setError($field, ERROR_TERMS);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return 1;  //Errors with form
      }
      /* No errors, add the new account to the */
      else{
	  	$time = time();
		$subfirstname = stripslashes($subfirstname);
		$subsurname = stripslashes($subsurname);
         if($database->addNewUser($subuser, md5($subpass), $subemail, $time, $subfirstname, $subsurname, $sublang)){
            if(EMAIL_WELCOME){
               $mailer->sendActivation($subuser,$subemail,$subpass, $time);
            }
            return 0;  //New user added succesfully
         }else{
            return 2;  //Registration attempt failed
         }
      }
   }
   
   /*
   Activate user
   */
   
   function activate($pass, $time){
   	global $database, $form, $mailer;  //The database, form and mailer object
		$time = base64_decode($time);
   		if($database->activateUser($pass, $time)){
			// check if there are invitations for this user
			$database->handleInvitations($pass, $time);
			return 0;  //New user activated succesfully
		} else {
			return 1;  //activation failed
		}
   }
   /**
    * editAccount - Attempts to edit the user's account information
    * including the password, which it first makes sure is correct
    * if entered, if so and the new password is in the right
    * format, the change is made. All other fields are changed
    * automatically.
    */
   function editAccount($subcurpass, $subnewpass, $subemail, $subfirstname, $subsurname){
      global $database, $form;  //The database and form object
      /* New password entered */
      if($subnewpass){
         /* Current Password error checking */
         $field = "curpass";  //Use field name for current password
         if(!$subcurpass){
            $form->setError($field, PASSWORD_EMPTY);
         }
         else{
            /* Check if password too short or is not alphanumeric */
            $subcurpass = stripslashes($subcurpass);
            if(strlen($subcurpass) < 6 ||
			   !preg_match("/^([0-9a-z])+$/i", ($subcurpass = trim($subcurpass)))){
               $form->setError($field, "* Current Password incorrect");
            }
            /* Password entered is incorrect */
            if($database->confirmUserPass($this->username,md5($subcurpass)) != 0){
               $form->setError($field, "* Current Password incorrect");
            }
         }
         
         /* New Password error checking */
         $field = "newpass";  //Use field name for new password
         /* Spruce up password and check length*/
         $subpass = stripslashes($subnewpass);
         if(strlen($subnewpass) < 6){
            $form->setError($field, PASSWORT_TOOSHORT);
         }
         /* Check if password is not alphanumeric */
         else if(!preg_match("/^([0-9a-z])+$/i", ($subcurpass = trim($subcurpass)))){
            $form->setError($field, PASSWORD_ALPHANUM);
         }
      }
      /* Change password attempted */
      else if($subcurpass){
         /* New Password error reporting */
         $field = "newpass";  //Use field name for new password
         $form->setError($field, PASSWORD_EMPTY);
      }
      
      /* Email error checking */
      $field = "email";  //Use field name for email
      if($subemail && strlen($subemail = trim($subemail)) > 0){
         $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$/i";
         if(!preg_match($regex,$subemail)){
            $form->setError($field, EMAIL_INVALID);
         }
         $subemail = stripslashes($subemail);
      }
      
      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return false;  //Errors with form
      }
      
      /* Update password since there were no errors */
      if($subcurpass && $subnewpass){
         $database->updateUserField($this->username,"password",md5($subnewpass));
      }
      
      /* Change Email */
      if($subemail){
         $database->updateUserField($this->username,"email",$subemail);
      }
	  
	  /* change first name */
      if($subfirstname){
         $database->updateUserField($this->username,"firstname",$subfirstname);
      }
	  
	  /* change surname */
      if($subsurname){
         $database->updateUserField($this->username,"surname",$subsurname);
      }
	  
	  /* change language */
      /*if($sublanguage){
         $database->updateUserField($this->username,"language",$sublanguage);
		 
		 $uid = $this->uid;
		 $q = "SELECT id from orders where userid='$uid'";
		 $result = $database->query($q);
		 while($row = mysql_fetch_array($result)) {
			 $oid = $row["id"];
			 $qd = "UPDATE orders_details set language='$sublanguage' where oid='$oid'";
			 $resultd = $database->query($qd);
			 $qo = "UPDATE orders set language='$sublanguage' where id='$oid'";
			 $resulto = $database->query($qo);
		 }
      }*/
	  
      /* Success! */
      return true;
   }
   
   /**
    * isAdmin - Returns true if currently logged in user is
    * an administrator, false otherwise.
    */
   function isAdmin(){
      return ($this->userlevel == ADMIN_LEVEL ||
              $this->username  == ADMIN_NAME);
   }
   
   /**
    * generateRandID - Generates a string made up of randomized
    * letters (lower and upper case) and digits and returns
    * the md5 hash of it to be used as a userid.
    */
   function generateRandID(){
      return md5($this->generateRandStr(16));
   }
   
   /**
    * generateRandStr - Generates a string made up of randomized
    * letters (lower and upper case) and digits, the length
    * is a specified parameter.
    */
   function generateRandStr($length){
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(0,61);
         if($randnum < 10){
            $randstr .= chr($randnum+48);
         }else if($randnum < 36){
            $randstr .= chr($randnum+55);
         }else{
            $randstr .= chr($randnum+61);
         }
      }
      return $randstr;
   }
   
   function generateEventKEY(){
      return $this->generateRandStr(16);
   }
   
   function checkMagicQuotes($string) {
		if (!get_magic_quotes_gpc()) {
			return addslashes($string);
		} else {
			return $string;
		}
	}
	
	
	
	function checkBookPermissions($book_id){
		global $database; 
		if($database->checkBookPermissions($book_id,$this->uid)) {
			return true;
		} else {
			return false;
		}
	}
	
	function getBookOwnerFromWidget($id){
		global $database; 
		return $database->getBookOwnerFromWidget($id);
	}
	function getBookOwnerFromStructure($id){
		global $database; 
		return $database->getBookOwnerFromStructure($id);
	}
	function getBookOwnerFromBook($id){
		global $database; 
		return $database->getBookOwnerFromBook($id);
	}
	

   
   /*function editSubscription($oid, $name, $phone, $id1, $day1, $time1, $id2, $day2, $time2, $id3, $day3, $time3){
      global $database; 
      $database->editSubOrder($oid, $name, $phone);
	  $database->editSubOrderDetails($id1, $day1, $time1);
	  
	  if($id2 != "") {
		  if($day2 != "" && $time2 != "") {
			$database->editSubOrderDetails($id2, $day2, $time2);
		  } else {
			$database->deleteSubOrderDetails($id2);
		  }
	  } else {
		  if($day2 != "" && $time2 != "") {
			$database->newSubOrderDetails($oid, $day2, $time2, $this->userlang);
		  } 
	  }
	  
	  if($id3 != "") {
		  if($day3 != "" && $time3 != "") {
			$database->editSubOrderDetails($id3, $day3, $time3);
		  } else {
			$database->deleteSubOrderDetails($id3);
		  }
	  } else {
		  if($day3 != "" && $time3 != "") {
			$database->newSubOrderDetails($oid, $day3, $time3, $this->userlang);
		  } 
	  }
	  
      return true;
   }
   
   function cancelSubscription($oid){
      global $database; 
      $database->cancelSubOrder($oid);
	  $database->cancelSubOrderDetails($oid);
      return true;
   }*/
   


function date_engl2mysql($datum) {
    list($tag, $monat, $jahr) = explode(".", $datum);
    return sprintf("%04d-%02d-%02d", $jahr, $monat, $tag);
}

 function date_mysql2engl ($datum) {
	if($datum != "0000-00-00") {
	list($jahr, $monat, $tag) = explode("-", $datum);
	return sprintf("%02d.%02d.%02d", $tag, $monat, $jahr);
	} else {
	return "";
	}
}  

/*function text($x,$z) {
	//$fh = fopen($z, 'r');
	$y = file_get_contents($z);
	//fclose($fh);
	
	$x = $y;
	// Paragraphs and line breaks	
	$x = eregi_replace("\r","",$x);
	$x = eregi_replace("\[t]","<h1>",$x);
	$x = eregi_replace("\[et]\n","</h1>",$x);
	//$x = eregi_replace("\n\n","<br /><br />",$x);
	$x = eregi_replace("\n","<br />",$x);

	$x = eregi_replace("\[i]","<i>",$x);
	$x = eregi_replace("\[ei]","</i>",$x);
	$x = eregi_replace("\[b]","<b>",$x);
	$x = eregi_replace("\[eb]","</b>",$x);
	
	
	$x = ereg_replace( "\[buttonSignUp](.+)\[ebuttonSignUp]", "<div class=\"button\"><a href=\"register.php\">\\1</a></div>", $x);
	
	$x = ereg_replace( "\[l=([-_./a-zA-Z0-9!&%#?,'=:~]+)]". "([-_./a-zA-Z0-9; !&%#?,'=:~]+)\[el]", "<a href=\"\\1\">\\2</a>", $x);
	$x = ereg_replace( "\[anchor]([-_./a-zA-Z0-9; !&%#?,'=:~]+)\[eanchor]", "<a name=\"\\1\"></a>", $x);
	$x = ereg_replace( "\[email=([-_./a-zA-Z0-9!@&%#?,'=:~]+)]". "([-_./a-zA-Z0-9 @!&%#?,'=:~]+)\[eemail]", "<a href=\"mailto:\\1\">\\2</a>", $x);
	$x = ereg_replace("\[img]", "<img src=",$x);
	$x = ereg_replace("\[eimg]"," border='0' align='absmiddle'>",$x);
	
	return($x);
}*/
   
   
};


/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$session = new Session;

/* Initialize form object */
$form = new Form;
?>