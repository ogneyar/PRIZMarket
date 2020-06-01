CREATE TABLE IF NOT EXISTS `vk_url` (
		`id` bigint(20) DEFAULT NULL,
		`url` varchar(200) DEFAULT NULL,
		`url_vk` varchar(200) DEFAULT NULL,
		`vk_file` varchar(200) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
