CREATE DATABASE IF NOT EXISTS `ca_certificate_manager` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ca_certificate_manager`;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'Administrator',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `firm_settings` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `firm_name` VARCHAR(255) DEFAULT NULL,
    `frn` VARCHAR(80) DEFAULT NULL,
    `address` TEXT DEFAULT NULL,
    `city` VARCHAR(150) DEFAULT NULL,
    `state` VARCHAR(150) DEFAULT NULL,
    `phone` VARCHAR(50) DEFAULT NULL,
    `email` VARCHAR(150) DEFAULT NULL,
    `gst_number` VARCHAR(80) DEFAULT NULL,
    `pan_number` VARCHAR(80) DEFAULT NULL,
    `udin_number` VARCHAR(80) DEFAULT NULL,
    `signatory_name` VARCHAR(255) DEFAULT NULL,
    `signatory_status` VARCHAR(150) DEFAULT NULL,
    `membership_number` VARCHAR(150) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `clients` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `status` VARCHAR(80) NOT NULL,
    `pan_number` VARCHAR(80) DEFAULT NULL,
    `gst_number` VARCHAR(80) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_pan` (`pan_number`),
    KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `client_financials` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `client_id` INT UNSIGNED NOT NULL,
    `financial_year` VARCHAR(20) NOT NULL,
    `amount` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_client_year` (`client_id`, `financial_year`),
    CONSTRAINT `fk_client_financials_client`
        FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `certificates` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `client_id` INT UNSIGNED NOT NULL,
    `certificate_type` VARCHAR(150) NOT NULL,
    `certificate_date` DATE DEFAULT NULL,
    `place_of_signing` VARCHAR(150) DEFAULT NULL,
    `udin_number` VARCHAR(120) DEFAULT NULL,
    `template_style` VARCHAR(150) DEFAULT NULL,
    `pdf_path` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_cert_client` (`client_id`),
    CONSTRAINT `fk_certificates_client`
        FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`username`, `password`, `role`)
SELECT 'admin', 'admin123', 'Administrator'
WHERE NOT EXISTS (
    SELECT 1 FROM `users` WHERE `username` = 'admin'
);

INSERT INTO `firm_settings` (
    `firm_name`, `address`, `city`, `state`, `phone`, `email`, `gst_number`, `pan_number`, `udin_number`, `signatory_name`, `signatory_status`, `membership_number`
) VALUES (
    'CA Certificate Manager',
    'Your Firm Address',
    'Ahmedabad',
    'Gujarat',
    '+91 98765 43210',
    'info@yourfirm.com',
    '24AAAAA0000A1Z5',
    'AAAAA0000A',
    '12345678BMJXY1234',
    'Authorized Signatory',
    'Chartered Accountant',
    'ICAI-123456'
) ON DUPLICATE KEY UPDATE
    `firm_name` = VALUES(`firm_name`),
    `city` = VALUES(`city`),
    `state` = VALUES(`state`),
    `phone` = VALUES(`phone`),
    `email` = VALUES(`email`);
