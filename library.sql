-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 07:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `Id` int(20) NOT NULL,
  `profile_pic` varchar(50) NOT NULL DEFAULT 'default-pp.jpg',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_type` varchar(10) DEFAULT 'user',
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`Id`, `profile_pic`, `username`, `email`, `password`, `user_type`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'default-pp.jpg', 'SicBell', 'Warrenmiltaico6@gmail.com', 'chynngehtrow', 'admin', NULL, NULL),
(2, 'Richard65797a9c7a3858.35810725.jpg', 'Richard', 'c14220059@john.petra.ac.id', '12345', 'user', 'a614708331c93b6c0824476d7ace396dc190afe12eaa520e058f45d336fc83df', '2023-12-04 16:18:49'),
(3, 'Kevin656c73aba72553.44041931.jpg', 'Kevin', 'kevin@gmail.com', '123', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `tahun_terbit` date NOT NULL,
  `genre` varchar(255) NOT NULL,
  `book_status` varchar(10) NOT NULL DEFAULT 'ready',
  `sinopsis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `gambar`, `pengarang`, `tahun_terbit`, `genre`, `book_status`, `sinopsis`) VALUES
(1, 'Harry Potter', 'Harry Potter.jpg', 'gei', '2023-12-01', 'Romance', 'ready', 'TESTING 123 123'),
(2, 'james', 'scunt1.png', '123', '2023-12-01', 'Mystery', 'ready', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_borrowed_books`
--

CREATE TABLE `user_borrowed_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `book_title` varchar(255) NOT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_borrowed_books`
--
ALTER TABLE `user_borrowed_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_borrowed_books`
--
ALTER TABLE `user_borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_borrowed_books`
--
ALTER TABLE `user_borrowed_books`
  ADD CONSTRAINT `user_borrowed_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`Id`),
  ADD CONSTRAINT `user_borrowed_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
