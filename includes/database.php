<?php
/**
 * Database.php
 * 
 * The Database class is meant to simplify the task of accessing
 * information from the website's database.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 17, 2004
 */

      
class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysql_connect(CO_DB_HOST, CO_DB_USER, CO_DB_PASS) or die(mysql_error());
      mysql_select_db(CO_DB_NAME, $this->connection) or die(mysql_error());
      mysql_query("SET NAMES 'utf8'");
      /**
       * Only query database to find out number of members
       * when getNumMembers() is called for the first time,
       * until then, default value set.
       */
      $this->num_members = -1;
      
      if(TRACK_VISITORS){
         /* Calculate number of users at site */
         $this->calcNumActiveUsers();
      
         /* Calculate number of guests at site */
         $this->calcNumActiveGuests();
      }
   }


   /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserPass($username, $password){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT password,status FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);
	  /* get status */
	  $status = $dbarray['status'];
      /* Validate that password is correct */
      if($password == $dbarray['password']){
         if($status == 0) {
		 	return 3;
		 } else {
		 	return 0; //Success! Username, password and status confirmed
		 }
		 
      }
      else{
         return 2; //Indicates password failure
      }
   }
   
   /**
    * confirmUserID - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given userid is the same userid in the database
    * for that user. If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT userid FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['userid']){
         return 0; //Success! Username and userid confirmed
      }
      else{
         return 2; //Indicates userid invalid
      }
   }
   
   /**
    * usernameTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
   
   /**
    * usernameBanned - Returns true if the username has
    * been banned by the administrator.
    */
   function usernameBanned($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
  
  
   /**
    * emailTaken - Returns true if the email has
    * been taken by another user, false otherwise.
    */
   function emailTaken($email){
      $q = "SELECT email FROM ".TBL_USERS." WHERE email = '$email'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
  
   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewUser($username, $password, $email, $time, $firstname, $surname, $language ){
      //$time = time();
      /* If admin sign up, give admin user level */
      if(strcasecmp($username, ADMIN_NAME) == 0){
         $ulevel = ADMIN_LEVEL;
      }else{
         $ulevel = USER_LEVEL;
      }
      $q = "INSERT INTO ".TBL_USERS." SET username='$username', password='$password', userid='0', userlevel='$ulevel', email='$email', language = '$language', timestamp='$time', status='0', firstname='$firstname', surname='$surname'";
      return mysql_query($q, $this->connection);
   }
   
   function activateUser($pass, $time){
   	  $start = time();
	  $end = strtotime("+45 day", $start);
	  $q = "UPDATE ".TBL_USERS." SET status = '1', registration_date='$start', subscribe_start='$start', subscribe_end='$end' WHERE password = '$pass' and timestamp='$time'";
      return mysql_query($q, $this->connection);
   }
   
   function handleInvitations($pass, $time){
	  $q = "SELECT uid,email FROM ".TBL_USERS." WHERE password = '$pass' and timestamp='$time'";
      $result = mysql_query($q, $this->connection);
	  $user = mysql_fetch_array($result);
	  $uid = $user['uid'];
	  $email = $user['email'];
	  
	  $q = "SELECT id FROM books_shared WHERE sharer_email = '$email'";
      $result = mysql_query($q, $this->connection);
	  while($row = mysql_fetch_array($result)) {
		  $rid = $row['id'];
		  $qr = "UPDATE books_shared SET sharer_id='$uid', sharer_email='' WHERE id='$rid'";
      	$resultr = mysql_query($qr, $this->connection);
	  }
	  
   }
   
   
   /**
    * updateUserField - Updates a field, specified by the field
    * parameter, in the user's row of the database.
    */
   function updateUserField($username, $field, $value){
      $q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$username'";
      return mysql_query($q, $this->connection);
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getUserInfo($username){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      /* Error occurred, return given name by default */
      if(!$result || (mysql_numrows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
   }
   
   /**
    * getNumMembers - Returns the number of signed-up users
    * of the website, banned members not included. The first
    * time the function is called on page load, the database
    * is queried, on subsequent calls, the stored result
    * is returned. This is to improve efficiency, effectively
    * not querying the database when no call is made.
    */
   function getNumMembers(){
      if($this->num_members < 0){
         $q = "SELECT * FROM ".TBL_USERS;
         $result = mysql_query($q, $this->connection);
         $this->num_members = mysql_numrows($result);
      }
      return $this->num_members;
   }
   
   /**
    * calcNumActiveUsers - Finds out how many active users
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveUsers(){
      /* Calculate number of users at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_USERS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_users = mysql_numrows($result);
   }
   
   /**
    * calcNumActiveGuests - Finds out how many active guests
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveGuests(){
      /* Calculate number of guests at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_guests = mysql_numrows($result);
   }
   
   /**
    * addActiveUser - Updates username's last active timestamp
    * in the database, and also adds him to the table of
    * active users, or updates timestamp if already there.
    */
   function addActiveUser($username, $time){
      $q = "UPDATE ".TBL_USERS." SET timestamp = '$time' WHERE username = '$username'";
      mysql_query($q, $this->connection);
      
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('$username', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   /* addActiveGuest - Adds guest to active guests table */
   function addActiveGuest($ip, $time){
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('$ip', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /* These functions are self explanatory, no need for comments */
   
   /* removeActiveUser */
   function removeActiveUser($username){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '$username'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   /* removeActiveGuest */
   function removeActiveGuest($ip){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /* removeInactiveUsers */
   function removeInactiveUsers(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-USER_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }

   /* removeInactiveGuests */
   function removeInactiveGuests(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-GUEST_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
      return mysql_query($query, $this->connection);
   }
   
   
   function checkBookPermissions($book_id, $uid){
      $q = "SELECT id FROM books WHERE id='$book_id' and uid='$uid' UNION ALL SELECT a.id FROM books as a, books_shared as b WHERE a.id='$book_id' and b.sharer_id='$uid' and a.id=b.book_id and a.bin='0'";
		$result = mysql_query($q, $this->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		} else {
			return true;
		}
   }
   
   function getBookOwnerFromWidget($id){
		global $database; 
		$q = "SELECT a.uid FROM " . TBL_BOOKS . " as a, " . TBL_BOOKS_STRUCTURE . " as b, " . TBL_BOOKS_WIDGETS . " as c  WHERE c.id='$id' and c.chapter_id = b.id and b.book_id = a.id";
		$result = mysql_query($q, $this->connection);
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	function getBookOwnerFromStructure($id){
		global $database; 
		$q = "SELECT a.uid FROM " . TBL_BOOKS . " as a, " . TBL_BOOKS_STRUCTURE . " as b  WHERE b.id='$id' and b.book_id = a.id";
		$result = mysql_query($q, $this->connection);
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	function getBookOwnerFromBook($id){
		global $database; 
		$q = "SELECT uid FROM " . TBL_BOOKS . "  WHERE id='$id'";
		$result = mysql_query($q, $this->connection);
		$row = mysql_fetch_row($result);
		return $row[0];
	}

};

/* Create database connection */
$database = new MySQLDB;

?>