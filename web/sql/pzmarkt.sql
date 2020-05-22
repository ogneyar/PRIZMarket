SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `pzmarkt` (
  `id` int(20) NOT NULL,
  `otdel` varchar(100) DEFAULT NULL,
  `format` varchar(20) DEFAULT NULL,
  `file_id` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `kuplu_prodam` varchar(100) DEFAULT NULL,
  `nazvanie` varchar(255) DEFAULT NULL,
  `valuta` varchar(100) DEFAULT NULL,
  `gorod` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `doverie` varchar(100) DEFAULT NULL,
  `podrobno` varchar(100) DEFAULT NULL,
  `time` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;