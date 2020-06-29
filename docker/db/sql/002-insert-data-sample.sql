--
-- Dumping data for table `accounts`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `username`, `password`)
VALUES
(1, NULL, NULL, NULL, 'Admin', 'admin', '$2y$10$er1CNmeV6ZBGLMz1U48Yk.1OW5u9llEt3UYBYMu1JxrN.2YAwZVhK');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;