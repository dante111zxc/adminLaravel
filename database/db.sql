-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table laravel.transaction_pcoin
CREATE TABLE IF NOT EXISTS `transaction_pcoin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT '0',
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0 - Đang xử lý\n1 - Hoàn thành\n2 - Lỗi',
  `type` int(4) NOT NULL DEFAULT '1' COMMENT '1 - nap pcoin bang card dt\r\n        2 - nap pcoin  bang cach ck qua tk ngan hang\r\n        3 - nap pcoin bang QR momo\r\n        4 - nap pcoin bang QR VNPAY',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id_uindex` (`id`),
  UNIQUE KEY `transaction_request_uindex` (`request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.transaction_pcoin: ~2 rows (approximately)
DELETE FROM `transaction_pcoin`;
/*!40000 ALTER TABLE `transaction_pcoin` DISABLE KEYS */;
INSERT INTO `transaction_pcoin` (`id`, `user_id`, `request_id`, `status`, `type`, `note`, `created_at`, `updated_at`) VALUES
	(1, 1, 'QTpSTIVJi2', 0, 1, 'Nạp Pcoin bằng thẻ điện thoại', '2021-09-18 18:55:37', '2021-09-18 18:55:37'),
	(2, 1, 'DYs7m8YQQy', 0, 1, 'Nạp Pcoin bằng thẻ điện thoại', '2021-09-18 18:55:52', '2021-09-18 18:55:52');
/*!40000 ALTER TABLE `transaction_pcoin` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
