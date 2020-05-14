SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `avtozakaz_ojidanie` (
  `id_client` bigint(20) DEFAULT NULL,
  `ojidanie` varchar(200) DEFAULT NULL,
  `last` varchar(200) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;