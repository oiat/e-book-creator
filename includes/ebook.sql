SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `active_guests` (
  `ip` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `active_users` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `banned_users` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `books` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `edition` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `country` tinyint(3) NOT NULL,
  `chapterlabels` tinyint(1) NOT NULL,
  `ebooks` tinyint(1) NOT NULL,
  `license` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL,
  `is_template` tinyint(1) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_shared` (
`id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `sharer_id` int(11) NOT NULL,
  `sharer_email` varchar(250) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_structure` (
`id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `book_id` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_structure_users` (
`id` int(11) NOT NULL,
  `book_temp_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `type` varchar(100) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_to_categories` (
`id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_to_targets` (
`id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_users` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `edition` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `country` tinyint(3) NOT NULL,
  `chapterlabels` tinyint(1) NOT NULL,
  `ebooks` tinyint(1) NOT NULL,
  `license` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL,
  `is_template` tinyint(1) NOT NULL,
  `temp_title` varchar(100) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_widgets` (
`id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `content2` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `sort` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_date` datetime NOT NULL,
  `bin` tinyint(1) NOT NULL,
  `saved` tinyint(1) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `books_widgets_users` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `structure_temp_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `content2` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_date` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `categories` (
`id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `targets` (
`id` int(11) NOT NULL,
  `target` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
`uid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `userlevel` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL DEFAULT '0',
  `registration_date` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `language` varchar(2) NOT NULL,
  `location` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `lang` varchar(2) NOT NULL,
  `free_reminder` tinyint(1) NOT NULL DEFAULT '0',
  `subscribe_start` int(11) unsigned DEFAULT NULL,
  `subscribe_end` int(11) unsigned DEFAULT NULL,
  `subscribe_id` varchar(30) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


ALTER TABLE `active_guests`
 ADD PRIMARY KEY (`ip`);

ALTER TABLE `active_users`
 ADD PRIMARY KEY (`username`);

ALTER TABLE `banned_users`
 ADD PRIMARY KEY (`username`);

ALTER TABLE `books`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`), ADD KEY `is_template` (`is_template`);

ALTER TABLE `books_shared`
 ADD PRIMARY KEY (`id`), ADD KEY `book_id` (`book_id`), ADD KEY `sharer_id` (`sharer_id`), ADD KEY `sharer_email` (`sharer_email`);

ALTER TABLE `books_structure`
 ADD PRIMARY KEY (`id`), ADD KEY `book_id` (`book_id`), ADD KEY `sort` (`sort`), ADD KEY `bin` (`bin`);

ALTER TABLE `books_structure_users`
 ADD PRIMARY KEY (`id`), ADD KEY `book_id` (`chapter_id`), ADD KEY `sort` (`sort`), ADD KEY `uid` (`uid`);

ALTER TABLE `books_to_categories`
 ADD PRIMARY KEY (`id`), ADD KEY `book_id` (`book_id`,`cat_id`), ADD KEY `cat_id` (`cat_id`);

ALTER TABLE `books_to_targets`
 ADD PRIMARY KEY (`id`), ADD KEY `book_id` (`book_id`,`target_id`), ADD KEY `target_id` (`target_id`);

ALTER TABLE `books_users`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`), ADD KEY `is_template` (`is_template`);

ALTER TABLE `books_widgets`
 ADD PRIMARY KEY (`id`), ADD KEY `chapter_id` (`chapter_id`), ADD KEY `sort` (`sort`), ADD KEY `bin` (`bin`);

ALTER TABLE `books_widgets_users`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`);

ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `targets`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`uid`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
