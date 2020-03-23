
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `site_users` (
		  `login` varchar(100) DEFAULT NULL,
		  `password` varchar(100) DEFAULT NULL,
		  `email` varchar(200) DEFAULT NULL,
		  `podtverjdenie` varchar(10) DEFAULT NULL,
		  `vremya` bigint(20) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";