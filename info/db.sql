-- области сообщений
CREATE TABLE IF NOT EXISTS `areas` (
  `area` varchar(128) NOT NULL default '',
  `recieved` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `messages` bigint(20) NOT NULL default '0',
  UNIQUE KEY `area` (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `area_groups`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `area_groups` (
  `area` varchar(128) NOT NULL default '',
  `group` int(11) NOT NULL default '0',
  UNIQUE KEY `area` (`area`),
  KEY `group` (`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `default`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `default` (
  `key` varchar(64) default NULL,
  `value` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `default_perm`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `default_perm` (
  `group` bigint(20) NOT NULL default '0',
  `perm` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `default_subscribe`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `default_subscribe` (
  `group` bigint(20) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(255) NOT NULL default '0',
  `point` int(64) NOT NULL default '0',
  `message` varchar(64) NOT NULL default '',
  `uniq_index` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`uniq_index`),
  KEY `point` (`point`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
-- сообщения

CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(64) NOT NULL auto_increment,
  `fromname` varchar(255) NOT NULL default '',
  `fromaddr` text NOT NULL,
  `toname` varchar(255) NOT NULL default '',
  `toaddr` text NOT NULL,
  `area` varchar(128) NOT NULL default '',
  `subject` text NOT NULL,
  `text` longtext NOT NULL,
  `pktfrom` text NOT NULL,
  `date` text NOT NULL,
  `attr` blob NOT NULL,
  `secure` text NOT NULL,
  `msgid` varchar(128) NOT NULL default '',
  `reply` varchar(128) NOT NULL default '',
  `hash` varchar(64) NOT NULL default '',
  `recieved` datetime NOT NULL default '0000-00-00 00:00:00',
  `thread` varchar(128) NOT NULL default '',
  `level` bigint(20) default NULL,
  `inthread` bigint(20) default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `hash` (`hash`),
  KEY `thread` (`thread`),
  KEY `area` (`area`),
  KEY `fromname` (`fromname`),
  KEY `toname` (`toname`),
  KEY `inthread` (`inthread`),
  KEY `msgid` (`msgid`),
  KEY `reply` (`reply`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73390 ;

-- --------------------------------------------------------

--
-- Структура таблицы `outbox`
-- исходящие - сообщения отсюда парсятся скриптом и уходят в Фидо

CREATE TABLE IF NOT EXISTS `outbox` (
  `id` bigint(64) NOT NULL auto_increment,
  `fromname` text NOT NULL,
  `toname` text NOT NULL,
  `subject` text NOT NULL,
  `text` longtext NOT NULL,
  `fromaddr` text NOT NULL,
  `toaddr` text NOT NULL,
  `origin` text NOT NULL,
  `area` text NOT NULL,
  `reply` varchar(128) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hash` varchar(64) NOT NULL default '',
  `sent` tinyint(1) default '0',
  `approve` binary(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `sessions` (
  `active` tinyint(1) NOT NULL default '0',
  `ip` varchar(100) NOT NULL default '',
  `id` int(128) NOT NULL auto_increment,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `point` bigint(64) NOT NULL default '0',
  `sessionid` varchar(100) NOT NULL default '',
  `browser` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Структура таблицы `subscribe`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `subscribe` (
  `point` bigint(20) NOT NULL default '0',
  `area` varchar(128) NOT NULL default '',
  `subscribed` tinyint(1) NOT NULL default '0',
  KEY `point` (`point`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `threads`
-- трэды в конференциях используется

CREATE TABLE IF NOT EXISTS `threads` (
  `area` varchar(128) NOT NULL default '',
  `thread` varchar(128) NOT NULL default '',
  `hash` varchar(128) NOT NULL default '',
  `subject` text NOT NULL,
  `author` varchar(128) NOT NULL default '',
  `author_address` varchar(128) NOT NULL default '',
  `author_date` varchar(128) NOT NULL default '',
  `last_author` varchar(128) NOT NULL default '',
  `last_author_address` varchar(128) NOT NULL default '',
  `last_author_date` varchar(128) NOT NULL default '',
  `num` bigint(20) NOT NULL default '0',
  `lastupdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  UNIQUE KEY `area_2` (`area`,`thread`),
  KEY `area` (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `users` (
  `point` int(64) NOT NULL auto_increment,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `origin` text NOT NULL,
  `limit` bigint(20) NOT NULL default '0',
  `close_old_session` tinyint(1) NOT NULL default '1',
  `registred` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastlog` datetime NOT NULL default '0000-00-00 00:00:00',
  `jid` varchar(255) NOT NULL default '',
  `confirm` varchar(64) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`point`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_groups`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `user_groups` (
  `point` int(64) NOT NULL default '0',
  `group` int(11) NOT NULL default '0',
  `perm` int(1) NOT NULL default '0',
  UNIQUE KEY `point_2` (`point`,`group`),
  KEY `point` (`point`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `vfido_users`
-- Пользователи

CREATE TABLE IF NOT EXISTS `vfido_users` (
  `uid` bigint(20) NOT NULL,
  `firstname` varchar(200) character set utf8 collate utf8_unicode_ci NOT NULL,
  `lastname` varchar(200) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `view`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `view` (
  `point` int(64) NOT NULL default '0',
  `area` varchar(128) NOT NULL default '',
  `last_view_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_view_message` varchar(64) NOT NULL default '',
  UNIQUE KEY `point` (`point`,`area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `view_thread`
-- Из wFido - не используется

CREATE TABLE IF NOT EXISTS `view_thread` (
  `point` bigint(20) NOT NULL default '0',
  `area` varchar(128) NOT NULL default '',
  `thread` varchar(128) NOT NULL default '',
  `last_view_date` datetime NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY `point` (`point`,`area`,`thread`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

