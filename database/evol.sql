-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2026 at 12:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evol`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `language`, `description`, `cover_image`, `pdf_file`, `created_by`, `created_at`) VALUES
(3, 'hello', 'hello raj', '123123', 'Bhojpuri', 'Written while he was imprisoned in Bankipur Jail during the Indian independence movement, this book is an exhaustive historical document. It details his personal upbringing, his philosophical views on truth and non-violence, and acts as a firsthand, ringside account of India’s struggle for independence. It also sheds light on the early days of the Constituent Assembly and the drafting of the Indian Constitution.', 'habbit.jpeg', 'know_your_bear_facts_brochure.pdf', 1, '2026-05-24 11:16:41'),
(4, 'R A J ', 'builder maurya ', '12121312', 'Hindi , Bhojpuri', 'Only sanskrit', 'photo3.jpeg', 'know_your_bear_facts_brochure.pdf', 1, '2026-05-24 11:26:56'),
(5, 'title', 'sagar', '12234', 'English', 'spiderman brand new day ', 'photo1.jpeg', 'know_your_bear_facts_brochure.pdf', 1, '2026-05-24 12:26:58'),
(6, 'Small Baby', 'baby', '234255', 'english', 'hello this fake copy so don\'t read this ', 'photo2.jpeg', 'hobbit.pdf', 1, '2026-05-27 08:23:23'),
(7, 'Simplicity', 'Gretchen stewart', '384738', 'English ,Spanish ', 'Eliminate overwhelm and learn to cultivate a life freedom.Focus and key.', 'photo6.jpeg', 'hobbit.pdf', 1, '2026-05-27 08:25:48'),
(8, 'Haunted ', 'jacksparrow', '9472952', 'English, spanish ', 'the story of the unkown place ', 'photo4.jpeg', 'hobbit.pdf', 1, '2026-05-27 10:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `book_genres`
--

CREATE TABLE `book_genres` (
  `book_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_genres`
--

INSERT INTO `book_genres` (`book_id`, `genre_id`) VALUES
(3, 2),
(3, 4),
(4, 4),
(4, 5),
(4, 6),
(5, 2),
(5, 3),
(5, 6),
(6, 2),
(6, 4),
(6, 6),
(7, 2),
(7, 4),
(7, 5),
(8, 2),
(8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `book_likes`
--

CREATE TABLE `book_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_likes`
--

INSERT INTO `book_likes` (`id`, `user_id`, `book_id`, `created_at`) VALUES
(6, 1, 3, '2026-05-24 13:38:18'),
(18, 1, 5, '2026-05-25 08:17:55'),
(19, 2, 4, '2026-05-25 08:50:51'),
(20, 1, 8, '2026-05-27 10:04:19'),
(21, 2, 8, '2026-05-27 10:04:43'),
(24, 3, 6, '2026-05-28 16:39:46'),
(26, 3, 8, '2026-05-28 18:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `book_views`
--

CREATE TABLE `book_views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `view_count` int(11) DEFAULT 1,
  `last_viewed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_views`
--

INSERT INTO `book_views` (`id`, `user_id`, `book_id`, `viewed_at`, `view_count`, `last_viewed_at`) VALUES
(8, 1, 4, '2026-05-24 13:01:01', 2, '2026-05-25 13:47:58'),
(9, 1, 3, '2026-05-24 13:14:07', 3, '2026-05-27 13:59:48'),
(10, 2, 3, '2026-05-24 13:38:35', 2, '2026-05-25 14:45:04'),
(11, 2, 4, '2026-05-24 13:53:52', 2, '2026-05-25 14:20:48'),
(12, 2, 5, '2026-05-24 14:05:15', 2, '2026-05-25 15:43:59'),
(13, 1, 5, '2026-05-25 07:56:34', 1, '2026-05-25 13:26:34'),
(14, 1, 7, '2026-05-27 08:27:05', 1, '2026-05-27 13:57:05'),
(15, 1, 6, '2026-05-27 08:31:57', 1, '2026-05-27 14:01:57'),
(16, 1, 8, '2026-05-27 10:04:17', 1, '2026-05-27 15:34:17'),
(17, 2, 8, '2026-05-27 10:04:41', 1, '2026-05-27 15:34:41'),
(18, 3, 8, '2026-05-27 10:05:12', 4, '2026-05-28 23:36:51'),
(19, 3, 7, '2026-05-28 09:51:04', 2, '2026-05-28 19:22:44'),
(20, 3, 6, '2026-05-28 12:50:37', 2, '2026-05-28 22:09:10'),
(21, 3, 3, '2026-05-28 13:16:37', 1, '2026-05-28 18:46:37'),
(22, 3, 4, '2026-05-28 13:28:24', 1, '2026-05-28 18:58:24');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `subject`, `message`, `created_at`, `phone`) VALUES
(1, 3, 'new book', 'hey i want new books to read pls bring some new books', '2026-05-27 09:30:22', '1234567890'),
(3, 4, 'want new book ', 'hey i wnat new books to read cause i have read all ur book so i am waiting for ur new books ', '2026-05-29 08:49:46', '9619501196'),
(4, 4, 'jacksparrow 2 part', 'hey i really like the book written by the jacksparrow  i am waiting for the second part when it will come pls let me know ', '2026-05-29 08:58:35', '9136554183');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(2, 'Adventure'),
(6, 'Drama'),
(1, 'Fantasy'),
(4, 'Mystery'),
(3, 'Romance'),
(5, 'Science Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`, `reset_token`, `reset_token_expiry`, `created_at`) VALUES
(1, 'sagar', 'sagar@gmail.com', 'sagar', '$2y$10$fdLGJnRPsUcp7zICuL5yhu/KQWffPMkNO5eHRZ1u4sjRGN9gGurm.', 'admin', NULL, NULL, '2026-05-23 11:35:40'),
(2, 'raj', 'raj@gmail.com', 'raj', '$2y$10$o2/QgDUEwiZVzzFmrksbk.TEpsL1bMiBuj356gyRLqUKSQt9h3pcy', 'user', NULL, NULL, '2026-05-24 08:44:48'),
(3, 'Raj Maurya', 'rajmaurya@gmail.com', 'rajm', '$2y$10$WB/HPti/8I/R.haSOCpiF.rF7oFZZ29MgaY2ZVXKcayCnMzKWdnhK', 'user', NULL, NULL, '2026-05-27 09:26:39'),
(4, 'Raj', 'rajmaurya94949@gmail.com', 'rajmaurya', '$2y$10$ldvQBYZavuplH3OQIZnLhuanBwNFvhPSMtHBIZIjABrL.6Y2bNNem', 'user', NULL, NULL, '2026-05-29 08:48:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `book_genres`
--
ALTER TABLE `book_genres`
  ADD PRIMARY KEY (`book_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `book_likes`
--
ALTER TABLE `book_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `book_views`
--
ALTER TABLE `book_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_view` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `book_likes`
--
ALTER TABLE `book_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `book_views`
--
ALTER TABLE `book_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `book_genres`
--
ALTER TABLE `book_genres`
  ADD CONSTRAINT `book_genres_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_likes`
--
ALTER TABLE `book_likes`
  ADD CONSTRAINT `book_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_likes_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_views`
--
ALTER TABLE `book_views`
  ADD CONSTRAINT `book_views_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_views_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
