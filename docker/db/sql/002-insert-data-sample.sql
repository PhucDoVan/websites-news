-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: docker
-- ------------------------------------------------------
-- Server version	5.7.24

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
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`account_id`, `created_at`, `updated_at`, `deleted_at`, `corporation_id`, `group_id`, `username`, `password`, `name_last`, `name_first`, `kana_last`, `kana_first`, `email`, `t_service_id`, `shikakumap_registered_at`, `shikakumap_deregistered_at`)
VALUES
(1, NULL, NULL, NULL, 1, 1, 'Ab7-abc72', '$2y$10$6gc5pgmmHLixxqb/1XQcqOPJ7fmNFL7vEKRQcCefsIX0sAfpWaqfa', '⽥中', '太郎', 'タナカ', 'タロウ', 't_tanaka@example.com', NULL, NULL, NULL),
(2, NULL, NULL, NULL, 1, 3, 'Ab7-def34', '$2y$10$6PO4Tup4lLhgA1OtRXtcN.sjFvfWF3Y1J6cj4e1txkh0ZEiK5JPXi', '⼭⽥', '花⼦', 'ヤマダ', 'ハナコ', 'h_yamada@example.com', NULL, NULL, NULL),
(3, NULL, NULL, NULL, 1, 3, 'Ab7-ghi56', '$2y$10$R4twA7IhcNO1ZYjtSqlCveeFf9b74KH/jNEkUzsnOieS05wrt4Due', '鈴⽊', '⼀郎', 'スズキ', 'イチロウ', 'i_suzuki@example.com', NULL, NULL, NULL),
(4, NULL, NULL, NULL, 2, 4, 'Cd2-xyz78', '$2y$10$K2OwCEvsP1d0dGXqPAdJP.v8NtZL5pXAHTV4wEvfU4TnNL0wiS/a6', '佐藤', 'たけし', 'サトウ', 'タケシ', 't_sato@example.com', NULL, NULL, NULL),
(5, NULL, NULL, '2020-04-03 11:30:00', 1, 5, 'Ab7-jkm99', '$2y$10$gPGCU1dVO4FmN9SwRITw/.tlD4RVP2Y/ueL/feF5JRcE92n.OVTd2', '渡辺', 'ひろし', 'ワタナベ', 'ヒロシ', 'h_watanabe@example.com', NULL, NULL, NULL);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `corporations`
--

LOCK TABLES `corporations` WRITE;
/*!40000 ALTER TABLE `corporations` DISABLE KEYS */;
INSERT INTO `corporations` (`corporation_id`, `created_at`, `updated_at`, `deleted_at`, `name`, `kana`, `uid`, `postal`, `address_pref`, `address_city`, `address_town`, `address_etc`)
VALUES
(1, NULL, NULL, NULL, '株式会社 エー・ビー・シー', 'エービーシー', 'Ab7', '9200907', '⽯川県', '⾦沢市', '⻘草町', '1-2-3'),
(2, NULL, NULL, NULL, '有限会社 xx商事', 'xxショウジ', 'Cd2', '8740902', '⼤分県', '別府市', '⻘⼭町', NULL);
/*!40000 ALTER TABLE `corporations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `corporation_contacts`
--

LOCK TABLES `corporation_contacts` WRITE;
/*!40000 ALTER TABLE `corporation_contacts` DISABLE KEYS */;
INSERT INTO `corporation_contacts` (`corporation_contact_id`, `created_at`, `updated_at`, `deleted_at`, `corporation_id`, `name`, `tel`, `email`, `fax`)
VALUES
(1, NULL, NULL, NULL, 1, NULL, '123-4567-8901', 'abc@example.com', NULL),
(2, NULL, NULL, NULL, 2, '代表', '098-7654-3219', 'xx_shoji@example.com', NULL);
/*!40000 ALTER TABLE `corporation_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `corporation_service`
--

LOCK TABLES `corporation_service` WRITE;
/*!40000 ALTER TABLE `corporation_service` DISABLE KEYS */;
INSERT INTO `corporation_service` (`id`, `created_at`, `updated_at`, `corporation_id`, `service_id`, `status`, `reason`, `terminated_at`)
VALUES
(1, NULL, NULL, 1, 1, 1, 'JONからの営業', NULL),
(2, NULL, NULL, 2, 1, 9, 'JONからの営業', NULL);
/*!40000 ALTER TABLE `corporation_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `corporation_id`, `parent_group_id`)
VALUES
(1, NULL, NULL, NULL, '経営部', 1, NULL),
(2, NULL, NULL, NULL, '営業部', 1, NULL),
(3, NULL, NULL, NULL, '第⼀営業課', 1, 2),
(4, NULL, NULL, NULL, '経営部', 2, NULL),
(5, NULL, NULL, '2020-04-03 02:30:00', '第⼆営業課 ', 1, 2);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `managers`
--

LOCK TABLES `managers` WRITE;
/*!40000 ALTER TABLE `managers` DISABLE KEYS */;
INSERT INTO `managers` (`manager_id`, `created_at`, `updated_at`, `deleted_at`, `name`, `username`, `password`)
VALUES
(1, NULL, NULL, NULL, '管理者', 'admin', '$2y$10$er1CNmeV6ZBGLMz1U48Yk.1OW5u9llEt3UYBYMu1JxrN.2YAwZVhK');
/*!40000 ALTER TABLE `managers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
VALUES
(1, 'App\\Http\\Models\\Account', 1),
(1, 'App\\Http\\Models\\Account', 4),
(2, 'App\\Http\\Models\\Account', 2),
(2, 'App\\Http\\Models\\Account', 3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `service_id`, `label`, `name`, `created_at`, `updated_at`)
VALUES
(1, 1, '法⼈に関する操作', 'corporation', NULL, NULL),
(2, 1, '部⾨に関する操作', 'group', NULL, NULL),
(3, 1, '全体のアカウントに関する操作', 'whole_account', NULL, NULL),
(4, 1, '⾃⾝のアカウントに関する操作', 'self_account', NULL, NULL),
(5, 1, '全体のログに関する操作', 'whole_log', NULL, NULL),
(6, 1, '⾃⾝のログに関する操作', 'self_log', NULL, NULL),
(7, 1, '全体の料⾦に関する操作', 'whole_bill', NULL, NULL),
(8, 1, '⾃⾝の料⾦に関する操作', 'self_bill', NULL, NULL),
(9, 1, '全体の登記情報に関する操作', 'whole_touki', NULL, NULL),
(10, 1, '⾃⾝の登記情報に関する操作', 'self_touki', NULL, NULL),
(11, 1, 'コンテンツに関する操作', 'content', NULL, NULL),
(12, 2, '全体統括', 'admin', NULL, NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` (`permission_id`, `role_id`, `level`)
VALUES
(1, 1, 7),
(2, 1, 7),
(3, 1, 7),
(4, 1, 7),
(5, 1, 7),
(6, 1, 7),
(7, 2, 7),
(8, 2, 7),
(9, 2, 4),
(10, 2, 7),
(11, 2, 7),
(12, 3, 7);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `registries`
--

LOCK TABLES `registries` WRITE;
/*!40000 ALTER TABLE `registries` DISABLE KEYS */;
INSERT INTO `registries` (`id`, `created_at`, `updated_at`, `deleted_at`, `corporation_id`, `group_id`, `account_id`, `label`, `v1_code`, `number_type`, `number`, `pdf_type`, `s3_object_url`, `requested_at`, `based_at`, `latitude`, `longitude`)
VALUES
(1, NULL, NULL, NULL, 1, 3, 2, '全部事項、⼟地、愛媛県松⼭市xxx', '3820103360000', 1, '1-2', 1, 'https://...', '2020-04-03 11:00:00', '2020-04-03 11:30:00', '33.84198170', '132.76075100'),
(2, NULL, NULL, NULL, 1, 3, 3, '全部事項、⼟地、愛媛県今治市aaa', '3820201020002', 1, '1-2', 1, 'https://...', '2020-04-03 11:00:00', '2020-04-03 11:30:00', '34.11737220', '132.95601730'),
(3, NULL, NULL, NULL, 2, 4, 4, '所有者事項、⼟地、愛媛県松⼭市yyy', '3820101220000', 1, '1-2', 2, 'https://...', '2020-04-03 11:00:00', '2020-04-03 11:30:00', '33.83254670', '132.76432130'),
(4, NULL, NULL, NULL, 1, 3, 2, '全部事項、⼟地、愛媛県松⼭市zzz', '3820103420007', 1, '1-2', 1, 'https://...', '2020-04-03 11:00:00', '2020-04-03 11:30:00', '33.83299130', '132.75188260');
/*!40000 ALTER TABLE `registries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `service_id`, `label`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'スーパーユーザー ', 'shikakumap_super_user', NULL, NULL),
(2, 1, '利⽤者', 'shikakumap_user', NULL, NULL),
(3, 2, '管理者', 'xxx_admin', NULL, NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `token`)
VALUES
(1, NULL, NULL, NULL, 'シカクマップ', '3874f2b7-ec9a-4858-846d-c9a3e6aa8be9'),
(2, NULL, NULL, NULL, 'マダミヌサービス', '54a60370-5328-4d74-8680-3de50d00ad22');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
INSERT INTO `tokens` (`id`, `created_at`, `updated_at`, `account_id`, `service_id`, `token`, `expires_in`)
VALUES
(1, NULL, NULL, 1, 1, 'ec68391f-ba6e-4ad0-a12e-74f5225eade6', '2021-04-01 09:00:00'),
(2, NULL, NULL, 4, 1, 'f38a077f-bcc1-40b8-83c2-af94c3d4c826', '2020-04-03 10:42:18');
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-26 13:34:53
