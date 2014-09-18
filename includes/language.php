<?php
function detectLanguage() {
	$lang = WO_LANG_DEFAULT;
	
	if(WO_LANG_ARRAY != "") {
		// there's a language cookie
		if (isset($_COOKIE['wolang']) && $_COOKIE['wolang'] != "") {
			$lang = $_COOKIE['wolang'];
		}
		
		/*if($session->logged_in){
		$lang = $session->userinfo['language'];
		}*/
		
		// lang is set through url
		if (isset($_GET["lang"]) && $_GET["lang"] != '') {
			$language = $_GET["lang"];
			$active_lang = explode(',', WO_LANG_DEFAULT.','.WO_LANG_ARRAY);
				if(in_array($language, $active_lang) ) {
					$lang = $language;
				}
				
		// no language chooses - assume from browser configuration
		} else if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) && $_SERVER["HTTP_ACCEPT_LANGUAGE"] != "") {
			$active_lang = explode(',', WO_LANG_ARRAY);
			$browser_lang = explode(',', $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
			
				foreach( $browser_lang as $language ) {
					$language = substr( $language, 0, 2 );
					if( in_array($language, $active_lang) ) {
						$lang = $language;
						break;
					}
				}
		}
	}
	// set locale for this ISO code
	setlocale(LC_ALL, $lang);
	setcookie( "wolang", $lang, time()+24*3600, '/' );
	
	return $lang;
}
?>