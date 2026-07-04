-- Admin account for Luxe Spa
-- Email: admin@luxespa.com | Password: temp123
INSERT INTO `admins` (`full_name`, `email`, `password`, `phone`)
VALUES ('Admin', 'admin@luxespa.com', '$2y$10$lBqiX1h5HAgokJz8SL5i2eU6sUsOSjGhAGiQPcEN2YaYp5t4m6B1O', '+60 12-345 6789')
ON DUPLICATE KEY UPDATE
    `full_name` = VALUES(`full_name`),
    `password`  = VALUES(`password`);
