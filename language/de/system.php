<?php
// Overall Site title
define("WEBSITE_TITLE", "E-Book-Creator");
// Meta Tags
define("WEBSITE_DESCRIPTION", "E-Book-Creator");
define("WEBSITE_KEYWORDS", "E-Book-Creator");

// Name for e.g. Emails
define("CO_WEBSITE_NAME", "E-Book-Creator");


// Main Navigation
define("NAV_HOME", "Home");
define("NAV_EBOOKS", "Katalog");
define("NAV_LOGIN", "Anmelden");
define("NAV_MYEBOOKS", "Meine E-Books");
define("NAV_ACCOUNT", "Mein Konto");
define("NAV_SIGNUP", "Registrieren");
define("NAV_LOGOUT", "Abmelden");

// Misc
define("ALREADY_MEMBER", "Login");
define("USERNAME", "Benutzername");
define("PASSWORD", "Passwort");
define("FIRSTNAME", "Vorname");
define("SURNAME", "Nachname");
define("EMAIL", "E-Mail");
define("LANGUAGE", "Sprache");
define("MEMBER_SINCE", "Member since");
define("LOGIN", "Anmelden");
define("FORGOTTEN_PASSWORD", "Passwort vergessen?");
define("REMEMBER_ME", "Angemeldet bleiben?");
define("INVALID_LOGIN", "Unzureichende Anmeldung. Bitte versuchen Sie es erneut:");
define("SUBMIT", "absenden");
define("EDIT", "Bearbeiten");
define("CANCEL", "Abbrechen");

// forgotten password page
define("FORGOTTEN_PASSWORD_TEXT", "Geben Sie Ihren Benutzernamen an und Sie bekommen ein neues Passwort an die hinterlegte E-Mail-Adresse geschickt.");
define("USERNAME_WRONG", "* Der Benutzername existiert nicht");
define("NEW_PASSWORD_GENERATED", "Ein neues Passwort wurde an Ihre E-mail Adresse gesendet.");
define("FORGOTTEN_PW_EMAIL_SUBJECT", "Neues Passwort");
define("FORGOTTEN_PW_EMAIL_TEXT", "Für Ihr Benutzerkonto beim E-Book-Creator wurde ein neues Passwort für Sie generiert.\n\n"
		."Benutzername: %s\n"
		."Neues Passwort: %s\n\n"
		."Sie können das Passwort nach der Anmeldung auf " . CO_WEBSITE_URL . "/login.php unter 'Mein Konto' ändern. \n\n"
		."Ihr E-Book-Creator-Team");


/******************************/
/*    SIGN UP
/******************************/

define("REG_TITLE", "Registrierung");
define("PASSWORD_LETTERS", "(a-z, A-Z, 0-9), 6 Zeichen minimum");
define("PASSWORD_CONFIRM", "Passwort wiederholen");
define("TERMS_CONFIRM", "Ich akzeptiere die <a href=\"/nutzung.php\" target=\"_blank\">Nutzungsbedingungen</a>");

define("REGISTRATION_SUCCESS", "Erfolgreiche Registrierung!");
define("REGISTRATION_SUCCESS_TEXT", "Danke!  Ihre Registrierung war erfolgreich. Sie erhalten in Kürze eine E-Mail um Ihre Registrierung abzuschließen.");

define("REGISTRATION_FAILED", "Anmeldung fehlgeschlagen!");
define("REGISTRATION_FAILED_TEXT", "We're sorry, but an error has occurred. Please try again at a later time.");

define("ALLREADY_REGISTERED", "Sie sind schon registriert!");
define("ALLREADY_REGISTERED_TEXT", "Wie es scheint haben Sie sich schon bei e-book-creator.at angemeldet.");

define("ACTIVATION_EMAIL_SUBJECT", "Anmeldung E-Book-Creator");
define("ACTIVATION_EMAIL_TEXT", "Willkommen bei E-Book-Creator!\n\n"
	   	. "Vielen Dank für Ihre Registrierung. Ihr Konto wurde erfolgreich angelegt. Folgen Sie dem untenstehenden Link, um die Registrierung abzuschließen:\n\n"
		."%s \n\n"
		//."(If the link does not work when you click it, copy and paste it into the address bar in Internet Explorer or another web browser). \n\n"
		."Ihr Benutzername ist \"%s\". Hier geht es zur Anmeldung " . CO_WEBSITE_URL . " \n\n"
		."Bei Fragen: " . CO_WEBSITE_URL . "\n"
		."oder senden Sie uns eine E-mail an " . EMAIL_SUPPORT . "\n\n"
		."Sollte jemand ohne Ihre Zustimmung die Registrierung mit Ihrer Mail-Adresse vorgenommen haben, irgnorieren Sie diese E-Mail einfach. Das Konto wird nicht aktiviert.\n\n"
		."Ihr E-Book-Creator-Team");

define("ACTIVATION_SUCCESS", "<h1>Willkommen bei " . CO_WEBSITE_NAME . "</h1><br />Ihr Konto wurde erfolgreich aktiviert<br /><a href=\"" . CO_WEBSITE_URL . "/login.php\">Zur Anmeldung</a>.");
define("ACTIVATION_ERROR", "<h1>Registrierung Fehlgeschlagen!</h1><br />Leider konten wir Ihr Konto nicht aktivieren.<br />Bitte probieren Sie es erneut.");


/******************************/
/*    MY ACCOUNT 
/******************************/
/*define("ACCOUNT_DETAILS", "Ihr Konto");
define("EDIT_ACCOUNT", "Edit your Account");
define("CURRENT_PASSWORD", "Current Password");
define("NEW_PASSWORD", "New Password");*/


/******************************/
/*    ERROR MESSAGES
/******************************/

define("USERNAME_EMPTY", "* Benutzername ist leer");
define("USERNAME_ALPHANUM", "* Benutzername ist nicht alphanumerisch");
define("USERNAME_TOOSHORT", "* 5 Zeichen minimum");
define("USERNAME_TOOLONG", "* Zu viele Zeichen");
define("USERNAME_INUSE", "* Benutzername existiert schon");
define("USERNAME_BANNED", "* Benutzername wurde gebannt");
define("PASSWORD_EMPTY", "* Passwort ist leer");
define("PASSWORD_ALPHANUM", "* Passwort ist nicht alphanumerisch");
define("PASSWORT_TOOSHORT", "* 6 Zeichen minimum");
define("PASSWORT_MATCH", "* Passwörten sind nicht ident");
define("EMAIL_EMPTY", "* Email leer");
define("EMAIL_INVALID", "* Email ungültig");
define("EMAIL_INUSE", "* Email existiert schon");
define("ERROR_TERMS", "* Nutzungsbedingungen");
/*"* Current Password not entered"
"* Current Password incorrect"
"* New Password too short"
"* New Password not alphanumeric"
"* New Password not entered"*/

define("INVITATION_EMAIL_TEXT", "\n\nSie wurden von %s zur Mitarbeit an einem E-Book eingeladen.\n\n"
		."Melden Sie sich mit Ihrem bestehenden Konto unter " . CO_WEBSITE_URL . " an, um das E-Book zu bearbeiten. \n\n"
		."Bei Fragen: " . CO_WEBSITE_URL . "/faq.php \n"
		."oder senden Sie uns eine E-mail an " . EMAIL_SUPPORT . "\n\n"
		."Ihr E-Book-Creator Team!\n\n");
		
define("NEW_INVITATION_EMAIL_TEXT", "\n\nSie wurden von %s zur Mitarbeit an einem E-Book eingeladen.\n\n"
		."Legen Sie ein neues Konto unter  " . CO_WEBSITE_URL . "/register.php an, um das E-Book zu bearbeiten. \n\n"
		."Bei Fragen: " . CO_WEBSITE_URL . "/faq.php \n"
		."oder senden Sie uns eine E-mail an " . EMAIL_SUPPORT . "\n\n"
		."Ihr E-Book-Creator Team!\n\n");
?>