-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2025 at 10:01 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kml_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `author_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `author` (`author`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `description`, `category`, `topic`, `image`, `author`, `author_image`, `created_at`) VALUES
(1, 'Dolorum optio tempore', 'Politics (from Ancient Greek πολιτικά (politiká) \'affairs of the cities\') is the set of activities that are associated with making decisions in groups, or other forms of power relations among individuals, such as the distribution of status or resources. The branch of social science that studies politics and government is referred to as political science.\r\n\r\nPolitics may be used positively in the context of a \"political solution\" which is compromising and non-violent,[1] or descriptively as \"the art or science of government\", but the word often also carries a negative connotation.[2] The concept has been defined in various ways, and different approaches have fundamentally differing views on whether it should be used extensively or in a limited way, empirically or normatively, and on whether conflict or co-operation is more essential to it.\r\n\r\nA variety of methods are deployed in politics, which include promoting one\'s own political views among people, negotiation with other political subjects, making laws, and exercising internal and external force, including warfare against adversaries.[3][4][5][6][7] Politics is exercised on a wide range of social levels, from clans and tribes of traditional societies, through modern local governments, companies and institutions up to sovereign states, to the international level.\r\n\r\nIn modern states, people often form political parties to represent their ideas. Members of a party often agree to take the same position on many issues and agree to support the same changes to law and the same leaders. An election is usually a competition between different parties.', 'Politics', 'Government', 'assets/img/blog/blog-1.jpg', 'maria', 'assets/img/blog/blog-author.jpg', '2025-05-07 19:40:54'),
(2, 'Nisi magni odit', 'Nisi magni odit consequatur autem nulla dolorem.', 'Sports', 'Football', 'assets/img/blog/blog-2.jpg', 'allisa', 'assets/img/blog/blog-author-2.jpg', '2025-05-07 19:50:54'),
(3, 'Possimus soluta ut id', 'Possimus soluta ut id suscipit ea ut in quo quia et soluta.', 'Entertainment', 'Movies', 'assets/img/blog/blog-3.jpg', 'mark', 'assets/img/blog/blog-author-3.jpg', '2025-05-07 19:34:54'),
(4, 'Non rem rerum', 'Non rem rerum nam cum quo minus olor distincti.', 'Sports', 'Cricket', 'assets/img/blog/blog-4.jpg', 'lisa', 'assets/img/blog/blog-author-4.jpg', '2025-05-07 19:34:54'),
(5, 'Accusamus quaerat', 'Accusamus quaerat aliquam qui debitis facilis consequatur.', 'Politics', 'Elections', 'assets/img/blog/blog-5.jpg', 'denis', 'assets/img/blog/blog-author-5.jpg', '2025-05-07 19:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `author_image` varchar(255) DEFAULT 'assets/img/blog/default-author.jpg',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `author_image`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@example.com', 'assets/img/blog/blog-author.jpg', '2025-05-07 19:34:54'),
(2, 'maria', 'f8461b554d59b3014e8ff5165dc62fac', 'maria@example.com', 'assets/img/blog/blog-author-2.jpg', '2025-05-07 19:34:54'),
(3, 'allisa', '8e302c4ef3274928d5c73dd888b28be1', 'allisa@example.com', 'assets/img/blog/blog-author-3.jpg', '2025-05-07 19:34:54'),
(4, 'mark', '6d295738eb6579053ac46a9ca1902583', 'mark@example.com', 'assets/img/blog/blog-author-4.jpg', '2025-05-07 19:34:54'),
(5, 'lisa', 'e9803a706f81a40884b8aeafafb2cfd3', 'lisa@example.com', 'assets/img/blog/blog-author-5.jpg', '2025-05-07 19:34:54');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
