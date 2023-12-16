-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 05:27 PM
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
-- Dumping data for table `user_borrowed_books`
--

INSERT INTO `user_borrowed_books` (`id`, `user_id`, `username`, `book_id`, `book_title`, `borrow_date`, `return_date`) VALUES
(16, 5, 'Joyce', 3, 'Antares', '2023-12-16', '2023-12-14');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `user_borrowed_books`
--
ALTER TABLE `user_borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
