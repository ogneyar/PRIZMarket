-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 14 2020 г., 10:04
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
-- Структура таблицы `pzmarkt`
--

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
