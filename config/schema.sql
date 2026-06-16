-- ==========================================================================
-- 🛠️ 專案資料庫初始化腳本 (MariaDB / MySQL)
-- ==========================================================================

-- 確保編碼與連線校對正確（防亂碼）
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------------------------
-- 1. 👥 建立系所成員資料表 (teachers)
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '唯一識別碼',
  `name` VARCHAR(50) NOT NULL COMMENT '成員姓名',
  `title` VARCHAR(100) NOT NULL COMMENT '職稱 / 標籤 (如：特聘教授、網頁講師)',
  `bio` TEXT DEFAULT NULL COMMENT '個人詳細簡介',
  `image_url` VARCHAR(255) DEFAULT 'default_avatar.png' COMMENT '大頭貼圖片檔名',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 插入成員測試資料
INSERT INTO `teachers` (`id`, `name`, `title`, `bio`, `image_url`) VALUES
(1, '陳資工', '系主任 / 專任教授', '研究領域包含雲端運算、低階系統程式設計與區塊鏈技術。擁有超過 15 年的產學合作經驗。', 'teacher1.png'),
(2, '林智能', '副教授', '專長為電腦視覺、深度學習、Python 資料科學分析。積極指導學生參與各項全國實專題競賽。', 'teacher2.png');

-- --------------------------------------------------------------------------
-- 2. 📢 建立最新公告資料表 (news)
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '公告識別碼',
  `title` VARCHAR(255) NOT NULL COMMENT '公告標題',
  `category` VARCHAR(50) DEFAULT '一般' COMMENT '公告分類 (如：招生、演講、榮譽)',
  `content` TEXT NOT NULL COMMENT '公告內文 (可支援 HTML)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '發布時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 插入最新公告測試資料
INSERT INTO `news` (`id`, `title`, `category`, `content`) VALUES
(1, '【招生】115 學年度研究所碩士班甄試入學簡章公告囉！', '招生', '歡迎各位有志於深耕 AI 與大數據領域的同學踴躍報考，詳情請點選招生專區查看完整簡章說明。'),
(2, '【演講】本周五邀請矽谷資深架構師進行「低階系統優化」專題演講', '學術', '時間：本周五下午 14:00-16:00。<br>地點：資工館一樓國際會議廳。歡迎全體師生準時到場聆聽。'),
(3, '【榮譽】本系學生團隊榮獲全國大專院校資訊應用服務創新競賽第一名！', '榮譽', '恭喜本系丁班學生團隊以「智慧型影像辨識系統」專案榮獲全國冠軍，全系師生同賀！');

-- --------------------------------------------------------------------------
-- 3. 🔐 建立管理員帳號資料表 (admin_users)
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE COMMENT '登入帳號',
  `password` VARCHAR(255) NOT NULL COMMENT '加密後的密碼',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 插入預設管理員帳號
-- 帳號：admin
-- 密碼：123456 (下方這串字是用 PHP password_hash('123456', PASSWORD_DEFAULT) 產生的安全雜湊值)
INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$w8W9N9/K2K76S6XoU3r0fO5f5vsh9jZ2k2I8Z5eZg4hO69xZ4w5tG');

SET FOREIGN_KEY_CHECKS = 1;