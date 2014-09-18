<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?php echo WEBSITE_TITLE;?></title>
<meta name="description" content="<?php echo WEBSITE_DESCRIPTION;?>" />
<meta name="keywords" content="<?php echo WEBSITE_KEYWORDS;?>" />
<link rel="shortcut icon" href="favicons/favicon.ico" />
<link rel="apple-touch-icon" sizes="57x57" href="favicons/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon" sizes="114x114" href="favicons/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon" sizes="72x72" href="favicons/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="144x144" href="favicons/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon" sizes="60x60" href="favicons/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon" sizes="120x120" href="favicons/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon" sizes="76x76" href="favicons/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="favicons/favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="favicons/favicon-160x160.png" sizes="160x160" />
<link rel="icon" type="image/png" href="favicons/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="favicons/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="favicons/favicon-16x16.png" sizes="16x16" />
<meta name="msapplication-TileColor" content="#ffffff" />
<meta name="msapplication-TileImage" content="favicons/mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="favicons/mstile-70x70.png" />
<meta name="msapplication-square144x144logo" content="favicons/mstile-144x144.png" />
<meta name="msapplication-square150x150logo" content="favicons/mstile-150x150.png" />
<meta name="msapplication-square310x310logo" content="favicons/mstile-310x310.png" />
<meta name="msapplication-wide310x150logo" content="favicons/mstile-310x150.png" />
<meta name="viewport" content="user-scalable=yes, width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/normalize.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" type="text/css" media="screen,projection" />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
<link href="css/jquery-impromptu.min.css" rel="stylesheet">
<link href="css/fileuploader.css" rel="stylesheet">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen,projection" />
</head>
<body>
<div id="header-wrapper">
	<div id="header">
    <div id="logo"><a href="<?php echo CO_WEBSITE_URL;?>" title="<?php echo WEBSITE_TITLE;?>"><img src="/img/logo.png" width="328" height="99" alt="<?php echo WEBSITE_TITLE;?>" /></a></div>
        <div id="navbar">
            <ul>
                <li><a href="<?php echo CO_WEBSITE_URL;?>" title="<?php echo NAV_HOME;?>"><?php echo NAV_HOME;?></a></li>
                <li><a href="<?php echo CO_WEBSITE_URL;?>/ebooks.php" title="<?php echo NAV_EBOOKS;?>"><?php echo NAV_EBOOKS;?></a></li>
                <?php if($session->logged_in){?>
                    <li><a href="<?php echo CO_WEBSITE_URL;?>/myebooks.php" title="<?php echo NAV_MYEBOOKS;?>"><?php echo NAV_MYEBOOKS;?></a></li>
                    <li><a href="<?php echo CO_WEBSITE_URL;?>/account.php" title="<?php echo NAV_ACCOUNT;?>"><?php echo NAV_ACCOUNT;?></a></li>
                    <li><a href="<?php echo CO_WEBSITE_URL;?>/process.php" title="<?php echo NAV_LOGOUT;?>"><?php echo NAV_LOGOUT;?></a></li>
                <?php } else { ?>
                    <li><a href="<?php echo CO_WEBSITE_URL;?>/login.php" title="<?php echo NAV_LOGIN;?>"><?php echo NAV_LOGIN;?></a></li>
                    <li><a href="<?php echo CO_WEBSITE_URL;?>/register.php" title="<?php echo NAV_SIGNUP;?>"><?php echo NAV_SIGNUP;?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>