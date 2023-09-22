-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 07:53 AM
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
-- Database: `fee_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(13, 'Grade 1'),
(14, 'Grade 2'),
(15, 'Grade 3'),
(16, 'Grade 4');

-- --------------------------------------------------------

--
-- Table structure for table `fee_vouchers`
--

CREATE TABLE `fee_vouchers` (
  `VoucherID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `Month` varchar(255) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Amount` int(11) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_vouchers`
--

INSERT INTO `fee_vouchers` (`VoucherID`, `userID`, `Month`, `Year`, `DueDate`, `Amount`, `Status`) VALUES
(1, 3, 'April', 2023, '2023-09-24', 0, 'Unpaid'),
(2, 3, 'June', 2023, '2023-08-30', 0, 'Paid'),
(3, 3, 'June', 2023, '2023-08-29', 0, 'Paid'),
(4, 3, 'June', 2021, '2023-08-29', 0, 'Paid'),
(5, 3, 'June', 2021, '2023-09-05', 0, 'Paid'),
(6, 3, 'July', 2023, '2023-08-30', 0, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text DEFAULT NULL,
  `sent_datetime` datetime DEFAULT current_timestamp(),
  `reply_text` text DEFAULT NULL,
  `reply_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_vouchers`
--

CREATE TABLE `uploaded_vouchers` (
  `VoucherID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FilePath` varchar(255) DEFAULT NULL,
  `UploadDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploaded_vouchers`
--

INSERT INTO `uploaded_vouchers` (`VoucherID`, `UserID`, `FilePath`, `UploadDate`) VALUES
(1, 3, 'uploads/650bf8c062196_certificate_5_13_3.pdf', '2023-09-21 08:03:12'),
(2, 3, 'uploads/650bf8cd56df5_certificate_5_13_3.pdf', '2023-09-21 08:03:25'),
(3, 3, 'uploads/650bfaf987dcd_certificate_5_13_3.pdf', '2023-09-21 08:12:41'),
(4, 3, 'uploads/650bfcbe11d65_certificate_5_13_2.pdf', '2023-09-21 08:20:14'),
(5, 3, 'uploads/650bffd4d154b_certificate_5_13_3.pdf', '2023-09-21 08:33:24'),
(6, 3, 'uploads/650c031d7256c_650bf8cd56df5_certificate_5_13_3.pdf', '2023-09-21 08:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `age`, `category_id`, `status`) VALUES
(3, 'NASIR ABBAS', '$2y$10$R0DZW9oy4bzYn.TRErR3zerU1Sndrj.2RcKql1ZcDFJ5SJ.97Q2KK', 'nasiryt.827@gmail.com', '03176526827', 23, 15, 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_vouchers`
--
ALTER TABLE `fee_vouchers`
  ADD PRIMARY KEY (`VoucherID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `uploaded_vouchers`
--
ALTER TABLE `uploaded_vouchers`
  ADD PRIMARY KEY (`VoucherID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fee_vouchers`
--
ALTER TABLE `fee_vouchers`
  MODIFY `VoucherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uploaded_vouchers`
--
ALTER TABLE `uploaded_vouchers`
  MODIFY `VoucherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fee_vouchers`
--
ALTER TABLE `fee_vouchers`
  ADD CONSTRAINT `fee_vouchers_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD CONSTRAINT `scholarships_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `uploaded_vouchers`
--
ALTER TABLE `uploaded_vouchers`
  ADD CONSTRAINT `uploaded_vouchers_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
