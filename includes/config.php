<?php
define("CO_WEBSITE_URL", "http://e-book-creator.at");
define("CO_WEBSITE_URL_REL", "/");
define("CO_WEBSITE_DOMAIN", "e-book-creator.at");
define("CO_PATH", "/home/ebook/public_html");
define("CO_UPLOAD_FOLDER", "/uploads/");

/* -------------------------------------------------------------------------
* Database Configuration
* -------------------------------------------------------------------------*/
define("CO_DB_HOST", "localhost");
define("CO_DB_USER", "ebook");
define("CO_DB_PASS", "");
define("CO_DB_NAME", "ebook");

define("WO_LANG_DEFAULT", "de");
define("WO_LANG_EN", "Deutsch");
define("WO_LANG_ARRAY", "");


/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
define("TBL_USERS", "users");
define("TBL_USER_LOG", "user_log");
define("TBL_ACTIVE_USERS",  "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS",  "banned_users");

define("TBL_BOOKS", "books");
define("TBL_BOOKS_USERS", "books_users");
define("TBL_BOOKS_STRUCTURE", "books_structure");
define("TBL_BOOKS_STRUCTURE_USERS", "books_structure_users");
define("TBL_BOOKS_WIDGETS", "books_widgets");
define("TBL_BOOKS_WIDGETS_USERS", "books_widgets_users");


/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level. Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */
define("ADMIN_NAME", "admin");
define("GUEST_NAME", "Guest");
define("ADMIN_LEVEL", 9);
define("USER_LEVEL",  1);
define("GUEST_LEVEL", 0);

/**
 * This boolean constant controls whether or
 * not the script keeps track of active users
 * and active guests who are visiting the site.
 */
define("TRACK_VISITORS", true);

/**
 * Timeout Constants - these constants refer to
 * the maximum amount of time (in minutes) after
 * their last page fresh that a user and guest
 * are still considered active visitors.
 */
define("USER_TIMEOUT", 10);
define("GUEST_TIMEOUT", 5);

/**
 * Cookie Constants - these are the parameters
 * to the setcookie function call, change them
 * if necessary to fit your website. If you need
 * help, visit www.php.net for more info.
 * <http://www.php.net/manual/en/function.setcookie.php>
 */
define("COOKIE_EXPIRE", 60*60*24*100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain

/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
define("EMAIL_FROM_NAME", "E-Book-Creator");
define("EMAIL_FROM_ADDR", "support@e-book-creator.at");
define("EMAIL_WELCOME", true);
define("EMAIL_SUPPORT", "support@e-book-creator.at");

// Licenses
$LICENSE[0] = 'nicht im Katalog';
$LICENSE[1] = 'CC by SA';
$LICENSE[2] = 'CC 0';


/**
 * This constant forces all users to have
 * lowercase usernames, capital letters are
 * converted automatically.
 */
define("ALL_LOWERCASE", false);
?>
