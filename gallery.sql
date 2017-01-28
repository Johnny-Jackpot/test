-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Січ 28 2017 р., 14:52
-- Версія сервера: 5.7.14
-- Версія PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `gallery`
--

-- --------------------------------------------------------

--
-- Структура таблиці `log`
--

CREATE TABLE `log` (
  `id` int(2) NOT NULL,
  `type` int(2) NOT NULL,
  `target` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `log`
--

INSERT INTO `log` (`id`, `type`, `target`, `date`) VALUES
(1, 2, 'D:\\wamp\\www/app', '2017-01-28 14:41:42'),
(2, 2, 'log', '2017-01-28 14:42:03'),
(3, 2, 'D:\\wamp\\www/app', '2017-01-28 14:42:06');

-- --------------------------------------------------------

--
-- Структура таблиці `operation`
--

CREATE TABLE `operation` (
  `id` int(2) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `operation`
--

INSERT INTO `operation` (`id`, `type`) VALUES
(1, 'create'),
(2, 'read'),
(3, 'update'),
(4, 'delete'),
(5, 'img auto resize');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Індекси таблиці `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `log`
--
ALTER TABLE `log`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`type`) REFERENCES `operation` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
