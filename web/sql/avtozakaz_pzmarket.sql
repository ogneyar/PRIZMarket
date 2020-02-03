-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 03 2020 г., 13:58
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `testerbotoff`
--

-- --------------------------------------------------------

--
-- Структура таблицы `avtozakaz_pzmarket`
--

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
  `url_info_bot` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
