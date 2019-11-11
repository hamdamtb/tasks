-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.27-0ubuntu0.16.04.1 - (Ubuntu)
-- Операционная система:         Linux
-- HeidiSQL Версия:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных testbeejee
CREATE DATABASE IF NOT EXISTS `testbeejee` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `testbeejee`;

-- Дамп структуры для таблица testbeejee.tasks
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `task` text NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_edited` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы testbeejee.tasks: ~19 rows (приблизительно)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `user_name`, `email`, `task`, `status`, `is_edited`) VALUES
	(13, 'test1', 'test1@test', 'asdasdasdad', 1, 1),
	(14, 'test2', 'test2@test2', 'test2', 1, 0),
	(16, 'test3', 'test3@test3', 'test3', 1, 0),
	(17, 'test4', 'test4@test4', 'test4', 1, 0),
	(18, 'test5', 'test5@test5', 'test5', 1, 0),
	(19, 'test6', 'test6@test6', 'test6', 1, 0),
	(20, 'test7', 'test7@test7', 'test7', 1, 0),
	(21, 'test8', 'test8@test8', 'test9', 1, 0),
	(22, 'test9', 'test9@test9', 'test9', 1, 0),
	(24, 'test10', 'test10@test10', 'test10zxczcz', 1, 1),
	(25, 'test11', 'test11@test11', 'test11', 0, 0),
	(26, 'test12', 'test12@test12', 'test12', 0, 0),
	(27, 'test13', 'test13@test13', 'test13', 0, 0),
	(28, 'test14', 'test14@test14', 'test14', 0, 0),
	(29, 'test15', 'test15@test15', 'test15', 1, 0),
	(30, 'test16', 'test16@test16', 'test16', 1, 0),
	(31, 'test98', 'test998@test98', 'test98', 0, 0),
	(32, 'hamdam', 'hamdam@hamdam', '"asdasda" "" `` `dsdfsdfs`\r\n<script>"czxczxc "asdasdad &&&&alert(‘test’);</script>\r\naslkdja alskdj asdkj asd ad asd ad `kjskdjfhskfhs` sdkfjsdlfjsf \'asdasda\' asdasdasda', 1, 1),
	(33, 'sasasda', 'asdada@sdfsdfs', 'sfsdfs dfs dfs df s <b>asdasdasda</b> `dsdfsdfs` \'sdfsd s\' "sdfsf " ""', 0, 0);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
