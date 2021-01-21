-- --------------------------------------------------------
-- Host:                         85.214.34.117
-- Server Version:               10.1.47-MariaDB-0ubuntu0.18.04.1 - Ubuntu 18.04
-- Server Betriebssystem:        debian-linux-gnu
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportiere Datenbank Struktur für api
CREATE DATABASE IF NOT EXISTS `api` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `api`;

-- Exportiere Struktur von Tabelle api.actions
CREATE TABLE IF NOT EXISTS `actions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `tweetID` int(11) NOT NULL,
  `action_type` varchar(25) CHARACTER SET utf8 NOT NULL,
  `content` varchar(240) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__tweets` (`tweetID`),
  CONSTRAINT `FK__tweets` FOREIGN KEY (`tweetID`) REFERENCES `tweets` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle api.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TweetID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Content` char(240) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `TweetID` (`TweetID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle api.like2comment
CREATE TABLE IF NOT EXISTS `like2comment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CommentID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CommentID` (`CommentID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle api.like2tweet
CREATE TABLE IF NOT EXISTS `like2tweet` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TweetID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `TweetID` (`TweetID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle api.tweets
CREATE TABLE IF NOT EXISTS `tweets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` varchar(240) CHARACTER SET utf8 NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Likes` int(11) NOT NULL DEFAULT '0',
  `Retweets` int(11) NOT NULL DEFAULT '0',
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle api.user
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Follower` int(11) NOT NULL DEFAULT '0',
  `Follows` int(11) NOT NULL DEFAULT '0',
  `Tweets` int(11) NOT NULL DEFAULT '0',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `workID` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle api.user2user
CREATE TABLE IF NOT EXISTS `user2user` (
  `UserID` int(11) NOT NULL,
  `UserToFollowID` int(11) NOT NULL,
  KEY `UserID_UserToFollowID` (`UserID`,`UserToFollowID`),
  KEY `UserToFollowID` (`UserToFollowID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
