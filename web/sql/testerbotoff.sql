-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 28 2019 г., 12:39
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
-- Структура таблицы `culc`
--

CREATE TABLE IF NOT EXISTS `culc` (
  `id_client` int(20) DEFAULT NULL,
  `id` int(20) DEFAULT NULL,
  `knopka` varchar(10) DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `zpt` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) DEFAULT NULL,
  `id_client` int(20) DEFAULT NULL,
  `name_client` varchar(15) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `id_client`, `name_client`, `status`, `flag`) VALUES
(1, 351009636, 'Ogneyar', 'admin', 0),
(2, 298466355, 'Otrad', 'admin', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `zayavka`
--

CREATE TABLE IF NOT EXISTS `zayavka` (
  `id_client` int(15) DEFAULT NULL,
  `id_zakaz` int(20) DEFAULT NULL,
  `vibor` varchar(10) DEFAULT NULL,
  `monet` varchar(20) DEFAULT NULL,
  `kol_monet` double DEFAULT NULL,
  `valuta` varchar(20) DEFAULT NULL,
  `cena` double DEFAULT NULL,
  `itog` double DEFAULT NULL,
  `bank` text,
  `flag_isp` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
