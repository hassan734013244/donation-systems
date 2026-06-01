-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01 يونيو 2026 الساعة 09:56
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donation_system`
--

-- --------------------------------------------------------

--
-- بنية الجدول `approvals`
--

CREATE TABLE `approvals` (
  `id_approval` bigint(20) UNSIGNED NOT NULL,
  `id_supply` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approval_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `attachments`
--

CREATE TABLE `attachments` (
  `id_attachment` bigint(20) UNSIGNED NOT NULL,
  `attachable_type` varchar(255) NOT NULL,
  `attachable_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `attachments`
--

INSERT INTO `attachments` (`id_attachment`, `attachable_type`, `attachable_id`, `file_path`, `file_name`, `file_type`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Supply', 1, 'uploads/attachments/1779004328_6a0973a8b0b01.jpg', '20230330_181000 - frame at 0m4s.jpg', 'jpg', '2026-05-17 04:52:08', '2026-05-17 04:52:08');

-- --------------------------------------------------------

--
-- بنية الجدول `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id_log` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `operation_type` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `record_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `branches`
--

CREATE TABLE `branches` (
  `id_branch` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('ntham-adar-altbraaat-cache-alhmad112@gmail.com|127.0.0.1', 'i:1;', 1779000945),
('ntham-adar-altbraaat-cache-alhmad112@gmail.com|127.0.0.1:timer', 'i:1779000945;', 1779000945);

-- --------------------------------------------------------

--
-- بنية الجدول `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `currencies`
--

CREATE TABLE `currencies` (
  `id_currency` bigint(20) UNSIGNED NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  `exchange_rate` decimal(15,2) NOT NULL DEFAULT 1.00,
  `currency_name` varchar(255) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `currencies`
--

INSERT INTO `currencies` (`id_currency`, `currency_code`, `exchange_rate`, `currency_name`, `symbol`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'YER', 1.00, 'ريال يمني', 'ر.ي', 1, '2026-04-13 15:43:09', '2026-04-13 15:43:09'),
(2, 'SAR', 139.00, 'ريال سعودي', 'ر.س', 0, '2026-04-13 15:43:09', '2026-04-17 10:08:53'),
(3, 'USD', 533.00, 'دولار أمريكي', '$', 0, '2026-04-13 15:43:09', '2026-04-13 15:44:18');

-- --------------------------------------------------------

--
-- بنية الجدول `departments`
--

CREATE TABLE `departments` (
  `id_department` bigint(20) UNSIGNED NOT NULL,
  `name_department` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `departments`
--

INSERT INTO `departments` (`id_department`, `name_department`, `created_at`, `updated_at`) VALUES
(1, 'مدارس تعليم القرآن', '2026-05-13 09:06:02', '2026-05-13 09:06:02'),
(2, 'التوعية والتعليم', '2026-05-13 09:06:12', '2026-05-13 09:06:12'),
(3, 'التمكين الأسري', '2026-05-13 09:06:21', '2026-05-13 09:06:21'),
(4, 'الإدارة الإجتماعية', '2026-05-13 09:06:35', '2026-05-13 09:06:35'),
(5, 'التعليم عن بعد', '2026-05-13 09:06:48', '2026-05-13 09:06:48'),
(6, 'التدريب', '2026-05-13 09:07:08', '2026-05-13 09:07:08'),
(7, 'الإعلام', '2026-05-13 09:07:22', '2026-05-13 09:07:27'),
(8, 'المالية', '2026-05-13 09:29:43', '2026-05-13 09:29:43');

-- --------------------------------------------------------

--
-- بنية الجدول `disbursements`
--

CREATE TABLE `disbursements` (
  `id_disbursement` bigint(20) UNSIGNED NOT NULL,
  `id_supply` bigint(20) UNSIGNED NOT NULL,
  `amount` double(15,2) NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `statement` text DEFAULT NULL,
  `disbursement_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `donors`
--

CREATE TABLE `donors` (
  `id_donor` bigint(20) UNSIGNED NOT NULL,
  `donor_name` varchar(255) NOT NULL,
  `donor_type` enum('individual','organization','broker') NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `donors`
--

INSERT INTO `donors` (`id_donor`, `donor_name`, `donor_type`, `phone`, `email`, `address`, `created_at`, `updated_at`) VALUES
(3, 'الارض الطيبة', 'organization', NULL, NULL, NULL, '2026-05-17 04:50:36', '2026-05-17 04:50:36');

-- --------------------------------------------------------

--
-- بنية الجدول `donor_reports`
--

CREATE TABLE `donor_reports` (
  `id_report` bigint(20) UNSIGNED NOT NULL,
  `id_project` bigint(20) UNSIGNED NOT NULL,
  `id_donor` bigint(20) UNSIGNED NOT NULL,
  `id_supply` bigint(20) UNSIGNED DEFAULT NULL,
  `report_title` varchar(255) NOT NULL,
  `report_type` enum('financial','narrative','photos','final') NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('pending','completed','overdue') NOT NULL DEFAULT 'pending',
  `report_file` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `donor_reports`
--

INSERT INTO `donor_reports` (`id_report`, `id_project`, `id_donor`, `id_supply`, `report_title`, `report_type`, `due_date`, `status`, `report_file`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 'ختامي', 'final', '2026-07-31', 'pending', NULL, NULL, '2026-05-17 04:52:08', '2026-05-17 04:52:08');

-- --------------------------------------------------------

--
-- بنية الجدول `expenses`
--

CREATE TABLE `expenses` (
  `id_expense` bigint(20) UNSIGNED NOT NULL,
  `id_supply` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `statement` varchar(255) NOT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
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
-- بنية الجدول `funding_entities`
--

CREATE TABLE `funding_entities` (
  `id_entity` bigint(20) UNSIGNED NOT NULL,
  `entity_name` varchar(255) NOT NULL,
  `entity_type` enum('bank','cash','exchange') NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `funding_entities`
--

INSERT INTO `funding_entities` (`id_entity`, `entity_name`, `entity_type`, `account_number`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'مؤسسة الفتاة اليمنية التنموية', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_00_000000_create_departments_table', 1),
(2, '0001_01_01_000000_create_users_table', 1),
(3, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '2026_04_08_095949_create_branches_table', 1),
(6, '2026_04_08_100004_create_currencies_table', 1),
(7, '2026_04_08_100017_create_projects_table', 1),
(8, '2026_04_08_103249_create_roles_table', 1),
(9, '2026_04_08_103253_create_permissions_table', 1),
(10, '2026_04_08_103606_create_role_user_table', 1),
(11, '2026_04_08_103821_create_permission_role_table', 1),
(12, '2026_04_08_104400_create_donors_table', 1),
(13, '2026_04_08_104409_create_funding_entities_table', 1),
(14, '2026_04_08_105252_create_supplies_table', 1),
(15, '2026_04_08_111954_create_approvals_table', 1),
(16, '2026_04_08_112119_create_reports_table', 1),
(17, '2026_04_08_112139_create_audit_logs_table', 1),
(18, '2026_04_08_190304_add_exchange_rate_to_currencies_table', 1),
(19, '2026_04_08_191038_add_missing_columns_to_supplies_table', 1),
(20, '2026_04_08_191341_make_id_entity_nullable_in_supplies', 1),
(21, '2026_04_08_202649_create_donor_reports_table', 1),
(22, '2026_04_09_115516_add_extra_fields_to_supplies_table', 1),
(23, '2026_04_13_130812_create_attachments_table', 2),
(24, '2026_04_13_130820_create_expenses_table', 2),
(25, '2026_04_13_191407_add_rejection_reason_to_supplies_table', 3);

-- --------------------------------------------------------

--
-- بنية الجدول `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `permissions`
--

CREATE TABLE `permissions` (
  `id_permission` bigint(20) UNSIGNED NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `id_permission` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `projects`
--

CREATE TABLE `projects` (
  `id_project` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','completed','on_hold') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `projects`
--

INSERT INTO `projects` (`id_project`, `project_name`, `description`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'تجربة 1', NULL, '2026-04-01', '2026-07-31', 'active', '2026-05-17 04:02:48', '2026-05-17 04:15:49');

-- --------------------------------------------------------

--
-- بنية الجدول `reports`
--

CREATE TABLE `reports` (
  `id_report` bigint(20) UNSIGNED NOT NULL,
  `id_supply` bigint(20) UNSIGNED NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `roles`
--

CREATE TABLE `roles` (
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `roles`
--

INSERT INTO `roles` (`id_role`, `role_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'مدير', NULL, NULL, NULL),
(2, 'موظف', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `id_role`, `created_at`, `updated_at`) VALUES
(12, 13, 2, NULL, NULL),
(13, 14, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('67sCNWMNU4h9nKxwVjCjKeGU1AcktaXRBkpHXoOF', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJxZ3pSVnQyRUJZNXpvbVR0THladXJ2QUMyRGU5a2lYeUdKS2NWSVNXIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3VzZXJzIiwicm91dGUiOiJ1c2Vycy5pbmRleCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1779133354),
('bwIYUD7ZMJFjJtgDIIUbEH9Q6KusFeMzO6xSu5EW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'eyJfdG9rZW4iOiJac3Z0MlQ1bmpBOTdjenZONVVkN0VrRWNwbkFCdFRSaFg4c0NtblJZIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6bnVsbH19', 1779133161);

-- --------------------------------------------------------

--
-- بنية الجدول `supplies`
--

CREATE TABLE `supplies` (
  `id_supply` bigint(20) UNSIGNED NOT NULL,
  `id_project` bigint(20) UNSIGNED NOT NULL,
  `id_department` int(11) DEFAULT NULL,
  `id_donor` bigint(20) UNSIGNED NOT NULL,
  `id_entity` bigint(20) UNSIGNED DEFAULT NULL,
  `id_currency` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `statement` text DEFAULT NULL,
  `admin_ratio` decimal(5,2) NOT NULL DEFAULT 0.00,
  `transfer_ratio` decimal(5,2) NOT NULL DEFAULT 0.00,
  `other_ratio` decimal(5,2) NOT NULL DEFAULT 0.00,
  `admin_value` decimal(18,2) NOT NULL DEFAULT 0.00,
  `transfer_value` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_value` decimal(18,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(18,2) NOT NULL,
  `exchange_rate` decimal(18,6) NOT NULL DEFAULT 1.000000,
  `amount_base_currency` decimal(18,2) NOT NULL,
  `net_amount_base_currency` decimal(18,2) NOT NULL,
  `receipt_number` varchar(255) NOT NULL,
  `deposit_location` varchar(255) DEFAULT NULL,
  `supply_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('draft','pending','approved','rejected') NOT NULL DEFAULT 'draft',
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `supplies`
--

INSERT INTO `supplies` (`id_supply`, `id_project`, `id_department`, `id_donor`, `id_entity`, `id_currency`, `amount`, `quantity`, `statement`, `admin_ratio`, `transfer_ratio`, `other_ratio`, `admin_value`, `transfer_value`, `other_value`, `net_amount`, `exchange_rate`, `amount_base_currency`, `net_amount_base_currency`, `receipt_number`, `deposit_location`, `supply_date`, `notes`, `status`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 3, 1, 3, 2000.00, 10, 'تنفيذ المشروع كفالة تعليم عن بعد', 10.00, 0.00, 0.00, 200.00, 0.00, 0.00, 1800.00, 533.000000, 1066000.00, 959400.00, '1', 'صندوق المؤسسة', '2026-05-17', NULL, 'approved', NULL, '2026-05-17 04:52:08', '2026-05-17 04:52:19');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `id_department` bigint(20) UNSIGNED DEFAULT NULL,
  `id_role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `id_department`, `id_role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', NULL, '$2y$12$urZsiJMfeFU4sqEq9F10pO973SRgOOQFJKzb8PCuEkXgdfGSpzUFS', NULL, 'admin', 'active', NULL, '2026-04-13 10:32:34', '2026-04-13 10:32:34'),
(13, 'ايمان', 'a_m@fatat.info', NULL, '$2y$12$e9D7bqyaWiewU5Ystx6pF.uCVjFQ9hjhv6rhSE4MO79gtBZHFhd02', 7, 'user', 'active', NULL, '2026-05-13 09:09:35', '2026-05-13 09:09:35'),
(14, 'هارون البعداني', 'ha@fatat.info', NULL, '$2y$12$xzluUbnRg.kBLcAxLy3M/O2ReSpBfXfyOS9yIm3Mm8N7BGkZNz2IO', 4, 'user', 'active', NULL, '2026-05-13 09:15:45', '2026-05-13 09:15:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`id_approval`),
  ADD KEY `approvals_id_supply_foreign` (`id_supply`),
  ADD KEY `approvals_user_id_foreign` (`user_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id_attachment`),
  ADD KEY `attachments_attachable_type_attachable_id_index` (`attachable_type`,`attachable_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id_branch`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id_currency`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id_department`);

--
-- Indexes for table `disbursements`
--
ALTER TABLE `disbursements`
  ADD PRIMARY KEY (`id_disbursement`),
  ADD KEY `fk_disbursement_supply` (`id_supply`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id_donor`);

--
-- Indexes for table `donor_reports`
--
ALTER TABLE `donor_reports`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `donor_reports_id_project_foreign` (`id_project`),
  ADD KEY `donor_reports_id_donor_foreign` (`id_donor`),
  ADD KEY `donor_reports_id_supply_foreign` (`id_supply`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id_expense`),
  ADD KEY `expenses_id_supply_foreign` (`id_supply`),
  ADD KEY `expenses_id_user_foreign` (`id_user`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `funding_entities`
--
ALTER TABLE `funding_entities`
  ADD PRIMARY KEY (`id_entity`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_id_role_foreign` (`id_role`),
  ADD KEY `permission_role_id_permission_foreign` (`id_permission`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id_project`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `reports_id_supply_foreign` (`id_supply`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`),
  ADD KEY `role_user_id_role_foreign` (`id_role`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`id_supply`),
  ADD UNIQUE KEY `supplies_receipt_number_unique` (`receipt_number`),
  ADD KEY `supplies_id_project_foreign` (`id_project`),
  ADD KEY `supplies_id_donor_foreign` (`id_donor`),
  ADD KEY `supplies_id_entity_foreign` (`id_entity`),
  ADD KEY `supplies_id_currency_foreign` (`id_currency`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_department_id_foreign` (`id_department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id_approval` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id_attachment` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id_branch` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id_currency` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id_department` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `disbursements`
--
ALTER TABLE `disbursements`
  MODIFY `id_disbursement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id_donor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donor_reports`
--
ALTER TABLE `donor_reports`
  MODIFY `id_report` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id_expense` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funding_entities`
--
ALTER TABLE `funding_entities`
  MODIFY `id_entity` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id_permission` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id_project` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id_report` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `id_supply` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_id_supply_foreign` FOREIGN KEY (`id_supply`) REFERENCES `supplies` (`id_supply`) ON DELETE CASCADE,
  ADD CONSTRAINT `approvals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `disbursements`
--
ALTER TABLE `disbursements`
  ADD CONSTRAINT `fk_unique_disbursement_to_supply` FOREIGN KEY (`id_supply`) REFERENCES `supplies` (`id_supply`) ON DELETE CASCADE;

--
-- قيود الجداول `donor_reports`
--
ALTER TABLE `donor_reports`
  ADD CONSTRAINT `donor_reports_id_donor_foreign` FOREIGN KEY (`id_donor`) REFERENCES `donors` (`id_donor`) ON DELETE CASCADE,
  ADD CONSTRAINT `donor_reports_id_project_foreign` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id_project`) ON DELETE CASCADE,
  ADD CONSTRAINT `donor_reports_id_supply_foreign` FOREIGN KEY (`id_supply`) REFERENCES `supplies` (`id_supply`) ON DELETE CASCADE;

--
-- قيود الجداول `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_id_supply_foreign` FOREIGN KEY (`id_supply`) REFERENCES `supplies` (`id_supply`),
  ADD CONSTRAINT `expenses_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- قيود الجداول `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_id_permission_foreign` FOREIGN KEY (`id_permission`) REFERENCES `permissions` (`id_permission`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE;

--
-- قيود الجداول `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_id_supply_foreign` FOREIGN KEY (`id_supply`) REFERENCES `supplies` (`id_supply`) ON DELETE CASCADE;

--
-- قيود الجداول `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `supplies`
--
ALTER TABLE `supplies`
  ADD CONSTRAINT `supplies_id_currency_foreign` FOREIGN KEY (`id_currency`) REFERENCES `currencies` (`id_currency`),
  ADD CONSTRAINT `supplies_id_donor_foreign` FOREIGN KEY (`id_donor`) REFERENCES `donors` (`id_donor`),
  ADD CONSTRAINT `supplies_id_entity_foreign` FOREIGN KEY (`id_entity`) REFERENCES `funding_entities` (`id_entity`),
  ADD CONSTRAINT `supplies_id_project_foreign` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id_project`);

--
-- قيود الجداول `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`id_department`) REFERENCES `departments` (`id_department`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
