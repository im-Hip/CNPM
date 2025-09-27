-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: quanlylichhoc
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `receiver` enum('student','teacher','all') NOT NULL DEFAULT 'all',
  `seeding_time` datetime DEFAULT NULL,
  `schedule_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `announcements_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'Thông báo kiểm tra giữa kỳ','Học sinh chuẩn bị cho bài kiểm tra giữa kỳ môn Toán.','student','2025-09-26 09:41:23',1,'2025-09-25 02:41:23','2025-09-25 02:41:23'),(2,'Họp giáo viên','Toàn thể giáo viên họp vào thứ 6 tuần này tại phòng hội đồng.','teacher','2025-09-27 09:41:23',2,'2025-09-25 02:41:23','2025-09-25 02:41:23'),(3,'Nghỉ học toàn trường','Toàn trường nghỉ học vào ngày 10/10/2025 để bảo trì hệ thống.','all','2025-09-30 09:41:23',3,'2025-09-25 02:41:23','2025-09-25 02:41:23');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `number_of_students` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `classes_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'10A1','10','50','2025-09-24 02:58:49','2025-09-24 02:58:49'),(2,'10A2','10','50','2025-09-24 02:58:49','2025-09-24 02:58:49'),(3,'11A1','11','50','2025-09-24 02:58:49','2025-09-24 02:58:49'),(4,'12A1','12','50','2025-09-24 02:58:49','2025-09-24 02:58:49');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_16_092538_add_role_to_users_table',1),(5,'2025_09_20_091632_create_schedules_table',1),(6,'2025_09_21_135400_create_rooms_table',1),(7,'2025_09_21_144157_modify_rooms_table',2),(8,'2025_09_21_145648_drop_schedules_table',3),(9,'2025_09_22_083708_add_capacity_to_rooms_table',4),(10,'2025_09_22_084427_create_teachers_table',5),(11,'2025_09_22_090500_create_classes_table',6),(12,'2025_09_22_091438_create_students_table',7),(13,'2025_09_22_092515_create_schedules_table',8),(14,'2025_09_22_095413_update_teachers_table_add_constraints',9),(15,'2025_09_22_101418_add_capacity_to_classes_table',10),(16,'2025_09_22_102157_update_capacity_constraint_in_rooms_table',11),(17,'2025_09_22_103334_add_name_to_students_table',11),(18,'2025_09_22_133113_update_gender_enum_in_students_table',12),(19,'2025_09_22_145107_remove_name_from_teachers_table',13),(20,'2025_09_22_145709_remove_name_from_students_table',14),(21,'2025_09_23_011011_remove_name_from_classes_table',15),(22,'2025_09_23_014300_add_grade_to_classes_table',16),(23,'2025_09_23_024227_add_unique_userid_to_students_table',17),(24,'2025_09_23_024811_add_unique_roomid_and_teacherid_to_classes_talbe',18),(25,'2025_09_23_032440_add_unique_roomid_to_teachers_table',19),(26,'2025_09_24_025826_recreate_teachers_table',20),(27,'2025_09_24_031106_recreate_classes_table',21),(28,'2025_09_24_031501_recreate_students_table',22),(29,'2025_09_24_032035_recreate_subjects_table',23),(33,'2025_09_24_034859_recreate_schedules_table',24),(34,'2025_09_24_040441_create_announcements_table',25),(35,'2025_09_24_090740_rename_subject_group_to_subject_in_teachers_table=teachers',26),(37,'2025_09_25_070557_update_schedules_table_change_class_period',27),(39,'2025_09_25_072813_update_day_of_week_in_schedules_table',28),(40,'2025_09_25_083716_update_teachers_table',29),(41,'2025_09_25_084602_drop_column_subject_from_teachers_table',30),(42,'2025_09_25_091033_delete_room_id_from_schedules_table',31),(43,'2025_09_25_092108_add_day_of_week_column_to_schedules_table',32);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `capacity` int(10) unsigned NOT NULL DEFAULT 50,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'classroom 1',50,'2025-09-24 20:32:45','2025-09-24 20:32:45'),(2,'classroom 2',50,'2025-09-24 20:32:45','2025-09-24 20:32:45'),(3,'classroom 3',50,'2025-09-24 20:32:45','2025-09-24 20:32:45'),(4,'classroom 4',50,'2025-09-24 20:32:45','2025-09-24 20:32:45'),(5,'classroom 5',50,'2025-09-24 20:32:45','2025-09-24 20:32:45'),(6,'seminar room 1',50,'2025-09-24 20:32:45','2025-09-24 20:32:45'),(7,'computer room 1',50,'2025-09-24 20:32:45','2025-09-24 20:32:45');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_teacher_id_foreign` (`teacher_id`),
  KEY `schedules_class_id_foreign` (`class_id`),
  KEY `schedules_room_id_foreign` (`room_id`),
  CONSTRAINT `schedules_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,13,3,4,'Tuesday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(2,10,3,4,'Tuesday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(3,13,3,6,'Friday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(4,2,3,4,'Tuesday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(5,5,4,6,'Thursday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(6,7,1,3,'Friday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(7,6,2,4,'Tuesday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(8,9,3,5,'Thursday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(9,12,2,7,'Monday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57'),(10,12,3,2,'Saturday',1,2,NULL,'2025-09-25 02:25:57','2025-09-25 02:25:57');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0qxcZNb53liZ9JBteg8DEYUoKUxuhgytRvMtroLX',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnRUSkFvcUlLclVEaHdxam05eGNpWVl4eVpRUjJocTAyRm44RGpwdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1758528135),('3qHefF7i2vDvB4wIwGtUuKOciQrW6LCkosPIqeSt',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2tnbG1FaktIV3pvRkZEeFViWHoxYk1BYm40VjRQN0owaEE2OXdSQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1758682316),('7jpEtWPfeddG5J5tvOkZoZRf7PErlOhPns52Mm1t',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoid2RCeWt6MEpwcnRMd2Z6UlhXQ0xneDJCUjZwNU5RVDc3eVVnUW9hZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1758551651),('CRbJXbCNJ3HtEwseCFsDgmoaNpaCwKYTRPj9mLhK',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieHc4YmF1VldjMnprNmZsUGdHZnYxUmxMNmlHdDVZcXRZSmhiMXdzaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zY2hlZHVsZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1758803223),('oEr9c0wcWajKFUyDjHwT6KJuzKa1HwxIsIYpQo5r',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnNXVkE4djBkT21ZeHRzaHJ2Y2dqM20wZFBlNVRtaWhwZ1BoWGNHOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1758696519),('U3vEZyF3VEFHN82AegW1aOamXGh0tT8UvjsZXL8L',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVBLRDhDUjI3SDRxSENlV0RydnJHOGNtUWwzY0dQekVSdkk1eGZCNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1758587714),('vtqFaKKtHBtxucX20qd3hc2EJxx5oLAY1laLYjJJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjBQNTgzMTBOcFJIcGw5T3UyY2tQbWxlOEpJMktRMHk3ekZuSW92TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1758606310);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `day_of_birth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_student_id_unique` (`student_id`),
  KEY `students_class_id_foreign` (`class_id`),
  CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (14,'SV0014','2009-12-13','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(15,'SV0015','2009-08-08','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(16,'SV0016','2009-08-24','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(17,'SV0017','2009-03-16','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(18,'SV0018','2009-11-11','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(19,'SV0019','2009-04-19','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(20,'SV0020','2009-01-04','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(21,'SV0021','2009-10-11','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(22,'SV0022','2009-10-18','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(23,'SV0023','2009-04-03','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(24,'SV0024','2009-08-03','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(25,'SV0025','2009-04-24','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(26,'SV0026','2009-05-10','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(27,'SV0027','2009-05-03','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(28,'SV0028','2009-05-24','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(29,'SV0029','2009-02-02','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(30,'SV0030','2009-01-23','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(31,'SV0031','2009-03-01','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(32,'SV0032','2009-05-06','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(33,'SV0033','2009-01-20','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(34,'SV0034','2009-08-10','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(35,'SV0035','2009-10-11','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(36,'SV0036','2009-01-22','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(37,'SV0037','2009-02-22','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(38,'SV0038','2009-02-05','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(39,'SV0039','2009-06-26','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(40,'SV0040','2009-10-18','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(41,'SV0041','2009-03-02','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(42,'SV0042','2009-02-23','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(43,'SV0043','2009-03-11','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(44,'SV0044','2009-09-24','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(45,'SV0045','2009-02-14','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(46,'SV0046','2009-08-14','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(47,'SV0047','2009-11-23','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(48,'SV0048','2009-01-19','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(49,'SV0049','2009-01-24','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(50,'SV0050','2009-10-18','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(51,'SV0051','2009-01-17','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(52,'SV0052','2009-08-11','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(53,'SV0053','2009-03-23','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(54,'SV0054','2009-03-07','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(55,'SV0055','2009-04-15','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(56,'SV0056','2009-07-13','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(57,'SV0057','2009-12-08','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(58,'SV0058','2009-06-18','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(59,'SV0059','2009-07-25','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(60,'SV0060','2009-12-26','male',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(61,'SV0061','2009-03-22','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(62,'SV0062','2009-01-10','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(63,'SV0063','2009-04-02','female',1,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(64,'SV0064','2009-06-27','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(65,'SV0065','2009-03-16','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(66,'SV0066','2009-06-26','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(67,'SV0067','2009-11-16','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(68,'SV0068','2009-08-27','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(69,'SV0069','2009-09-14','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(70,'SV0070','2009-12-06','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(71,'SV0071','2009-08-02','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(72,'SV0072','2009-05-05','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(73,'SV0073','2009-04-19','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(74,'SV0074','2009-10-04','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(75,'SV0075','2009-04-01','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(76,'SV0076','2009-08-24','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(77,'SV0077','2009-11-21','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(78,'SV0078','2009-07-14','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(79,'SV0079','2009-12-04','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(80,'SV0080','2009-08-24','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(81,'SV0081','2009-09-17','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(82,'SV0082','2009-04-21','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(83,'SV0083','2009-03-13','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(84,'SV0084','2009-02-05','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(85,'SV0085','2009-01-08','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(86,'SV0086','2009-06-08','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(87,'SV0087','2009-04-20','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(88,'SV0088','2009-08-04','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(89,'SV0089','2009-09-18','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(90,'SV0090','2009-04-21','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(91,'SV0091','2009-09-27','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(92,'SV0092','2009-10-12','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(93,'SV0093','2009-12-22','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(94,'SV0094','2009-01-12','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(95,'SV0095','2009-02-07','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(96,'SV0096','2009-08-10','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(97,'SV0097','2009-06-19','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(98,'SV0098','2009-09-14','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(99,'SV0099','2009-03-26','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(100,'SV0100','2009-07-24','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(101,'SV0101','2009-03-16','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(102,'SV0102','2009-02-02','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(103,'SV0103','2009-07-15','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(104,'SV0104','2009-04-05','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(105,'SV0105','2009-03-28','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(106,'SV0106','2009-11-07','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(107,'SV0107','2009-06-15','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(108,'SV0108','2009-05-11','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(109,'SV0109','2009-01-05','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(110,'SV0110','2009-05-17','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(111,'SV0111','2009-03-13','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(112,'SV0112','2009-02-28','female',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(113,'SV0113','2009-09-12','male',2,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(114,'SV0114','2008-11-13','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(115,'SV0115','2008-04-12','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(116,'SV0116','2008-12-28','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(117,'SV0117','2008-03-05','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(118,'SV0118','2008-03-15','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(119,'SV0119','2008-03-05','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(120,'SV0120','2008-11-05','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(121,'SV0121','2008-02-20','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(122,'SV0122','2008-03-15','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(123,'SV0123','2008-02-24','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(124,'SV0124','2008-05-12','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(125,'SV0125','2008-04-08','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(126,'SV0126','2008-10-10','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(127,'SV0127','2008-11-09','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(128,'SV0128','2008-10-21','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(129,'SV0129','2008-05-10','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(130,'SV0130','2008-10-26','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(131,'SV0131','2008-01-24','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(132,'SV0132','2008-06-11','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(133,'SV0133','2008-09-14','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(134,'SV0134','2008-12-12','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(135,'SV0135','2008-06-15','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(136,'SV0136','2008-09-11','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(137,'SV0137','2008-07-27','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(138,'SV0138','2008-01-25','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(139,'SV0139','2008-03-13','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(140,'SV0140','2008-07-28','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(141,'SV0141','2008-06-21','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(142,'SV0142','2008-03-09','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(143,'SV0143','2008-11-23','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(144,'SV0144','2008-03-08','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(145,'SV0145','2008-03-15','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(146,'SV0146','2008-11-23','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(147,'SV0147','2008-06-02','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(148,'SV0148','2008-03-26','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(149,'SV0149','2008-05-08','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(150,'SV0150','2008-05-20','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(151,'SV0151','2008-04-03','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(152,'SV0152','2008-09-02','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(153,'SV0153','2008-10-23','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(154,'SV0154','2008-11-02','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(155,'SV0155','2008-08-12','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(156,'SV0156','2008-04-09','female',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(157,'SV0157','2008-07-18','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(158,'SV0158','2008-10-09','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(159,'SV0159','2008-09-17','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(160,'SV0160','2008-10-28','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(161,'SV0161','2008-11-25','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(162,'SV0162','2008-10-11','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(163,'SV0163','2008-04-04','male',3,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(164,'SV0164','2007-12-21','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(165,'SV0165','2007-11-20','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(166,'SV0166','2007-09-13','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(167,'SV0167','2007-01-22','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(168,'SV0168','2007-11-07','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(169,'SV0169','2007-11-24','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(170,'SV0170','2007-11-23','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(171,'SV0171','2007-08-02','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(172,'SV0172','2007-08-24','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(173,'SV0173','2007-08-02','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(174,'SV0174','2007-10-13','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(175,'SV0175','2007-03-22','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(176,'SV0176','2007-05-14','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(177,'SV0177','2007-10-25','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(178,'SV0178','2007-02-10','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(179,'SV0179','2007-11-16','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(180,'SV0180','2007-03-20','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(181,'SV0181','2007-06-13','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(182,'SV0182','2007-02-01','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(183,'SV0183','2007-10-04','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(184,'SV0184','2007-06-12','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(185,'SV0185','2007-09-14','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(186,'SV0186','2007-01-03','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(187,'SV0187','2007-01-02','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(188,'SV0188','2007-11-17','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(189,'SV0189','2007-07-01','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(190,'SV0190','2007-10-17','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(191,'SV0191','2007-10-10','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(192,'SV0192','2007-03-11','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(193,'SV0193','2007-01-24','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(194,'SV0194','2007-04-28','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(195,'SV0195','2007-05-16','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(196,'SV0196','2007-10-05','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(197,'SV0197','2007-04-05','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(198,'SV0198','2007-08-13','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(199,'SV0199','2007-10-19','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(200,'SV0200','2007-08-20','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(201,'SV0201','2007-08-06','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(202,'SV0202','2007-08-23','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(203,'SV0203','2007-02-15','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(204,'SV0204','2007-07-10','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(205,'SV0205','2007-11-12','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(206,'SV0206','2007-10-02','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(207,'SV0207','2007-04-11','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(208,'SV0208','2007-03-01','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(209,'SV0209','2007-12-16','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(210,'SV0210','2007-05-19','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(211,'SV0211','2007-03-12','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(212,'SV0212','2007-12-04','male',4,'2025-09-24 20:04:12','2025-09-24 20:04:12'),(213,'SV0213','2007-01-06','female',4,'2025-09-24 20:04:12','2025-09-24 20:04:12');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `number_of_periods` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_subject_id_unique` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'math','MATH001',4,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(2,'physics','PHYS001',3,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(3,'chemistry','CHEM001',3,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(4,'biology','BIOL001',3,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(5,'literature','LITE001',4,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(6,'history','HIST001',3,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(7,'geography','GEOG001',3,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(8,'english','ENGL001',4,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(9,'IT','COMP001',2,'2025-09-24 20:26:15','2025-09-24 20:26:15'),(10,'exercise','EXER001',1,'2025-09-24 20:26:15','2025-09-24 20:26:15');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` bigint(20) unsigned NOT NULL,
  `teacher_id` varchar(255) NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `level` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teachers_teacher_id_unique` (`teacher_id`),
  KEY `teachers_subject_id_foreign` (`subject_id`),
  CONSTRAINT `teachers_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teachers_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (2,'GV001',5,'Bachelor','2025-09-25 02:03:04','2025-09-25 02:03:04'),(3,'GV002',4,'PhD','2025-09-25 02:03:04','2025-09-25 02:03:04'),(4,'GV003',6,'Master','2025-09-25 02:03:04','2025-09-25 02:03:04'),(5,'GV004',1,'Master','2025-09-25 02:03:04','2025-09-25 02:03:04'),(6,'GV005',5,'Master','2025-09-25 02:03:04','2025-09-25 02:03:04'),(7,'GV006',5,'PhD','2025-09-25 02:03:04','2025-09-25 02:03:04'),(8,'GV007',7,'PhD','2025-09-25 02:03:04','2025-09-25 02:03:04'),(9,'GV008',8,'Bachelor','2025-09-25 02:03:04','2025-09-25 02:03:04'),(10,'GV009',2,'PhD','2025-09-25 02:03:04','2025-09-25 02:03:04'),(11,'GV010',6,'Bachelor','2025-09-25 02:03:04','2025-09-25 02:03:04'),(12,'GV011',3,'Bachelor','2025-09-25 02:03:04','2025-09-25 02:03:04'),(13,'GV012',3,'PhD','2025-09-25 02:03:04','2025-09-25 02:03:04');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','hadanghiep@gmail.com',NULL,'$2y$12$hw.ebNZWUdSUSDxKVb5YmutNjvFGstkSRO2DqfZlSzDDxnkaXgu9m',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','admin'),(2,'Dr. Herta Oberbrunner','conroy.karli@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(3,'Angelina Hoppe DVM','strosin.elyse@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(4,'Annabel Bergnaum','hagenes.kaylee@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(5,'Amely Wyman','pattie60@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(6,'Audreanne Schimmel Jr.','boris.mosciski@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(7,'Mrs. Meggie Kling','vlubowitz@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(8,'Ottilie Reichel','beth24@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(9,'Mrs. Summer Kertzmann','ortiz.assunta@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(10,'Lavina Hammes','mbeatty@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(11,'Reva Armstrong','vmarquardt@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(12,'Emmy Thiel','marlene.bartell@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(13,'Dr. Coty Hermiston','beier.laurel@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','teacher'),(14,'Prof. Peter Fahey','berneice.pfannerstill@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(15,'Tracy Powlowski','shemar66@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(16,'Mrs. Chelsie Goyette','wdeckow@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(17,'Mrs. Gerda Stoltenberg Jr.','dickinson.domenica@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(18,'Mr. Elliott McDermott MD','tyshawn.mills@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(19,'Addison Ortiz','gchristiansen@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(20,'Freddie Sanford','johnston.marcia@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(21,'Perry Emmerich','king.bernhard@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(22,'Eulah Goyette','hoeger.madaline@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(23,'Ms. Rita Moen Sr.','kenya55@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(24,'Gladyce Miller','okuneva.colton@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(25,'Jannie Pfannerstill','ewill@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(26,'Dr. Jared Metz','bmclaughlin@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(27,'Lazaro Zieme','hessel.ethelyn@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(28,'Candice Nikolaus','tsauer@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(29,'Elinore Gutmann','camylle41@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(30,'Lavonne Casper Jr.','sbartoletti@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(31,'Keith Hackett Jr.','lukas.erdman@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(32,'Clint Torp','gretchen.murazik@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(33,'Shaylee Grant','destin.deckow@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(34,'Carmel Doyle','konopelski.oren@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(35,'Ayla Ruecker','adaline.greenholt@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(36,'Delpha Altenwerth','kirstin.lockman@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(37,'Rebecca Schaden','vwalter@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(38,'Miss Lesly Cronin','jacobi.caesar@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(39,'Thora Altenwerth','leuschke.bette@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(40,'Barrett Green','mayer.tressie@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(41,'Annabel Brakus','jharber@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(42,'Prof. Kendra Harris','ukiehn@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(43,'Amely Feest','chasity.kris@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(44,'Agnes Ondricka','rey26@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(45,'Micaela Osinski','dondricka@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(46,'Gianni Schaden','wilford23@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(47,'Tanner Jacobs','deondre61@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(48,'Esperanza Borer','kunde.dillon@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(49,'Oscar Sanford','ffadel@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(50,'Ramiro DuBuque','gyost@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(51,'Spencer Strosin','keyon02@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(52,'Josh Bartoletti','vladimir.hauck@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(53,'Sanford DuBuque','domenic.reichert@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(54,'Mr. Dominic Morissette MD','willis34@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(55,'Dr. Baron Kutch Sr.','upagac@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(56,'Bennett Huel','maryse.parker@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(57,'Jackeline Pfeffer','gottlieb.jewell@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(58,'Cyril Torphy','amira.eichmann@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(59,'Mr. Santa Spinka','hyatt.daphnee@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(60,'Ms. Kailey Kuhlman','rau.estel@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(61,'Ms. Susana Hilpert','jacques77@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(62,'Enos Kihn','andrew.bednar@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(63,'Joannie Simonis','quigley.scot@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(64,'Jolie Homenick','ybayer@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(65,'Katarina Jakubowski','cassandre11@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(66,'Josefina Friesen','jason.spinka@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(67,'Arden Herman','mayer.robert@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(68,'Kenyatta Mueller I','myriam.kuphal@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(69,'Keith Davis','stone63@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(70,'Eloy Hyatt','qcummerata@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(71,'Dr. Vivien Oberbrunner I','awillms@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(72,'Ben Schroeder','miller.breana@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(73,'Lorenzo Koepp V','koby.roob@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(74,'Osborne Gutkowski','filiberto04@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(75,'Silas Olson','jstrosin@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(76,'Valentina Anderson','waelchi.myron@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(77,'Amani Dibbert Jr.','mayer.karine@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(78,'Nella Jakubowski','tatyana61@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(79,'Yvonne Windler','dsauer@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(80,'Alycia Beahan','nolan.lesly@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(81,'Adella Kling I','barton.louvenia@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(82,'Paxton Schneider PhD','geoffrey.schroeder@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(83,'Karolann Gislason','alexanne93@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(84,'Mauricio Miller','witting.leopold@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(85,'Breana Heathcote Jr.','dominique33@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(86,'Adah Kohler','alexandro85@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(87,'Rowan Smitham','abraun@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(88,'Leopold Kuhic','mikayla.rath@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(89,'Dr. Amina Breitenberg','zgusikowski@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(90,'Mr. Kelvin Lynch DVM','kmarquardt@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(91,'Mrs. Shanelle Frami','waters.jade@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(92,'Jaron Greenfelder','ratke.arnold@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(93,'Fletcher Wunsch','aadams@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(94,'Britney Wolff','reilly.vincenza@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(95,'Graciela Littel','ursula.wyman@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(96,'Hassie Lemke','kathryn.will@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(97,'Garth Schultz','annabel96@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(98,'Margarette Bins','eudora59@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(99,'Mrs. Lucie Bradtke PhD','paxton.schaefer@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(100,'Prof. Garrett Denesik','quitzon.louie@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(101,'Laila Dooley','lonzo09@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(102,'Nash Douglas III','myra11@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(103,'Evangeline Bechtelar','stiedemann.blanche@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(104,'Julian Bauch IV','kaelyn.mayer@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(105,'Ida Kiehn','alisa77@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(106,'Unique Waters','mayra49@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(107,'Prof. Prince Abernathy','yharber@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(108,'Hassan Kemmer I','wiza.hilton@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(109,'Una Swaniawski','johan86@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(110,'Alexie Heller','jhansen@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(111,'Chester Gislason','elta.morissette@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(112,'Joanne Mills','rosario.murazik@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(113,'Miss Justine Erdman','malvina.kris@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(114,'Eve Murazik PhD','hermiston.christiana@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(115,'Toy Schuster','amara80@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(116,'Phoebe Schultz','arvilla.kohler@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(117,'Makayla Bernier III','kub.genesis@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(118,'Mr. Jerry Quitzon','dawn.grant@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(119,'Luisa Wuckert','dolores.hammes@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(120,'Rogers Hammes','harmony.lubowitz@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(121,'Alfonzo Durgan','qbruen@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(122,'Prof. Hayden Anderson','mante.rhianna@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(123,'Mr. Shad Haley IV','gmante@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(124,'Prof. Johnnie Smitham PhD','izabella.wolff@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(125,'Dr. Sylvia Williamson Jr.','sanford.isadore@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(126,'Dessie West MD','gussie.harris@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(127,'Shanna Harris','schneider.adolfo@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(128,'Rogelio Schumm IV','savanna.gulgowski@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(129,'Claire Bruen','ewehner@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(130,'Dr. Adrain Steuber','ilene.oreilly@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(131,'Dr. Alysha McLaughlin IV','ferry.emanuel@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(132,'Addie Klocko','alf.crooks@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(133,'Meaghan Nienow','gregorio.bailey@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(134,'Stephon Senger','klein.derrick@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(135,'Mrs. Taya Renner','rashad.kemmer@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(136,'Enrique Williamson','bret.koch@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(137,'Wellington Schowalter','elouise.turner@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(138,'Coy Murray','belle21@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(139,'Antonia Ryan MD','gracie97@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(140,'Deshawn Mante DVM','dwindler@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(141,'Prof. Darren Collier','dschmeler@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(142,'Ms. Sophie Stoltenberg','west.reggie@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(143,'Ricky Marks','camryn30@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(144,'Ivy Funk','hellen.purdy@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(145,'Genesis Bogan MD','everardo62@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(146,'Prof. Alice Parisian V','irving72@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(147,'Katelynn Blanda','charlie28@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(148,'Mrs. Carole Thiel MD','lilly03@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(149,'Dr. Wade Schiller MD','knienow@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(150,'Kelsi Walker','deborah95@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(151,'Aliza Cummings','xdubuque@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(152,'Judge Murray DDS','cornell25@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(153,'Jabari Wolf','allan.renner@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(154,'Jaylin Bauch','dmurphy@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(155,'Albert Schaefer','gregoria.schinner@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(156,'Gordon Schaefer','jacinto89@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(157,'Prof. Kelvin Wilderman II','freeman.wehner@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(158,'Prof. Mario Huels','keira.corwin@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(159,'Tate Casper','amiller@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(160,'Shanny Wunsch','pearline74@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(161,'Prof. Frederik Rohan','mireille.ferry@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(162,'Abbie Lang','kellie29@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(163,'Savannah Schroeder','jgoyette@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(164,'Leann Simonis','emmalee08@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(165,'Evalyn Ruecker','naomi.von@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(166,'Steve Hilpert DDS','thalia.mcdermott@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(167,'Charlene Smith','orion36@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(168,'Janet Raynor','nathan.tromp@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(169,'Mrs. Britney Haag','stephen86@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(170,'Jaron Reichel','runolfsdottir.millie@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(171,'Ronaldo Bernhard','braeden55@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(172,'Makenna Shields','meta.hegmann@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(173,'Mohammed Dibbert DVM','jace.mayer@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(174,'Norma Spencer IV','dibbert.odessa@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(175,'Neoma Ziemann','jeff60@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(176,'Lloyd Batz','bennett09@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(177,'Idella Reilly','ubrown@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(178,'Mr. Dino Breitenberg MD','emerson.harvey@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(179,'Dr. Talia Fritsch MD','laurel91@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(180,'Imani Flatley DDS','haskell27@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(181,'Mrs. Cydney Mosciski','waino58@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(182,'Prof. Everette Fisher IV','sschneider@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(183,'Dr. Jimmy Mann','koepp.jillian@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(184,'Rashawn Kozey Sr.','katrine57@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(185,'Miss Keara Hirthe II','rachael.halvorson@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(186,'Dr. Rupert Botsford Sr.','barton.leonie@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(187,'Victor Pollich','laverna69@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(188,'Ada Cormier','niko.osinski@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(189,'Elvis Hagenes','valentina.abbott@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(190,'Prof. Amya Prosacco','edgardo16@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(191,'Grayce Johnston','schinner.leta@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(192,'Mrs. Jaunita Paucek','aleen08@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(193,'Dr. Gage Herman','earline57@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(194,'Alek Paucek','collin.powlowski@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(195,'Prof. Deon Schumm Sr.','carmela.kerluke@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(196,'Ms. Marie Fritsch','ibarrows@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(197,'Dr. Owen Rohan','celine.prohaska@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(198,'Prof. Jacynthe Cartwright III','augusta.paucek@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(199,'Christian Waters I','owisozk@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(200,'Brody Rau','lue.zulauf@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(201,'Zelma Grady','hyatt.al@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(202,'Anabelle Langworth III','maeve.nader@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(203,'Casper Ryan','stefan61@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(204,'Gino McCullough','riley04@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(205,'Alfredo Luettgen','kquigley@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(206,'Danielle Crist DDS','kchristiansen@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(207,'Dr. Fermin McGlynn','rosalia.harvey@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(208,'Gail Wisoky','ndamore@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(209,'Rogelio Blick','fswaniawski@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(210,'Everette Hills','aufderhar.ramon@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(211,'Ms. Anahi Kuhlman','sabryna64@example.org',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(212,'Andreanne Williamson','mdickens@example.net',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student'),(213,'Ms. Andreanne Morar III','ktrantow@example.com',NULL,'$2y$12$hZqsKlmCmXUwFxu9r1va3O9FBLNQ0sIeslkNocPYpqpb68UqjQSQS',NULL,'2025-09-24 01:57:48','2025-09-24 01:57:48','student');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-25 20:07:13
