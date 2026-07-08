-- =============================================================
-- Luxe Spa – Full Database Setup
-- Run this file once on a fresh database to create all tables
-- and seed the admin account.
-- Admin login: admin@luxespa.com / temp123
-- =============================================================

-- ---------------------------------------------------------------
-- Admins
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id`   INT(11)      NOT NULL AUTO_INCREMENT,
  `full_name`  VARCHAR(100) NOT NULL,
  `email`      VARCHAR(100) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `phone`      VARCHAR(20)           DEFAULT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `uq_admin_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ---------------------------------------------------------------
-- Members
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `members` (
  `member_id`       INT(11)      NOT NULL AUTO_INCREMENT,
  `member_code`     VARCHAR(10)  NOT NULL,
  `full_name`       VARCHAR(100) NOT NULL,
  `email`           VARCHAR(100) NOT NULL,
  `password`        VARCHAR(255) NOT NULL,
  `phone`           VARCHAR(20)           DEFAULT NULL,
  `gender`          ENUM('Male','Female') DEFAULT NULL,
  `member_type`     VARCHAR(50)  NOT NULL DEFAULT 'Individual',
  `membership`      ENUM('Bronze','Silver','Gold') DEFAULT NULL,
  `status`          ENUM('Active','Inactive')      DEFAULT NULL,
  `join_date`       DATE                  DEFAULT NULL,
  `created_at`      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_picture` VARCHAR(255)          DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `uq_member_code` (`member_code`),
  UNIQUE KEY `uq_member_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ---------------------------------------------------------------
-- Bookings
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id`   INT(11)      NOT NULL AUTO_INCREMENT,
  `member_id`    INT(11)      NOT NULL,
  `service`      VARCHAR(100) NOT NULL,
  `booking_date` DATE         NOT NULL,
  `booking_time` TIME         NOT NULL,
  `therapist`    VARCHAR(100)          DEFAULT NULL,
  `duration`     INT(11)               DEFAULT 60,
  `notes`        TEXT                  DEFAULT NULL,
  `status`       ENUM('Pending','Confirmed','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`booking_id`),
  KEY `idx_booking_member_id` (`member_id`),
  KEY `idx_booking_date` (`booking_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ---------------------------------------------------------------
-- Payments
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id`     INT(11)       NOT NULL AUTO_INCREMENT,
  `member_id`      INT(11)       NOT NULL,
  `service`        VARCHAR(100)  NOT NULL,
  `amount`         DECIMAL(10,2)          DEFAULT NULL,
  `payment_date`   DATE                   DEFAULT NULL,
  `payment_method` VARCHAR(30)            DEFAULT NULL,
  `payment_status` ENUM('Completed','Pending') DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `idx_payment_member_id` (`member_id`),
  KEY `idx_payment_date` (`payment_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ---------------------------------------------------------------
-- Staff
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id`   INT(11)      NOT NULL AUTO_INCREMENT,
  `full_name`  VARCHAR(100) NOT NULL,
  `email`      VARCHAR(100) NOT NULL,
  `phone`      VARCHAR(20)           DEFAULT NULL,
  `position`   VARCHAR(50)  NOT NULL DEFAULT 'Therapist',
  `status`     ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `join_date`  DATE                  DEFAULT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `uq_staff_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ---------------------------------------------------------------
-- Admin seed  (idempotent – safe to re-run)
-- ---------------------------------------------------------------
INSERT INTO `admins` (`full_name`, `email`, `password`, `phone`)
VALUES ('Admin', 'admin@luxespa.com', '$2y$10$lBqiX1h5HAgokJz8SL5i2eU6sUsOSjGhAGiQPcEN2YaYp5t4m6B1O', '+60 12-345 6789')
ON DUPLICATE KEY UPDATE
    `full_name` = VALUES(`full_name`),
    `password`  = VALUES(`password`);
