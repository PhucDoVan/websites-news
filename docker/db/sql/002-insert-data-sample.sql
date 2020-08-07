--
-- Dumping data for table `accounts`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `username`, `email`, `password`, `remember_me`, `code`, `time_code`)
VALUES
(1, NULL, NULL, NULL, 'Admin', 'admin', 'phuc.dovan.96@gmail.com', '$2y$10$er1CNmeV6ZBGLMz1U48Yk.1OW5u9llEt3UYBYMu1JxrN.2YAwZVhK', NULL, '$2y$10$P/ynamQyTiSQ/BicCwWgouIPLgTzfSrscZKUdG23AX.JpSDctJX9C', '2020-08-07 06:23:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;