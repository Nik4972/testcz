-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 10 2019 г., 15:09
-- Версия сервера: 5.6.35-1+deb.sury.org~xenial+0.1-log
-- Версия PHP: 7.2.15-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testcz`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cards`
--

CREATE TABLE `cards` (
  `id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cards`
--

INSERT INTO `cards` (`id`, `name`, `status`) VALUES
(1, '6795896784', 1),
(2, '1473788963', 1),
(3, '9479140705', 1),
(4, 'b567c90kft', 1),
(5, 'ma74lf92mt', 1),
(6, 'msnr834bsп', 1),
(7, '59054kndvf', 1),
(8, 'klm4560982', 1),
(9, 'l63l78mk4u', 0),
(10, '2893ksjdhf', 0),
(11, 'eklf3494kj', 0),
(12, 'kewj834ds8', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tovar`
--

CREATE TABLE `tovar` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tovar`
--

INSERT INTO `tovar` (`id`, `name`, `price`) VALUES
(1, 'Tovar 1', 10),
(2, 'Tovar 2', 20),
(3, 'Tovar 3', 30),
(4, 'Tovar 4', 40),
(5, 'Tovar 5', 50),
(6, 'Tovar 6', 15),
(7, 'Tovar 7', 25),
(8, 'Tovar 8', 35),
(9, 'Tovar 9', 5),
(10, 'Tovar 10', 58);

-- --------------------------------------------------------

--
-- Структура таблицы `trash`
--

CREATE TABLE `trash` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `tovarid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kol` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `summa` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `trash`
--

INSERT INTO `trash` (`id`, `userid`, `tovarid`, `name`, `kol`, `price`, `summa`, `created_at`) VALUES
(1, 28, 3, 'Tovar 3', 3, 30, 90, '2019-02-10 11:31:34'),
(2, 28, 1, 'Tovar 1', 5, 10, 50, '2019-02-10 11:32:14'),
(3, 28, 10, 'Tovar 10', 10, 58, 580, '2019-02-10 11:49:51'),
(4, 28, 6, 'Tovar 6', 6, 15, 90, '2019-02-10 11:50:09'),
(5, 28, 1, 'Tovar 1', 1, 10, 10, '2019-02-10 11:55:27'),
(6, 28, 1, 'Tovar 1', 1, 10, 10, '2019-02-10 11:55:37'),
(7, 28, 1, 'Tovar 1', 1, 10, 10, '2019-02-10 11:59:01'),
(8, 1, 1, 'Tovar 1', 1, 10, 10, '2019-02-10 12:00:34'),
(9, 1, 4, 'Tovar 4', 3, 40, 120, '2019-02-10 12:02:07'),
(10, 28, 1, 'Tovar 1', 1, 10, 10, '2019-02-10 14:11:53'),
(11, 28, 1, 'Tovar 1', 1, 10, 10, '2019-02-10 14:39:24'),
(12, 1, 8, 'Tovar 8', 12, 35, 420, '2019-02-10 14:39:58');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `fam` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name2` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dr` date NOT NULL,
  `email` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `card_id` int(5) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fam`, `name`, `name2`, `dr`, `email`, `username`, `password`, `card_id`, `created_at`) VALUES
(1, 'Ivanov', 'Ivan', 'Ivanovich', '1964-07-29', 'ivanov@ukr.net', 'ivanov', 'ivanov', 4, '2016-11-06 22:46:02'),
(2, 'Karakukino', 'Izya', 'Abramovicho', '1900-01-01', 'kara@ukr.net', 'karakum', 'karakum', 1, '2017-03-29 15:37:02'),
(3, 'Semenov', 'Semen', 'Semenovich', '2017-04-01', 'semenov@ukr.net', 'abonent', 'abonent', 5, '2017-09-14 17:12:56'),
(4, 'Administrator', 'Admin', 'Adminovich', '2017-09-01', 'admin@ukr.net', 'admin', 'admin', 2, '2017-09-01 00:00:00'),
(28, 'Петров', 'Петр', 'Петрович', '1976-01-01', 'petrov@gmail.com', 'petrov', 'petrov', 3, '2019-02-09 17:04:08'),
(29, 'Кульман', 'Изя', 'Маркович', '1970-09-25', 'kulman@ukr.net', 'kulman', 'kulman', 7, '2019-02-09 21:29:09'),
(31, 'Малый', 'Игорь', 'Савельевич', '2000-01-09', 'maliy@gmail.com', 'maliy', 'maliy', 8, '2019-02-10 14:36:06');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tovar`
--
ALTER TABLE `tovar`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `trash`
--
ALTER TABLE `trash`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `tovar`
--
ALTER TABLE `tovar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `trash`
--
ALTER TABLE `trash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
