-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2014 at 09:32 AM
-- Server version: 5.5.31
-- PHP Version: 5.4.4-14+deb7u8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `testLiving`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comment_user1` (`user_id`),
  KEY `fk_comment_post1` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `infos`
--

CREATE TABLE IF NOT EXISTS `infos` (
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `category` varchar(4) NOT NULL,
  `uname` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`email`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `infos`
--

INSERT INTO `infos` (`email`, `password`, `category`, `uname`) VALUES
('fongohmartin@gmail.com', '688549e381deb1928075e5b6f9532ec6e683e10ae5751e49be6922c98fe35a3c0af6e2ee', 'U', 'fongoh'),
('root@rootmail.com', '7b24afc8bc80e548d66c4e7ff72171c5e683e10ae5751e49be6922c98fe35a3c0af6e2ee', 'U', 'root');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `type` varchar(4) NOT NULL,
  `vote_value` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `item` varchar(45) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_user1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `date`, `type`, `vote_value`, `user_id`, `item`, `title`) VALUES
(65, '2014-06-13', 'img', 0, 29, 'img/post_photos/P0041_16-09-13.JPG', 'Fongoh Martin'),
(66, '2014-06-13', 'img', 0, 29, 'img/post_photos/P0046_16-09-13.JPG', 'Me again'),
(67, '2014-06-13', 'img', 0, 29, 'img/post_photos/DSC00102.JPG', 'derick and martin'),
(68, '2014-06-13', 'img', 0, 29, 'img/post_photos/DSC01330.JPG', 'In my cabarn'),
(69, '2014-06-13', 'img', 0, 29, 'img/post_photos/dopper.gif', 'what is this monkey doing like that?');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_infos1` (`email`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(29, 'fongohmartin@gmail.com', '688549e381deb1928075e5b6f9532ec6e683e10ae5751e49be6922c98fe35a3c0af6e2ee'),
(30, 'root@rootmail.com', '7b24afc8bc80e548d66c4e7ff72171c5e683e10ae5751e49be6922c98fe35a3c0af6e2ee');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`post_id`),
  KEY `fk_user_has_post_post1` (`post_id`),
  KEY `fk_user_has_post_user1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_post1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_post_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_infos1` FOREIGN KEY (`email`, `password`) REFERENCES `infos` (`email`, `password`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk_user_has_post_post1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_post_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
