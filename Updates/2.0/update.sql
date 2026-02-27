ALTER TABLE `general_settings` CHANGE `sms_body` `sms_template` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `notification_templates` CHANGE `shortcodes` `shortcodes` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `sms_body`, CHANGE `email_status` `email_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `shortcodes`, CHANGE `sms_status` `sms_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `email_status`;

ALTER TABLE `notification_logs` ADD `image` VARCHAR(255) NULL DEFAULT NULL AFTER `notification_type`;

UPDATE `extensions` SET `script` = '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>' WHERE `extensions`.`act` = 'google-analytics';

UPDATE `extensions` SET `shortcode` = '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}' WHERE `extensions`.`act` = 'google-analytics';


ALTER TABLE `general_settings` ADD `paginate_number` INT NOT NULL DEFAULT '0' AFTER `email_batch_prefix`;


CREATE TABLE `cron_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_schedule_id` int NOT NULL DEFAULT '0',
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_jobs`
--

ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

  ALTER TABLE `cron_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `cron_jobs` CHANGE `is_default` `is_default` TINYINT(1) NOT NULL DEFAULT '1';

INSERT INTO `cron_jobs` (`id`, `name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 'Send Schedule Email', 'send_schedule_email', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"sentScheduleEmail\"]', NULL, 1, '2024-07-01 06:46:20', '2024-07-01 05:46:20', 1, 1, '2024-05-05 22:46:06', '2024-06-30 23:46:20'),
(3, 'Send Schedule Sms', 'send_schedule_sms', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"sentScheduleSms\"]', NULL, 1, '2024-06-30 16:11:12', '2024-06-30 15:11:12', 1, 1, '2024-05-05 22:46:06', '2024-06-30 03:11:12');

CREATE TABLE `cron_job_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `cron_job_id` int UNSIGNED NOT NULL DEFAULT '0',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int UNSIGNED NOT NULL DEFAULT '0',
  `error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `cron_job_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cron_job_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `cron_job_logs` CHANGE `cron_job_id` `cron_job_id` INT UNSIGNED NOT NULL DEFAULT '0';



ALTER TABLE `notification_templates` ADD `email_sent_from_name` VARCHAR(40) NULL DEFAULT NULL AFTER `email_status`, ADD `email_sent_from_address` VARCHAR(40) NULL DEFAULT NULL AFTER `email_sent_from_name`;
ALTER TABLE `notification_templates` ADD `sms_sent_from` VARCHAR(40) NULL DEFAULT NULL AFTER `sms_status`;

ALTER TABLE `notification_templates` CHANGE `subj` `subject` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `general_settings` ADD `email_from_name` VARCHAR(255) NULL DEFAULT NULL AFTER `email_from`;

ALTER TABLE `general_settings` CHANGE `last_email_cron` `last_cron` DATETIME NULL DEFAULT NULL;

ALTER TABLE `general_settings` ADD `available_version` VARCHAR(40) NULL DEFAULT NULL AFTER `last_cron`;

ALTER TABLE `general_settings` CHANGE `paginate_number` `paginate_number` INT(11) NOT NULL DEFAULT '0';


CREATE TABLE `update_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `update_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;



CREATE TABLE `cron_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--


ALTER TABLE `cron_schedules`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cron_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;


INSERT INTO `cron_schedules` (`id`, `name`, `interval`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hourly', 3600, 1, '2024-03-13 17:34:09', '2024-05-05 22:45:32'),
(2, 'Daily', 86400, 1, '2024-05-05 22:46:39', '2024-05-05 22:46:39');



ALTER TABLE `admin_notifications` CHANGE `read_status` `is_read` TINYINT(1) NOT NULL DEFAULT '0';

ALTER TABLE `general_settings` ADD `force_ssl` TINYINT(1) NOT NULL DEFAULT '0' AFTER `sn`;

TRUNCATE TABLE `extensions`;

INSERT INTO `extensions` (`act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
('google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"---------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"----------------\"}}', 'recaptcha.png', 0, '2019-10-18 11:16:05', '2024-05-08 03:23:13'),
('custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 11:16:05', '2022-10-12 17:02:43');
