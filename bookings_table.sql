-- Bookings table for Luxe Spa booking system
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
  KEY `idx_member_id` (`member_id`),
  KEY `idx_booking_date` (`booking_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
