-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 09, 2025 at 08:16 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `description`, `category`, `topic`, `image`, `author`, `author_image`, `created_at`) VALUES
(1, 'Dolorum optio tempore', 'Politics (from Ancient Greek πολιτικά (politiká) \'affairs of the cities\') is the set of activities that are associated with making decisions in groups, or other forms of power relations among individuals, such as the distribution of status or resources. The branch of social science that studies politics and government is referred to as political science.\r\n\r\nPolitics may be used positively in the context of a \"political solution\" which is compromising and non-violent,[1] or descriptively as \"the art or science of government\", but the word often also carries a negative connotation.[2] The concept has been defined in various ways, and different approaches have fundamentally differing views on whether it should be used extensively or in a limited way, empirically or normatively, and on whether conflict or co-operation is more essential to it.\r\n\r\nA variety of methods are deployed in politics, which include promoting one\'s own political views among people, negotiation with other political subjects, making laws, and exercising internal and external force, including warfare against adversaries.[3][4][5][6][7] Politics is exercised on a wide range of social levels, from clans and tribes of traditional societies, through modern local governments, companies and institutions up to sovereign states, to the international level.\r\n\r\nIn modern states, people often form political parties to represent their ideas. Members of a party often agree to take the same position on many issues and agree to support the same changes to law and the same leaders. An election is usually a competition between different parties.', 'Politics', 'Government', 'assets/img/blog/blog-1.jpg', 'maria', 'assets/img/blog/blog-author.jpg', '2025-05-07 19:40:54'),
(2, 'Nisi magni odit', 'Nisi magni odit consequatur autem nulla dolorem.', 'Sports', 'Football', 'assets/img/blog/blog-2.jpg', 'allisa', 'assets/img/blog/blog-author-2.jpg', '2025-05-07 19:50:54'),
(3, 'Possimus soluta ut id', 'Possimus soluta ut id suscipit ea ut in quo quia et soluta.', 'Entertainment', 'Movies', 'assets/img/blog/blog-3.jpg', 'mark', 'assets/img/blog/blog-author-3.jpg', '2025-05-07 19:34:54'),
(4, 'Non rem rerum', 'Non rem rerum nam cum quo minus olor distincti.', 'Sports', 'Cricket', 'assets/img/blog/blog-4.jpg', 'lisa', 'assets/img/blog/blog-author-4.jpg', '2025-05-07 19:34:54'),
(5, 'Accusamus quaerat', 'Accusamus quaerat aliquam qui debitis facilis consequatur.', 'Politics', 'Elections', 'assets/img/blog/blog-5.jpg', 'denis', 'assets/img/blog/blog-author-5.jpg', '2025-05-07 19:34:54'),
(9, 'Childhood, youth and education', 'Albert Einstein[a] (14 March 1879 – 18 April 1955) was a German-born theoretical physicist who is best known for developing the theory of relativity. Einstein also made important contributions to quantum mechanics.[1][5] His mass–energy equivalence formula E = mc2, which arises from special relativity, has been called \"the world\'s most famous equation\".[6] He received the 1921 Nobel Prize in Physics for his services to theoretical physics, and especially for his discovery of the law of the photoelectric effect.[7]\r\n\r\nBorn in the German Empire, Einstein moved to Switzerland in 1895, forsaking his German citizenship (as a subject of the Kingdom of Württemberg)[note 1] the following year. In 1897, at the age of seventeen, he enrolled in the mathematics and physics teaching diploma program at the Swiss federal polytechnic school in Zurich, graduating in 1900. He acquired Swiss citizenship a year later, which he kept for the rest of his life, and afterwards secured a permanent position at the Swiss Patent Office in Bern. In 1905, he submitted a successful PhD dissertation to the University of Zurich. In 1914, he moved to Berlin to join the Prussian Academy of Sciences and the Humboldt University of Berlin, becoming director of the Kaiser Wilhelm Institute for Physics in 1917; he also became a German citizen again, this time as a subject of the Kingdom of Prussia.[note 1] In 1933, while Einstein was visiting the United States, Adolf Hitler came to power in Germany. Horrified by the Nazi persecution of his fellow Jews,[8] he decided to remain in the US, and was granted American citizenship in 1940.[9] On the eve of World War II, he endorsed a letter to President Franklin D. Roosevelt alerting him to the potential German nuclear weapons program and recommending that the US begin similar research.', 'Investment', 'paper discussion for kids', 'assets/img/blog/_ce0ff27d-3bea-401b-b8b4-6c75b4a97c46.jpeg', 'maria', 'assets/img/blog/blog-author-2.jpg', '2025-05-09 18:59:21'),
(8, 'Albert Einstein', 'Albert Einstein[a] (14 March 1879 – 18 April 1955) was a German-born theoretical physicist who is best known for developing the theory of relativity. Einstein also made important contributions to quantum mechanics.[1][5] His mass–energy equivalence formula E = mc2, which arises from special relativity, has been called \"the world\'s most famous equation\".[6] He received the 1921 Nobel Prize in Physics for his services to theoretical physics, and especially for his discovery of the law of the photoelectric effect.[7]\r\n\r\nBorn in the German Empire, Einstein moved to Switzerland in 1895, forsaking his German citizenship (as a subject of the Kingdom of Württemberg)[note 1] the following year. In 1897, at the age of seventeen, he enrolled in the mathematics and physics teaching diploma program at the Swiss federal polytechnic school in Zurich, graduating in 1900. He acquired Swiss citizenship a year later, which he kept for the rest of his life, and afterwards secured a permanent position at the Swiss Patent Office in Bern. In 1905, he submitted a successful PhD dissertation to the University of Zurich. In 1914, he moved to Berlin to join the Prussian Academy of Sciences and the Humboldt University of Berlin, becoming director of the Kaiser Wilhelm Institute for Physics in 1917; he also became a German citizen again, this time as a subject of the Kingdom of Prussia.[note 1] In 1933, while Einstein was visiting the United States, Adolf Hitler came to power in Germany. Horrified by the Nazi persecution of his fellow Jews,[8] he decided to remain in the US, and was granted American citizenship in 1940.[9] On the eve of World War II, he endorsed a letter to President Franklin D. Roosevelt alerting him to the potential German nuclear weapons program and recommending that the US begin similar research.', 'science', 'paper discussion ', 'assets/img/blog/WhatsApp Image 2025-03-09 at 07.41.17_0dce1be2.jpg', 'admin', 'assets/img/blog/blog-author.jpg', '2025-05-09 17:48:34');

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
  `user_type` enum('admin','user') DEFAULT 'user',
  `author_image` varchar(255) DEFAULT 'assets/img/blog/default-author.jpg',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `user_type`, `author_image`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@example.com', 'admin', 'assets/img/blog/blog-author.jpg', '2025-05-07 19:34:54'),
(2, 'maria', 'f8461b554d59b3014e8ff5165dc62fac', 'maria@example.com', 'user', 'assets/img/blog/blog-author-2.jpg', '2025-05-07 19:34:54'),
(3, 'allisa', '8e302c4ef3274928d5c73dd888b28be1', 'allisa@example.com', 'user', 'assets/img/blog/blog-author-3.jpg', '2025-05-07 19:34:54'),
(4, 'mark', '6d295738eb6579053ac46a9ca1902583', 'mark@example.com', 'user', 'assets/img/blog/blog-author-4.jpg', '2025-05-07 19:34:54'),
(5, 'lisa', 'e9803a706f81a40884b8aeafafb2cfd3', 'lisa@example.com', 'user', 'assets/img/blog/blog-author-5.jpg', '2025-05-07 19:34:54'),
(7, 'test', '827ccb0eea8a706c4c34a16891f84e7b', 'test@gmail.com', 'user', 'assets/img/blog/681e6125deb25-m7mrmjs81btnodbi2oqmts5gbv.png', '2025-05-09 20:10:13');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
