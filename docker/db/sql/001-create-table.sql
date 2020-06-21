--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'AccountID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Created_at',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Updated_at',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted_at',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Name',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'UserName',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'password',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='Admin';
/*!40101 SET character_set_client = @saved_cs_client */;
