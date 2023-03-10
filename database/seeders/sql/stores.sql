-- --------------------------------------------------------
-- 主機:                           localhost
-- 伺服器版本:                        10.4.21-MariaDB - mariadb.org binary distribution
-- 伺服器作業系統:                      Win64
-- HeidiSQL 版本:                  11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 傾印 demo_food 的資料庫結構
CREATE DATABASE IF NOT EXISTS `demo_food` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `demo_food`;

-- 傾印  資料表 demo_food.stores 結構
CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商店名稱',
  `store_phone` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商店電話',
  `store_business_start_time` time DEFAULT NULL COMMENT '起始營業時間',
  `store_business_end_time` time DEFAULT NULL COMMENT '結束營業時間',
  `store_longitude` decimal(20,6) DEFAULT NULL COMMENT '經度',
  `store_latitude` decimal(20,6) DEFAULT NULL COMMENT '緯度',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `index_store_name` (`store_name`),
  KEY `index_store_phone` (`store_phone`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在傾印表格  demo_food.stores 的資料：~3 rows (近似值)
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` (`id`, `store_name`, `store_phone`, `store_business_start_time`, `store_business_end_time`, `store_longitude`, `store_latitude`, `created_at`, `updated_at`) VALUES
	(1, '山東姥姥麵食館', '07-5540303', '01:00:00', '05:00:00', 22.660612, 120.294080, '2023-03-10 18:11:44', '2023-03-10 18:11:44'),
	(2, 'foodomo測試店家', '02-77527666', '00:00:00', '23:59:00', 24.874606, 121.256690, '2023-03-10 18:11:44', '2023-03-10 18:11:44'),
	(36, '雷蒙叔叔(安和店)', '02-27006648', NULL, NULL, 25.061901, 121.533635, '2023-03-10 18:11:44', '2023-03-10 18:12:12');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
