-- Admin table and seed for Luxe Spa
-- Email: admin@luxespa.com | Password: temp123

CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id`  INT(11)      NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(100) NOT NULL,
  `email`     VARCHAR(150) NOT NULL,
  `password`  VARCHAR(255) NOT NULL,
  `phone`     VARCHAR(20)           DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `uq_admin_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`full_name`, `email`, `password`, `phone`)
VALUES ('Admin', 'admin@luxespa.com', '$2y$10$lBqiX1h5HAgokJz8SL5i2eU6sUsOSjGhAGiQPcEN2YaYp5t4m6B1O', '+60 12-345 6789')
ON DUPLICATE KEY UPDATE
    `full_name` = VALUES(`full_name`),
    `password`  = VALUES(`password`);
