-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2023 at 07:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `email`, `hashed_password`, `first_name`, `last_name`) VALUES
(5, 'mark@gmail.com', '$2y$10$DZ7620uHNSN2E8B8DLA4GugyzWD8u57ba4NbdBTAlXIDFSz31Ngzu', 'Kenedy', 'Mark'),
(6, 'li@gmail.com', '$2y$10$Z5hAWpgXAL9CS.CRhlZFN.rGexwJ0QlRUTNxVO.MhZunp3kXglaty', 'liam', 'smith');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `category`, `availability`) VALUES
(1, 'Hands-On Machine Learning with Scikit-Learn and TensorFlow: Concepts, Tools, and Techniques to Build', 'Geron Aurelien', 'ML', 1),
(2, 'A Degree in a Book: Electrical And Mechanical Engineering: Everything You Need to Know to Master the', 'David Baker', 'ME and EE', 1),
(4, 'Digital Design and Computer Architecture', 'David Harris', 'CSE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `borrowing_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `returned` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`borrowing_id`, `student_id`, `book_id`, `borrow_date`, `return_date`, `returned`) VALUES
(1, 5, 1, '2023-07-13', '2023-07-27', 1),
(2, 6, 1, '2023-07-13', '2023-07-27', 1),
(3, 6, 1, '2023-07-14', '2023-07-28', 1),
(4, 14, 1, '2023-07-15', '2023-07-29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `days_for_completion` int(11) DEFAULT NULL,
  `course_details` text DEFAULT NULL,
  `instructor_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `days_for_completion`, `course_details`, `instructor_name`, `price`) VALUES
(1, 'CSE', 100, ' Explore the world of computer science and gain skills in programming, algorithms, and system design for a successful career in technology.', 'MR Thomas Hardy', 9000.00),
(2, 'ME', 120, 'Explore the fascinating world of Mechanical Engineering and gain knowledge in the design and operation of machines, structures, and systems.', 'MR Jeff Lloyd', 8500.00),
(3, 'EE', 90, 'Discover the fundamentals of electrical engineering and gain practical knowledge in circuit design, power systems, and electronics.', 'MR Martis Nevile', 6500.00),
(4, 'ML', 90, 'Explore the fascinating world of Machine Learning and unlock the power to build intelligent systems that can learn and make predictions from data.', 'MRS Cynthia Stirling', 7000.00),
(5, 'Data Science', 150, 'Perfect course for data science aspirants', 'MR John Stevens', 8000.00);

-- --------------------------------------------------------

--
-- Table structure for table `course_managers`
--

CREATE TABLE `course_managers` (
  `course_manager_id` int(11) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_managers`
--

INSERT INTO `course_managers` (`course_manager_id`, `email`, `hashed_password`, `first_name`, `last_name`) VALUES
(1, 'matt@gmail.com', '$2y$10$Rgl8sghEcMNvHsyRLNkV1e5MwkLGSlyZNa0QGhmnhDgaBUCkmy5iy', 'Matt', 'Henry'),
(2, 'js@gmail.com', '$2y$10$t/8R8q0adqMTFi0bgPvdOuPuTtZjb8opaSrd2Lw/m6gWAWf2xgMrm', 'Jason', 'Hedge');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `paid_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `enrollment_date`, `paid_status`) VALUES
(1, 5, 1, '2023-07-12 04:25:25', 1),
(2, 6, 3, '2023-07-13 19:40:38', 1),
(3, 6, 2, '2023-07-13 19:48:16', 1),
(4, 7, 2, '2023-07-13 19:50:41', 1),
(5, 8, 3, '2023-07-13 23:08:30', 1),
(6, 8, 1, '2023-07-13 23:09:54', 1),
(7, 8, 2, '2023-07-14 15:08:23', 0),
(8, 7, 1, '2023-07-14 15:10:38', 1),
(9, 7, 3, '2023-07-14 15:12:42', 0),
(10, 9, 1, '2023-07-14 15:17:10', 1),
(11, 9, 2, '2023-07-14 15:22:11', 0),
(12, 9, 3, '2023-07-14 15:23:56', 0),
(13, 14, 4, '2023-07-14 22:57:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

CREATE TABLE `finance` (
  `invoice_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `paid_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `graduates`
--

CREATE TABLE `graduates` (
  `graduate_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_price` decimal(10,2) NOT NULL,
  `graduate` enum('UnderGraduate','Graduate') NOT NULL DEFAULT 'Graduate'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `graduates`
--

INSERT INTO `graduates` (`graduate_id`, `student_id`, `first_name`, `last_name`, `course_id`, `course_name`, `course_price`, `graduate`) VALUES
(8, 6, 'Julia', 'Hales', 2, 'ME', 8500.00, 'Graduate'),
(9, 14, 'Jimm', 'Fowler', 4, 'ML', 7000.00, 'Graduate');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `student_id`, `course_id`, `amount`, `status`, `created_at`) VALUES
(1, 5, 1, 0.00, 'paid', '2023-07-12 23:16:00'),
(2, 6, 3, 0.00, 'paid', '2023-07-13 19:42:40'),
(3, 7, 2, 0.00, 'paid', '2023-07-13 19:53:44'),
(4, 8, 3, 0.00, 'paid', '2023-07-13 23:09:26'),
(5, 8, 1, 0.00, 'paid', '2023-07-13 23:27:02'),
(6, 8, 1, 0.00, 'paid', '2023-07-14 15:07:48'),
(7, 8, 3, 0.00, 'paid', '2023-07-14 15:08:29'),
(8, 8, 3, 0.00, 'paid', '2023-07-14 15:09:39'),
(9, 7, 1, 0.00, 'paid', '2023-07-14 15:10:44'),
(10, 7, 1, 0.00, 'paid', '2023-07-14 15:12:46'),
(11, 7, 1, 0.00, 'paid', '2023-07-14 15:13:38'),
(12, 9, 1, 0.00, 'paid', '2023-07-14 15:23:16'),
(13, 9, 1, 0.00, 'paid', '2023-07-14 15:24:10'),
(14, 14, 4, 0.00, 'paid', '2023-07-14 22:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `borrower_id` int(11) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `university` varchar(100) DEFAULT NULL,
  `borrowed_books` int(11) DEFAULT 0,
  `returned_books` int(11) DEFAULT 0,
  `graduated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `hashed_password`, `contact_number`, `email`, `address`, `university`, `borrowed_books`, `returned_books`, `graduated`) VALUES
(5, 'Jackyl', 'Daniels', '$2y$10$yz1jQfIJEW/Od5HWGjgCEO0/NeI4Zfw35FRVulAleQBkJ45GozgPC', '1238529874', 'rtr@gmail.com', 'jk row str', 'bpp', 0, 0, 1),
(6, 'Julia', 'Roberts', '$2y$10$Dn8gFobHcgB4U5BTx6vb6u.QlZUpUGkLBRH8cVCNYSzkItqlKNAqq', '7539512582', 'jul@gmail.com', '15 RF road', 'UK', 0, 0, 1),
(7, 'Charles', 'Robin', '$2y$10$zxQnZ6lpdzpK9gHX21v9KuTE5pcghvbx1TUJToxoZZBR6liDuT5l6', '7539512582', 'char@gmail.com', '15 road', 'USA', 0, 0, 0),
(11, 'Johny', 'English', '$2y$10$4OMggXJj3cO0nPCELWRjwO6YkprtDm1jdDHor3XGgbI0YfyIZLUyq', '7589654520', 'john@gmail.com', 'Radson Ave', 'UK', 0, 0, 0),
(13, 'Sean', 'Kingston', '$2y$10$C8FI27st4zzA2h8cMbEd5.71g8zfkPi6QlMMKxqd2KX6cS7OuQgrG', '7585654798', 'sean@gmail.com', 'Great Britain', 'BPP', 0, 0, 0),
(14, 'Jimm', 'Fowler', '$2y$10$wuEYtCSeRNBjEbD.xFMu1.4JcOhBCGhFSNPGMv09hCjzzfG9ejxsi', '8523214589', 'jim@gmail.com', 'Ramnes Road', 'Harvard', 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`borrowing_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_managers`
--
ALTER TABLE `course_managers`
  ADD PRIMARY KEY (`course_manager_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `finance`
--
ALTER TABLE `finance`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `graduates`
--
ALTER TABLE `graduates`
  ADD PRIMARY KEY (`graduate_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `borrower_id` (`borrower_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `borrowing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_managers`
--
ALTER TABLE `course_managers`
  MODIFY `course_manager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `finance`
--
ALTER TABLE `finance`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `graduates`
--
ALTER TABLE `graduates`
  MODIFY `graduate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `finance`
--
ALTER TABLE `finance`
  ADD CONSTRAINT `finance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `library_ibfk_1` FOREIGN KEY (`borrower_id`) REFERENCES `students` (`student_id`);
COMMIT;
