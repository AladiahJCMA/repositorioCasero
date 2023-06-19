-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 01:18 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idea-exchange`
--

-- --------------------------------------------------------

--
-- Table structure for table `post-score`
--

CREATE TABLE `post-score` (
  `id-post` int(11) NOT NULL,
  `id-user` int(11) NOT NULL,
  `score` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post-score`
--

INSERT INTO `post-score` (`id-post`, `id-user`, `score`) VALUES
(30, 1, 0),
(31, 1, 1),
(32, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post-types`
--

CREATE TABLE `post-types` (
  `id-post-type` int(11) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post-types`
--

INSERT INTO `post-types` (`id-post-type`, `type`) VALUES
(4, 'Brainstorm'),
(2, 'Highlight'),
(3, 'Looking for people'),
(1, 'Original code');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id-post` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `id-creator` int(11) NOT NULL,
  `id-subtheme-1` int(11) NOT NULL,
  `id-subtheme-2` int(11) DEFAULT NULL,
  `id-subtheme-3` int(11) DEFAULT NULL,
  `post-name` varchar(30) NOT NULL,
  `post-description` text DEFAULT NULL,
  `original-code` tinyint(1) NOT NULL,
  `link` varchar(50) DEFAULT NULL,
  `link-demo` varchar(50) DEFAULT NULL,
  `link-verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id-post`, `type`, `id-creator`, `id-subtheme-1`, `id-subtheme-2`, `id-subtheme-3`, `post-name`, `post-description`, `original-code`, `link`, `link-demo`, `link-verified`) VALUES
(30, 'Original code', 1, 10, NULL, NULL, 'PRUEBA', 'PRUEBA', 1, NULL, NULL, 0),
(31, 'Original code', 1, 10, 30, NULL, 'Prueba2', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n\r\nWhere does it come from?\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.\r\n\r\nWhere can I get some?\r\nThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 1, 'www.google.com', 'www.google.es', 1),
(32, 'Highlight', 1, 18, 16, 24, 'Angular', 'Angular (also referred to as \"Angular 2+\")[4] is a TypeScript-based, free and open-source single-page web application framework led by the Angular Team at Google and by a community of individuals and corporations. Angular is a complete rewrite from the same team that built AngularJS.\n\nDifferences between Angular and AngularJS\n\nArchitecture of an Angular application. The main building blocks are modules, components, templates, metadata, data binding, directives, services, and dependency injection.\nGoogle designed Angular as a ground-up rewrite of AngularJS.\n\nAngular does not have a concept of \"scope\" or controllers; instead, it uses a hierarchy of components as its primary architectural characteristic.[5]\nAngular has a different expression syntax, focusing on \"[ ]\" for property binding, and \"( )\" for event binding[6]\nModularity – much core functionality has moved to modules\nAngular recommends the use of Microsoft\'s TypeScript language, which introduces the following features:\nStatic typing, including Generics\nType annotations\nDynamic loading\nAsynchronous template compilations\nIterative callbacks provided by RxJS.\nSupport to run Angular applications on servers.', 1, 'https://en.wikipedia.org/wiki/Angular_(web_framewo', 'https://en.wikipedia.org/wiki/Angular_(web_framewo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subthemes`
--

CREATE TABLE `subthemes` (
  `id-subtheme` int(11) NOT NULL,
  `main-theme-id` int(11) NOT NULL,
  `subtheme-name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subthemes`
--

INSERT INTO `subthemes` (`id-subtheme`, `main-theme-id`, `subtheme-name`) VALUES
(10, 8, 'HTML5'),
(11, 8, 'SASS'),
(12, 8, 'Bootstrap'),
(13, 8, 'Tailwind'),
(14, 8, 'Figma'),
(15, 9, 'Javascript'),
(16, 9, 'Typescript'),
(17, 9, 'React'),
(18, 9, 'Angular'),
(19, 10, 'SQL'),
(20, 11, 'Java'),
(21, 11, 'Spring'),
(22, 11, 'Hibernate'),
(23, 12, 'C'),
(24, 13, 'PHP'),
(25, 13, 'Laravel'),
(26, 13, 'Smyfony'),
(27, 14, 'Python'),
(28, 15, 'C++'),
(29, 16, 'Oracle'),
(30, 8, 'HTML - CSS'),
(31, 17, 'Kobol'),
(32, 18, 'Ruby');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id-theme` int(11) NOT NULL,
  `theme-name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id-theme`, `theme-name`) VALUES
(8, 'HTML-CSS'),
(9, 'Javascript'),
(10, 'SQL'),
(11, 'Java'),
(12, 'C'),
(13, 'PHP'),
(14, 'Python'),
(15, 'C++'),
(16, 'Oracle'),
(17, 'Kobol'),
(18, 'Ruby');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id-user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `premium-expire` date DEFAULT NULL COMMENT 'YYYY-MM-DD',
  `is-premium` tinyint(1) NOT NULL DEFAULT 0,
  `register-date` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `cookie-md5` varchar(43) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id-user`, `username`, `email`, `password`, `role`, `premium-expire`, `is-premium`, `register-date`, `verified`, `cookie-md5`) VALUES
(1, 'root', 'root@root.root', '$2y$10$3uaJyE/sqXOSnFjw1AisfO7Z9YBX7IiN1YAh3wtZfGMu/su.wSCxW', 'root', NULL, 1, '2023-06-12 08:41:01', 1, 'c3ab1a9cb67f708d36e6f67992e8b784'),
(92, 'user', 'user@user.user', '$2y$10$2sinkdRFnXjqjSbokdjyveypD3txDdGVBivocun05Q8HnOSlHbGya', 'user', NULL, 0, '2023-06-17 16:56:47', 0, NULL),
(93, 'user1', 'user2@user.user', '$2y$10$uO11jv0LnpTpJpaDCKmh0uqn8ARTNK7hlU2d5SmU2I9YJ/V7/nLc.', 'user', NULL, 0, '2023-06-17 16:58:24', 0, NULL),
(94, 'user2', 'root@root.root1', '$2y$10$m72SXyk2GP0NIgqiFTgZa.DtqENDjMAT2XHRdsYu0U27BmK3sgoLG', 'user', NULL, 0, '2023-06-17 17:01:05', 0, NULL),
(95, 'user4', 'root@root.root4', '$2y$10$Pq1ubw4gvWBtILdaRnpXKet.6r6BHuwXcK1ht3MruT.7rMHsC6I3u', 'user', NULL, 0, '2023-06-17 17:01:54', 0, NULL),
(96, 'tttt', 'root@root.root3', '$2y$10$cCNI3QBUrNy3kyKp55upmevTvQzVGdJREdDRX7P.gI3KwrLyFS0uO', 'user', NULL, 0, '2023-06-17 17:04:06', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post-score`
--
ALTER TABLE `post-score`
  ADD UNIQUE KEY `unique-score` (`id-post`,`id-user`),
  ADD KEY `id-user` (`id-user`);

--
-- Indexes for table `post-types`
--
ALTER TABLE `post-types`
  ADD PRIMARY KEY (`id-post-type`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id-post`),
  ADD KEY `posts-creator` (`id-creator`),
  ADD KEY `posts-subthemes-1` (`id-subtheme-1`),
  ADD KEY `posts-subthemes-2` (`id-subtheme-2`),
  ADD KEY `posts-subthemes-3` (`id-subtheme-3`),
  ADD KEY `fk-types` (`type`);

--
-- Indexes for table `subthemes`
--
ALTER TABLE `subthemes`
  ADD PRIMARY KEY (`id-subtheme`),
  ADD KEY `subthemes-themes` (`main-theme-id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id-theme`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id-user`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post-types`
--
ALTER TABLE `post-types`
  MODIFY `id-post-type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id-post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `subthemes`
--
ALTER TABLE `subthemes`
  MODIFY `id-subtheme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id-theme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id-user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post-score`
--
ALTER TABLE `post-score`
  ADD CONSTRAINT `post-fk` FOREIGN KEY (`id-post`) REFERENCES `posts` (`id-post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post-score_ibfk_1` FOREIGN KEY (`id-user`) REFERENCES `users` (`id-user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user-fk` FOREIGN KEY (`id-user`) REFERENCES `users` (`id-user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk-types` FOREIGN KEY (`type`) REFERENCES `post-types` (`type`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts-creator` FOREIGN KEY (`id-creator`) REFERENCES `users` (`id-user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts-subthemes-1` FOREIGN KEY (`id-subtheme-1`) REFERENCES `subthemes` (`id-subtheme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts-subthemes-2` FOREIGN KEY (`id-subtheme-2`) REFERENCES `subthemes` (`id-subtheme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts-subthemes-3` FOREIGN KEY (`id-subtheme-3`) REFERENCES `subthemes` (`id-subtheme`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subthemes`
--
ALTER TABLE `subthemes`
  ADD CONSTRAINT `subthemes-themes` FOREIGN KEY (`main-theme-id`) REFERENCES `themes` (`id-theme`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
