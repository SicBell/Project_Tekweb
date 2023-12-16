-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 07:59 AM
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
  `admin_type` varchar(25) NOT NULL DEFAULT 'super',
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`Id`, `profile_pic`, `username`, `email`, `password`, `user_type`, `admin_type`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'SicBell657bc528874477.02156380.png', 'SicBell', 'Warrenmiltaico6@gmail.com', 'chynngehtrow', 'admin', 'super', NULL, NULL),
(2, 'Richard65797a9c7a3858.35810725.jpg', 'Richard', 'c14220059@john.petra.ac.id', '12345', 'admin', 'member', '9564d66036de9456dfbbd4eabae48503c3349a25c58c3245fd64bcc54d406ea9', '2023-12-15 04:58:07'),
(3, 'Kevin657c60cc372942.06198740.png', 'Kevin', 'kevin@gmail.com', '123', 'user', '', NULL, NULL);

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
  `book_status` varchar(10) NOT NULL DEFAULT 'available',
  `sinopsis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `gambar`, `pengarang`, `tahun_terbit`, `genre`, `book_status`, `sinopsis`) VALUES
(1, 'Harry Potter', 'Harry Potter.jpg', 'gei', '2023-12-01', 'Romance', 'available', 'Harry Potter and the Goblet of Fire is an enchanting fantasy novel by J.K. Rowling. It follows Harry\'s fourth year at Hogwarts School, where he competes in a dangerous tournament and uncovers a dark plot threatening the wizarding world.'),
(3, 'Antares', 'Antares.jpg', 'Rweinda', '2023-12-15', 'Action & Adventure', 'available', 'The story itself will revolve around the relationship between Zea (Cut Beby Tsabina) and Ares (Angga Yunanda). Their meeting began when Zea tried to get to know Ares, who is the leader of Calderioz. Not without reason, but because he wanted to further investigate a tragic incident involving his brother. However, without realizing it, his efforts to get to know Ares actually made the two of them involved in a love relationship.\n'),
(4, 'Matahari', 'tere liye.jpg', 'Tere Liye', '2023-12-14', 'romance', 'available', 'Matahari is sun'),
(5, 'dilan', 'dilan.jpg', 'Dilan', '2023-12-28', 'Romance', 'available', 'He is Dilanku 1990 edition 1 in light blue with the character Dilan and his motorbike on the cover. Well, the picture of Dilan wearing a high school uniform in a very relaxed style on the cover was illustrated by the writer Pidi Baiq himself. The picture on the cover characterizes the contents of the novel which depicts teenage life. Below Dilan\'s picture is Pidi Baiq\'s quote, adding an interesting impression to the cover.'),
(6, 'Hobbit', 'Hobbit.jpg', 'Wow', '2023-12-21', 'Action & Adventure', 'available', 'The Hobbit is set in Middle-earth and follows home-loving Bilbo Baggins, the hobbit of the title, who joins the wizard Gandalf and the thirteen dwarves of Thorin\'s Company, on a quest to reclaim the dwarves\' home and treasure from the dragon Smaug.'),
(7, 'Percy jackson', 'Percy jackson.jpeg', 'Rick Riordan', '2023-12-20', 'Science Fiction', 'available', 'Like the first book of the series, Percy Jackson and the Olympians follows Percy Jackson, a troubled middle school student who learns that all the Greek myths he grew up hearing are real, and that his mysterious absent father is actually one of those gods.'),
(8, 'Malioboro at Midnight', 'Malioboro at Midnight.jpg', 'Skysphire', '2023-03-31', 'Romance', 'available', 'Midnight for most people is the best time to rest and sleep soundly. But for Serana Nighita, it was a time to cry over life and mourn her relationship with the famous singer, Jan Ichard. Popularity took the man far from him, Ichard in Jakarta, leaving Sera in Jogja. For Sera, midnight is always scary. However, everything changed after Malioboro Hartigan accidentally broke open his bedroom door one night. Malio comes and offers friendship so that Sera is not alone, so that Sera can share her sadness. So what about Sera and Jan Ichard\'s increasingly complicated relationship? And is it true that without realizing it, Malio has become Sera\'s best \'Midnight\'?'),
(9, 'Crazy Rich Asians', 'Crazy Rich Asians.jpg', 'Kevin Kwan', '2023-07-05', 'Romance', 'available', 'Crazy Rich Asians is a darkly funny debut novel about three super-rich Chinese families and the genealogy and gossip, backbiting and scheming that ensues when the heir to one of Asia\'s most enormous fortunes brings home his ABC (American-born Chinese) girlfriend for the wedding this season. When Rachel Chu agreed to spend the summer in Singapore with her boyfriend, Nicholas Young, she envisioned a modest family home, long trips to explore the island, and quality time with the man she might one day marry.'),
(10, 'Fantastic Beasts', 'Fantastic Beasts.jpeg', 'J.K. Rowling', '2023-02-10', 'Action & Adventure', 'available', 'Almost every witch\'s house in the country had a copy of Fantastic Beasts and Where to Find Them. Now Muggles also get the chance to find out where Quintapeds live, what Puffskeins eat, and why not leave milk for Knarl. Almost every wizard\'s house throughout the country must have a copy of the book Fantastic Beasts and Where to Find Them or Fantastic Beasts and Where to Find Them. Now for a limited time only, Muggles also get the chance to find out where Buckbeak the Hippogriff came from, that the Norwegian Fin-backed Dragon (Baby Norbert\'s breed) once preyed on whales, and that the Pixie who once scared Professor Lockhart half to death is actually very fond of pranks- silly joke.');

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_borrowed_books`
--
ALTER TABLE `user_borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
