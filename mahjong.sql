-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-03 19:49:18
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `mahjong`
--

-- --------------------------------------------------------

--
-- 資料表結構 `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, '麻將桌'),
(2, '競技類'),
(3, '派對類'),
(4, 'RPG類');

-- --------------------------------------------------------

--
-- 資料表結構 `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount_code` varchar(50) NOT NULL,
  `discount_type` varchar(20) NOT NULL,
  `discount_value` decimal(10,0) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `limit_value` int(50) NOT NULL,
  `usage_limit` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `name`, `discount_code`, `discount_type`, `discount_value`, `valid_from`, `valid_to`, `limit_value`, `usage_limit`, `status`) VALUES
(1, '會員專享', '7L2SX656EZ', 'percent', 8, '2024-06-13', '2024-08-17', 1794, 717, 'inactive'),
(2, '夏季大促', '4B8XAJQLYH', 'percent', 6, '2024-06-09', '2024-08-26', 3800, 982, 'active'),
(3, '生日特惠', 'MZGQC1YQA5', 'percent', 69, '2024-06-13', '2024-07-23', 5216, 312, 'active'),
(4, '會員專享', '5SW7Y0YVUY', 'cash', 41759, '2024-06-17', '2024-08-09', 6218, 681, 'active'),
(5, '冬季減價', 'CUJVA1DUYH', 'percent', 37, '2024-06-17', '2024-07-23', 9790, 666, 'inactive'),
(6, '新客禮包', '1VCC98C2LX', 'percent', 57, '2024-06-05', '2024-08-08', 9181, 327, 'active'),
(7, '會員專享', 'LGWUGPAZ1S', 'cash', 25681, '2024-06-14', '2024-08-30', 4043, 172, 'inactive'),
(8, '會員專享', '03EL0O80LY', 'cash', 47552, '2024-06-28', '2024-09-16', 1397, 507, 'active'),
(9, '節日特賣', '2KSXFPQCJI', 'cash', 47475, '2024-06-20', '2024-08-24', 9636, 79, 'inactive'),
(10, '春季促銷', 'MA4X1V5APR', 'percent', 68, '2024-06-04', '2024-07-15', 9345, 306, 'active'),
(11, '秋季特惠', 'N1RVK6YLIZ', 'cash', 9725, '2024-06-15', '2024-07-16', 7786, 967, 'inactive'),
(12, '生日特惠', '8L83ICCFNQ', 'cash', 19658, '2024-06-01', '2024-08-12', 7766, 708, 'active'),
(13, '會員專享', 'F708U8EEVE', 'cash', 44277, '2024-06-02', '2024-07-08', 8611, 923, 'active'),
(14, '夏季大促', '6POZL3D50Z', 'percent', 71, '2024-06-06', '2024-07-17', 2621, 952, 'inactive'),
(15, '春季促銷', '2F56IRP2ON', 'percent', 66, '2024-06-18', '2024-09-04', 3058, 708, 'active'),
(16, '新客禮包', '197933IIXN', 'percent', 8, '2024-06-22', '2024-09-03', 6289, 291, 'active'),
(17, '夏季大促', '8DCDN97F5U', 'percent', 17, '2024-06-02', '2024-07-11', 4484, 446, 'active'),
(18, '節日特賣', '13E3FG8CAF', 'percent', 45, '2024-06-02', '2024-08-27', 8705, 955, 'active'),
(19, '週年慶', 'MWK4A1VMC7', 'cash', 41422, '2024-06-17', '2024-09-14', 9385, 776, 'active'),
(20, '限時優惠', 'XUB218N05B', 'cash', 20703, '2024-06-15', '2024-08-27', 9118, 639, 'inactive'),
(21, '限時優惠', '8DB9PTTM6S', 'cash', 27340, '2024-06-20', '2024-08-06', 3374, 163, 'active'),
(22, '節日特賣', 'A5GD6PJNLA', 'percent', 65, '2024-06-10', '2024-09-01', 1481, 803, 'active'),
(23, '週年慶', 'FXDJVF9Z5C', 'percent', 71, '2024-06-09', '2024-08-04', 1331, 132, 'active'),
(24, '限時優惠', 'NGKE58XRYM', 'cash', 29414, '2024-06-23', '2024-09-12', 1631, 474, 'active'),
(25, '限時優惠', 'SSXGEXM0LO', 'cash', 35646, '2024-06-20', '2024-08-02', 8354, 282, 'active'),
(26, '會員專享', 'D10L20TG7U', 'cash', 27163, '2024-06-17', '2024-09-09', 7584, 199, 'active'),
(27, '節日特賣', '3O3C478AR6', 'percent', 38, '2024-06-26', '2024-09-18', 6748, 855, 'inactive'),
(28, '春季促銷', 'MFUAWBO3I0', 'cash', 27963, '2024-06-24', '2024-09-21', 6020, 525, 'active'),
(29, '節日特賣', 'TK6SEV0CLO', 'cash', 42785, '2024-06-07', '2024-07-23', 4040, 917, 'active'),
(30, '冬季減價', 'T6MBBYA1QY', 'percent', 75, '2024-06-07', '2024-08-24', 4837, 418, 'active'),
(31, '春季促銷', '1AYL5DLCH2', 'percent', 21, '2024-06-11', '2024-08-04', 4463, 283, 'inactive'),
(32, '會員專享', 'LQ8UYJCYCI', 'percent', 34, '2024-06-02', '2024-07-27', 855, 944, 'active'),
(33, '會員專享', 'ZMN9L8SKZ1', 'cash', 42705, '2024-06-16', '2024-07-26', 7227, 980, 'active'),
(34, '週年慶', 'SO61BN058Z', 'percent', 74, '2024-06-05', '2024-07-19', 8419, 143, 'inactive'),
(35, '新客禮包', 'K0JH6XFIZB', 'percent', 21, '2024-06-10', '2024-08-23', 4101, 403, 'active'),
(36, '秋季特惠', 'M5GCGV0VDT', 'cash', 9871, '2024-06-17', '2024-08-17', 2635, 737, 'active'),
(37, '生日特惠', 'UU0XRFREOO', 'cash', 22637, '2024-06-16', '2024-07-21', 8952, 963, 'inactive'),
(38, '冬季減價', 'GJYMFSENF8', 'percent', 72, '2024-06-14', '2024-09-04', 8097, 579, 'inactive'),
(39, '週年慶', 'BGBUEYOPBC', 'cash', 36209, '2024-06-06', '2024-08-23', 9658, 462, 'active'),
(40, '冬季減價', 'DWGA4FSZEB', 'percent', 28, '2024-06-18', '2024-08-21', 4845, 654, 'inactive'),
(41, '節日特賣', 'XMAJFVK9H7', 'cash', 26766, '2024-06-16', '2024-08-27', 7509, 113, 'active'),
(42, '春季促銷', '6SQHEZYXN7', 'percent', 55, '2024-06-16', '2024-07-20', 6605, 104, 'inactive'),
(43, '春季促銷', '4UHCRFQVLL', 'cash', 22337, '2024-06-09', '2024-08-10', 5432, 122, 'active'),
(44, '週年慶', 'X9C5N0N5QH', 'cash', 18842, '2024-06-27', '2024-08-05', 7220, 604, 'active'),
(45, '春季促銷', 'RJRUOZHC1A', 'cash', 16696, '2024-06-20', '2024-08-17', 8376, 645, 'inactive'),
(46, '限時優惠', 'ZL2R22W3LX', 'percent', 84, '2024-06-16', '2024-07-25', 2893, 55, 'active'),
(47, '生日特惠', 'SPAIZTMA9T', 'percent', 34, '2024-06-24', '2024-09-12', 5079, 112, 'inactive'),
(48, '春季促銷', 'AXWVEGL90E', 'cash', 5393, '2024-06-19', '2024-07-23', 3699, 132, 'active'),
(49, '生日特惠', 'D4BRCCTH4P', 'percent', 82, '2024-06-19', '2024-07-26', 8886, 447, 'inactive'),
(50, '生日特惠', 'C8A0O4FLMG', 'cash', 45, '2024-06-12', '2024-08-05', 877, 519, 'inactive'),
(51, '節日特賣	', 'PYGIEB0CF8', 'cash', 1000, '2024-05-08', '2024-05-31', 2000, 200, ''),
(52, '生日特惠	', 'EOAS5XIZWV', 'cash', 2000, '2024-05-14', '2024-05-31', 2000, 20, 'active'),
(53, '夏日優惠', 'IOA478CDUI', 'cash', 1000, '2024-04-17', '2024-05-01', 2000, 3000, 'active'),
(54, '夏日優惠', '277SZB2MT7', 'percent', 20, '2024-06-13', '2024-07-11', 2000, 200, 'active');

-- --------------------------------------------------------

--
-- 資料表結構 `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `mahjong_room`
--

CREATE TABLE `mahjong_room` (
  `room_id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `tele` varchar(10) NOT NULL,
  `tax_number` varchar(8) NOT NULL,
  `address` varchar(100) NOT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `mahjong_room`
--

INSERT INTO `mahjong_room` (`room_id`, `name`, `tele`, `tax_number`, `address`, `open_time`, `close_time`, `create_at`, `update_at`, `id`) VALUES
(1, '麻將大師中壢店', '0999999999', '12345678', '3F., No. 122-1, Jianguo Rd., Yingge Dist., New Taipei City 239 , Taiwan (R.O.C.)', NULL, NULL, '2024-05-30 10:35:32', '2024-05-30 16:35:32', 0),
(2, '麻將大師中山店', '0999999999', '12345678', '台北市中山區中山路2號2樓', '00:12:00', '23:12:00', '2024-05-31 04:14:46', '2024-05-31 10:14:46', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `marjong_table`
--

CREATE TABLE `marjong_table` (
  `table_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `table_type` tinyint(4) NOT NULL,
  `price` varchar(10) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `marjong_table`
--

INSERT INTO `marjong_table` (`table_id`, `room_id`, `name`, `status`, `table_type`, `price`, `create_at`, `update_at`) VALUES
(1, 2, '玄武桌', '0', 1, '1000', '2024-05-31 10:22:22', NULL),
(4, 2, '神龍桌', '0', 1, '1000', '2024-06-03 03:59:05', NULL),
(5, 1, '', '0', 0, '', '2024-06-03 11:30:52', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `rent_images`
--

CREATE TABLE `rent_images` (
  `id` int(3) UNSIGNED NOT NULL,
  `rent_product_id` int(3) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `rent_images`
--

INSERT INTO `rent_images` (`id`, `rent_product_id`, `url`) VALUES
(1, 1, '4563.jpg'),
(2, 1, 'rummikub-card.jpg'),
(3, 6, '下載.jpg'),
(4, 6, 'uno-hand_I1JrsbV.webp'),
(5, 2, 'rent2.webp'),
(8, 3, 'rent3.webp'),
(9, 4, 'rent4.webp'),
(10, 5, 'rent5.webp'),
(11, 6, 'original.jpg'),
(12, 7, 'quewang.webp'),
(13, 8, '機密代號.jpg'),
(14, 9, 'Dixit.webp'),
(15, 10, 'HARRY-POTTER.jpg'),
(16, 11, 'Betrayal at House on the Hill.jpg'),
(17, 12, '16922370081.jpg'),
(18, 13, '樂雀台.webp'),
(19, 14, 'pink.webp'),
(20, 15, '305f3d4b4052b06fb5e478f57d21d53c.png'),
(21, 16, 'D&D.jpg'),
(22, 17, '矮人礦坑.jpg'),
(31, 1, '38227864406_478df03b6c_z.jpg'),
(35, 1, '2015-10-23-16-17-33.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `rent_price_category`
--

CREATE TABLE `rent_price_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `range` varchar(20) NOT NULL,
  `rent_price` int(6) NOT NULL,
  `rent_day` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `rent_price_category`
--

INSERT INTO `rent_price_category` (`id`, `range`, `rent_price`, `rent_day`) VALUES
(1, '麻將桌', 3000, 30),
(2, '<500元', 150, 7),
(3, '501元~1000元', 300, 7),
(4, '1001元~2000元', 450, 7),
(5, '>2000元', 600, 7);

-- --------------------------------------------------------

--
-- 資料表結構 `rent_product`
--

CREATE TABLE `rent_product` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `category_id` int(10) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `img` varchar(100) NOT NULL,
  `quantity` int(4) NOT NULL,
  `quantity_available` int(4) NOT NULL,
  `rent_price_category_id` int(3) NOT NULL,
  `price` int(6) NOT NULL,
  `create_at` date NOT NULL,
  `update_at` date NOT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `rent_product`
--

INSERT INTO `rent_product` (`id`, `name`, `category_id`, `content`, `img`, `quantity`, `quantity_available`, `rent_price_category_id`, `price`, `create_at`, `update_at`, `valid`) VALUES
(1, '拉密', 2, '拉密是一款數字組合遊戲，遊戲規則簡單易懂，只有兩種數字排列法，用自己的邏輯來重新規劃排列順序，創造出變幻多端的數字組合；歡迎對數字敏感的你，規則簡單，只需要明白數字排列，能夠分辨紅、橘、藍、黑四種顏色即可暢玩。', '4563.jpg', 3, 3, 3, 850, '2024-05-23', '2024-06-03', 1),
(2, 'Go-stop', 2, '花牌是韓國的傳統遊戲，最早來自於日本，於朝鮮王朝後期傳到朝鮮半島。每副花牌中含有54張牌，其中48張牌分成12組花色，代表著12個月，各月份皆以當月的花草與動物為代表圖案。\r\n花牌常見的玩法為稱為GO&STOP 고스톱 ，由三位玩家進行，類似於台灣撲克牌「釣魚」與「撿紅點」，玩家需吃掉相同月份的牌以賺取分數，最後分數最高者勝利。遊戲玩法相當有趣，\r\n就算不會韓文也沒關係，非常適合在過節期間與家人、朋友一起同樂哦!', 'rent2.webp', 5, 0, 2, 200, '2024-05-23', '2024-05-23', 1),
(3, '斜行高手三代 - 寶麗來實木餐桌-胡桃木', 1, '✦雙模式設定，保留傳統模式，並增加計圈模式，免用方向環 \r\n✦業界獨家四液晶螢幕設計，無論圈數、風位、連莊次數都可一目了然 \r\n✦獨家20度大斜口,升牌位置集中向前\r\n✦快速充電,充電效能快4倍\r\n✦雙層隔音罩落牌超靜音\r\n✦骰盤防水設計 \r\n✦紫外線殺菌 \r\n✦熱風烘乾除溼\r\n✦奶茶色桌布', 'rent3.webp', 5, 5, 1, 43000, '2024-05-23', '2024-05-31', 1),
(4, '四旋翼二代-專折-MODO-X藍', 1, '✦大桌面小機身設計，遊戲空間大，又不佔居家空間\r\n✦USB快速充電(須手機本身配置快入充電功能)\r\n✦熱風烘乾除濕\r\n✦磁浮列車式出牌設計，升牌不卡物\r\n✦最新無聲機設計洗牌、上牌靜悄悄\r\n✦超薄機身設計腿部空間更舒適\r\n✦紫外線殺菌 \r\n✦雙層隔音罩', 'rent4.webp', 0, 0, 1, 27800, '2024-05-23', '2024-06-03', 0),
(5, '磁浮列車二代-超薄折疊-MODO-S系列', 1, '✦(二代骰盤升級)LED燈靜音液晶四模式設定\r\n✦大桌面小機身設計，遊戲空間大，又不佔居家空間\r\n✦USB快速充電(須手機本身配置快充功能)\r\n✦熱風烘乾除濕\r\n✦磁浮列車式出牌設計，升牌不卡物\r\n✦最新無聲機設計洗牌、上牌靜悄悄\r\n✦超薄機身設計腿部空間更舒適\r\n✦雙層隔音罩\r\n✦紫外線殺菌', 'rent5.webp', 4, 0, 1, 30800, '2024-05-23', '2024-05-28', 1),
(6, 'uno', 2, '風靡世界的UNO的紙牌遊戲,是1971發明的經典遊戲,現在由玩具公司美泰兒生產。當玩家打出倒數第二張牌時,必須喊出\"UNO\",遊戲因而得名。趕快加入UNO的行列吧!', 'original.jpg', 5, 5, 2, 250, '2024-05-23', '2024-06-03', 1),
(7, '雀王X7旋翼式過山車-餐桌款', 1, '型號：X7夢幻灰 / X7星空藍 / X7墨韻白\r\n電壓：AC110V/60Hz\r\n功耗：最小9W / 最大60W\r\n重量：70 Kg\r\n尺寸：約長100cm、寬100cm、高78cm\r\n保固期：1年（核心馬達終身保固）\r\n\r\n📌無皮帶、雙軸出牌設計\r\n📌減少耗材維修\r\n📌熱風除濕功能', 'quewang.webp', 3, 3, 1, 26800, '2024-05-25', '2024-05-28', 1),
(8, '機密代號', 3, '一款分組競賽的派對陣營遊戲。在一組加密情報之中，領袖必須想出絕妙的暗號，如：「一個名詞+數量」，讓隊員們以最少回合找出最多特務，率先找出我方所有特務的隊伍獲得勝利。不過得小心潛伏在情報背後的殺手，找到他的人必死無疑！這款遊戲擁有簡潔的遊戲機制，以及難以重複的題庫組合，讓它百玩不膩。', '機密代號.jpg', 5, 5, 3, 880, '2024-05-26', '2024-05-26', 1),
(9, '妙語說書人', 3, 'Dixit 是一款充滿想像力的桌上遊戲，適合各年齡層的玩家。遊戲由 3 到 6 人參與，遊戲時間大約為 30 分鐘。遊戲中，玩家輪流擔任敘述者，選擇一張手中的圖畫卡牌，並給出一個敘述，這個敘述可以是一個詞、一句話或者一段故事，只要是能夠引導其他玩家聯想到這張卡牌的提示。其他玩家則從自己的手牌中選擇一張他們認為與敘述者提示最匹配的卡牌。選好後，將這些卡牌洗牌，然後一起展示出來。所有人（除了敘述者）都要投票，猜測哪一張是敘述者的原始卡牌。', 'Dixit.webp', 5, 5, 4, 1320, '2024-05-26', '2024-06-03', 1),
(10, '【哈利波特】HARRY POTTER 超豪華巫師棋套組', 2, '朋友!先別管那麼多了,來場巫師棋吧!《哈利波特》中人氣超高的巫師棋完美還原.巫師棋的遊玩方式和一般西洋棋一樣雙方共有一個國王、一個王后、兩個城堡、兩個主教、兩個騎士和八個小卒,共16枚棋子.此套裝中共有32枚精緻的模型棋,分別裝在兩袋精美的禮品袋中和一枚大棋盤.棋子的尺寸約為5到10CM,棋盤為47*47CM', 'HARRY-POTTER.jpg', 3, 3, 5, 3580, '2024-05-26', '2024-05-26', 1),
(11, '山中小屋', 4, '「山中小屋」是個經典的探索類角色扮演遊戲，玩家扮演著受邀來到深山中一座豪宅，然後當所有人進屋之後，卻發現大門被鎖上了，而豪宅中不斷地發生一些詭異的事件，玩家必須尋找逃離的辦法。然而，在不知不覺中，有人成為了背叛者！引出了可怕的怪物，玩家該如何才能齊心協力地打到怪物，平安回家呢？讓我們一起來看看吧！', 'Betrayal at House on the Hill.jpg', 4, 4, 4, 1750, '2024-05-26', '0000-00-00', 1),
(12, '天胡一號 電動麻將桌_白色(摺疊款)', 1, '‧旋翼式過山車電動麻將桌。\r\n‧高質感羊絨檯面。\r\n‧全自動熱風除濕。\r\n‧執骰雙模式。\r\n‧防撞 + 降噪雙重防護。\r\n‧四邊USB充電孔。\r\n‧薄型桌面設計。\r\n‧贈精美配件組。', '16922370081.jpg', 2, 2, 1, 22800, '2024-05-26', '2024-05-28', 1),
(13, '樂雀台LQ-300-T6-超薄折疊機款', 1, '✦紫外線殺菌 \r\n✦機底一體沖壓鋼板\r\n✦大桌面小機身，取牌不費力\r\n✦熱風除濕烘乾洗牌自動開啟\r\n✦無輸送帶設計，免除皮帶損耗\r\n✦二階段上牌設計，順滑不倒牌\r\n✦快扣式折腳，玻璃底板高顏質\r\n✦骰盤檔位&電源按鍵設計更便利\r\n✦大桌面小機身設計，遊戲空間大，又不佔居家空間', '樂雀台.webp', 4, 4, 1, 25800, '2024-05-26', '2024-05-28', 1),
(14, 'T350 二代 櫻花少女心系列 過山麻將機 折疊款 櫻花湘妃粉', 1, '* 全新櫻花少女心系列\r\n* 足瓦熱風除濕、紫外線殺菌\r\n* 櫻花粉桌布 專屬粉色控制盤\r\n* 專製質感粉色邊框，絕美搭配\r\n* 超薄機身、腳下空間寬敞舒適\r\n* 新型無輸送帶設計、旋風上牌\r\n* 整合型電子式開關／檔位控制盤，免彎腰設計\r\n* 機底一體沖壓鋼板設計，無『甘蔗板』或『塑料板』濫竽充數', 'pink.webp', 3, 3, 1, 30800, '2024-05-26', '2024-05-28', 1),
(15, '黃金列車 V1折疊款麻將桌', 1, '講到電動麻將桌，許多人腦中第一個想到的可能就是長勝，其因為桌子款式多、品質不錯、加上有完善的售後服務，故一直是國人喜愛的品牌之一。這一款黃金列車 V1 標榜配有全封閉式軌道技術，不僅在操作上近乎無聲音，又加上過山車設計而不會卡牌尺，就使用性來說，兼具順暢、安靜及安全。\r\n\r\n而且機身內也配有熱風除濕，即便是久未使用，只要一鍵按下，不用多少時間就能讓麻將保持乾燥溫暖。同時還有 USB 插座能用於手機充電，就算是要在牌桌上坐上3、5個小時也不成問題。另外廠商加贈萬元麻將椅與各式麻將配件，無論商用、家用都值得參考。', '305f3d4b4052b06fb5e478f57d21d53c.png', 5, 5, 1, 39800, '2024-05-26', '2024-05-28', 1),
(16, '龍與地下城：鴉閣城', 4, '在一個古老的年代，魔力充斥整片大陸，\r\n\r\n邪惡在暗影中猖獗，居住地的邊緣也逐漸被怪物入侵。\r\n\r\n在這邪龍展翅、地城遍布時代，世間等待著英雄的降臨。\r\n\r\n穿著不同的防具，手持長劍、長弓及法杖的英雄們探索著上古遺跡，\r\n\r\n進行大膽的任務，並挑戰令人畏懼的怪物。\r\n\r\n這些任務都將在陰暗且神祕的地城中進行，而這個地城通稱為拉文羅夫特堡。', 'D&D.jpg', 4, 4, 5, 3200, '2024-05-26', '0000-00-00', 1),
(17, '矮人礦坑﻿', 3, '熱愛團體合作型遊戲的可以玩看看「矮人礦坑」！在遊戲中所有玩家會扮演成矮人族，而族內還會再分成掏金矮人跟搗蛋鬼，大家互不知道對方的身份，所以大家必須在隱藏身份的同時幫助到自己的夥伴，看究竟矮人們到底能不能成功掏金？還是會被搗蛋鬼阻饒呢？', '矮人礦坑.jpg', 8, 8, 3, 790, '2024-05-26', '0000-00-00', 1),
(18, '駱駝大賽', 3, '快來見識有史以來最瘋狂的駱駝大賽！\r\n尤其是駱駝疊在一起而金字塔倒轉時，場面將會一片混亂、瀕臨失控狀態！\r\n身為埃及上流社會的一員，聚集在沙漠中的目的只有一個：下注在你看好的駱駝身上，以分段賽及整場比賽贏得最多的獎金。\r\n然而在比賽中不是只靠運氣就能壓倒其他玩家，抓住比賽的節奏和精準掌握下注時機也是贏得比賽不可或缺的能力。\r\n\r\n一款簡單、快速、極度有趣且最多可讓8名玩家同樂的家庭遊戲。', '5ab8f249ff9c8b65f4cecd73_Camel_Up_Box_3D-p-800.jpeg', 0, 0, 4, 1320, '2024-05-31', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `rent_record`
--

CREATE TABLE `rent_record` (
  `id` int(5) UNSIGNED NOT NULL,
  `user_id` int(5) UNSIGNED NOT NULL,
  `product_id` int(5) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL,
  `rental_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `fine` int(5) DEFAULT NULL,
  `status` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `rent_record`
--

INSERT INTO `rent_record` (`id`, `user_id`, `product_id`, `order_date`, `rental_date`, `due_date`, `return_date`, `fine`, `status`) VALUES
(1, 4, 15, '2024-03-02 18:35:08', '2024-03-09', '2024-09-05', NULL, NULL, 1),
(2, 1, 1, '2024-03-10 18:35:08', '2024-03-10', '2024-03-17', '2024-03-17', NULL, 0),
(3, 2, 7, '2024-03-11 18:36:45', '2024-03-17', '2024-09-13', NULL, NULL, 1),
(4, 14, 10, '2024-04-06 18:37:39', '2024-04-08', '2024-04-22', '2024-04-22', NULL, 0),
(5, 4, 10, '2024-04-14 18:38:33', '2024-04-14', '2024-04-21', '2024-06-01', 3514, 0),
(6, 9, 17, '2024-05-01 18:38:33', '2024-05-02', '2024-05-23', NULL, NULL, 2),
(7, 9, 8, '2024-05-06 15:53:48', '2024-05-08', '2024-05-22', '2024-05-22', NULL, 0),
(8, 8, 3, '2024-05-09 19:27:23', '2024-05-09', '2024-12-05', NULL, NULL, 1),
(9, 14, 16, '2024-05-09 20:27:23', '2024-05-09', '2024-05-16', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `account` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `create_at` datetime NOT NULL,
  `valid` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `name`, `account`, `password`, `phone`, `email`, `create_at`, `valid`) VALUES
(1, 'Bob', 'bob', '6572bdaff799084b973320f43f09b363', '0944666666', 'bob@gmail.com', '2024-05-16 11:44:52', 1),
(2, 'Bear', 'bear', '6572bdaff799084b973320f43f09b363', '0954575554', 'bear@test.com', '2024-05-16 11:45:36', 1),
(3, 'Sam', 'sam', '6572bdaff799084b973320f43f09b363', '0911111111', 'Sam@gmail.com', '2024-05-16 12:36:35', 1),
(4, 'John', 'john', '6572bdaff799084b973320f43f09b363', '0955444333', 'john@gmail.com', '2024-05-16 12:36:35', 1),
(5, 'Joy', 'joy', '', '0955555555', 'joy@gmail.com', '2024-05-16 12:36:35', 1),
(6, 'Alex', 'alex', '12345', '0955444333', 'alex@test.com', '2024-05-17 10:40:20', 1),
(7, 'Mary', 'mary', '6572bdaff799084b973320f43f09b363', '0988555777', 'mary@test.com', '2024-05-17 11:51:07', 1),
(8, 'Frad', 'frad', '6572bdaff799084b973320f43f09b363', '', 'frad6969@test.com', '2024-05-17 15:19:21', 1),
(9, 'Sara', 'sara', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-17 15:23:56', 1),
(10, 'Mike', 'mike', '5a68e6cc0195b878aa5ff70df000cd5c', NULL, NULL, '2024-05-17 15:24:33', 1),
(11, 'Jason', 'jason', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-20 10:35:51', 1),
(12, 'Tommy', 'tommy', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-20 10:36:11', 1),
(13, 'Terry', 'terry', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-20 10:36:27', 1),
(14, 'Sophia', 'sophia', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-20 10:36:50', 1),
(15, 'Cindy', 'cindy', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-20 10:37:47', 1),
(16, 'Amber', 'amber', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-20 10:39:17', 1),
(17, 'Jackson', 'jackson', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-27 09:48:35', 1),
(18, 'Bryant', 'bryant', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-27 09:51:54', 1),
(19, 'Lucy', 'lucy', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-27 10:35:25', 1),
(20, 'Maki', 'maki', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-27 10:36:24', 1),
(21, 'Ruby', 'ruby', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-27 10:50:19', 1),
(22, 'Sunny', 'sunny', '6572bdaff799084b973320f43f09b363', NULL, NULL, '2024-05-27 10:58:19', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `discount_code` (`discount_code`);

--
-- 資料表索引 `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `mahjong_room`
--
ALTER TABLE `mahjong_room`
  ADD PRIMARY KEY (`room_id`);

--
-- 資料表索引 `marjong_table`
--
ALTER TABLE `marjong_table`
  ADD PRIMARY KEY (`table_id`),
  ADD KEY `room_id` (`room_id`);

--
-- 資料表索引 `rent_images`
--
ALTER TABLE `rent_images`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `rent_price_category`
--
ALTER TABLE `rent_price_category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `rent_product`
--
ALTER TABLE `rent_product`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `rent_record`
--
ALTER TABLE `rent_record`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `marjong_table`
--
ALTER TABLE `marjong_table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `rent_images`
--
ALTER TABLE `rent_images`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `rent_price_category`
--
ALTER TABLE `rent_price_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `rent_product`
--
ALTER TABLE `rent_product`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `rent_record`
--
ALTER TABLE `rent_record`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `marjong_table`
--
ALTER TABLE `marjong_table`
  ADD CONSTRAINT `marjong_table_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `mahjong_room` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
