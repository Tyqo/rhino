CREATE TABLE `users` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	`group_id` int DEFAULT NULL,
	`email` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL
);