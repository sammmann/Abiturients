-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 12 2016 г., 10:41
-- Версия сервера: 5.7.13-log
-- Версия PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `abiturients`
--

-- --------------------------------------------------------

--
-- Структура таблицы `abiturient_list`
--

CREATE TABLE `abiturient_list` (
  `abt_id` int(11) NOT NULL,
  `abt_name` varchar(30) NOT NULL,
  `abt_second` varchar(50) NOT NULL,
  `abt_gender` enum('male','female') NOT NULL DEFAULT 'male',
  `abt_group` varchar(5) NOT NULL,
  `abt_email` varchar(30) NOT NULL,
  `abt_points` int(10) NOT NULL,
  `abt_birth_year` year(4) NOT NULL,
  `abt_is_local` tinyint(1) NOT NULL DEFAULT '0',
  `abt_pass` varchar(50) NOT NULL,
  `abt_photo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `abiturient_list`
--

INSERT INTO `abiturient_list` (`abt_id`, `abt_name`, `abt_second`, `abt_gender`, `abt_group`, `abt_email`, `abt_points`, `abt_birth_year`, `abt_is_local`, `abt_pass`, `abt_photo`) VALUES
(1, 'Иван', 'Иванов', 'male', 'фг102', 'i_ivanov@mail.com', 90, 1995, 1, '', NULL),
(2, 'Иван', 'Петров', 'male', 'фг103', 'i_petrov@mail.com', 90, 1995, 1, '', NULL),
(3, 'Иван', 'Сидоров', 'male', 'фг103', 'i_sidorov@mail.com', 99, 1995, 0, '', NULL),
(4, 'Сидор', 'Иванов', 'male', 'фг102', 's_ivanov@mail.com', 133, 1995, 0, '', NULL),
(5, 'Сергей', 'Сидоров', 'male', 'фг102', 'i_sidorov@mail.com', 121, 1995, 0, '', NULL),
(6, 'Алефтина', 'Иванова', 'female', 'фг103', 'a_ivanova@mail.com', 91, 1995, 1, '', NULL),
(7, 'Ольга', 'Сидорова', 'female', 'фг103', 'o_sid@mail.com', 135, 1995, 0, '', NULL),
(8, 'Сергей', 'Сергеев', 'male', 'фг102', 's_s@mail.com', 101, 1995, 1, '', NULL),
(9, 'Иван', 'Сергеев', 'male', 'фг102', 'i_serg@mail.com', 111, 1995, 0, '', NULL),
(10, 'Анна', 'Иванова', 'female', 'фг103', 'a_ivanova@mail.com', 141, 1995, 0, '', NULL),
(11, 'Алексей', 'Баранкин', 'male', 'фг103', 'barank@mail.ru', 113, 1996, 1, '', NULL),
(12, 'Яков', 'Курицын', 'male', 'фг102', 'kura@mail.ru', 98, 1995, 0, '', NULL),
(13, 'Иван', 'Куев', 'male', 'фг103', 'i_kuev@mail.com', 98, 1995, 0, '', NULL),
(14, 'Иван', 'Пиструнов', 'male', 'фг102', 'i_piss@mail.com', 109, 1995, 1, '', NULL),
(15, 'Аркадия', 'Якова', 'female', 'фг103', 'a_jakova@mail.com', 115, 1996, 1, '', NULL),
(16, 'Сергей', 'Сергеенко', 'male', 'фг103', 's_serg@mail.ru', 102, 1995, 0, '', NULL),
(17, 'Ивана', 'Алексеева', 'female', 'фг102', 'i_alekseeva@mail.com', 95, 1995, 1, '', NULL),
(18, 'Яков', 'Галкин', 'male', 'фг102', 'ja_ga@mail.ru', 119, 1996, 0, '', NULL),
(19, 'Мария', 'Пятка', 'female', 'фг103', 'ma_pa@mail.ru', 91, 1995, 0, '', NULL),
(20, 'Олег', 'Андреев', 'male', 'фг102', 'ole_and@mail.com', 112, 1995, 0, 'YKre82TAK6BrThrT8sHiADhQNDAKSDf7', '2icAUePEF2o.jpg'),
(21, 'Виталий', 'Жданов', 'male', 'фг102', 'v_jdan@mail.com', 90, 1995, 1, '2zSe7kQZGn7esZdiDRaQSsrFrEYB5G7E', '02Vbx0szsVI.jpg'),
(22, 'Фогот', 'Фозий', 'male', 'фг103', 'f_fozii@mail.com', 111, 1995, 0, 'ADHyA7SSYeaG89TY8nGSr7Ri2R4HdGtR', '0hBF_9atKyY.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `abiturient_list`
--
ALTER TABLE `abiturient_list`
  ADD PRIMARY KEY (`abt_id`),
  ADD KEY `abt_name` (`abt_name`),
  ADD KEY `abt_points` (`abt_points`),
  ADD KEY `abt_second` (`abt_second`),
  ADD KEY `abt_group` (`abt_group`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `abiturient_list`
--
ALTER TABLE `abiturient_list`
  MODIFY `abt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
