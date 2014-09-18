<?php
//check for Magic Quote settings
function checkMagicQuotes($string) {
	if (!get_magic_quotes_gpc()) {
		return addslashes($string);
	} else {
		return $string;
	}
}
?>