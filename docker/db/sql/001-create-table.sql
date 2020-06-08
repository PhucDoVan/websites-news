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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `account_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'アカウントID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `corporation_id` bigint(20) UNSIGNED NOT NULL COMMENT '法人ID',
  `group_id` bigint(20) UNSIGNED NOT NULL COMMENT '部門ID',
  `username` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ユーザー名',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'パスワード',
  `name_last` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'アカウント名.姓',
  `name_first` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'アカウント名.名',
  `kana_last` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'アカウント名（カナ）.姓',
  `kana_first` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'アカウント名（カナ）.名',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'メールアドレス',
  `t_service_id` char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '民事ID',
  `shikakumap_registered_at` datetime DEFAULT NULL COMMENT 'シカクマップ登録日時',
  `shikakumap_deregistered_at` datetime DEFAULT NULL COMMENT 'シカクマップ解除日時',
  PRIMARY KEY (`account_id`) USING BTREE,
  UNIQUE KEY `username_UNIQUE` (`username`, `deleted_at`),
  KEY `corporation_FK_idx` (`corporation_id`),
  KEY `group_FK_idx` (`group_id`),
  CONSTRAINT `account_corporation_FK` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`corporation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `account_group_FK` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='アカウント';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `corporations`
--

DROP TABLE IF EXISTS `corporations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `corporations` (
  `corporation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '法人ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '法人名表記',
  `kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '法人名カナ',
  `uid` VARCHAR(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '法人識別ID',
  `postal` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '郵便番号',
  `address_pref` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '都道府県',
  `address_city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '市区町村',
  `address_town` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '町名番地',
  `address_etc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ビル・マンション名・号室',
  PRIMARY KEY (`corporation_id`) USING BTREE,
  UNIQUE KEY `uid_UNIQUE` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='法人';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `corporation_contacts`
--
-- Creation: Mar 11, 2019 at 09:37 AM
--

DROP TABLE IF EXISTS `corporation_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `corporation_contacts` (
  `corporation_contact_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '法人.連絡先ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `corporation_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '法人ID',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '連絡先名、支払いについて、契約について',
  `tel` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話番号',
  `email` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'メールアドレス',
  `fax` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'FAX',
  PRIMARY KEY (`corporation_contact_id`),
  KEY `contact_corporation_PK` (`corporation_id`),
  CONSTRAINT `contact_corporation_PK` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`corporation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='法人.連絡先';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `managers`
--

DROP TABLE IF EXISTS `managers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `managers` (
  `manager_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '管理者ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '管理者名',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ユーザー名',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'パスワード',
  PRIMARY KEY (`manager_id`) USING BTREE,
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='管理者';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `service_restricts`
--

DROP TABLE IF EXISTS `service_restricts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_restricts` (
  `service_restrict_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'サービス制限ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `account_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'アカウントID',
  `type` smallint(4) DEFAULT NULL COMMENT '制限タイプ 10:IP 20:エリア 30:受付期限 40:登記目的 50:用途',
  `value` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '制限値',
  PRIMARY KEY (`service_restrict_id`) USING BTREE,
  KEY `service_restrict_account_FK_idx` (`account_id`),
  CONSTRAINT `service_restrict_account_FK` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='サービス制限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'サービスID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'サービス名称',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'サービス識別トークン',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `token_UNIQUE` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='サービス';

--
-- Table structure for table `registries`
--

DROP TABLE IF EXISTS `registries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `corporation_id` bigint(20) UNSIGNED NOT NULL COMMENT '法人ID',
  `group_id` bigint(20) UNSIGNED NOT NULL COMMENT '部門ID',
  `account_id` bigint(20) UNSIGNED NOT NULL COMMENT 'アカウントID',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ラベル',
  `v1_code` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'V1コード',
  `number_type` TINYINT(1) UNSIGNED NOT NULL COMMENT '番号種別（用途）',
  `number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地番・家屋番号',
  `pdf_type` TINYINT(1) UNSIGNED NOT NULL COMMENT '種類',
  `s3_object_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'S3オブジェクトURL',
  `requested_at` datetime DEFAULT NULL COMMENT '取得依頼日時',
  `based_at` datetime NOT NULL COMMENT '鮮度基準日時',
  `latitude` decimal(10,8) NOT NULL COMMENT '取得緯度',
  `longitude` decimal(11,8) NOT NULL COMMENT '取得経度',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `registry_corporation_FK_idx` (`corporation_id`),
  KEY `registry_group_FK_idx` (`group_id`),
  KEY `registry_account_FK_idx` (`account_id`),
  CONSTRAINT `registry_corporation_FK` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`corporation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `registry_group_FK` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `registry_account_FK` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='登記情報取得履歴';

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'トークンID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `account_id` bigint(20) UNSIGNED NOT NULL COMMENT 'アカウントID',
  `service_id` bigint(20) UNSIGNED NOT NULL COMMENT 'サービスID',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'トークン',
  `expires_in` datetime NOT NULL COMMENT 'トークン失効時間',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `token_UNIQUE` (`token`),
  KEY `token_account_FK_idx` (`account_id`),
  KEY `token_service_FK_idx` (`service_id`),
  CONSTRAINT `token_account_FK` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `token_service_FK` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='トークン';

--
-- Table structure for table `corporation_service`
--

DROP TABLE IF EXISTS `corporation_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `corporation_service` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'サービス契約状況ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `corporation_id` bigint(20) UNSIGNED NOT NULL COMMENT '法人ID',
  `service_id` bigint(20) UNSIGNED NOT NULL COMMENT 'サービスID',
  `status` TINYINT(1) UNSIGNED NOT NULL COMMENT '契約ステータス',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '契約動機・理由',
  `terminated_at` datetime DEFAULT NULL COMMENT '解約日時',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `corporation_service_corporation_FK_idx` (`corporation_id`),
  KEY `corporation_service_service_FK_idx` (`service_id`),
  CONSTRAINT `corporation_service_account_FK` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`corporation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `corporation_service_service_FK` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='サービス契約状況';

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '部門ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '削除日時',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '部門名称',
  `corporation_id` bigint(20) UNSIGNED NOT NULL COMMENT '法人ID',
  `parent_group_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '親部門ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `group_corporation_FK_idx` (`corporation_id`),
  KEY `group_parent_group_FK_idx` (`parent_group_id`),
  CONSTRAINT `group_corporation_FK` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`corporation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `group_parent_group_FK` FOREIGN KEY (`parent_group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='部門';

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ロールID',
  `service_id` bigint(20) UNSIGNED NOT NULL COMMENT 'サービスID',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ラベル',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ロール名',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `role_name_UNIQUE` (`name`),
  KEY `roles_service_FK_idx` (`service_id`),
  CONSTRAINT `roles_service_FK` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='ロール（役割）';

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'パーミッションID',
  `service_id` bigint(20) UNSIGNED NOT NULL COMMENT 'サービスID',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ラベル',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'パーミッション名',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '作成日時',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `permission_in_service_UNIQUE` (`service_id`, `name`),
  KEY `permissions_service_FK_idx` (`service_id`),
  CONSTRAINT `permissions_service_FK` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='パーミッション（権限）';

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL COMMENT 'パーミッションID',
  `role_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ロールID',
  `level` tinyint(1) UNSIGNED NOT NULL COMMENT '権限レベル',
  PRIMARY KEY (`permission_id`,`role_id`) USING BTREE,
  KEY `permission_role_permission_FK_idx` (`permission_id`),
  KEY `permission_role_role_FK_idx` (`role_id`),
  CONSTRAINT `permission_role_permission_FK` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `permission_role_role_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='パーミッション・ロール ピボット';

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ロールID',
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'モデルタイプ',
  `model_id` bigint(20) UNSIGNED NOT NULL COMMENT 'モデルID',
  PRIMARY KEY (`role_id`,`model_type`,`model_id`) USING BTREE,
  KEY `model_has_roles_role_FK_idx` (`role_id`),
  CONSTRAINT `model_has_roles_role_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='モデル(アカウント)xロール';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-26 13:34:48
