CREATE TABLE `customers` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	`equipmentNumber` int DEFAULT NULL,
	`sapNumber` bigint DEFAULT NULL,
	`street` varchar(255) DEFAULT NULL,
	`district` varchar(255) DEFAULT NULL,
	`city` varchar(255) DEFAULT NULL,
	`postcode` varchar(255) DEFAULT NULL,
	`houseNumber` varchar(255) DEFAULT NULL,
	`salutation_id` int NOT NULL
);