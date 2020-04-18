
--
-- База данных: `testerbotoff`
--

-- --------------------------------------------------------

--
-- Структура таблицы `market_ojidanie`
--

CREATE TABLE IF NOT EXISTS `market_ojidanie` (
  `id_client` bigint(20) DEFAULT NULL,
  `ojidanie` varchar(200) DEFAULT NULL,
  `last` varchar(200) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
