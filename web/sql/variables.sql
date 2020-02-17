
CREATE TABLE IF NOT EXISTS `variables` (
	  `id_bota` bigint(20) DEFAULT NULL,
	  `nazvanie` varchar(100) DEFAULT NULL,
	  `soderjimoe` varchar(200) DEFAULT NULL,
	  `opisanie` varchar(500) DEFAULT NULL,
	  `vremya` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
