-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 02 2019 г., 19:40
-- Версия сервера: 10.1.36-MariaDB
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kk`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `meetings` (IN `d1` DATE, IN `d2` DATE)  BEGIN
select cm.Name as "Комиссия", mt.time as "Дата", (select GROUP_CONCAT(concat(mm.surname,' ',mm.name) SEPARATOR ', ') from member as mm join meet_mem as meme on (mm.ID_mem=meme.ID_mem) where (meme.ID_meet=mt.ID_meet)) as "Состав" from meeting as mt join commission as cm on (mt.ID_com=cm.ID_com) where (mt.time>d1 and mt.time<d2) order by mt.time;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Missed_meetings` (IN `i` TINYINT, IN `d1` DATE, IN `d2` DATE)  begin
select concat(m.Surname,' ',m.Name) as "Член комиссии",(SELECT((select count(*) from meeting where (ID_com=i and meeting.time>d1 and meeting.time<d2))-(select Count(*) from meet_mem as mm join meeting as me on (me.ID_meet=mm.ID_meet) where (ID_com=i and me.time>d1 and me.time<d2 and mm.ID_mem=mc.ID_mem))))as "Кол-во пропущенных заседаний" from mem_com as mc join member as m on (mc.ID_mem=m.ID_mem) where (ID_com=i and (Enter>d1 and Enter<d2)  or (Exit_mem<d2 and Enter<d2));
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Number_of_meeting` (`d1` DATE, `d2` DATE)  begin
SELECT cm.name as "Комиссия", (select Count(*) from meeting as m where( m.time>d1 and m.time<d2 and cm.ID_com=m.ID_com)) as "Количество заседаний" from commission as cm;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Show_chairmens` (IN `nam` VARCHAR(30) CHARSET cp1251, IN `d1` DATE, IN `d2` DATE)  BEGIN
SELECT concat(mm.surname,' ',mm.name) as "Председатели" from member as mm inner join chairmen as ch on (mm.ID_mem=ch.ID_mem) where (mm.ID_mem=any(select ID_mem from chairmen as ch where (ch.ID_com=(select ID_com from commission where Name=nam limit 1) and ((ch.Enter>d1 and ch.Enter<d2 ) or (ch.Exit_mem>d1 and ch.Exit_mem<d2) ))) ) order by ch.Enter ;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `chairmen`
--

CREATE TABLE `chairmen` (
  `ID_mem` mediumint(8) UNSIGNED NOT NULL,
  `ID_com` mediumint(8) UNSIGNED NOT NULL,
  `Enter` date NOT NULL,
  `Exit_mem` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `chairmen`
--

INSERT INTO `chairmen` (`ID_mem`, `ID_com`, `Enter`, `Exit_mem`) VALUES
(1, 1, '2019-04-01', NULL),
(2, 2, '2019-04-01', NULL),
(8, 3, '2019-04-01', NULL),
(10, 3, '2019-03-19', '2019-03-31'),
(11, 4, '2019-05-06', NULL),
(13, 5, '2019-06-01', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `commission`
--

CREATE TABLE `commission` (
  `ID_com` mediumint(8) UNSIGNED NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `commission`
--

INSERT INTO `commission` (`ID_com`, `Name`) VALUES
(1, 'Город'),
(4, 'Дороги'),
(5, 'Работа'),
(3, 'Сады'),
(2, 'Школа');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `Commissions_members`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `Commissions_members` (
`Комиссия` varchar(20)
,`Председатель` varchar(31)
,`Состав` text
);

-- --------------------------------------------------------

--
-- Структура таблицы `meeting`
--

CREATE TABLE `meeting` (
  `ID_meet` mediumint(8) UNSIGNED NOT NULL,
  `ID_com` mediumint(8) UNSIGNED NOT NULL,
  `place` varchar(30) NOT NULL,
  `time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `meeting`
--

INSERT INTO `meeting` (`ID_meet`, `ID_com`, `place`, `time`) VALUES
(1, 1, 'Moscow', '2019-04-01'),
(2, 1, 'Moscow', '2019-04-10'),
(3, 2, 'Moscow', '2019-04-02'),
(4, 2, 'Moscow', '2019-04-11'),
(5, 3, 'Moscow', '2019-04-03'),
(6, 3, 'Moscow', '2019-04-12'),
(7, 1, 'Moscow', '2019-05-07'),
(8, 2, 'Moscow', '2019-06-01');

-- --------------------------------------------------------

--
-- Структура таблицы `meet_mem`
--

CREATE TABLE `meet_mem` (
  `ID_meet` mediumint(8) UNSIGNED NOT NULL,
  `ID_mem` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `meet_mem`
--

INSERT INTO `meet_mem` (`ID_meet`, `ID_mem`) VALUES
(1, 1),
(2, 1),
(2, 3),
(1, 7),
(5, 8),
(6, 9),
(6, 10),
(7, 1),
(7, 3),
(7, 7),
(7, 11),
(8, 1),
(8, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `member`
--

CREATE TABLE `member` (
  `ID_mem` mediumint(8) UNSIGNED NOT NULL,
  `Surname` varchar(15) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `Second_name` varchar(15) DEFAULT NULL,
  `Adress` varchar(50) NOT NULL,
  `Telephone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `member`
--

INSERT INTO `member` (`ID_mem`, `Surname`, `Name`, `Second_name`, `Adress`, `Telephone`) VALUES
(1, 'Кудратова', 'Хадижат', NULL, '123', '123'),
(2, 'Яким', 'Алексей', NULL, '1234', '1234'),
(3, 'Романова', 'Ангелина', NULL, '123', '123'),
(4, 'Радченко', 'Виолетта', NULL, '1234', '1234'),
(5, 'Банзаракцаева', 'Софья', NULL, '123', '123'),
(6, 'Сидорова', 'Марина', NULL, '123', '123'),
(7, 'Сергиенко', 'Оля', NULL, '123', '123'),
(8, 'Кузнецова', 'Анастасия', NULL, '123', '123'),
(9, 'Шибанова', 'Екатерина', NULL, '123', '123'),
(10, 'Егорова', 'Елизавета', NULL, '123', '123'),
(11, 'Амирханова', 'Сабина', '', '123', '123'),
(12, 'Кушнер', 'Алексей', 'Константинович', '123', '12345'),
(13, 'Кудратова', 'Рамина', '', '1234', '1234');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `Member_commissions`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `Member_commissions` (
`Члены Думы` varchar(31)
,`Комиссии` text
);

-- --------------------------------------------------------

--
-- Структура таблицы `mem_com`
--

CREATE TABLE `mem_com` (
  `ID_mem` mediumint(8) UNSIGNED NOT NULL,
  `ID_com` mediumint(8) UNSIGNED NOT NULL,
  `Enter` date NOT NULL,
  `Exit_mem` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `mem_com`
--

INSERT INTO `mem_com` (`ID_mem`, `ID_com`, `Enter`, `Exit_mem`) VALUES
(1, 1, '2019-04-01', NULL),
(2, 2, '2019-04-01', NULL),
(3, 1, '2019-04-01', NULL),
(4, 2, '2019-04-01', NULL),
(6, 2, '2019-04-01', NULL),
(5, 1, '2019-04-01', NULL),
(7, 3, '2019-04-01', '2019-04-05'),
(8, 3, '2019-04-01', NULL),
(9, 3, '2019-04-01', NULL),
(10, 3, '2019-03-03', NULL),
(7, 1, '2019-04-05', '2019-06-01'),
(1, 2, '2019-04-01', NULL),
(10, 2, '2019-04-01', '2019-04-02'),
(1, 3, '2019-05-05', '2019-05-05'),
(11, 1, '2019-05-05', NULL),
(11, 4, '2019-05-06', NULL),
(12, 4, '2019-05-08', NULL),
(13, 3, '2019-06-01', NULL),
(13, 1, '2019-06-01', NULL),
(13, 5, '2019-06-01', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_user` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(300) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `date_reg` date NOT NULL,
  `salt` varchar(50) NOT NULL,
  `administrator` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_user`, `login`, `password`, `Name`, `date_reg`, `salt`, `administrator`) VALUES
(1, 'kk', '4ce993d8372fa22d906a2fac732defe5', 'КХР', '2019-06-01', 'pjj', 1);

-- --------------------------------------------------------

--
-- Структура для представления `Commissions_members`
--
DROP TABLE IF EXISTS `Commissions_members`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `Commissions_members`  AS  select `cm`.`Name` AS `Комиссия`,(select concat(`member`.`Surname`,' ',`member`.`Name`) from `member` where (`member`.`ID_mem` = `ch`.`ID_mem`)) AS `Председатель`,(select group_concat(concat(`mm`.`Surname`,' ',`mm`.`Name`) separator ', ') from `member` `mm` where (`mm`.`ID_mem` in (select `mem_com`.`ID_mem` from `mem_com` where (`mem_com`.`ID_com` = `ch`.`ID_com`)) and (`mm`.`ID_mem` <> `ch`.`ID_mem`) and isnull((select `mc`.`Exit_mem` from `mem_com` `mc` where ((`mc`.`ID_com` = `ch`.`ID_com`) and (`mm`.`ID_mem` = `mc`.`ID_mem`)))))) AS `Состав` from (`commission` `cm` join `chairmen` `ch` on((`cm`.`ID_com` = `ch`.`ID_com`))) where isnull(`ch`.`Exit_mem`) ;

-- --------------------------------------------------------

--
-- Структура для представления `Member_commissions`
--
DROP TABLE IF EXISTS `Member_commissions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `Member_commissions`  AS  select concat(`mm`.`Surname`,' ',`mm`.`Name`) AS `Члены Думы`,(select group_concat(`cm`.`Name` separator ', ') from `commission` `cm` where `cm`.`ID_com` in (select `mc`.`ID_com` from `mem_com` `mc` where (`mm`.`ID_mem` = `mc`.`ID_mem`))) AS `Комиссии` from `member` `mm` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chairmen`
--
ALTER TABLE `chairmen`
  ADD PRIMARY KEY (`ID_mem`,`ID_com`),
  ADD KEY `FK_ID_com` (`ID_com`);

--
-- Индексы таблицы `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`ID_com`),
  ADD UNIQUE KEY `unique_index` (`Name`);

--
-- Индексы таблицы `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`ID_meet`),
  ADD KEY `meet_com_fk` (`ID_com`);

--
-- Индексы таблицы `meet_mem`
--
ALTER TABLE `meet_mem`
  ADD KEY `FK_meet` (`ID_meet`),
  ADD KEY `FK_mem` (`ID_mem`);

--
-- Индексы таблицы `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`ID_mem`);

--
-- Индексы таблицы `mem_com`
--
ALTER TABLE `mem_com`
  ADD KEY `mem_com_fk` (`ID_mem`),
  ADD KEY `com_mem_fk` (`ID_com`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `chairmen`
--
ALTER TABLE `chairmen`
  ADD CONSTRAINT `FK_ID_com` FOREIGN KEY (`ID_com`) REFERENCES `commission` (`ID_com`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ID_mem` FOREIGN KEY (`ID_mem`) REFERENCES `member` (`ID_mem`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `meeting`
--
ALTER TABLE `meeting`
  ADD CONSTRAINT `meet_com_fk` FOREIGN KEY (`ID_com`) REFERENCES `commission` (`ID_com`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `meet_mem`
--
ALTER TABLE `meet_mem`
  ADD CONSTRAINT `FK_meet` FOREIGN KEY (`ID_meet`) REFERENCES `meeting` (`ID_meet`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_mem` FOREIGN KEY (`ID_mem`) REFERENCES `member` (`ID_mem`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mem_com`
--
ALTER TABLE `mem_com`
  ADD CONSTRAINT `com_mem_fk` FOREIGN KEY (`ID_com`) REFERENCES `commission` (`ID_com`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mem_com_fk` FOREIGN KEY (`ID_mem`) REFERENCES `member` (`ID_mem`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
