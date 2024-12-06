-- Database: `assignment2` and php web application user
CREATE DATABASE assignment2;
GRANT USAGE ON *.* TO 'group7'@'localhost' IDENTIFIED BY 'group7';
GRANT ALL PRIVILEGES ON assignment2.* TO 'group7'@'localhost';
FLUSH PRIVILEGES;

USE assignment2;
--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(20) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(8) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `books` (
  `email` varchar(20) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `title` varchar(200),
  `wantType` varchar(1) NOT NULL,
  `startDate` DATETIME,
  `endDate` DATETIME,
  `review` VARCHAR(1000),
  `rating` SMALLINT,
  PRIMARY KEY (`email`, `isbn`),
  FOREIGN KEY (`email`) REFERENCES users (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `userName`, `password`) VALUES
('group7@abc.com', 'Group7', 'abcd1234');
