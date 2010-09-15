DROP TABLE `area_groups`, `default`, `default_perm`, `default_subscribe`, `favorites`, `groups`, `sessions`, `subscribe`, `users`, `user_groups`, `view`, `view_thread`;
ALTER TABLE  `vfido_users` ADD  `statReadedMsgsCount` BIGINT NOT NULL DEFAULT  '0';
ALTER TABLE  `areas` ADD  `statReadedMsgsCount` BIGINT NOT NULL DEFAULT  '0';

