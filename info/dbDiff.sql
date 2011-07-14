DROP TABLE `area_groups`, `default`, `default_perm`, `default_subscribe`, `favorites`, `groups`, `sessions`, `subscribe`, `users`, `user_groups`, `view`, `view_thread`;

ALTER TABLE  `vfido_users` ADD  `statReadedMsgsCount` BIGINT NOT NULL DEFAULT  '0';

ALTER TABLE  `areas` ADD  `statReadedMsgsCount` BIGINT NOT NULL DEFAULT  '0';

CREATE TABLE `stat_sessions` (
  `id` bigint(20) NOT NULL auto_increment,
  `uid` bigint(20) NOT NULL,
  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `msgs_readed_in_session` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE `vfido_areaSubscr` (
  `uid` bigint(20) NOT NULL,
  `area` varchar(128) NOT NULL,
  KEY `uid` (`uid`,`area`)
) ENGINE=MyISAM;
