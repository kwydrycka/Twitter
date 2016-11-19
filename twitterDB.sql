-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2016 at 12:40 AM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `twitterDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(60) NOT NULL,
  `creationDate` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `tweetId` int(11) NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `userId` (`userId`),
  KEY `tweetId` (`tweetId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `Comment`
--

INSERT INTO `Comment` (`commentId`, `text`, `creationDate`, `userId`, `tweetId`) VALUES
(1, 'super', '2016-10-28 22:09:06', 17, 9),
(2, 'super', '2016-10-28 22:10:42', 17, 9),
(3, 'super 2', '2016-10-28 22:11:17', 17, 9),
(4, 'super', '2016-10-28 22:11:39', 17, 10),
(5, 'super', '2016-10-28 22:12:34', 17, 10),
(6, 'jjjj', '2016-10-28 22:13:03', 17, 10),
(7, 'hhhhhhhhhhhh', '2016-10-28 22:16:31', 17, 10),
(8, 'hhhhhhhhhhhh', '2016-10-28 22:18:31', 17, 10),
(9, 'uuuu iii oooo', '2016-10-28 22:21:27', 17, 10),
(10, ':)', '2016-10-28 22:22:27', 17, 10),
(11, ';P', '2016-10-28 22:24:08', 17, 10),
(12, '8', '2016-10-28 22:25:34', 17, 8),
(13, 'stary stary stary', '2016-10-28 22:28:38', 17, 8),
(14, 'lu lu lu lu', '2016-10-28 22:30:24', 17, 8),
(15, 'kwiatek', '2016-10-28 23:08:31', 9, 9),
(16, 'grrrrrrrr!', '2016-10-28 23:12:15', 9, 11),
(17, 'czarne oczy', '2016-10-28 23:31:20', 9, 5),
(18, 'czerwony', '2016-10-28 23:31:42', 9, 2),
(19, 'biaÅ‚y', '2016-10-28 23:31:49', 9, 2),
(20, 'Mi mi mi', '2016-10-28 23:31:59', 9, 6),
(21, 'znowu?', '2016-10-28 23:32:12', 9, 5),
(22, 'more more more zzzz....', '2016-10-28 23:50:45', 48, 13),
(23, '????', '2016-10-29 01:00:30', 1, 7),
(24, ':)))))))))', '2016-10-29 01:00:37', 1, 7),
(25, 'taaaaaaaaak', '2016-10-29 01:01:57', 11, 14),
(26, 'dobry dobry :)', '2016-10-29 01:02:09', 11, 11),
(27, 'cichy', '2016-10-29 01:02:35', 11, 9),
(28, 'tu jestesm', '2016-10-29 01:03:24', 10, 15),
(29, 'Pani Wydra?', '2016-10-29 01:06:12', 16, 14),
(30, 'sia la la la la', '2016-10-29 01:06:25', 16, 10),
(31, 'Å›pisz?', '2016-10-29 01:06:51', 16, 5),
(32, 'dobry wieczor ', '2016-11-20 00:27:56', 49, 22),
(33, '4567 ha ha ha ha', '2016-11-20 00:28:16', 49, 19),
(34, 'no piÄ™knie', '2016-11-20 00:30:37', 2, 23),
(35, ':(', '2016-11-20 00:38:44', 50, 24),
(36, 'zasypiamy nad klawiaturÄ…', '2016-11-20 00:39:17', 50, 22);

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `messageId` int(11) NOT NULL AUTO_INCREMENT,
  `creationDate` datetime NOT NULL,
  `isRead` tinyint(1) DEFAULT NULL,
  `recipientUserId` int(11) NOT NULL,
  `senderUserId` int(11) NOT NULL,
  `text` text,
  PRIMARY KEY (`messageId`),
  KEY `recipientUserId` (`recipientUserId`),
  KEY `senderUserId` (`senderUserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Messages`
--

INSERT INTO `Messages` (`messageId`, `creationDate`, `isRead`, `recipientUserId`, `senderUserId`, `text`) VALUES
(1, '2016-10-29 00:18:56', 0, 9, 48, 'testowy'),
(2, '2016-10-29 00:20:47', 0, 9, 48, 'testowy 2'),
(3, '2016-10-29 00:23:51', 0, 17, 48, 'nowa wiadomoÅ›Ä‡ do Ciebie'),
(4, '2016-10-29 00:25:32', 0, 1, 48, ':)'),
(5, '2016-10-29 00:26:03', 1, 1, 48, 'klklklk nmnmnmn\r\nooooo pppp'),
(6, '2016-10-29 01:00:13', 1, 1, 1, 'test do siebie'),
(7, '2016-10-29 01:03:39', 0, 11, 10, 'raz dwa trzy'),
(8, '2016-10-29 01:03:48', 0, 11, 10, 'raz osiem dwa'),
(9, '2016-10-29 01:04:22', 0, 11, 16, 'hello world'),
(10, '2016-10-29 01:08:11', 0, 10, 16, '?'),
(11, '2016-11-20 00:29:01', 1, 1, 49, 'coz za piekny i chlodny wieczor.:)))'),
(12, '2016-11-20 00:30:59', 1, 49, 2, 'kogo moje piÄ™kne oczy widzÄ…'),
(13, '2016-11-20 00:32:20', 1, 2, 49, 'To chyba pomyÅ‚ka'),
(14, '2016-11-20 00:38:32', 0, 2, 50, 'zdrÃ³wka'),
(15, '2016-11-20 00:39:02', 0, 1, 50, 'A gdzie Pani siÄ™ podziaÅ‚a?');

-- --------------------------------------------------------

--
-- Table structure for table `Tweet`
--

CREATE TABLE IF NOT EXISTS `Tweet` (
  `tweetId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `text` varchar(140) NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`tweetId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `Tweet`
--

INSERT INTO `Tweet` (`tweetId`, `userId`, `text`, `creationDate`) VALUES
(1, 47, 'zisiaj bylo piekne slonko!', '2016-10-27 16:51:29'),
(2, 47, 'zisiaj byla piekna pogoda', '2016-10-27 16:53:06'),
(3, 47, 'Dzisiaj byla piekna pogoda', '2016-10-27 16:55:19'),
(4, 47, 'la la la la la', '2016-10-27 17:00:49'),
(5, 47, 'komu komu, bo ide do domu :)', '2016-10-27 17:01:35'),
(6, 47, 'komu komu, bo ide do domu :)', '2016-10-27 17:02:46'),
(7, 47, 'baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaardzo dlugi komentarz gggggggggggggggggggg', '2016-10-28 13:55:43'),
(8, 1, 'nowy nowy nowy nowy', '2016-10-28 14:14:39'),
(9, 3, 'piekny wieczÃ³r', '2016-10-28 17:47:54'),
(10, 14, 'la la la la la!!!!:))))', '2016-10-28 20:01:24'),
(11, 17, 'dobry wieczÃ³r', '2016-10-28 21:23:21'),
(12, 9, 'Porrraaa na dobranoc bo juÅ¼ ksiÄ™Å¼yc Å›wieci...', '2016-10-28 23:32:34'),
(13, 48, 'zzzzz....', '2016-10-28 23:50:30'),
(14, 1, 'czas goni nas goni nas...', '2016-10-29 01:01:20'),
(15, 11, 'gdzie jest zosia?', '2016-10-29 01:02:51'),
(16, 16, 'dobre wieÅ›cie :)', '2016-10-29 01:04:39'),
(17, 16, 'Dobranoc wszystkim', '2016-10-29 01:07:05'),
(18, 10, 'nowy tweet', '2016-10-29 01:08:30'),
(19, 1, '123...', '2016-10-29 12:35:09'),
(20, 1, '456..', '2016-10-29 12:35:19'),
(21, 1, '456..', '2016-10-29 12:35:22'),
(22, 1, 'ggggggg tttt', '2016-10-29 12:35:38'),
(23, 49, 'Witam!', '2016-11-20 00:29:25'),
(24, 2, 'Kolejny piekny dzien. ChorÃ³bsko vs ja 1:0 :/', '2016-11-20 00:30:26'),
(25, 50, 'czary czary czary', '2016-11-20 00:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hashedPassword` varchar(255) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`userId`, `userName`, `email`, `hashedPassword`) VALUES
(1, 'Kasia', 'kasia@gmail.com', '$2y$10$TlKLH5fLHKbTB1G3kFhPFOFnJj4th.ZIsUutNNMYTp4hs9lYSJuHi'),
(2, 'Monika', 'monika@gmail.com', '$2y$10$nogAz5jn7DBEOidY2fkM2OnXr7oabl3p34Yyxntfr4VZsNUGo0aAO'),
(3, 'kamil', 'kamil@gmail.com', '$2y$10$DU2ako/xqLc6magljHCpFuw2.6Lvop27S4swFA0.f3U.L08/DEXfC'),
(9, 'piotr', 'piotr@gmail.com', '$2y$10$IJOyEfvcFoIhcEs8d3i8XulEhqxhg6k1Zz4WXffFIEVOYeAiHqbcm'),
(10, 'zosia', 'zosia@gmail.com', '$2y$10$XKbLXxA8OwMkpwwWA.AqB.R1mhsDerr2BaPy9vHgq/gJ46r3O3Fpq'),
(11, 'bogdan', 'bogdan@gmail.com', '$2y$10$hRXnk59G6tAh22evYQ4b.uPVZQSySyOwiWr0zNnJvF9IOLq5i.X0G'),
(12, 'marek', 'marek@gmail.com', '$2y$10$mus0js0sMaoLgaGm7h5sVuHN/52haLQcODuAImn0fNzt4OXwzG1ae'),
(13, 'agnieszka', 'agnieszka@gmail.com', '$2y$10$Vpt.YjaRqKs7KpoY8DvLOuabV.We6RkESCSUaNtabTbIX8Q.fAkW2'),
(14, 'jola', 'jola@gmail.com', '$2y$10$eIrx4Ku104lj3Yz0NM6z4.pWqC34cZjPx3QC3UP8nCK7e/Lpqz1Ci'),
(15, 'antek', 'antek@gmail.com', '$2y$10$FlM6HgELNhP41O9IAoQ9iOCZMj56NTjU/VpQPtPmiqKui8nU/Y1W6'),
(16, 'Karol', 'karol@gmail.com', '$2y$10$3kTINFFULWAwXQs/jt62C.tiuhYW1e5YvKQ/TvOgwwc34Ua7W9dJi'),
(17, 'kamila', 'kamila@gmail.com', '$2y$10$vLZaVFXGQqcPqaHsHTJoU.gqIEtLy83gAI8drV8ioQFAWoG6s4BtO'),
(47, 'jeremi', 'jeremi@gmail.com', '$2y$10$MVJH/C.pzjt2kRDWm5V6J.XN/y7HEsDxCxuUJZMMJs2cdPf1OcYN6'),
(48, 'michal', 'michal@gmail.com', '$2y$10$yAYW/K88Nm48IEuJRHHFP.p82SknhXMo596tQytDzgASm136Vctze'),
(49, 'karol4', 'karol4@mail.com', '$2y$10$f1F2i2ov9Q.YlaBk/2GBgerIFY7VSojj/M5XGZXkU6udEpd9hGyDW'),
(50, 'wojtek', 'wojtek@gmail.com', '$2y$10$B03MIcVnIkIlOw5M.b3W.OyYQtIrG.um5P9wutOdvRkPv4DGgZHCq');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `Users` (`userId`),
  ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`tweetId`) REFERENCES `Tweet` (`tweetId`) ON DELETE CASCADE;

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`recipientUserId`) REFERENCES `Users` (`userId`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`senderUserId`) REFERENCES `Users` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `Tweet`
--
ALTER TABLE `Tweet`
  ADD CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `Users` (`userId`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
