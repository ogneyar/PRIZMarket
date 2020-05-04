SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `avtozakaz_pzmarket` (
  `id_client` bigint(20) DEFAULT NULL,
  `id_zakaz` int(20) DEFAULT NULL,
  `kuplu_prodam` varchar(100) DEFAULT NULL,
  `nazvanie` varchar(500) DEFAULT NULL,
  `url_nazv` varchar(200) DEFAULT NULL,
  `valuta` varchar(100) DEFAULT NULL,
  `gorod` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `doverie` tinyint(1) DEFAULT NULL,
  `otdel` varchar(100) DEFAULT NULL,
  `format_file` varchar(20) DEFAULT NULL,
  `file_id` varchar(200) DEFAULT NULL,
  `url_podrobno` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `podrobno` blob,
  `url_tgraph` varchar(200) DEFAULT NULL,
  `foto_album` tinyint(1) DEFAULT NULL,
  `url_info_bot` varchar(200) DEFAULT NULL,
  `date` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;