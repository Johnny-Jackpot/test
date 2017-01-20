-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Січ 20 2017 р., 02:03
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
(165, 2, 'log', '2017-01-20 00:48:29'),
(166, 2, 'D:\\wamp\\www/app', '2017-01-20 00:48:42'),
(167, 2, 'D:\\wamp\\www/app', '2017-01-20 00:59:39'),
(168, 2, 'D:\\wamp\\www/app', '2017-01-20 01:00:53'),
(169, 2, 'D:\\wamp\\www/app', '2017-01-20 01:11:08'),
(170, 2, 'D:\\wamp\\www/app', '2017-01-20 01:12:20'),
(171, 2, 'D:\\wamp\\www/app', '2017-01-20 01:12:55'),
(172, 2, 'D:\\wamp\\www/app', '2017-01-20 01:13:14'),
(173, 2, 'D:\\wamp\\www/app', '2017-01-20 01:13:53'),
(174, 2, 'D:\\wamp\\www/app', '2017-01-20 01:15:29'),
(175, 2, 'D:\\wamp\\www/app', '2017-01-20 01:16:13'),
(176, 2, 'D:\\wamp\\www/app', '2017-01-20 01:16:49'),
(177, 2, 'D:\\wamp\\www/app', '2017-01-20 01:21:44'),
(178, 2, 'D:\\wamp\\www/app', '2017-01-20 01:22:31'),
(179, 2, 'D:\\wamp\\www/app', '2017-01-20 01:23:17'),
(180, 2, 'D:\\wamp\\www/app', '2017-01-20 01:27:58'),
(181, 2, 'D:\\wamp\\www/app', '2017-01-20 01:30:31'),
(182, 2, 'D:\\wamp\\www/app', '2017-01-20 01:31:13'),
(183, 2, 'D:\\wamp\\www/app', '2017-01-20 01:31:59'),
(184, 2, 'D:\\wamp\\www/app', '2017-01-20 01:32:54'),
(185, 2, 'D:\\wamp\\www/app', '2017-01-20 01:32:58'),
(186, 2, 'D:\\wamp\\www/app', '2017-01-20 01:33:17'),
(187, 2, 'D:\\wamp\\www/app', '2017-01-20 01:41:21'),
(188, 2, 'D:\\wamp\\www/app', '2017-01-20 01:42:00'),
(189, 2, 'D:\\wamp\\www/app', '2017-01-20 01:42:42'),
(190, 2, 'D:\\wamp\\www/app', '2017-01-20 01:50:58'),
(191, 2, 'D:\\wamp\\www/app', '2017-01-20 01:54:53'),
(192, 2, 'D:\\wamp\\www/app', '2017-01-20 02:02:47');

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
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;
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
