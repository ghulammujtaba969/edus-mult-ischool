-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2026 at 06:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `campus_id`, `name`, `start_date`, `end_date`, `is_current`, `is_locked`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, '2025-2026', '2025-04-01', '2026-03-31', 1, 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'bi-check2-circle',
  `tone` varchar(255) NOT NULL DEFAULT 'success',
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `campus_id`, `user_id`, `title`, `description`, `icon`, `tone`, `logged_at`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 2, 'Class 9-A attendance marked', 'Attendance submitted by Bilal Ahmed for Class 9-A.', 'bi-check2-circle', 'success', '2026-04-13 01:29:43', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(2, 1, 2, 'Fee payment received', 'Payment received from Zaid Abbas Mirza for PKR 4,200.', 'bi-cash-coin', 'info', '2026-04-13 01:15:43', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(3, 1, 2, 'New admission enrolled', 'Hamza Raza Khan enrolled in Class 8-A.', 'bi-person-plus', 'warning', '2026-04-13 00:37:43', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(4, 1, 2, 'Fee defaulter alert', '14 students are overdue by more than 15 days.', 'bi-exclamation-triangle', 'danger', '2026-04-12 23:37:43', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(5, 1, 2, 'Bulk SMS sent', 'Exam schedule reminder sent to 218 parents.', 'bi-chat-dots', 'success', '2026-04-12 22:37:43', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admission_inquiries`
--

CREATE TABLE `admission_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `address` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumnis`
--

CREATE TABLE `alumnis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `graduation_year` year(4) NOT NULL,
  `current_occupation` varchar(255) DEFAULT NULL,
  `current_organization` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_events`
--

CREATE TABLE `alumni_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `asset_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `condition` varchar(255) NOT NULL DEFAULT 'new',
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_assignments`
--

CREATE TABLE `asset_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_to_type` varchar(255) NOT NULL,
  `assigned_to_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` date NOT NULL,
  `returned_at` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_categories`
--

CREATE TABLE `asset_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

CREATE TABLE `campuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`id`, `school_id`, `name`, `code`, `phone`, `email`, `address`, `city`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Al-Falah School System - Islamabad Campus', 'AFS-ISB', '051-2345678', 'isb@alfalah.edu.pk', 'G-11 Markaz, Islamabad', 'Islamabad', 1, '2026-04-13 01:37:40', '2026-04-13 01:37:40'),
(2, NULL, 'Al-Falah School System - Lahore Campus', 'AFS-LHE', '042-3456789', 'lhr@alfalah.edu.pk', 'Johar Town, Lahore', 'Lahore', 1, '2026-04-13 01:37:40', '2026-04-13 01:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_templates`
--

CREATE TABLE `certificate_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `certificate_type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `weekly_hours` int(10) UNSIGNED NOT NULL DEFAULT 4,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) NOT NULL,
  `type` enum('subdomain','custom') NOT NULL DEFAULT 'subdomain',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `dns_verified_at` timestamp NULL DEFAULT NULL,
  `dns_check_count` int(11) NOT NULL DEFAULT 0,
  `last_dns_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_code` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `joining_date` date NOT NULL,
  `cnic` varchar(20) DEFAULT NULL,
  `basic_salary` decimal(12,2) NOT NULL DEFAULT 0.00,
  `phone` varchar(20) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `campus_id`, `user_id`, `employee_code`, `designation`, `department`, `joining_date`, `cnic`, `basic_salary`, `phone`, `status`, `created_at`, `updated_at`, `deleted_at`, `school_id`) VALUES
(1, 1, 2, 'EMP-001', 'Campus Admin', 'Administration', '2022-08-01', NULL, 0.00, '0312-3456789', 'active', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL),
(2, 1, 3, 'EMP-002', 'Senior Teacher', 'Science', '2021-03-01', NULL, 0.00, '0311-1234567', 'active', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_assignments`
--

CREATE TABLE `employee_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `academic_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance`
--

CREATE TABLE `employee_attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in` timestamp NULL DEFAULT NULL,
  `check_out` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED DEFAULT NULL,
  `exam_type_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `campus_id`, `academic_year_id`, `term_id`, `exam_type_id`, `school_class_id`, `name`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 1, 1, 4, 'Mid Term 2025-26', '2025-10-10', '2025-10-20', 'published', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `weightage_percent` decimal(5,2) NOT NULL DEFAULT 100.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_types`
--

INSERT INTO `exam_types` (`id`, `campus_id`, `name`, `weightage_percent`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 'Mid Term', 100.00, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `expense_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_discounts`
--

CREATE TABLE `fee_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount_type` varchar(255) NOT NULL DEFAULT 'percent',
  `value` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_invoices`
--

CREATE TABLE `fee_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `fee_type_id` bigint(20) UNSIGNED NOT NULL,
  `billing_month` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fine_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(12,2) NOT NULL,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `balance_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `challan_no` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_invoices`
--

INSERT INTO `fee_invoices` (`id`, `campus_id`, `student_id`, `academic_year_id`, `fee_type_id`, `billing_month`, `amount`, `discount_amount`, `fine_amount`, `net_amount`, `paid_amount`, `balance_amount`, `due_date`, `status`, `challan_no`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 1, 2, '2026-04-01', 4200.00, 420.00, 0.00, 3780.00, 3780.00, 0.00, '2026-04-05', 'paid', 'CH-1-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(2, 1, 1, 1, 1, '2026-03-01', 4200.00, 420.00, 0.00, 3780.00, 3780.00, 0.00, '2026-03-05', 'paid', 'CH-1-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(3, 1, 1, 1, 1, '2026-02-01', 4200.00, 420.00, 0.00, 3780.00, 3780.00, 0.00, '2026-02-05', 'paid', 'CH-1-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(4, 1, 1, 1, 1, '2026-01-01', 4200.00, 420.00, 200.00, 3980.00, 3980.00, 0.00, '2026-01-05', 'paid', 'CH-1-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(5, 1, 1, 1, 1, '2025-12-01', 4200.00, 420.00, 0.00, 3780.00, 3780.00, 0.00, '2025-12-05', 'paid', 'CH-1-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(6, 1, 1, 1, 1, '2025-11-01', 4200.00, 420.00, 0.00, 3780.00, 3780.00, 0.00, '2025-11-05', 'paid', 'CH-1-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(7, 1, 2, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 3500.00, 700.00, '2026-04-05', 'partial', 'CH-2-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(8, 1, 2, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-2-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(9, 1, 2, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-2-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(10, 1, 2, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-2-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(11, 1, 2, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-2-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(12, 1, 2, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-2-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(13, 1, 3, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-04-05', 'paid', 'CH-3-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(14, 1, 3, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-3-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(15, 1, 3, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-3-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(16, 1, 3, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-3-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(17, 1, 3, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-3-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(18, 1, 3, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-3-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(19, 1, 4, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 0.00, 4200.00, '2026-04-05', 'unpaid', 'CH-4-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(20, 1, 4, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-4-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(21, 1, 4, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-4-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(22, 1, 4, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-4-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(23, 1, 4, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-4-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(24, 1, 4, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-4-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(25, 1, 5, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-04-05', 'paid', 'CH-5-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(26, 1, 5, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-5-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(27, 1, 5, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-5-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(28, 1, 5, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-5-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(29, 1, 5, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-5-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(30, 1, 5, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-5-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(31, 1, 6, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-04-05', 'paid', 'CH-6-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(32, 1, 6, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-6-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(33, 1, 6, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-6-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(34, 1, 6, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-6-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(35, 1, 6, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-6-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(36, 1, 6, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-6-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(37, 1, 7, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-04-05', 'paid', 'CH-7-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(38, 1, 7, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-7-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(39, 1, 7, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-7-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(40, 1, 7, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-7-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(41, 1, 7, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-7-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(42, 1, 7, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-7-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(43, 1, 8, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-04-05', 'paid', 'CH-8-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(44, 1, 8, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-8-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(45, 1, 8, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-8-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(46, 1, 8, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-8-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(47, 1, 8, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-8-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(48, 1, 8, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-8-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(49, 1, 9, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 3500.00, 700.00, '2026-04-05', 'partial', 'CH-9-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(50, 1, 9, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-9-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(51, 1, 9, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-9-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(52, 1, 9, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-9-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(53, 1, 9, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-9-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(54, 1, 9, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-9-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(55, 1, 10, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-04-05', 'paid', 'CH-10-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(56, 1, 10, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-10-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(57, 1, 10, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-10-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(58, 1, 10, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-10-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(59, 1, 10, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-10-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(60, 1, 10, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-10-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(61, 1, 11, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-04-05', 'paid', 'CH-11-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(62, 1, 11, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-11-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(63, 1, 11, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-11-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(64, 1, 11, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-11-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(65, 1, 11, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-11-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(66, 1, 11, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-11-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(67, 1, 12, 1, 2, '2026-04-01', 4200.00, 0.00, 0.00, 4200.00, 0.00, 4200.00, '2026-04-05', 'unpaid', 'CH-12-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(68, 1, 12, 1, 1, '2026-03-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-03-05', 'paid', 'CH-12-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(69, 1, 12, 1, 1, '2026-02-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2026-02-05', 'paid', 'CH-12-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(70, 1, 12, 1, 1, '2026-01-01', 4200.00, 0.00, 200.00, 4400.00, 4400.00, 0.00, '2026-01-05', 'paid', 'CH-12-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(71, 1, 12, 1, 1, '2025-12-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-12-05', 'paid', 'CH-12-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(72, 1, 12, 1, 1, '2025-11-01', 4200.00, 0.00, 0.00, 4200.00, 4200.00, 0.00, '2025-11-05', 'paid', 'CH-12-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `fee_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `payment_date` date NOT NULL,
  `method` varchar(255) NOT NULL DEFAULT 'cash',
  `reference_no` varchar(255) DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_payments`
--

INSERT INTO `fee_payments` (`id`, `campus_id`, `fee_invoice_id`, `student_id`, `amount_paid`, `payment_date`, `method`, `reference_no`, `received_by`, `receipt_no`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 1, 3780.00, '2026-04-08', 'cash', NULL, 2, 'RCPT-1-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(2, 1, 2, 1, 3780.00, '2026-03-08', 'cash', NULL, 2, 'RCPT-1-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(3, 1, 3, 1, 3780.00, '2026-02-08', 'cash', NULL, 2, 'RCPT-1-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(4, 1, 4, 1, 3980.00, '2026-01-08', 'cash', NULL, 2, 'RCPT-1-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(5, 1, 5, 1, 3780.00, '2025-12-08', 'cash', NULL, 2, 'RCPT-1-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(6, 1, 6, 1, 3780.00, '2025-11-08', 'cash', NULL, 2, 'RCPT-1-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(7, 1, 7, 2, 3500.00, '2026-04-09', 'bank', NULL, 2, 'RCPT-2-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(8, 1, 8, 2, 4200.00, '2026-03-09', 'bank', NULL, 2, 'RCPT-2-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(9, 1, 9, 2, 4200.00, '2026-02-09', 'bank', NULL, 2, 'RCPT-2-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(10, 1, 10, 2, 4400.00, '2026-01-09', 'bank', NULL, 2, 'RCPT-2-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(11, 1, 11, 2, 4200.00, '2025-12-09', 'bank', NULL, 2, 'RCPT-2-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(12, 1, 12, 2, 4200.00, '2025-11-09', 'bank', NULL, 2, 'RCPT-2-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(13, 1, 13, 3, 4200.00, '2026-04-10', 'cash', NULL, 2, 'RCPT-3-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(14, 1, 14, 3, 4200.00, '2026-03-10', 'cash', NULL, 2, 'RCPT-3-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(15, 1, 15, 3, 4200.00, '2026-02-10', 'cash', NULL, 2, 'RCPT-3-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(16, 1, 16, 3, 4400.00, '2026-01-10', 'cash', NULL, 2, 'RCPT-3-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(17, 1, 17, 3, 4200.00, '2025-12-10', 'cash', NULL, 2, 'RCPT-3-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(18, 1, 18, 3, 4200.00, '2025-11-10', 'cash', NULL, 2, 'RCPT-3-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(19, 1, 20, 4, 4200.00, '2026-03-11', 'bank', NULL, 2, 'RCPT-4-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(20, 1, 21, 4, 4200.00, '2026-02-11', 'bank', NULL, 2, 'RCPT-4-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(21, 1, 22, 4, 4400.00, '2026-01-11', 'bank', NULL, 2, 'RCPT-4-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(22, 1, 23, 4, 4200.00, '2025-12-11', 'bank', NULL, 2, 'RCPT-4-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(23, 1, 24, 4, 4200.00, '2025-11-11', 'bank', NULL, 2, 'RCPT-4-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(24, 1, 25, 5, 4200.00, '2026-04-12', 'cash', NULL, 2, 'RCPT-5-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(25, 1, 26, 5, 4200.00, '2026-03-12', 'cash', NULL, 2, 'RCPT-5-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(26, 1, 27, 5, 4200.00, '2026-02-12', 'cash', NULL, 2, 'RCPT-5-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(27, 1, 28, 5, 4400.00, '2026-01-12', 'cash', NULL, 2, 'RCPT-5-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(28, 1, 29, 5, 4200.00, '2025-12-12', 'cash', NULL, 2, 'RCPT-5-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(29, 1, 30, 5, 4200.00, '2025-11-12', 'cash', NULL, 2, 'RCPT-5-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(30, 1, 31, 6, 4200.00, '2026-04-13', 'bank', NULL, 2, 'RCPT-6-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(31, 1, 32, 6, 4200.00, '2026-03-13', 'bank', NULL, 2, 'RCPT-6-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(32, 1, 33, 6, 4200.00, '2026-02-13', 'bank', NULL, 2, 'RCPT-6-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(33, 1, 34, 6, 4400.00, '2026-01-13', 'bank', NULL, 2, 'RCPT-6-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(34, 1, 35, 6, 4200.00, '2025-12-13', 'bank', NULL, 2, 'RCPT-6-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(35, 1, 36, 6, 4200.00, '2025-11-13', 'bank', NULL, 2, 'RCPT-6-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(36, 1, 37, 7, 4200.00, '2026-04-14', 'cash', NULL, 2, 'RCPT-7-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(37, 1, 38, 7, 4200.00, '2026-03-14', 'cash', NULL, 2, 'RCPT-7-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(38, 1, 39, 7, 4200.00, '2026-02-14', 'cash', NULL, 2, 'RCPT-7-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(39, 1, 40, 7, 4400.00, '2026-01-14', 'cash', NULL, 2, 'RCPT-7-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(40, 1, 41, 7, 4200.00, '2025-12-14', 'cash', NULL, 2, 'RCPT-7-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(41, 1, 42, 7, 4200.00, '2025-11-14', 'cash', NULL, 2, 'RCPT-7-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(42, 1, 43, 8, 4200.00, '2026-04-15', 'bank', NULL, 2, 'RCPT-8-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(43, 1, 44, 8, 4200.00, '2026-03-15', 'bank', NULL, 2, 'RCPT-8-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(44, 1, 45, 8, 4200.00, '2026-02-15', 'bank', NULL, 2, 'RCPT-8-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(45, 1, 46, 8, 4400.00, '2026-01-15', 'bank', NULL, 2, 'RCPT-8-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(46, 1, 47, 8, 4200.00, '2025-12-15', 'bank', NULL, 2, 'RCPT-8-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(47, 1, 48, 8, 4200.00, '2025-11-15', 'bank', NULL, 2, 'RCPT-8-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(48, 1, 49, 9, 3500.00, '2026-04-16', 'cash', NULL, 2, 'RCPT-9-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(49, 1, 50, 9, 4200.00, '2026-03-16', 'cash', NULL, 2, 'RCPT-9-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(50, 1, 51, 9, 4200.00, '2026-02-16', 'cash', NULL, 2, 'RCPT-9-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(51, 1, 52, 9, 4400.00, '2026-01-16', 'cash', NULL, 2, 'RCPT-9-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(52, 1, 53, 9, 4200.00, '2025-12-16', 'cash', NULL, 2, 'RCPT-9-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(53, 1, 54, 9, 4200.00, '2025-11-16', 'cash', NULL, 2, 'RCPT-9-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(54, 1, 55, 10, 4200.00, '2026-04-17', 'bank', NULL, 2, 'RCPT-10-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(55, 1, 56, 10, 4200.00, '2026-03-17', 'bank', NULL, 2, 'RCPT-10-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(56, 1, 57, 10, 4200.00, '2026-02-17', 'bank', NULL, 2, 'RCPT-10-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(57, 1, 58, 10, 4400.00, '2026-01-17', 'bank', NULL, 2, 'RCPT-10-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(58, 1, 59, 10, 4200.00, '2025-12-17', 'bank', NULL, 2, 'RCPT-10-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(59, 1, 60, 10, 4200.00, '2025-11-17', 'bank', NULL, 2, 'RCPT-10-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(60, 1, 61, 11, 4200.00, '2026-04-18', 'cash', NULL, 2, 'RCPT-11-202604', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(61, 1, 62, 11, 4200.00, '2026-03-18', 'cash', NULL, 2, 'RCPT-11-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(62, 1, 63, 11, 4200.00, '2026-02-18', 'cash', NULL, 2, 'RCPT-11-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(63, 1, 64, 11, 4400.00, '2026-01-18', 'cash', NULL, 2, 'RCPT-11-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(64, 1, 65, 11, 4200.00, '2025-12-18', 'cash', NULL, 2, 'RCPT-11-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(65, 1, 66, 11, 4200.00, '2025-11-18', 'cash', NULL, 2, 'RCPT-11-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(66, 1, 68, 12, 4200.00, '2026-03-19', 'bank', NULL, 2, 'RCPT-12-202603', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(67, 1, 69, 12, 4200.00, '2026-02-19', 'bank', NULL, 2, 'RCPT-12-202602', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(68, 1, 70, 12, 4400.00, '2026-01-19', 'bank', NULL, 2, 'RCPT-12-202601', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(69, 1, 71, 12, 4200.00, '2025-12-19', 'bank', NULL, 2, 'RCPT-12-202512', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(70, 1, 72, 12, 4200.00, '2025-11-19', 'bank', NULL, 2, 'RCPT-12-202511', '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `fee_type_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `due_day` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `effective_from` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_types`
--

CREATE TABLE `fee_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT 1,
  `frequency` varchar(255) NOT NULL DEFAULT 'monthly',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_types`
--

INSERT INTO `fee_types` (`id`, `campus_id`, `name`, `is_recurring`, `frequency`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 'Monthly Fee', 1, 'monthly', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(2, 1, 'Exam Fee', 0, 'term', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `front_office_complaints`
--

CREATE TABLE `front_office_complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `complaint_by` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_office_enquiries`
--

CREATE TABLE `front_office_enquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `date` date NOT NULL,
  `next_follow_up_date` date DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `class_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `front_office_visitors`
--

CREATE TABLE `front_office_visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `id_card` varchar(255) DEFAULT NULL,
  `no_of_person` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `date` date NOT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_scales`
--

CREATE TABLE `grade_scales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `min_percent` decimal(5,2) NOT NULL,
  `max_percent` decimal(5,2) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `gpa_value` decimal(3,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `homework_submissions`
--

CREATE TABLE `homework_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostels`
--

CREATE TABLE `hostels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'boys',
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `capacity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostel_allocations`
--

CREATE TABLE `hostel_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `hostel_room_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `bed_no` int(10) UNSIGNED DEFAULT NULL,
  `allocated_at` date NOT NULL,
  `vacated_at` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostel_rooms`
--

CREATE TABLE `hostel_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `room_no` varchar(255) NOT NULL,
  `room_type` varchar(255) NOT NULL DEFAULT 'non-ac',
  `no_of_beds` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `cost_per_bed` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `id_card_templates`
--

CREATE TABLE `id_card_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `layout_json` text DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_item_issues`
--

CREATE TABLE `inventory_item_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_suppliers`
--

CREATE TABLE `inventory_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_plans`
--

CREATE TABLE `lesson_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time_from` time DEFAULT NULL,
  `time_to` time DEFAULT NULL,
  `lecture_youtube_url` text DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `presentation` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_books`
--

CREATE TABLE `library_books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn_no` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `rack_no` varchar(255) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `available_quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_issues`
--

CREATE TABLE `library_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `library_book_id` bigint(20) UNSIGNED NOT NULL,
  `library_member_id` bigint(20) UNSIGNED NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `fine_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'issued',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_members`
--

CREATE TABLE `library_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `library_card_no` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `obtained_marks` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_marks` decimal(8,2) NOT NULL DEFAULT 100.00,
  `is_absent` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `entered_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `campus_id`, `exam_id`, `student_id`, `subject_id`, `obtained_marks`, `total_marks`, `is_absent`, `remarks`, `entered_by`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 1, 1, 88.00, 100.00, 0, NULL, 3, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(2, 1, 1, 1, 2, 74.00, 100.00, 0, NULL, 3, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(3, 1, 1, 1, 3, 82.00, 100.00, 0, NULL, 3, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(4, 1, 1, 1, 4, 71.00, 100.00, 0, NULL, 3, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(5, 1, 1, 1, 5, 65.00, 100.00, 0, NULL, 3, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(6, 1, 1, 1, 6, 79.00, 100.00, 0, NULL, 3, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL),
(7, 1, 1, 1, 7, 91.00, 100.00, 0, NULL, 3, '2026-04-13 01:37:43', '2026-04-13 01:37:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_09_000001_create_sms_core_tables', 1),
(6, '2026_04_13_053044_create_payrolls_table', 1),
(7, '2026_04_13_053055_add_salary_to_employees_table', 1),
(8, '2026_04_13_053847_create_hostels_table', 1),
(9, '2026_04_13_053849_create_hostel_rooms_table', 1),
(10, '2026_04_13_053850_create_hostel_allocations_table', 1),
(11, '2026_04_13_054149_create_asset_categories_table', 1),
(12, '2026_04_13_054150_create_assets_table', 1),
(13, '2026_04_13_054151_create_asset_assignments_table', 1),
(14, '2026_04_24_000001_create_transport_vehicles_table', 2),
(15, '2026_04_24_000002_create_transport_routes_table', 2),
(16, '2026_04_24_000003_create_transport_pickup_points_table', 2),
(17, '2026_04_24_000004_create_transport_assignments_table', 2),
(18, '2026_04_24_142213_create_transport_vehicles_table', 3),
(19, '2026_04_24_142225_create_transport_routes_table', 4),
(20, '2026_04_24_142229_create_transport_pickup_points_table', 5),
(21, '2026_04_24_142233_create_transport_assignments_table', 6),
(22, '2026_04_24_142440_create_library_books_table', 6),
(23, '2026_04_24_142442_create_library_members_table', 6),
(24, '2026_04_24_142444_create_library_issues_table', 6),
(25, '2026_04_24_142743_create_front_office_visitors_table', 6),
(26, '2026_04_24_142745_create_front_office_enquiries_table', 6),
(27, '2026_04_24_142747_create_front_office_complaints_table', 6),
(28, '2026_04_24_143038_create_homework_table', 6),
(29, '2026_04_24_143040_create_homework_submissions_table', 6),
(30, '2026_04_24_143042_create_syllabus_progress_table', 6),
(31, '2026_04_24_143302_create_homework_table', 7),
(32, '2026_04_24_143304_create_homework_submissions_table', 8),
(33, '2026_04_24_143306_create_certificate_templates_table', 8),
(34, '2026_04_24_143306_create_syllabus_progress_table', 9),
(35, '2026_04_24_143308_create_id_card_templates_table', 9),
(36, '2026_04_24_143749_create_staff_attendances_table', 9),
(37, '2026_04_24_143751_create_staff_leaves_table', 9),
(38, '2026_04_24_143753_create_staff_ratings_table', 9),
(39, '2026_04_24_144150_create_inventory_suppliers_table', 9),
(40, '2026_04_24_144155_create_inventory_items_table', 9),
(41, '2026_04_24_144158_create_inventory_item_issues_table', 9),
(42, '2026_04_24_144249_create_inventory_suppliers_table', 10),
(43, '2026_04_24_144251_create_inventory_items_table', 11),
(44, '2026_04_24_144253_create_inventory_item_issues_table', 12),
(45, '2026_04_24_144443_create_lesson_plans_table', 12),
(46, '2026_04_24_144446_create_online_exams_table', 12),
(47, '2026_04_24_144449_create_online_exam_questions_table', 12),
(48, '2026_04_24_144451_create_online_exam_attempts_table', 12),
(49, '2026_04_24_150445_create_alumnis_table', 12),
(50, '2026_04_24_150447_create_alumni_events_table', 12),
(51, '2026_04_24_150824_create_settings_table', 12),
(52, '2026_04_24_151030_create_expenses_table', 12),
(53, '2026_04_24_151940_create_timetable_slots_table', 12),
(54, '2026_04_24_151942_create_timetable_entries_table', 12),
(55, '2026_04_24_152340_create_student_promotions_table', 13),
(56, '2026_04_24_152521_create_grade_scales_table', 13),
(57, '2026_04_24_153007_create_admission_inquiries_table', 13),
(58, '2026_04_24_154213_create_plans_table', 13),
(59, '2026_04_24_154217_create_schools_table', 13),
(60, '2026_04_24_154220_create_domains_table', 13),
(61, '2026_04_24_154354_add_school_id_to_campuses_and_users_table', 13),
(62, '2026_04_24_154640_add_school_id_to_all_tenant_tables', 13),
(63, '2026_04_24_155222_add_verification_fields_to_domains_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'announcement',
  `target_role` varchar(255) DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exams`
--

CREATE TABLE `online_exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `exam_title` varchar(255) NOT NULL,
  `exam_from` datetime NOT NULL,
  `exam_to` datetime NOT NULL,
  `duration_minutes` int(10) UNSIGNED NOT NULL,
  `minimum_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `publish_result` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_attempts`
--

CREATE TABLE `online_exam_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `online_exam_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `started_at` datetime NOT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `total_marks` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `obtained_marks` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'in_progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_questions`
--

CREATE TABLE `online_exam_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `online_exam_id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `question_type` varchar(255) NOT NULL DEFAULT 'mcq',
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `correct_option` varchar(255) DEFAULT NULL,
  `marks` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `billing_month` date NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL,
  `allowances` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deductions` decimal(12,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `max_branches` int(11) NOT NULL DEFAULT 1,
  `monthly_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','active','suspended') NOT NULL DEFAULT 'active',
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_classes`
--

CREATE TABLE `school_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `order_seq` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_classes`
--

INSERT INTO `school_classes` (`id`, `campus_id`, `name`, `level`, `order_seq`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 'Class 6', 'Middle', 6, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(2, 1, 'Class 7', 'Middle', 7, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(3, 1, 'Class 8', 'Middle', 8, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(4, 1, 'Class 9', 'Secondary', 9, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(5, 1, 'Class 10', 'Secondary', 10, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `campus_id`, `school_class_id`, `name`, `capacity`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 'A', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(2, 1, 1, 'B', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(3, 1, 2, 'A', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(4, 1, 2, 'B', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(5, 1, 3, 'A', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(6, 1, 3, 'B', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(7, 1, 3, 'C', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(8, 1, 4, 'A', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(9, 1, 4, 'B', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(10, 1, 5, 'A', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(11, 1, 5, 'B', 40, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'queued',
  `provider_response` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendances`
--

CREATE TABLE `staff_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'present',
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_leaves`
--

CREATE TABLE `staff_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_ratings`
--

CREATE TABLE `staff_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `rated_by` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `registration_no` varchar(255) NOT NULL,
  `b_form_no` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) NOT NULL DEFAULT 'Pakistani',
  `enrollment_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `photo_path` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `campus_id`, `user_id`, `registration_no`, `b_form_no`, `date_of_birth`, `gender`, `blood_group`, `religion`, `nationality`, `enrollment_date`, `status`, `photo_path`, `email`, `address`, `created_at`, `updated_at`, `deleted_at`, `school_id`) VALUES
(1, 1, 4, 'REG-2018-00188', '61101-1234567-1', '2010-01-01', 'Male', 'O+', 'Islam', 'Pakistani', '2019-04-01', 'active', NULL, 'ahmed.bilal.khan@gmail.com', 'House 10, Street 1, G-11/2, Islamabad', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL),
(2, 1, 5, 'REG-2019-00189', '61101-1234568-2', '2011-02-02', 'Female', 'A+', 'Islam', 'Pakistani', '2020-04-01', 'active', NULL, 'sara.noor.fatima@gmail.com', 'House 11, Street 2, G-11/2, Islamabad', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL),
(3, 1, 6, 'REG-2020-00190', '61101-1234569-3', '2012-03-03', 'Male', 'B+', 'Islam', 'Pakistani', '2021-04-01', 'active', NULL, 'zaid.abbas.mirza@gmail.com', 'House 12, Street 3, G-11/2, Islamabad', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL),
(4, 1, 7, 'REG-2021-00191', '61101-1234570-4', '2013-04-04', 'Female', 'AB+', 'Islam', 'Pakistani', '2022-04-01', 'active', NULL, 'hina.arshad.malik@gmail.com', 'House 13, Street 4, G-11/2, Islamabad', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL),
(5, 1, 8, 'REG-2022-00192', '61101-1234571-5', '2010-05-05', 'Male', 'O+', 'Islam', 'Pakistani', '2019-04-01', 'active', NULL, 'omar.usman.sheikh@gmail.com', 'House 14, Street 5, G-11/2, Islamabad', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL),
(6, 1, 9, 'REG-2018-00193', '61101-1234572-6', '2011-06-06', 'Female', 'A+', 'Islam', 'Pakistani', '2020-04-01', 'active', NULL, 'amna.tariq.butt@gmail.com', 'House 15, Street 6, G-11/2, Islamabad', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL, NULL),
(7, 1, 10, 'REG-2019-00194', '61101-1234573-7', '2012-07-07', 'Male', 'B+', 'Islam', 'Pakistani', '2021-04-01', 'enrolled', NULL, 'hamza.raza.khan@gmail.com', 'House 16, Street 7, G-11/2, Islamabad', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL, NULL),
(8, 1, 11, 'REG-2020-00195', '61101-1234574-8', '2013-08-08', 'Female', 'AB+', 'Islam', 'Pakistani', '2022-04-01', 'active', NULL, 'khadija.imran.ali@gmail.com', 'House 17, Street 8, G-11/2, Islamabad', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL, NULL),
(9, 1, 12, 'REG-2021-00196', '61101-1234575-9', '2010-09-09', 'Male', 'O+', 'Islam', 'Pakistani', '2019-04-01', 'active', NULL, 'faisal.akhtar.qazi@gmail.com', 'House 18, Street 1, G-11/2, Islamabad', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL, NULL),
(10, 1, 13, 'REG-2022-00197', '61101-1234576-1', '2011-10-10', 'Female', 'A+', 'Islam', 'Pakistani', '2020-04-01', 'active', NULL, 'rabia.shahid.awan@gmail.com', 'House 19, Street 2, G-11/2, Islamabad', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL, NULL),
(11, 1, 14, 'REG-2018-00198', '61101-1234577-2', '2012-01-11', 'Male', 'B+', 'Islam', 'Pakistani', '2021-04-01', 'active', NULL, 'ali.hassan.siddiqui@gmail.com', 'House 20, Street 3, G-11/2, Islamabad', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL, NULL),
(12, 1, 15, 'REG-2019-00199', '61101-1234578-3', '2013-02-12', 'Female', 'AB+', 'Islam', 'Pakistani', '2022-04-01', 'active', NULL, 'maryam.zahid.baig@gmail.com', 'House 21, Street 4, G-11/2, Islamabad', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL, NULL),
(13, 2, 17, 'REG-2025-99999', '35202-7654321-1', '2012-01-10', 'Male', 'A+', 'Islam', 'Pakistani', '2025-04-01', 'active', NULL, 'lahore.student@gmail.com', 'Johar Town, Lahore', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_academic_records`
--

CREATE TABLE `student_academic_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `roll_no` varchar(20) NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 1,
  `assigned_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_academic_records`
--

INSERT INTO `student_academic_records` (`id`, `campus_id`, `student_id`, `academic_year_id`, `school_class_id`, `section_id`, `roll_no`, `is_current`, `assigned_at`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 1, 4, 8, '01', 1, '2025-04-01', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(2, 1, 2, 1, 2, 4, '02', 1, '2025-04-01', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(3, 1, 3, 1, 5, 10, '03', 1, '2025-04-01', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(4, 1, 4, 1, 3, 7, '04', 1, '2025-04-01', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(5, 1, 5, 1, 1, 1, '05', 1, '2025-04-01', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(6, 1, 6, 1, 2, 3, '06', 1, '2025-04-01', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(7, 1, 7, 1, 3, 5, '07', 1, '2025-04-01', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(8, 1, 8, 1, 4, 9, '08', 1, '2025-04-01', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(9, 1, 9, 1, 5, 11, '09', 1, '2025-04-01', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(10, 1, 10, 1, 1, 2, '10', 1, '2025-04-01', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(11, 1, 11, 1, 3, 6, '11', 1, '2025-04-01', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(12, 1, 12, 1, 2, 4, '12', 1, '2025-04-01', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL DEFAULT 'manual',
  `marked_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`id`, `campus_id`, `student_id`, `section_id`, `attendance_date`, `status`, `method`, `marked_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, '2026-04-13', 'late', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(2, 1, 1, 8, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(3, 1, 1, 8, '2026-04-11', 'absent', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(4, 1, 1, 8, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(5, 1, 1, 8, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(6, 1, 1, 8, '2026-04-08', 'leave', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(7, 1, 1, 8, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(8, 1, 1, 8, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(9, 1, 1, 8, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(10, 1, 1, 8, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(11, 1, 1, 8, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(12, 1, 1, 8, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(13, 1, 1, 8, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(14, 1, 1, 8, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(15, 1, 2, 4, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(16, 1, 2, 4, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(17, 1, 2, 4, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(18, 1, 2, 4, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(19, 1, 2, 4, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(20, 1, 2, 4, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(21, 1, 2, 4, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(22, 1, 2, 4, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(23, 1, 2, 4, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(24, 1, 2, 4, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(25, 1, 2, 4, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(26, 1, 2, 4, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(27, 1, 2, 4, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(28, 1, 2, 4, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(29, 1, 3, 10, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(30, 1, 3, 10, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(31, 1, 3, 10, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(32, 1, 3, 10, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(33, 1, 3, 10, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(34, 1, 3, 10, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(35, 1, 3, 10, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(36, 1, 3, 10, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(37, 1, 3, 10, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(38, 1, 3, 10, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(39, 1, 3, 10, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(40, 1, 3, 10, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(41, 1, 3, 10, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(42, 1, 3, 10, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(43, 1, 4, 7, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(44, 1, 4, 7, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(45, 1, 4, 7, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(46, 1, 4, 7, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(47, 1, 4, 7, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(48, 1, 4, 7, '2026-04-08', 'leave', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(49, 1, 4, 7, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(50, 1, 4, 7, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(51, 1, 4, 7, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(52, 1, 4, 7, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(53, 1, 4, 7, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(54, 1, 4, 7, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(55, 1, 4, 7, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(56, 1, 4, 7, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(57, 1, 5, 1, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(58, 1, 5, 1, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(59, 1, 5, 1, '2026-04-11', 'absent', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(60, 1, 5, 1, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(61, 1, 5, 1, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(62, 1, 5, 1, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(63, 1, 5, 1, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(64, 1, 5, 1, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(65, 1, 5, 1, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(66, 1, 5, 1, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(67, 1, 5, 1, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(68, 1, 5, 1, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(69, 1, 5, 1, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(70, 1, 5, 1, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(71, 1, 6, 3, '2026-04-13', 'late', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(72, 1, 6, 3, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(73, 1, 6, 3, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(74, 1, 6, 3, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(75, 1, 6, 3, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(76, 1, 6, 3, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(77, 1, 6, 3, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(78, 1, 6, 3, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(79, 1, 6, 3, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(80, 1, 6, 3, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(81, 1, 6, 3, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(82, 1, 6, 3, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(83, 1, 6, 3, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(84, 1, 6, 3, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(85, 1, 7, 5, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(86, 1, 7, 5, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(87, 1, 7, 5, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(88, 1, 7, 5, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(89, 1, 7, 5, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(90, 1, 7, 5, '2026-04-08', 'leave', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(91, 1, 7, 5, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(92, 1, 7, 5, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(93, 1, 7, 5, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(94, 1, 7, 5, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(95, 1, 7, 5, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(96, 1, 7, 5, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(97, 1, 7, 5, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(98, 1, 7, 5, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(99, 1, 8, 9, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(100, 1, 8, 9, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(101, 1, 8, 9, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(102, 1, 8, 9, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(103, 1, 8, 9, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(104, 1, 8, 9, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(105, 1, 8, 9, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(106, 1, 8, 9, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(107, 1, 8, 9, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(108, 1, 8, 9, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(109, 1, 8, 9, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(110, 1, 8, 9, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(111, 1, 8, 9, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(112, 1, 8, 9, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(113, 1, 9, 11, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(114, 1, 9, 11, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(115, 1, 9, 11, '2026-04-11', 'absent', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(116, 1, 9, 11, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(117, 1, 9, 11, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(118, 1, 9, 11, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(119, 1, 9, 11, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(120, 1, 9, 11, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(121, 1, 9, 11, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(122, 1, 9, 11, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(123, 1, 9, 11, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(124, 1, 9, 11, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(125, 1, 9, 11, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(126, 1, 9, 11, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(127, 1, 10, 2, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(128, 1, 10, 2, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(129, 1, 10, 2, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(130, 1, 10, 2, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(131, 1, 10, 2, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(132, 1, 10, 2, '2026-04-08', 'leave', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(133, 1, 10, 2, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(134, 1, 10, 2, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(135, 1, 10, 2, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(136, 1, 10, 2, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(137, 1, 10, 2, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(138, 1, 10, 2, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(139, 1, 10, 2, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(140, 1, 10, 2, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(141, 1, 11, 6, '2026-04-13', 'late', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(142, 1, 11, 6, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(143, 1, 11, 6, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(144, 1, 11, 6, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(145, 1, 11, 6, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(146, 1, 11, 6, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(147, 1, 11, 6, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(148, 1, 11, 6, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(149, 1, 11, 6, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(150, 1, 11, 6, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(151, 1, 11, 6, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(152, 1, 11, 6, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(153, 1, 11, 6, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(154, 1, 11, 6, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(155, 1, 12, 4, '2026-04-13', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(156, 1, 12, 4, '2026-04-12', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(157, 1, 12, 4, '2026-04-11', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(158, 1, 12, 4, '2026-04-10', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(159, 1, 12, 4, '2026-04-09', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(160, 1, 12, 4, '2026-04-08', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(161, 1, 12, 4, '2026-04-07', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(162, 1, 12, 4, '2026-04-06', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(163, 1, 12, 4, '2026-04-05', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(164, 1, 12, 4, '2026-04-04', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(165, 1, 12, 4, '2026-04-03', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(166, 1, 12, 4, '2026-04-02', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(167, 1, 12, 4, '2026-04-01', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43'),
(168, 1, 12, 4, '2026-03-31', 'present', 'manual', 2, '2026-04-13 01:37:43', '2026-04-13 01:37:43');

-- --------------------------------------------------------

--
-- Table structure for table `student_documents`
--

CREATE TABLE `student_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_fee_discounts`
--

CREATE TABLE `student_fee_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `fee_discount_id` bigint(20) UNSIGNED NOT NULL,
  `applied_from` date DEFAULT NULL,
  `applied_to` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_parents`
--

CREATE TABLE `student_parents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `father_cnic` varchar(20) DEFAULT NULL,
  `father_phone` varchar(20) NOT NULL,
  `father_occupation` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_phone` varchar(20) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_phone` varchar(20) DEFAULT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_parents`
--

INSERT INTO `student_parents` (`id`, `campus_id`, `student_id`, `father_name`, `father_cnic`, `father_phone`, `father_occupation`, `mother_name`, `mother_phone`, `guardian_name`, `guardian_phone`, `emergency_contact`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 'Bilal Ahmed Khan', '61101-9876543-1', '0312-3456789', 'Software Engineer', 'Ayesha Bilal', '0345-9876543', 'Bilal Ahmed Khan', '0312-3456789', '0312-3456789', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(2, 1, 2, 'Noor Muhammad', '61101-9876544-2', '0333-8765432', 'Businessman', 'Sadia Noor', '0340-8765432', 'Noor Muhammad', '0333-8765432', '0333-8765432', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(3, 1, 3, 'Abbas Mirza', '61101-9876545-3', '0321-5544332', 'Banker', 'Hina Abbas', '0321-5544333', 'Abbas Mirza', '0321-5544332', '0321-5544332', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(4, 1, 4, 'Arshad Malik', '61101-9876546-4', '0345-1122334', 'Teacher', 'Sana Malik', '0345-1122335', 'Arshad Malik', '0345-1122334', '0345-1122334', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(5, 1, 5, 'Usman Sheikh', '61101-9876547-5', '0300-9988776', 'Trader', 'Amina Sheikh', '0300-9988777', 'Usman Sheikh', '0300-9988776', '0300-9988776', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(6, 1, 6, 'Tariq Butt', '61101-9876548-6', '0311-2233445', 'Engineer', 'Fiza Tariq', '0311-2233446', 'Tariq Butt', '0311-2233445', '0311-2233445', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(7, 1, 7, 'Raza Khan', '61101-9876549-7', '0312-9988001', 'Contractor', 'Rabia Raza', '0312-9988002', 'Raza Khan', '0312-9988001', '0312-9988001', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(8, 1, 8, 'Imran Ali', '61101-9876550-8', '0321-3344556', 'Doctor', 'Farah Imran', '0321-3344557', 'Imran Ali', '0321-3344556', '0321-3344556', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(9, 1, 9, 'Akhtar Qazi', '61101-9876551-9', '0300-7766554', 'Advocate', 'Zehra Akhtar', '0300-7766555', 'Akhtar Qazi', '0300-7766554', '0300-7766554', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(10, 1, 10, 'Shahid Awan', '61101-9876552-1', '0333-2211009', 'Accountant', 'Lubna Shahid', '0333-2211010', 'Shahid Awan', '0333-2211009', '0333-2211009', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(11, 1, 11, 'Hassan Siddiqui', '61101-9876553-2', '0312-4455667', 'Architect', 'Maha Hassan', '0312-4455668', 'Hassan Siddiqui', '0312-4455667', '0312-4455667', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL),
(12, 1, 12, 'Zahid Baig', '61101-9876554-3', '0345-8877665', 'Lecturer', 'Nida Zahid', '0345-8877666', 'Zahid Baig', '0345-8877665', '0345-8877665', '2026-04-13 01:37:42', '2026-04-13 01:37:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_promotions`
--

CREATE TABLE `student_promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `from_academic_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_academic_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_school_class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_school_class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `promoted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `promoted_at` timestamp NULL DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `subject_type` varchar(255) NOT NULL DEFAULT 'theory',
  `is_optional` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `campus_id`, `name`, `code`, `subject_type`, `is_optional`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 'Mathematics', 'MTH', 'theory', 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(2, 1, 'English', 'ENG', 'theory', 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(3, 1, 'Urdu', 'URD', 'theory', 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(4, 1, 'Physics', 'PHY', 'theory', 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(5, 1, 'Chemistry', 'CHE', 'theory', 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(6, 1, 'Biology', 'BIO', 'theory', 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL),
(7, 1, 'Computer Science', 'CSC', 'theory', 0, '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `syllabus_progress`
--

CREATE TABLE `syllabus_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `campus_id`, `academic_year_id`, `name`, `start_date`, `end_date`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 1, 1, 'Mid Term', '2025-09-01', '2025-11-15', '2026-04-13 01:37:41', '2026-04-13 01:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timetable_entries`
--

CREATE TABLE `timetable_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `timetable_slot_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `room_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timetable_slots`
--

CREATE TABLE `timetable_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `period_no` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_break` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_assignments`
--

CREATE TABLE `transport_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `transport_route_id` bigint(20) UNSIGNED NOT NULL,
  `transport_pickup_point_id` bigint(20) UNSIGNED NOT NULL,
  `transport_vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_at` date NOT NULL,
  `ended_at` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_pickup_points`
--

CREATE TABLE `transport_pickup_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `transport_route_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `pickup_time` time DEFAULT NULL,
  `additional_fare` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_routes`
--

CREATE TABLE `transport_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `route_code` varchar(255) DEFAULT NULL,
  `fare` decimal(12,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_vehicles`
--

CREATE TABLE `transport_vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campus_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_no` varchar(255) NOT NULL,
  `vehicle_model` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `driver_phone` varchar(255) DEFAULT NULL,
  `driver_license` varchar(255) DEFAULT NULL,
  `capacity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `campus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'campus_admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `school_id`, `campus_id`, `name`, `email`, `phone`, `role`, `is_active`, `email_verified_at`, `last_login_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Muhammad Asif', 'superadmin@educore.test', '0300-1111111', 'super_admin', 1, NULL, NULL, '$2y$10$hsE4md3TXEElG2fZcErkp.EvIZIcVbmnCPX42lVGA.ONuG/orqHL2', NULL, '2026-04-13 01:37:40', '2026-04-13 01:37:40'),
(2, NULL, 1, 'Muhammad Asif', 'admin@alfalah.edu.pk', '0312-3456789', 'campus_admin', 1, NULL, '2026-04-24 11:53:17', '$2y$10$aXc1fFfG/bftsw/.u0KCiOZ.EXIzmQXnbQso9wY4g9xq1L.pRo2uu', 'LMFheKJ8pJPffU2yrwoGFXNTzLmtQJHbGtIQae3Yl817uMFqx7wkrhjZGoDy', '2026-04-13 01:37:41', '2026-04-24 11:53:17'),
(3, NULL, 1, 'Bilal Ahmed', 'teacher@alfalah.edu.pk', '0311-1234567', 'teacher', 1, NULL, NULL, '$2y$10$KW/fmIQokHY8RtEnkYPRwu4mjch1x7aY48IxgTrhXzhqopfUSbRUK', NULL, '2026-04-13 01:37:41', '2026-04-13 01:37:41'),
(4, NULL, 1, 'Ahmed Bilal Khan', 'student1@alfalah.edu.pk', '0312-3456789', 'student', 1, NULL, NULL, '$2y$10$4ryKB/dTcVbrksmZf.7N/usRWam0pgwRiOQg5G3No1h/RuG1Fb9jS', NULL, '2026-04-13 01:37:41', '2026-04-13 01:37:41'),
(5, NULL, 1, 'Sara Noor Fatima', 'student2@alfalah.edu.pk', '0333-8765432', 'student', 1, NULL, NULL, '$2y$10$gcJ5C2Jucca0/KcrZtG2/OItxMqSe0qbi6qvtrPUJS97Gs3e7UKtS', NULL, '2026-04-13 01:37:41', '2026-04-13 01:37:41'),
(6, NULL, 1, 'Zaid Abbas Mirza', 'student3@alfalah.edu.pk', '0321-5544332', 'student', 1, NULL, NULL, '$2y$10$uahgpBOQaLo1YWZp8IUS6ugpqhol45aJy8mpok0CuvoFLHKk2r4fW', NULL, '2026-04-13 01:37:41', '2026-04-13 01:37:41'),
(7, NULL, 1, 'Hina Arshad Malik', 'student4@alfalah.edu.pk', '0345-1122334', 'student', 1, NULL, NULL, '$2y$10$D36wlsnfJ8sLOK0QGXufvOHEYUFPyapZ/cSbJTVQR1IPCgrsgt0KO', NULL, '2026-04-13 01:37:41', '2026-04-13 01:37:41'),
(8, NULL, 1, 'Omar Usman Sheikh', 'student5@alfalah.edu.pk', '0300-9988776', 'student', 1, NULL, NULL, '$2y$10$QgtH0TSkd.oJ21LhaYG/EeqY0BEPRaWliZyX4r2LvTyjff6OLqJHu', NULL, '2026-04-13 01:37:41', '2026-04-13 01:37:41'),
(9, NULL, 1, 'Amna Tariq Butt', 'student6@alfalah.edu.pk', '0311-2233445', 'student', 1, NULL, NULL, '$2y$10$dxkN65b1ol9PlFeBRt6an.yEy30NiIGgHVCep./wXgy67S3D3AJiG', NULL, '2026-04-13 01:37:41', '2026-04-13 01:37:41'),
(10, NULL, 1, 'Hamza Raza Khan', 'student7@alfalah.edu.pk', '0312-9988001', 'student', 1, NULL, NULL, '$2y$10$A9bd4t4GXuN.6LC6dGnF5.RDahTw1ljXYbPUByRbEdR546d0DK45m', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(11, NULL, 1, 'Khadija Imran Ali', 'student8@alfalah.edu.pk', '0321-3344556', 'student', 1, NULL, NULL, '$2y$10$DP9bqpWj0uwjFO7N5kyUjusgECoY0x8boVhdcuaypsI.k/723wggO', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(12, NULL, 1, 'Faisal Akhtar Qazi', 'student9@alfalah.edu.pk', '0300-7766554', 'student', 1, NULL, NULL, '$2y$10$4l06.55OKxs645meKJYHaOz9n1mPwJJBFZLMV8Ow/jjvZZ3OT355m', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(13, NULL, 1, 'Rabia Shahid Awan', 'student10@alfalah.edu.pk', '0333-2211009', 'student', 1, NULL, NULL, '$2y$10$E7ilj9ojfnOgh4pD0etULO6XlTjmMWG5jvf4JC0dSu8nqVqUMcEzK', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(14, NULL, 1, 'Ali Hassan Siddiqui', 'student11@alfalah.edu.pk', '0312-4455667', 'student', 1, NULL, NULL, '$2y$10$iA8/VghPKR4ryb0IBIX/O.SecaoWF0ACE8Pd2Olrrl6GL4CCLghVW', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(15, NULL, 1, 'Maryam Zahid Baig', 'student12@alfalah.edu.pk', '0345-8877665', 'student', 1, NULL, NULL, '$2y$10$dxjSby9KlOB0gODP4n3UZ.4dTX.5MYOeaAHLoGo.cvp9Fys2EOsza', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(16, NULL, 2, 'Lahore Admin', 'admin.lahore@alfalah.edu.pk', '0301-0000000', 'campus_admin', 1, NULL, NULL, '$2y$10$wSa41akEOXM2/yCaEx2LC.NEasJxTGoeLgWRFUKoSezsDEj6LQof.', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42'),
(17, NULL, 2, 'Other Campus Student', 'lahore.student@alfalah.edu.pk', '0302-0000000', 'student', 1, NULL, NULL, '$2y$10$jlZF1UxJB8az.QoD4HloFuXlWFssrN6njiuf7ONjLq.EQsxTCZTiS', NULL, '2026-04-13 01:37:42', '2026-04-13 01:37:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_years_campus_id_foreign` (`campus_id`),
  ADD KEY `academic_years_school_id_foreign` (`school_id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_campus_id_foreign` (`campus_id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`),
  ADD KEY `activity_logs_school_id_foreign` (`school_id`);

--
-- Indexes for table `admission_inquiries`
--
ALTER TABLE `admission_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_inquiries_campus_id_foreign` (`campus_id`),
  ADD KEY `admission_inquiries_school_class_id_foreign` (`school_class_id`);

--
-- Indexes for table `alumnis`
--
ALTER TABLE `alumnis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumnis_campus_id_foreign` (`campus_id`),
  ADD KEY `alumnis_student_id_foreign` (`student_id`);

--
-- Indexes for table `alumni_events`
--
ALTER TABLE `alumni_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_events_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_code_unique` (`code`),
  ADD KEY `assets_campus_id_foreign` (`campus_id`),
  ADD KEY `assets_asset_category_id_foreign` (`asset_category_id`),
  ADD KEY `assets_school_id_foreign` (`school_id`);

--
-- Indexes for table `asset_assignments`
--
ALTER TABLE `asset_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_assignments_campus_id_foreign` (`campus_id`),
  ADD KEY `asset_assignments_asset_id_foreign` (`asset_id`),
  ADD KEY `asset_assignments_assigned_to_type_assigned_to_id_index` (`assigned_to_type`,`assigned_to_id`),
  ADD KEY `asset_assignments_school_id_foreign` (`school_id`);

--
-- Indexes for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_categories_campus_id_foreign` (`campus_id`),
  ADD KEY `asset_categories_school_id_foreign` (`school_id`);

--
-- Indexes for table `campuses`
--
ALTER TABLE `campuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `campuses_code_unique` (`code`),
  ADD KEY `campuses_school_id_foreign` (`school_id`);

--
-- Indexes for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificate_templates_campus_id_foreign` (`campus_id`),
  ADD KEY `certificate_templates_school_id_foreign` (`school_id`);

--
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_subjects_campus_id_foreign` (`campus_id`),
  ADD KEY `class_subjects_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `class_subjects_school_class_id_foreign` (`school_class_id`),
  ADD KEY `class_subjects_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domains_domain_unique` (`domain`),
  ADD KEY `domains_school_id_foreign` (`school_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_code_unique` (`employee_code`),
  ADD KEY `employees_campus_id_foreign` (`campus_id`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_school_id_foreign` (`school_id`);

--
-- Indexes for table `employee_assignments`
--
ALTER TABLE `employee_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_assignments_campus_id_foreign` (`campus_id`),
  ADD KEY `employee_assignments_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_assignments_subject_id_foreign` (`subject_id`),
  ADD KEY `employee_assignments_school_class_id_foreign` (`school_class_id`),
  ADD KEY `employee_assignments_section_id_foreign` (`section_id`),
  ADD KEY `employee_assignments_academic_year_id_foreign` (`academic_year_id`);

--
-- Indexes for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_attendance_campus_id_foreign` (`campus_id`),
  ADD KEY `employee_attendance_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_campus_id_foreign` (`campus_id`),
  ADD KEY `exams_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `exams_term_id_foreign` (`term_id`),
  ADD KEY `exams_exam_type_id_foreign` (`exam_type_id`),
  ADD KEY `exams_school_class_id_foreign` (`school_class_id`),
  ADD KEY `exams_school_id_foreign` (`school_id`);

--
-- Indexes for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_types_campus_id_foreign` (`campus_id`),
  ADD KEY `exam_types_school_id_foreign` (`school_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_discounts`
--
ALTER TABLE `fee_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_discounts_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `fee_invoices`
--
ALTER TABLE `fee_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fee_invoices_challan_no_unique` (`challan_no`),
  ADD KEY `fee_invoices_campus_id_foreign` (`campus_id`),
  ADD KEY `fee_invoices_student_id_foreign` (`student_id`),
  ADD KEY `fee_invoices_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `fee_invoices_fee_type_id_foreign` (`fee_type_id`),
  ADD KEY `fee_invoices_school_id_foreign` (`school_id`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fee_payments_receipt_no_unique` (`receipt_no`),
  ADD KEY `fee_payments_campus_id_foreign` (`campus_id`),
  ADD KEY `fee_payments_fee_invoice_id_foreign` (`fee_invoice_id`),
  ADD KEY `fee_payments_student_id_foreign` (`student_id`),
  ADD KEY `fee_payments_received_by_foreign` (`received_by`),
  ADD KEY `fee_payments_school_id_foreign` (`school_id`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_structures_campus_id_foreign` (`campus_id`),
  ADD KEY `fee_structures_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `fee_structures_school_class_id_foreign` (`school_class_id`),
  ADD KEY `fee_structures_fee_type_id_foreign` (`fee_type_id`),
  ADD KEY `fee_structures_school_id_foreign` (`school_id`);

--
-- Indexes for table `fee_types`
--
ALTER TABLE `fee_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_types_campus_id_foreign` (`campus_id`),
  ADD KEY `fee_types_school_id_foreign` (`school_id`);

--
-- Indexes for table `front_office_complaints`
--
ALTER TABLE `front_office_complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_office_complaints_campus_id_foreign` (`campus_id`),
  ADD KEY `front_office_complaints_school_id_foreign` (`school_id`);

--
-- Indexes for table `front_office_enquiries`
--
ALTER TABLE `front_office_enquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_office_enquiries_campus_id_foreign` (`campus_id`),
  ADD KEY `front_office_enquiries_school_id_foreign` (`school_id`);

--
-- Indexes for table `front_office_visitors`
--
ALTER TABLE `front_office_visitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_office_visitors_campus_id_foreign` (`campus_id`),
  ADD KEY `front_office_visitors_school_id_foreign` (`school_id`);

--
-- Indexes for table `grade_scales`
--
ALTER TABLE `grade_scales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_scales_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework_submissions`
--
ALTER TABLE `homework_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homework_submissions_school_id_foreign` (`school_id`);

--
-- Indexes for table `hostels`
--
ALTER TABLE `hostels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hostels_campus_id_foreign` (`campus_id`),
  ADD KEY `hostels_school_id_foreign` (`school_id`);

--
-- Indexes for table `hostel_allocations`
--
ALTER TABLE `hostel_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hostel_allocations_campus_id_foreign` (`campus_id`),
  ADD KEY `hostel_allocations_hostel_room_id_foreign` (`hostel_room_id`),
  ADD KEY `hostel_allocations_student_id_foreign` (`student_id`),
  ADD KEY `hostel_allocations_school_id_foreign` (`school_id`);

--
-- Indexes for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hostel_rooms_campus_id_foreign` (`campus_id`),
  ADD KEY `hostel_rooms_hostel_id_foreign` (`hostel_id`),
  ADD KEY `hostel_rooms_school_id_foreign` (`school_id`);

--
-- Indexes for table `id_card_templates`
--
ALTER TABLE `id_card_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_card_templates_campus_id_foreign` (`campus_id`),
  ADD KEY `id_card_templates_school_id_foreign` (`school_id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_items_school_id_foreign` (`school_id`);

--
-- Indexes for table `inventory_item_issues`
--
ALTER TABLE `inventory_item_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_item_issues_school_id_foreign` (`school_id`);

--
-- Indexes for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_suppliers_school_id_foreign` (`school_id`);

--
-- Indexes for table `lesson_plans`
--
ALTER TABLE `lesson_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_plans_campus_id_foreign` (`campus_id`),
  ADD KEY `lesson_plans_school_class_id_foreign` (`school_class_id`),
  ADD KEY `lesson_plans_subject_id_foreign` (`subject_id`),
  ADD KEY `lesson_plans_teacher_id_foreign` (`teacher_id`),
  ADD KEY `lesson_plans_school_id_foreign` (`school_id`);

--
-- Indexes for table `library_books`
--
ALTER TABLE `library_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `library_books_campus_id_foreign` (`campus_id`),
  ADD KEY `library_books_school_id_foreign` (`school_id`);

--
-- Indexes for table `library_issues`
--
ALTER TABLE `library_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `library_issues_campus_id_foreign` (`campus_id`),
  ADD KEY `library_issues_library_book_id_foreign` (`library_book_id`),
  ADD KEY `library_issues_library_member_id_foreign` (`library_member_id`),
  ADD KEY `library_issues_school_id_foreign` (`school_id`);

--
-- Indexes for table `library_members`
--
ALTER TABLE `library_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `library_members_library_card_no_unique` (`library_card_no`),
  ADD KEY `library_members_campus_id_foreign` (`campus_id`),
  ADD KEY `library_members_user_id_foreign` (`user_id`),
  ADD KEY `library_members_school_id_foreign` (`school_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marks_campus_id_foreign` (`campus_id`),
  ADD KEY `marks_exam_id_foreign` (`exam_id`),
  ADD KEY `marks_student_id_foreign` (`student_id`),
  ADD KEY `marks_subject_id_foreign` (`subject_id`),
  ADD KEY `marks_entered_by_foreign` (`entered_by`),
  ADD KEY `marks_school_id_foreign` (`school_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_campus_id_foreign` (`campus_id`);

--
-- Indexes for table `online_exams`
--
ALTER TABLE `online_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `online_exams_campus_id_foreign` (`campus_id`),
  ADD KEY `online_exams_school_id_foreign` (`school_id`);

--
-- Indexes for table `online_exam_attempts`
--
ALTER TABLE `online_exam_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `online_exam_attempts_campus_id_foreign` (`campus_id`),
  ADD KEY `online_exam_attempts_online_exam_id_foreign` (`online_exam_id`),
  ADD KEY `online_exam_attempts_student_id_foreign` (`student_id`),
  ADD KEY `online_exam_attempts_school_id_foreign` (`school_id`);

--
-- Indexes for table `online_exam_questions`
--
ALTER TABLE `online_exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `online_exam_questions_campus_id_foreign` (`campus_id`),
  ADD KEY `online_exam_questions_online_exam_id_foreign` (`online_exam_id`),
  ADD KEY `online_exam_questions_school_id_foreign` (`school_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payrolls_campus_id_foreign` (`campus_id`),
  ADD KEY `payrolls_employee_id_foreign` (`employee_id`),
  ADD KEY `payrolls_school_id_foreign` (`school_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schools_slug_unique` (`slug`),
  ADD KEY `schools_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_classes_campus_id_foreign` (`campus_id`),
  ADD KEY `school_classes_school_id_foreign` (`school_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_campus_id_foreign` (`campus_id`),
  ADD KEY `sections_school_class_id_foreign` (`school_class_id`),
  ADD KEY `sections_school_id_foreign` (`school_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_campus_id_key_unique` (`campus_id`,`key`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_logs_campus_id_foreign` (`campus_id`),
  ADD KEY `sms_logs_notification_id_foreign` (`notification_id`);

--
-- Indexes for table `staff_attendances`
--
ALTER TABLE `staff_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_attendances_campus_id_foreign` (`campus_id`),
  ADD KEY `staff_attendances_employee_id_foreign` (`employee_id`),
  ADD KEY `staff_attendances_school_id_foreign` (`school_id`);

--
-- Indexes for table `staff_leaves`
--
ALTER TABLE `staff_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_leaves_campus_id_foreign` (`campus_id`),
  ADD KEY `staff_leaves_employee_id_foreign` (`employee_id`),
  ADD KEY `staff_leaves_approved_by_foreign` (`approved_by`),
  ADD KEY `staff_leaves_school_id_foreign` (`school_id`);

--
-- Indexes for table `staff_ratings`
--
ALTER TABLE `staff_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_ratings_campus_id_foreign` (`campus_id`),
  ADD KEY `staff_ratings_employee_id_foreign` (`employee_id`),
  ADD KEY `staff_ratings_rated_by_foreign` (`rated_by`),
  ADD KEY `staff_ratings_school_id_foreign` (`school_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_campus_id_b_form_no_unique` (`campus_id`,`b_form_no`),
  ADD UNIQUE KEY `students_registration_no_unique` (`registration_no`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_school_id_foreign` (`school_id`);

--
-- Indexes for table `student_academic_records`
--
ALTER TABLE `student_academic_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_academic_records_campus_id_foreign` (`campus_id`),
  ADD KEY `student_academic_records_student_id_foreign` (`student_id`),
  ADD KEY `student_academic_records_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `student_academic_records_school_class_id_foreign` (`school_class_id`),
  ADD KEY `student_academic_records_section_id_foreign` (`section_id`),
  ADD KEY `student_academic_records_school_id_foreign` (`school_id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_attendance_student_id_attendance_date_unique` (`student_id`,`attendance_date`),
  ADD KEY `student_attendance_campus_id_foreign` (`campus_id`),
  ADD KEY `student_attendance_section_id_foreign` (`section_id`),
  ADD KEY `student_attendance_marked_by_foreign` (`marked_by`);

--
-- Indexes for table `student_documents`
--
ALTER TABLE `student_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_documents_campus_id_foreign` (`campus_id`),
  ADD KEY `student_documents_student_id_foreign` (`student_id`);

--
-- Indexes for table `student_fee_discounts`
--
ALTER TABLE `student_fee_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_fee_discounts_campus_id_foreign` (`campus_id`),
  ADD KEY `student_fee_discounts_student_id_foreign` (`student_id`),
  ADD KEY `student_fee_discounts_fee_discount_id_foreign` (`fee_discount_id`);

--
-- Indexes for table `student_parents`
--
ALTER TABLE `student_parents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_parents_campus_id_foreign` (`campus_id`),
  ADD KEY `student_parents_student_id_foreign` (`student_id`),
  ADD KEY `student_parents_school_id_foreign` (`school_id`);

--
-- Indexes for table `student_promotions`
--
ALTER TABLE `student_promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_promotions_campus_id_foreign` (`campus_id`),
  ADD KEY `student_promotions_student_id_foreign` (`student_id`),
  ADD KEY `student_promotions_from_academic_year_id_foreign` (`from_academic_year_id`),
  ADD KEY `student_promotions_to_academic_year_id_foreign` (`to_academic_year_id`),
  ADD KEY `student_promotions_from_school_class_id_foreign` (`from_school_class_id`),
  ADD KEY `student_promotions_to_school_class_id_foreign` (`to_school_class_id`),
  ADD KEY `student_promotions_promoted_by_foreign` (`promoted_by`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_campus_id_foreign` (`campus_id`),
  ADD KEY `subjects_school_id_foreign` (`school_id`);

--
-- Indexes for table `syllabus_progress`
--
ALTER TABLE `syllabus_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `syllabus_progress_school_id_foreign` (`school_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terms_campus_id_foreign` (`campus_id`),
  ADD KEY `terms_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `terms_school_id_foreign` (`school_id`);

--
-- Indexes for table `timetable_entries`
--
ALTER TABLE `timetable_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_section_slot` (`timetable_slot_id`,`section_id`),
  ADD UNIQUE KEY `unique_teacher_slot` (`timetable_slot_id`,`employee_id`),
  ADD KEY `timetable_entries_campus_id_foreign` (`campus_id`),
  ADD KEY `timetable_entries_academic_year_id_foreign` (`academic_year_id`),
  ADD KEY `timetable_entries_school_class_id_foreign` (`school_class_id`),
  ADD KEY `timetable_entries_section_id_foreign` (`section_id`),
  ADD KEY `timetable_entries_subject_id_foreign` (`subject_id`),
  ADD KEY `timetable_entries_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `timetable_slots_campus_id_day_period_no_unique` (`campus_id`,`day`,`period_no`);

--
-- Indexes for table `transport_assignments`
--
ALTER TABLE `transport_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_assignments_campus_id_foreign` (`campus_id`),
  ADD KEY `transport_assignments_student_id_foreign` (`student_id`),
  ADD KEY `transport_assignments_transport_route_id_foreign` (`transport_route_id`),
  ADD KEY `transport_assignments_transport_pickup_point_id_foreign` (`transport_pickup_point_id`),
  ADD KEY `transport_assignments_transport_vehicle_id_foreign` (`transport_vehicle_id`),
  ADD KEY `transport_assignments_school_id_foreign` (`school_id`);

--
-- Indexes for table `transport_pickup_points`
--
ALTER TABLE `transport_pickup_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_pickup_points_campus_id_foreign` (`campus_id`),
  ADD KEY `transport_pickup_points_transport_route_id_foreign` (`transport_route_id`),
  ADD KEY `transport_pickup_points_school_id_foreign` (`school_id`);

--
-- Indexes for table `transport_routes`
--
ALTER TABLE `transport_routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_routes_campus_id_foreign` (`campus_id`),
  ADD KEY `transport_routes_school_id_foreign` (`school_id`);

--
-- Indexes for table `transport_vehicles`
--
ALTER TABLE `transport_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transport_vehicles_vehicle_no_unique` (`vehicle_no`),
  ADD KEY `transport_vehicles_campus_id_foreign` (`campus_id`),
  ADD KEY `transport_vehicles_school_id_foreign` (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_campus_id_foreign` (`campus_id`),
  ADD KEY `users_school_id_foreign` (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admission_inquiries`
--
ALTER TABLE `admission_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alumnis`
--
ALTER TABLE `alumnis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alumni_events`
--
ALTER TABLE `alumni_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_assignments`
--
ALTER TABLE `asset_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_categories`
--
ALTER TABLE `asset_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campuses`
--
ALTER TABLE `campuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_assignments`
--
ALTER TABLE `employee_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_types`
--
ALTER TABLE `exam_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_discounts`
--
ALTER TABLE `fee_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_invoices`
--
ALTER TABLE `fee_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_types`
--
ALTER TABLE `fee_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `front_office_complaints`
--
ALTER TABLE `front_office_complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_office_enquiries`
--
ALTER TABLE `front_office_enquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_office_visitors`
--
ALTER TABLE `front_office_visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_scales`
--
ALTER TABLE `grade_scales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `homework_submissions`
--
ALTER TABLE `homework_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_allocations`
--
ALTER TABLE `hostel_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id_card_templates`
--
ALTER TABLE `id_card_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_item_issues`
--
ALTER TABLE `inventory_item_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lesson_plans`
--
ALTER TABLE `lesson_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_books`
--
ALTER TABLE `library_books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_issues`
--
ALTER TABLE `library_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_members`
--
ALTER TABLE `library_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exams`
--
ALTER TABLE `online_exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_attempts`
--
ALTER TABLE `online_exam_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_questions`
--
ALTER TABLE `online_exam_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_classes`
--
ALTER TABLE `school_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_attendances`
--
ALTER TABLE `staff_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_leaves`
--
ALTER TABLE `staff_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_ratings`
--
ALTER TABLE `staff_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student_academic_records`
--
ALTER TABLE `student_academic_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `student_documents`
--
ALTER TABLE `student_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_fee_discounts`
--
ALTER TABLE `student_fee_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_parents`
--
ALTER TABLE `student_parents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student_promotions`
--
ALTER TABLE `student_promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `syllabus_progress`
--
ALTER TABLE `syllabus_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timetable_entries`
--
ALTER TABLE `timetable_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_assignments`
--
ALTER TABLE `transport_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_pickup_points`
--
ALTER TABLE `transport_pickup_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_routes`
--
ALTER TABLE `transport_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_vehicles`
--
ALTER TABLE `transport_vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD CONSTRAINT `academic_years_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_years_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admission_inquiries`
--
ALTER TABLE `admission_inquiries`
  ADD CONSTRAINT `admission_inquiries_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admission_inquiries_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumnis`
--
ALTER TABLE `alumnis`
  ADD CONSTRAINT `alumnis_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alumnis_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `alumni_events`
--
ALTER TABLE `alumni_events`
  ADD CONSTRAINT `alumni_events_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_asset_category_id_foreign` FOREIGN KEY (`asset_category_id`) REFERENCES `asset_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_assignments`
--
ALTER TABLE `asset_assignments`
  ADD CONSTRAINT `asset_assignments_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_assignments_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_assignments_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD CONSTRAINT `asset_categories_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_categories_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `campuses`
--
ALTER TABLE `campuses`
  ADD CONSTRAINT `campuses_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
  ADD CONSTRAINT `certificate_templates_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificate_templates_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD CONSTRAINT `class_subjects_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `domains`
--
ALTER TABLE `domains`
  ADD CONSTRAINT `domains_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_assignments`
--
ALTER TABLE `employee_assignments`
  ADD CONSTRAINT `employee_assignments_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_assignments_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_assignments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_assignments_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_assignments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_assignments_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  ADD CONSTRAINT `employee_attendance_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_attendance_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_exam_type_id_foreign` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD CONSTRAINT `exam_types_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_types_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_discounts`
--
ALTER TABLE `fee_discounts`
  ADD CONSTRAINT `fee_discounts_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_invoices`
--
ALTER TABLE `fee_invoices`
  ADD CONSTRAINT `fee_invoices_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_invoices_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_invoices_fee_type_id_foreign` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_invoices_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_invoices_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD CONSTRAINT `fee_payments_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_payments_fee_invoice_id_foreign` FOREIGN KEY (`fee_invoice_id`) REFERENCES `fee_invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fee_payments_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_payments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD CONSTRAINT `fee_structures_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_structures_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_structures_fee_type_id_foreign` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_structures_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_structures_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fee_types`
--
ALTER TABLE `fee_types`
  ADD CONSTRAINT `fee_types_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_types_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `front_office_complaints`
--
ALTER TABLE `front_office_complaints`
  ADD CONSTRAINT `front_office_complaints_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `front_office_complaints_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `front_office_enquiries`
--
ALTER TABLE `front_office_enquiries`
  ADD CONSTRAINT `front_office_enquiries_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `front_office_enquiries_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `front_office_visitors`
--
ALTER TABLE `front_office_visitors`
  ADD CONSTRAINT `front_office_visitors_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `front_office_visitors_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grade_scales`
--
ALTER TABLE `grade_scales`
  ADD CONSTRAINT `grade_scales_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `homework_submissions`
--
ALTER TABLE `homework_submissions`
  ADD CONSTRAINT `homework_submissions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hostels`
--
ALTER TABLE `hostels`
  ADD CONSTRAINT `hostels_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostels_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hostel_allocations`
--
ALTER TABLE `hostel_allocations`
  ADD CONSTRAINT `hostel_allocations_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_allocations_hostel_room_id_foreign` FOREIGN KEY (`hostel_room_id`) REFERENCES `hostel_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_allocations_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_allocations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
  ADD CONSTRAINT `hostel_rooms_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_rooms_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_rooms_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `id_card_templates`
--
ALTER TABLE `id_card_templates`
  ADD CONSTRAINT `id_card_templates_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_card_templates_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD CONSTRAINT `inventory_items_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_item_issues`
--
ALTER TABLE `inventory_item_issues`
  ADD CONSTRAINT `inventory_item_issues_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  ADD CONSTRAINT `inventory_suppliers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_plans`
--
ALTER TABLE `lesson_plans`
  ADD CONSTRAINT `lesson_plans_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_plans_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_plans_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_plans_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_plans_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `library_books`
--
ALTER TABLE `library_books`
  ADD CONSTRAINT `library_books_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_books_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `library_issues`
--
ALTER TABLE `library_issues`
  ADD CONSTRAINT `library_issues_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_issues_library_book_id_foreign` FOREIGN KEY (`library_book_id`) REFERENCES `library_books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_issues_library_member_id_foreign` FOREIGN KEY (`library_member_id`) REFERENCES `library_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_issues_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `library_members`
--
ALTER TABLE `library_members`
  ADD CONSTRAINT `library_members_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_members_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_entered_by_foreign` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `marks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `online_exams`
--
ALTER TABLE `online_exams`
  ADD CONSTRAINT `online_exams_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_exams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `online_exam_attempts`
--
ALTER TABLE `online_exam_attempts`
  ADD CONSTRAINT `online_exam_attempts_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_exam_attempts_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_exam_attempts_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_exam_attempts_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `online_exam_questions`
--
ALTER TABLE `online_exam_questions`
  ADD CONSTRAINT `online_exam_questions_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_exam_questions_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_exam_questions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payrolls_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payrolls_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`);

--
-- Constraints for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD CONSTRAINT `school_classes_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `school_classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sections_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD CONSTRAINT `sms_logs_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sms_logs_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staff_attendances`
--
ALTER TABLE `staff_attendances`
  ADD CONSTRAINT `staff_attendances_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_attendances_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_leaves`
--
ALTER TABLE `staff_leaves`
  ADD CONSTRAINT `staff_leaves_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_leaves_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_leaves_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_ratings`
--
ALTER TABLE `staff_ratings`
  ADD CONSTRAINT `staff_ratings_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_ratings_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_ratings_rated_by_foreign` FOREIGN KEY (`rated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_ratings_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `student_academic_records`
--
ALTER TABLE `student_academic_records`
  ADD CONSTRAINT `student_academic_records_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_academic_records_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_academic_records_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_academic_records_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_academic_records_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_academic_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `student_attendance_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendance_marked_by_foreign` FOREIGN KEY (`marked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_attendance_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendance_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_documents`
--
ALTER TABLE `student_documents`
  ADD CONSTRAINT `student_documents_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_documents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_fee_discounts`
--
ALTER TABLE `student_fee_discounts`
  ADD CONSTRAINT `student_fee_discounts_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_fee_discounts_fee_discount_id_foreign` FOREIGN KEY (`fee_discount_id`) REFERENCES `fee_discounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_fee_discounts_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_parents`
--
ALTER TABLE `student_parents`
  ADD CONSTRAINT `student_parents_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_parents_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_parents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_promotions`
--
ALTER TABLE `student_promotions`
  ADD CONSTRAINT `student_promotions_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_promotions_from_academic_year_id_foreign` FOREIGN KEY (`from_academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_promotions_from_school_class_id_foreign` FOREIGN KEY (`from_school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_promotions_promoted_by_foreign` FOREIGN KEY (`promoted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_promotions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_promotions_to_academic_year_id_foreign` FOREIGN KEY (`to_academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_promotions_to_school_class_id_foreign` FOREIGN KEY (`to_school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `syllabus_progress`
--
ALTER TABLE `syllabus_progress`
  ADD CONSTRAINT `syllabus_progress_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `terms_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terms_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terms_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetable_entries`
--
ALTER TABLE `timetable_entries`
  ADD CONSTRAINT `timetable_entries_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_entries_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_entries_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_entries_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_entries_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_entries_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetable_entries_timetable_slot_id_foreign` FOREIGN KEY (`timetable_slot_id`) REFERENCES `timetable_slots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  ADD CONSTRAINT `timetable_slots_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_assignments`
--
ALTER TABLE `transport_assignments`
  ADD CONSTRAINT `transport_assignments_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_assignments_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_assignments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_assignments_transport_pickup_point_id_foreign` FOREIGN KEY (`transport_pickup_point_id`) REFERENCES `transport_pickup_points` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_assignments_transport_route_id_foreign` FOREIGN KEY (`transport_route_id`) REFERENCES `transport_routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_assignments_transport_vehicle_id_foreign` FOREIGN KEY (`transport_vehicle_id`) REFERENCES `transport_vehicles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transport_pickup_points`
--
ALTER TABLE `transport_pickup_points`
  ADD CONSTRAINT `transport_pickup_points_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_pickup_points_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_pickup_points_transport_route_id_foreign` FOREIGN KEY (`transport_route_id`) REFERENCES `transport_routes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_routes`
--
ALTER TABLE `transport_routes`
  ADD CONSTRAINT `transport_routes_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_routes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_vehicles`
--
ALTER TABLE `transport_vehicles`
  ADD CONSTRAINT `transport_vehicles_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_vehicles_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
