-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 04 2024 г., 14:24
-- Версия сервера: 5.7.39
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `topdrop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cases`
--

CREATE TABLE `cases` (
  `id` int(10) UNSIGNED NOT NULL,
  `img` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) NOT NULL,
  `one_open_per` int(10) UNSIGNED DEFAULT NULL,
  `cost` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `coefficient` decimal(6,3) UNSIGNED NOT NULL DEFAULT '0.000',
  `skins` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `cases`
--

INSERT INTO `cases` (`id`, `img`, `title`, `name`, `one_open_per`, `cost`, `category`, `coefficient`, `skins`) VALUES
(1, 'ice.png', 'ice', 'Лёд', NULL, 9, 'Новогодние кейсы', 2.144, '[13, 102, 130, 176, 229, 420, 445, 571, 579, 638, 676, 680, 717, 727, 734, 68, 72, 74, 188, 224, 230, 451, 468, 497, 507, 557, 663, 723, 738, 795]'),
(2, 'christmas_tree.png', 'christmas_tree', 'Новогодняя Ёлка', NULL, 19, 'Новогодние кейсы', 2.194, '[16, 24, 32, 57, 58, 65, 103, 406, 413, 420, 438, 462, 506, 571, 758, 78, 105, 124, 143, 182, 227, 228, 229, 400, 499, 654, 669, 741, 745, 790]'),
(3, 'holidays.png', 'holidays', 'Каникулы', NULL, 29, 'Новогодние кейсы', 2.036, '[6, 31, 55, 93, 120, 148, 410, 422, 443, 569, 572, 658, 710, 732, 743, 181, 219, 284, 411, 412, 448, 495, 511, 574, 689, 740, 763, 786, 790, 796]'),
(4, 'old_year.png', 'old_year', 'Старый Год', NULL, 49, 'Новогодние кейсы', 2.036, '[33, 55, 91, 101, 120, 144, 185, 277, 435, 493, 583, 609, 702, 725, 760, 23, 445, 472, 473, 538, 553, 571, 572, 587, 658, 685, 743, 758, 781, 796]'),
(5, 'new_year.png', 'new_year', 'Новый Год', NULL, 99, 'Новогодние кейсы', 1.818, '[144, 154, 261, 277, 388, 425, 433, 509, 523, 531, 710, 722, 750, 789, 798, 9, 20, 32, 33, 57, 65, 101, 120, 169, 183, 222, 276, 463, 708, 712]'),
(6, 'free_vk.png', 'free_vk', 'За подписку на ВК', 86400, 0, 'Бесплатные кейсы', 2.318, '[43, 73, 125, 190, 217, 218, 395, 429, 430, 436, 498, 635, 713, 718, 738, 37, 39, 146, 194, 231, 232, 235, 243, 244, 246, 396, 416, 542]'),
(7, 'free_youtube.png', 'free_youtube', 'За подписку на YT', 86400, 0, 'Бесплатные кейсы', 2.456, '[26, 29, 30, 38, 74, 184, 220, 283, 430, 450, 498, 516, 557, 718, 752, 37, 39, 146, 194, 231, 232, 235, 243, 244, 246, 396, 416, 542]'),
(8, 'free_telegram.png', 'free_telegram', 'За подписку на ТГ', 86400, 0, 'Бесплатные кейсы', 2.104, '[41, 42, 73, 125, 184, 193, 217, 395, 476, 516, 639, 735, 738, 752, 773, 37, 39, 146, 194, 231, 232, 235, 243, 244, 246, 396, 416, 542]'),
(9, 'free_12.png', 'free_12', '12 Часов', 43200, 0, 'Бесплатные кейсы', 2.238, '[26, 30, 45, 184, 242, 407, 429, 436, 513, 628, 639, 719, 752, 762, 776, 37, 39, 146, 194, 231, 232, 235, 243, 244, 246, 396, 416, 542]'),
(10, 'free_23.png', 'free_23', '23 Часа', 82800, 0, 'Бесплатные кейсы', 2.084, '[30, 43, 44, 73, 184, 190, 217, 395, 407, 429, 476, 516, 545, 738, 768, 37, 39, 146, 194, 231, 232, 235, 243, 244, 246, 396, 416, 542]'),
(11, 'neurogift.png', 'neurogift', 'Нейроподарок', NULL, 9, 'Кейсы от нейросети', 1.812, '[104, 176, 177, 225, 228, 279, 285, 400, 412, 524, 636, 652, 683, 764, 783, 98, 188, 224, 230, 484, 651, 663, 670, 694, 738, 749, 779, 784, 791, 795]'),
(12, 'neuropocalypse.png', 'neuropocalypse', 'Нейропокалипсис', NULL, 9, 'Кейсы от нейросети', 1.716, '[25, 99, 103, 104, 105, 181, 438, 511, 555, 556, 572, 636, 654, 662, 698, 29, 68, 141, 437, 468, 475, 501, 507, 557, 694, 735, 749, 751, 774, 795]'),
(13, 'neurocrystal.png', 'neurocrystal', 'Нейрокристалл', NULL, 9, 'Кейсы от нейросети', 1.856, '[127, 143, 228, 391, 414, 511, 512, 525, 614, 626, 676, 727, 764, 767, 772, 29, 68, 98, 224, 230, 431, 557, 631, 651, 663, 670, 723, 735, 751, 779]'),
(14, 'permafrost.png', 'permafrost', 'Мерзлота', NULL, 9, 'Кейсы от нейросети', 2.058, '[176, 182, 228, 406, 420, 472, 473, 477, 499, 536, 634, 662, 690, 697, 770, 72, 74, 223, 230, 405, 437, 451, 464, 475, 497, 651, 694, 723, 738, 751]'),
(15, 'killer.png', 'killer', 'Убийца', NULL, 9, 'Кейсы от нейросети', 2.258, '[78, 148, 219, 399, 427, 445, 506, 524, 553, 626, 632, 654, 659, 683, 743, 68, 72, 74, 141, 223, 224, 230, 651, 670, 723, 735, 742, 751, 774, 791]'),
(16, 'crystal.png', 'crystal', 'Кристалл', NULL, 99, 'Новые кейсы', 2.144, '[10, 12, 53, 94, 97, 121, 122, 274, 389, 425, 458, 465, 487, 714, 753, 9, 58, 65, 119, 120, 212, 213, 281, 403, 410, 417, 418, 428, 518, 584]'),
(17, 'ice_cream.png', 'ice_cream', 'Мороженка', NULL, 139, 'Новые кейсы', 1.728, '[61, 62, 108, 118, 167, 387, 388, 425, 487, 552, 562, 610, 731, 765, 785, 7, 9, 14, 19, 54, 101, 119, 120, 215, 277, 410, 424, 428, 433, 493]'),
(18, 'cybersport.png', 'cybersport', 'Киберспорт', NULL, 199, 'Новые кейсы', 2.192, '[2, 61, 140, 167, 266, 353, 387, 479, 487, 488, 623, 657, 686, 739, 748, 52, 59, 94, 185, 433, 461, 481, 493, 531, 678, 702, 753, 756, 760, 789]'),
(19, 'province.png', 'province', 'Провинция', NULL, 259, 'Новые кейсы', 1.726, '[53, 61, 85, 88, 97, 114, 161, 265, 302, 337, 479, 488, 548, 562, 657, 6, 52, 95, 185, 465, 609, 650, 668, 702, 714, 725, 728, 759, 765, 766]'),
(20, 'capital.png', 'capital', 'Столица', NULL, 299, 'Новые кейсы', 1.828, '[108, 161, 167, 168, 274, 298, 302, 333, 350, 352, 440, 529, 577, 666, 739, 10, 97, 116, 140, 282, 465, 544, 583, 610, 672, 714, 722, 765, 785, 798]'),
(21, 'rare.webp', 'rare', 'Редкий', NULL, 19, 'Редкие кейсы', 1.482, '[31, 32, 33, 34, 36, 103, 130, 148, 177, 221, 284, 285, 406, 420, 477, 494, 500, 546, 571, 572, 573, 629, 632, 679, 689, 707, 743, 786, 792, 796, 40, 78, 105, 127, 129, 145, 149, 150, 225, 227, 229, 404, 541, 547, 555, 634, 641, 654, 655, 662, 669, 680, 716, 736, 737, 744, 745, 767, 783, 793]'),
(22, 'epic.webp', 'epic', 'Эпический', NULL, 29, 'Редкие кейсы', 2.232, '[19, 20, 23, 64, 69, 119, 120, 174, 215, 216, 281, 389, 391, 413, 414, 435, 466, 481, 510, 518, 569, 613, 614, 658, 675, 712, 732, 733, 760, 761, 18, 28, 67, 182, 219, 401, 499, 511, 512, 525, 536, 553, 570, 638, 643, 652, 676, 687, 699, 704, 727, 734, 740, 763, 781, 790]'),
(23, 'legendary.webp', 'legendary', 'Легендарный', NULL, 99, 'Редкие кейсы', 2.042, '[10, 12, 92, 138, 166, 167, 274, 277, 383, 425, 426, 480, 508, 509, 523, 531, 550, 583, 609, 610, 650, 666, 672, 702, 725, 753, 756, 757, 778, 798, 14, 15, 16, 54, 55, 57, 58, 60, 169, 170, 171, 212, 213, 276, 410, 417, 418, 442, 462, 463, 551, 584, 591, 592, 630, 692]'),
(24, 'arcane.webp', 'arcane', 'Тайный', NULL, 329, 'Редкие кейсы', 3.416, '[50, 84, 108, 160, 161, 265, 266, 299, 301, 328, 334, 338, 340, 345, 347, 349, 351, 373, 374, 397, 479, 488, 521, 646, 647, 648, 681, 695, 739, 747, 52, 53, 88, 109, 135, 376, 457, 458, 470, 487, 563, 682]'),
(25, 'knife.webp', 'knife', 'Ножевой', NULL, 999, 'Редкие кейсы', 1.898, '[4, 48, 49, 82, 84, 85, 134, 136, 158, 312, 315, 316, 318, 319, 320, 321, 323, 325, 329, 330, 332, 333, 336, 337, 339, 340, 342, 455, 456, 747, 51, 137, 163, 344, 345, 346, 348, 350, 351, 353, 355, 356, 649]'),
(26, 'gloves.png', 'gloves', 'Перчаточный', NULL, 999, 'Редкие кейсы', 1.648, '[47, 50, 79, 81, 287, 288, 289, 290, 291, 292, 293, 294, 295, 296, 297, 298, 299, 300, 160, 301, 302]'),
(27, 'schoolboy.webp', 'schoolboy', 'Школьник', NULL, 9, 'Наши сборки', 2.188, '[25, 145, 176, 180, 221, 228, 278, 579, 614, 627, 652, 679, 693, 697, 737, 29, 68, 98, 100, 188, 451, 464, 497, 631, 670, 738, 742, 749, 751, 784]'),
(28, 'anime.webp', 'anime', 'Аниме', NULL, 19, 'Наши сборки', 1.746, '[130, 222, 410, 417, 472, 540, 551, 556, 571, 629, 630, 675, 698, 699, 704, 145, 149, 404, 499, 541, 638, 644, 662, 680, 683, 717, 730, 737, 744, 745]'),
(29, 'pc.png', 'pc', 'Игровой ПК', NULL, 29, 'Наши сборки', 2.104, '[36, 119, 128, 389, 391, 420, 449, 473, 481, 493, 514, 708, 710, 732, 733, 28, 67, 103, 210, 221, 511, 570, 643, 679, 680, 690, 699, 704, 734, 790]'),
(30, 'jungle.png', 'jungle', 'Джунгли', NULL, 49, 'Наши сборки', 1.474, '[20, 55, 116, 212, 277, 417, 419, 435, 466, 518, 551, 592, 692, 732, 757, 25, 31, 177, 399, 413, 414, 445, 472, 477, 482, 534, 553, 565, 579, 587]'),
(31, 'death.webp', 'death', 'Смерть', NULL, 59, 'Наши сборки', 2.224, '[7, 10, 34, 69, 480, 487, 539, 584, 609, 610, 612, 708, 710, 731, 785, 17, 24, 31, 64, 414, 417, 441, 442, 449, 514, 551, 587, 673, 743, 761]'),
(32, 'summer.webp', 'summer', 'Лето', NULL, 69, 'Наши сборки', 1.912, '[7, 118, 169, 273, 376, 388, 510, 518, 519, 552, 668, 678, 722, 729, 789, 16, 24, 31, 36, 55, 64, 171, 213, 413, 420, 494, 614, 698, 761, 800]'),
(33, 'winter.webp', 'winter', 'Зима', NULL, 79, 'Наши сборки', 1.586, '[19, 59, 66, 94, 97, 119, 211, 389, 531, 577, 610, 692, 754, 756, 771, 20, 24, 58, 170, 213, 414, 417, 435, 441, 482, 538, 551, 613, 614, 758]'),
(34, 'golden_tree.png', 'golden_tree', 'Золотое дерево', NULL, 199, 'Наши сборки', 1.992, '[8, 92, 154, 160, 163, 179, 261, 347, 382, 383, 465, 598, 684, 714, 739, 6, 138, 185, 424, 544, 554, 583, 650, 711, 728, 757, 771, 787, 788, 789]'),
(35, 'easy_knife.png', 'easy_knife', 'Изи нож', NULL, 749, 'Наши сборки', 2.784, '[110, 158, 288, 291, 318, 325, 326, 334, 345, 486, 615, 622, 688, 720, 746, 108, 168, 271, 302, 353, 355, 356, 373, 383, 521, 535, 608, 648, 666, 748]'),
(36, 'revenge.png', 'revenge', 'Revenge Case', NULL, 39, 'Коллекции', 2.268, '[54, 64, 119, 170, 183, 215, 419, 533, 544, 569, 616, 661, 665, 672, 725, 25, 177, 178, 210, 278, 284, 524, 556, 658, 676, 693, 697, 699, 781, 796]'),
(37, 'sharp.webp', 'sharp', 'Sharp Case', NULL, 39, 'Коллекции', 2.034, '[6, 7, 52, 169, 389, 402, 403, 428, 493, 584, 673, 726, 728, 757, 799, 25, 102, 216, 278, 444, 514, 524, 556, 566, 573, 658, 693, 727, 743, 781]'),
(38, 'empire.webp', 'empire', 'Empire Case', NULL, 39, 'Коллекции', 1.762, '[23, 58, 64, 93, 128, 169, 282, 571, 579, 584, 610, 616, 750, 788, 789, 28, 180, 226, 278, 438, 546, 553, 573, 679, 689, 693, 727, 743, 781, 800]'),
(39, 'revival.webp', 'revival', 'Revival Case', NULL, 39, 'Коллекции', 1.654, '[19, 31, 34, 52, 66, 170, 171, 461, 482, 583, 614, 760, 789, 792, 799, 25, 28, 130, 177, 180, 284, 444, 448, 473, 524, 629, 632, 658, 699, 704]'),
(40, 'project_z9.webp', 'project_z9', 'Project Z9 Case', NULL, 39, 'Коллекции', 1.696, '[6, 31, 36, 117, 138, 183, 211, 435, 442, 592, 613, 711, 712, 750, 792, 102, 130, 177, 278, 495, 512, 514, 515, 536, 553, 658, 676, 689, 781, 786]'),
(41, 'scorpion.webp', 'scorpion', 'Scorpion Case', NULL, 59, 'Коллекции', 2.106, '[34, 52, 88, 91, 116, 117, 211, 222, 403, 424, 428, 470, 702, 725, 785, 17, 31, 35, 36, 148, 278, 391, 414, 442, 579, 587, 592, 673, 685, 697]'),
(42, 'origin.webp', 'origin', 'Origin Case', NULL, 399, 'Коллекции', 2.414, '[50, 83, 139, 161, 172, 334, 340, 342, 535, 598, 608, 624, 645, 701, 739, 8, 62, 88, 92, 142, 280, 376, 457, 487, 550, 577, 657, 682, 714, 766]'),
(43, 'furios.webp', 'furios', 'Furios Case', NULL, 159, 'Коллекции', 1.442, '[88, 95, 112, 114, 138, 139, 140, 167, 275, 375, 470, 531, 610, 678, 788, 6, 7, 54, 91, 94, 117, 144, 187, 493, 554, 616, 672, 708, 732, 760]'),
(44, 'rival.webp', 'rival', 'Rival Case', NULL, 109, 'Коллекции', 1.602, '[94, 135, 138, 173, 273, 443, 487, 523, 598, 665, 668, 731, 756, 785, 788, 15, 21, 34, 65, 101, 170, 171, 402, 433, 493, 494, 584, 591, 712, 760]'),
(45, 'fable.webp', 'fable', 'Fable Case', NULL, 39, 'Коллекции', 1.808, '[16, 20, 36, 57, 101, 171, 173, 187, 213, 551, 661, 673, 692, 711, 771, 18, 25, 28, 180, 285, 406, 477, 500, 515, 587, 632, 653, 675, 693, 781]');

-- --------------------------------------------------------

--
-- Структура таблицы `contracts`
--

CREATE TABLE `contracts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `skins` json NOT NULL,
  `skin_win` int(10) UNSIGNED NOT NULL,
  `result` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `text` text CHARACTER SET utf8mb4 NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inventory`
--

CREATE TABLE `inventory` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `gotfrom` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `dropped_from_case` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
  `time_loss` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `inventory`
--

INSERT INTO `inventory` (`id`, `user_id`, `gotfrom`, `type`, `item_id`, `dropped_from_case`, `status`, `time`, `time_loss`) VALUES
(1, 1, 'case', 'skin', 751, 'neurocrystal', 0, 1719149652, 1719149663),
(2, 1, 'case', 'skin', 779, 'neurocrystal', 0, 1719149652, 1719149663),
(3, 1, 'case', 'skin', 723, 'neurocrystal', 0, 1719149652, 1719149663),
(4, 1, 'case', 'skin', 431, 'neurocrystal', 0, 1719149652, 1719149663),
(5, 1, 'case', 'skin', 127, 'neurocrystal', 0, 1719149652, 1719149663),
(6, 1, 'case', 'skin', 230, 'neurocrystal', 0, 1719149663, 1719149674),
(7, 1, 'case', 'skin', 143, 'neurocrystal', 0, 1719149663, 1719149674),
(8, 1, 'case', 'skin', 779, 'neurocrystal', 0, 1719149663, 1719149674),
(9, 1, 'case', 'skin', 631, 'neurocrystal', 0, 1719149663, 1719149674),
(10, 1, 'case', 'skin', 767, 'neurocrystal', 0, 1719149663, 1719149674),
(11, 1, 'case', 'skin', 779, 'neurocrystal', 0, 1719149677, 1719149679),
(12, 1, 'case', 'skin', 414, 'neurocrystal', 0, 1719149677, 1719149679),
(13, 1, 'case', 'skin', 68, 'neurocrystal', 0, 1719149677, 1719149679),
(14, 1, 'case', 'skin', 651, 'neurocrystal', 0, 1719149677, 1719149679),
(15, 1, 'case', 'skin', 557, 'neurocrystal', 0, 1719149677, 1719149679),
(16, 1, 'case', 'skin', 678, 'cybersport', 0, 1719149688, 1719149708),
(17, 1, 'case', 'skin', 531, 'cybersport', 0, 1719149688, 1719149708),
(18, 1, 'case', 'skin', 94, 'cybersport', 0, 1719149688, 1719149708),
(19, 1, 'case', 'skin', 760, 'cybersport', 0, 1719149688, 1719149708),
(20, 1, 'case', 'skin', 167, 'cybersport', 0, 1719149688, 1719149708),
(21, 1, 'case', 'skin', 433, 'cybersport', 0, 1719149713, 1719149726),
(22, 1, 'case', 'skin', 531, 'cybersport', 0, 1719149713, 1719149726),
(23, 1, 'case', 'skin', 623, 'cybersport', 0, 1719149713, 1719149726),
(24, 1, 'case', 'skin', 756, 'cybersport', 0, 1719149713, 1719149726),
(25, 1, 'case', 'skin', 461, 'cybersport', 0, 1719149713, 1719149726),
(26, 1, 'case', 'skin', 702, 'cybersport', 0, 1719149742, 1719149745),
(27, 1, 'case', 'skin', 59, 'cybersport', 0, 1719149742, 1719149745),
(28, 1, 'case', 'skin', 266, 'cybersport', 0, 1719149742, 1719149745),
(29, 1, 'case', 'skin', 760, 'cybersport', 0, 1719149742, 1719149745),
(30, 1, 'case', 'skin', 59, 'cybersport', 0, 1719149742, 1719149745),
(31, 1, 'case', 'skin', 764, 'neurocrystal', 0, 1719271282, 1719271295),
(32, 1, 'case', 'skin', 670, 'neurocrystal', 0, 1719271282, 1719271295),
(33, 1, 'case', 'skin', 557, 'neurocrystal', 0, 1719271282, 1719271295),
(34, 1, 'case', 'skin', 670, 'neurocrystal', 0, 1719271282, 1719271295),
(35, 1, 'case', 'skin', 779, 'neurocrystal', 0, 1719271282, 1719271295),
(36, 1, 'case', 'skin', 230, 'neurocrystal', 1, 1719271296, NULL),
(37, 1, 'case', 'skin', 29, 'neurocrystal', 1, 1719271296, NULL),
(38, 1, 'case', 'skin', 663, 'neurocrystal', 1, 1719271296, NULL),
(39, 1, 'case', 'skin', 676, 'neurocrystal', 1, 1719271296, NULL),
(40, 1, 'case', 'skin', 230, 'neurocrystal', 1, 1719271296, NULL),
(41, 1, 'case', 'skin', 512, 'neurocrystal', 1, 1719271335, NULL),
(42, 1, 'case', 'skin', 631, 'neurocrystal', 1, 1719271335, NULL),
(43, 1, 'case', 'skin', 651, 'neurocrystal', 1, 1719271335, NULL),
(44, 1, 'case', 'skin', 751, 'neurocrystal', 1, 1719271335, NULL),
(45, 1, 'case', 'skin', 557, 'neurocrystal', 1, 1719271335, NULL),
(46, 1, 'case', 'skin', 554, 'golden_tree', 0, 1720510468, 1720510481),
(47, 1, 'case', 'skin', 711, 'golden_tree', 0, 1720510468, 1720510481),
(48, 1, 'case', 'skin', 728, 'golden_tree', 0, 1720510468, 1720510481),
(49, 1, 'case', 'skin', 138, 'golden_tree', 0, 1720510468, 1720510481),
(50, 1, 'case', 'skin', 789, 'golden_tree', 0, 1720510468, 1720510481),
(51, 1, 'case', 'skin', 583, 'golden_tree', 0, 1720510481, 1720510495),
(52, 1, 'case', 'skin', 465, 'golden_tree', 0, 1720510481, 1720510495),
(53, 1, 'case', 'skin', 465, 'golden_tree', 0, 1720510481, 1720510495),
(54, 1, 'case', 'skin', 185, 'golden_tree', 0, 1720510481, 1720510495),
(55, 1, 'case', 'skin', 6, 'golden_tree', 0, 1720510481, 1720510495),
(56, 1, 'case', 'skin', 583, 'golden_tree', 0, 1720510495, 1720510508),
(57, 1, 'case', 'skin', 424, 'golden_tree', 0, 1720510495, 1720510508),
(58, 1, 'case', 'skin', 424, 'golden_tree', 0, 1720510495, 1720510508),
(59, 1, 'case', 'skin', 711, 'golden_tree', 0, 1720510495, 1720510508),
(60, 1, 'case', 'skin', 583, 'golden_tree', 0, 1720510495, 1720510508),
(61, 1, 'case', 'skin', 771, 'golden_tree', 0, 1720510508, 1720510520),
(62, 1, 'case', 'skin', 650, 'golden_tree', 0, 1720510508, 1720510520),
(63, 1, 'case', 'skin', 789, 'golden_tree', 0, 1720510508, 1720510520),
(64, 1, 'case', 'skin', 787, 'golden_tree', 0, 1720510508, 1720510520),
(65, 1, 'case', 'skin', 788, 'golden_tree', 0, 1720510508, 1720510520),
(66, 1, 'case', 'skin', 771, 'golden_tree', 0, 1720510520, 1720510531),
(67, 1, 'case', 'skin', 757, 'golden_tree', 0, 1720510520, 1720510531),
(68, 1, 'case', 'skin', 788, 'golden_tree', 0, 1720510520, 1720510531),
(69, 1, 'case', 'skin', 6, 'golden_tree', 0, 1720510520, 1720510531),
(70, 1, 'case', 'skin', 788, 'golden_tree', 0, 1720510520, 1720510531),
(71, 1, 'case', 'skin', 554, 'golden_tree', 0, 1720510533, 1720510544),
(72, 1, 'case', 'skin', 728, 'golden_tree', 0, 1720510533, 1720510544),
(73, 1, 'case', 'skin', 92, 'golden_tree', 0, 1720510533, 1720510544),
(74, 1, 'case', 'skin', 92, 'golden_tree', 0, 1720510533, 1720510544),
(75, 1, 'case', 'skin', 788, 'golden_tree', 0, 1720510533, 1720510544),
(76, 1, 'case', 'skin', 554, 'golden_tree', 1, 1720510544, NULL),
(77, 1, 'case', 'skin', 179, 'golden_tree', 1, 1720510544, NULL),
(78, 1, 'case', 'skin', 728, 'golden_tree', 1, 1720510544, NULL),
(79, 1, 'case', 'skin', 383, 'golden_tree', 1, 1720510544, NULL),
(80, 1, 'case', 'skin', 465, 'golden_tree', 1, 1720510544, NULL),
(81, 1, 'case', 'skin', 788, 'golden_tree', 0, 1720700035, 1720700047),
(82, 1, 'case', 'skin', 771, 'golden_tree', 0, 1720700035, 1720700047),
(83, 1, 'case', 'skin', 787, 'golden_tree', 0, 1720700035, 1720700047),
(84, 1, 'case', 'skin', 185, 'golden_tree', 0, 1720700035, 1720700047),
(85, 1, 'case', 'skin', 6, 'golden_tree', 0, 1720700035, 1720700047),
(86, 1, 'case', 'skin', 481, 'cybersport', 0, 1721052081, 1721052092),
(87, 1, 'case', 'skin', 753, 'cybersport', 0, 1721052081, 1721052092),
(88, 1, 'case', 'skin', 753, 'cybersport', 0, 1721052081, 1721052092),
(89, 1, 'case', 'skin', 702, 'cybersport', 0, 1721052081, 1721052092),
(90, 1, 'case', 'skin', 493, 'cybersport', 0, 1721052081, 1721052092),
(91, 1, 'case', 'skin', 433, 'cybersport', 0, 1721052093, 1721052104),
(92, 1, 'case', 'skin', 481, 'cybersport', 0, 1721052093, 1721052104),
(93, 1, 'case', 'skin', 94, 'cybersport', 0, 1721052093, 1721052104),
(94, 1, 'case', 'skin', 167, 'cybersport', 0, 1721052093, 1721052104),
(95, 1, 'case', 'skin', 702, 'cybersport', 0, 1721052093, 1721052104);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `sum` decimal(9,2) UNSIGNED NOT NULL,
  `promo` varchar(255) DEFAULT NULL,
  `pay_system` varchar(255) DEFAULT NULL,
  `pay_type` varchar(255) DEFAULT NULL,
  `time_creation` int(10) UNSIGNED NOT NULL,
  `time_payment` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `sum`, `promo`, `pay_system`, `pay_type`, `time_creation`, `time_payment`, `status`) VALUES
(1, 1, 200.00, NULL, 'atolpay', 'card', 1719581587, NULL, 0),
(2, 1, 200.00, NULL, 'atolpay', 'card', 1719581616, NULL, 0),
(3, 1, 200.00, NULL, 'atolpay', 'card', 1719581635, NULL, 0),
(4, 1, 200.00, NULL, 'atolpay', 'card', 1719581636, NULL, 0),
(5, 1, 200.00, NULL, 'atolpay', 'card', 1719581636, NULL, 0),
(6, 1, 200.00, NULL, 'atolpay', 'card', 1719581677, NULL, 0),
(7, 1, 200.00, NULL, 'streampay', 'sbp', 1719943290, NULL, 0),
(8, 1, 200.00, NULL, 'streampay', 'sbp', 1719943353, NULL, 0),
(9, 1, 200.00, NULL, 'streampay', 'sbp', 1719943403, NULL, 0),
(10, 1, 200.00, NULL, 'streampay', 'sbp', 1719943448, NULL, 0),
(11, 1, 200.00, NULL, 'streampay', 'sbp', 1719943749, NULL, 0),
(12, 1, 200.00, NULL, 'streampay', 'sbp', 1720008558, NULL, 0),
(13, 1, 300.00, NULL, 'streampay', 'sbp', 1720008565, NULL, 0),
(14, 1, 300.00, NULL, 'streampay', 'sbp', 1720089730, NULL, 0),
(15, 1, 300.00, NULL, 'streampay', 'sbp', 1720089830, NULL, 0),
(16, 1, 200.00, NULL, 'streampay', 'sbp', 1720092201, NULL, 0),
(17, 1, 200.00, NULL, 'streampay', 'sbp', 1720092204, NULL, 0),
(18, 1, 200.00, NULL, 'streampay', 'sbp', 1720092204, NULL, 0),
(19, 1, 200.00, NULL, 'streampay', 'sbp', 1720092204, NULL, 0),
(20, 1, 200.00, NULL, 'streampay', 'sbp', 1720092205, NULL, 0),
(21, 1, 200.00, NULL, 'streampay', 'sbp', 1720092205, NULL, 0),
(22, 1, 200.00, NULL, 'streampay', 'sbp', 1720092440, NULL, 0),
(23, 1, 200.00, NULL, 'streampay', 'sbp', 1720092440, NULL, 0),
(24, 1, 200.00, NULL, 'streampay', 'sbp', 1720092441, NULL, 0),
(25, 1, 3.00, NULL, 'streampay', 'sbp', 1720094144, NULL, 0),
(26, 1, 300.00, NULL, 'streampay', 'sbp', 1720094390, NULL, 0),
(27, 1, 25.00, NULL, 'streampay', 'sbp', 1720094398, NULL, 0),
(28, 1, 25.00, NULL, 'streampay', 'sbp', 1720094400, NULL, 0),
(29, 1, 25.00, NULL, 'streampay', 'sbp', 1720094400, NULL, 0),
(30, 1, 300.00, NULL, 'streampay', 'sbp', 1720094434, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `prizes`
--

CREATE TABLE `prizes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `day` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `xp` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `promo`
--

CREATE TABLE `promo` (
  `id` int(10) UNSIGNED NOT NULL,
  `promo` varchar(60) NOT NULL,
  `activations` int(10) UNSIGNED DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `bonus` int(10) UNSIGNED DEFAULT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `promo`
--

INSERT INTO `promo` (`id`, `promo`, `activations`, `expiration`, `bonus`, `type`) VALUES
(1, 'new', 5, '2023-12-28', 35, 0),
(2, 'DAVID_GENIY', 0, NULL, 20, 0),
(4, 'ЛУЧШИЙ', 100, NULL, 19, 0),
(5, 'ЯЙЦО', 5, NULL, 25, 0),
(6, 'ФЕВРАЛЬ', NULL, '2024-03-01', 16, 0),
(7, 'санж36', 9988, NULL, 36, 0),
(8, 'resli23', 99, NULL, 23, 0),
(9, 'ROZ4IK', 95, NULL, 36, 0),
(10, 'ХЭЙСИ', 100, NULL, 22, 0),
(11, 'HOS30', 100, NULL, 30, 0),
(12, 'МОДЕР', NULL, NULL, 11, 0),
(13, '9МАЯ', 0, NULL, 20, 0),
(14, 'САМЫЙ_КРУТОЙ_ПРОМОКОД_7892', 0, NULL, 40, 0),
(15, 'САМЫЙ_КРУТОЙ_ПРОМОКОД_5862', 1, NULL, 40, 0),
(16, 'САМЫЙ_КРУТОЙ_ПРОМОКОД_4562', 0, NULL, 40, 0),
(17, 'САМЫЙ_КРУТОЙ_ПРОМОКОД_7542', 0, NULL, 40, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `promo_users`
--

CREATE TABLE `promo_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `promo_id` int(10) UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `promo_users`
--

INSERT INTO `promo_users` (`id`, `user_id`, `promo_id`, `time`) VALUES
(1, 1, 4, 1720092195);

-- --------------------------------------------------------

--
-- Структура таблицы `skins`
--

CREATE TABLE `skins` (
  `id` int(10) UNSIGNED NOT NULL,
  `img` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rarity` varchar(60) NOT NULL,
  `cost` decimal(9,2) UNSIGNED NOT NULL,
  `collection` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `skins`
--

INSERT INTO `skins` (`id`, `img`, `title`, `name`, `rarity`, `cost`, `collection`) VALUES
(2, 'G22_Nest_pEgnVm0.webp', 'G22', 'Nest', 'arcane', 950.00, 'NULL'),
(3, 'Tanto_Year_Of_The_Tiger_VzE3RmC.webp', 'Tanto', 'Year Of The Tiger', 'gold', 1150.00, 'NULL'),
(4, 'Tanto_Glitch.webp', 'Tanto', 'Glitch', 'gold', 1080.00, 'NULL'),
(5, 'Charm_Cranium.webp', 'Charm', 'Cranium', 'arcane', 940.00, 'NULL'),
(6, 'UMP45_Beast_KGFJJzf.webp', 'UMP45', 'Beast', 'arcane', 134.00, 'NULL'),
(7, 'M4_Samurai_jUSYHq6.webp', 'M4', 'Samurai', 'arcane', 120.00, 'NULL'),
(8, 'Charm_Mengu_dqWlqJG.webp', 'Charm', 'Mengu', 'arcane', 359.00, 'NULL'),
(9, 'FS_Venom_vIjDlL1.webp', 'F/S', 'Venom', 'arcane', 70.00, 'NULL'),
(10, 'FS_Octopus_n0HSf3g.webp', 'F/S', 'Octopus', 'legendary', 222.00, 'NULL'),
(11, 'Charm_Cone_hCfdDMg.webp', 'Charm', 'Cone', 'legendary', 560.00, 'NULL'),
(12, 'Charm_Snow_Flake_eSjXrNc.webp', 'Charm', 'Snow Flake', 'legendary', 480.00, 'NULL'),
(13, 'UMP45_Luminous_hkQYFsF.webp', 'UMP45', 'Luminous', 'legendary', 29.60, 'NULL'),
(14, 'Sticker_Nice_Skill_Color_4cpOadq.webp', 'Sticker', 'Nice Skill Color', 'legendary', 98.99, 'NULL'),
(15, 'Sticker_Hades_OkX9IYD.webp', 'Sticker', 'Hades', 'legendary', 89.00, 'NULL'),
(16, 'Charm_4_Years_Gold_qiPMlXw.webp', 'Charm', '4 Years Gold', 'legendary', 65.00, 'NULL'),
(17, 'Charm_Hot_Ice_Balloon_Z6PAdbZ.webp', 'Charm', 'Hot Ice Balloon', 'legendary', 48.00, 'NULL'),
(18, 'M4_R.O.N.I.N._mk56_fNQ10zb.webp', 'M4', 'R.O.N.I.N. mk56', 'epic', 22.00, 'NULL'),
(19, 'Sticker_Fluffy_Assassin_k9uRg0Q.webp', 'Sticker', 'Fluffy Assassin', 'epic', 110.00, 'NULL'),
(20, 'Charm_Christmas_Tree_VlKQyTO.webp', 'Charm', 'Christmas Tree', 'epic', 67.00, 'NULL'),
(21, 'TEC-9_Splinter_Storm_e4ajZ6a.webp', 'TEC-9', 'Splinter Storm', 'epic', 65.20, 'NULL'),
(22, 'AWM_Kings_D3hRMkC.webp', 'AWM', 'Kings', 'epic', 2.90, 'NULL'),
(23, 'Sticker_Kraken_P58M5Df.webp', 'Sticker', 'Kraken', 'epic', 45.80, 'NULL'),
(24, 'Sticker_AC_Color.webp', 'Sticker', 'A/C Color', 'epic', 43.00, 'NULL'),
(25, 'Sticker_Thunderbolt_Gold_Ienr9Wd.webp', 'Sticker', 'Thunderbolt Gold', 'epic', 31.00, 'NULL'),
(26, 'USP_Pisces_Hfe0iAD.webp', 'USP', 'Pisces', 'epic', 2.19, 'NULL'),
(27, 'M110_Themis_AnqCTld.webp', 'M110', 'Themis', 'epic', 3.88, 'NULL'),
(28, 'Sticker_Ice_Hot_WJHYbiq.webp', 'Sticker', 'Ice Hot', 'epic', 20.20, 'NULL'),
(29, 'Graffiti_Quencher.webp', 'Graffiti', 'Quencher', 'epic', 4.59, 'NULL'),
(30, 'Graffiti_Hot_Winter_Party_JXlchke.webp', 'Graffiti', 'Hot Winter Party', 'epic', 2.24, 'NULL'),
(31, 'MP5_Project_Z9_2pDa6qC.webp', 'MP5', 'Project Z9', 'rare', 42.00, 'NULL'),
(32, 'AWM_Polar_Night_YP6fd8J.webp', 'AWM', 'Polar Night', 'rare', 60.00, 'NULL'),
(33, 'MP7_Winter_Sport_S9KTRAP.webp', 'MP7', 'Winter Sport', 'rare', 65.00, 'NULL'),
(34, 'Sticker_New_Year_2022_0PkvxWO.webp', 'Sticker', 'New Year 2022', 'rare', 76.00, 'NULL'),
(35, 'Sticker_Koi_LhhkPgz.webp', 'Sticker', 'Koi', 'rare', 57.90, 'NULL'),
(36, 'Sticker_Christmas_Joy_djVxHTq.webp', 'Sticker', 'Christmas Joy', 'rare', 45.90, 'NULL'),
(37, 'G22_Lion_Lord.webp', 'G22', 'Lion Lord', 'rare', 0.73, 'NULL'),
(38, 'M60_Ares_4ynGwT7.webp', 'M60', 'Ares', 'rare', 1.86, 'NULL'),
(39, 'P90_Purple_Mist_e9Fqawl.webp', 'P90', 'Purple Mist', 'rare', 0.80, 'NULL'),
(40, 'Sticker_Hot_Winter_Party_uIPFsEe.webp', 'Sticker', 'Hot Winter Party', 'rare', 14.50, 'NULL'),
(41, 'Graffiti_Headshot_CDERcO3.webp', 'Graffiti', 'Headshot', 'rare', 2.66, 'NULL'),
(42, 'Graffiti_Bull_U4bzOUv.webp', 'Graffiti', 'Bull', 'rare', 1.98, 'NULL'),
(43, 'Graffiti_Radio_G8KcOxV.webp', 'Graffiti', 'Radio', 'rare', 1.95, 'NULL'),
(44, 'Graffiti_UFO.webp', 'Graffiti', 'UFO', 'rare', 1.93, 'NULL'),
(45, 'M16_Camouflage_3V5n82t.webp', 'M16', 'Camouflage', 'uncommon', 2.00, 'NULL'),
(46, 'M4_Sunset_Dv8VRBb.webp', 'M4', 'Sunset', 'arcane', 578.00, 'NULL'),
(47, 'Gloves_Living_Flame_4ZF24ot.webp', 'Gloves', 'Living Flame', 'gold', 3000.00, 'NULL'),
(48, 'jKommando_Floral_iJqPWBF.webp', 'jKommando', 'Floral', 'gold', 2150.00, 'NULL'),
(49, 'Butterfly_Starfall_kPjHgE9.webp', 'Butterfly', 'Starfall', 'gold', 1725.00, 'NULL'),
(50, 'Gloves_Phoenix_Risen_pJ0YX6p.webp', 'Gloves', 'Phoenix Risen', 'gold', 1580.00, 'NULL'),
(51, 'Dual_Daggers_Grunge_BUawHwt.webp', 'Dual Daggers', 'Grunge', 'gold', 950.00, 'NULL'),
(52, 'P90_Samurai_2RRWbSl.webp', 'P90', 'Samurai', 'arcane', 180.00, 'NULL'),
(53, 'Sticker_Hot_Winter_Party_Gold_QWreDn5.webp', 'Sticker', 'Hot Winter Party Gold', 'arcane', 323.00, 'NULL'),
(54, 'FabM_Cranium.webp', 'FabM', 'Cranium', 'legendary', 84.00, 'NULL'),
(55, 'G22_Frost_Wyrm_wKobDc7.webp', 'G22', 'Frost Wyrm', 'legendary', 57.77, 'NULL'),
(56, 'Sticker_Sushi_Color_72U8B95.webp', 'Sticker', 'Sushi Color', 'legendary', 344.00, 'NULL'),
(57, 'FS_Rush_uKESmLk.webp', 'F/S', 'Rush', 'legendary', 71.50, 'NULL'),
(58, 'MP7_Arcade_7p6cM1y.webp', 'MP7', 'Arcade', 'legendary', 52.93, 'NULL'),
(59, 'Charm_Drakeling.webp', 'Charm', 'Drakeling', 'legendary', 195.00, 'NULL'),
(60, 'Chibi_Redhound.webp', 'Chibi', 'Redhound', 'legendary', 67.48, 'NULL'),
(61, 'G22_Monster_JAbI3pl.webp', 'G22', 'Monster', 'epic', 355.00, 'NULL'),
(62, 'M40_Winter_Track_EMGpEYg.webp', 'M40', 'Winter Track', 'epic', 303.00, 'NULL'),
(63, 'Sticker_Polar_Clarity_OOmqSH1.webp', 'Sticker', 'Polar Clarity', 'epic', 919.00, 'NULL'),
(64, 'P90_Iron_Will_xIh2Sma.webp', 'P90', 'Iron Will', 'epic', 50.00, 'NULL'),
(65, 'AKR12_Carving_i6vab6l.webp', 'AKR12', 'Carving', 'epic', 60.00, 'NULL'),
(66, 'Sticker_Demon_Flame_Color_zVSCCia.webp', 'Sticker', 'Demon Flame Color', 'epic', 177.00, 'NULL'),
(67, 'M40_Thief_Of_The_Christmas_mlHEMVN.webp', 'M40', 'Thief Of The Christmas', 'epic', 28.98, 'NULL'),
(68, 'AKR12_Carbon_m4A7W62.webp', 'AKR12', 'Carbon', 'epic', 6.20, 'NULL'),
(69, 'Sticker_Be_Cool_Color_fUDQa2i.webp', 'Sticker', 'Be Cool Color', 'epic', 85.00, 'NULL'),
(70, 'Sticker_Numb_Santa_LYRHcrC.webp', 'Sticker', 'Numb Santa', 'rare', 3470.00, 'NULL'),
(71, 'AWM_Xenoguard.webp', 'AWM', 'Xenoguard', 'rare', 5.05, 'NULL'),
(72, 'TEC-9_Royal_Frost_SrIt0Yk.webp', 'TEC-9', 'Royal Frost', 'rare', 8.75, 'NULL'),
(73, 'G22_Carbon_nkKrh6j.webp', 'G22', 'Carbon', 'rare', 1.80, 'NULL'),
(74, 'FabM_Thief_Of_The_Christmas_A7pcNqf.webp', 'FabM', 'Thief Of The Christmas', 'rare', 4.95, 'NULL'),
(75, 'MAC10_Purple_Mist_s7GtrDG.webp', 'MAC10', 'Purple Mist', 'rare', 9.20, 'NULL'),
(76, 'FAMAS_Handcraft_mOpQn3d.webp', 'FAMAS', 'Handcraft', 'rare', 1.20, 'NULL'),
(77, 'MP5_Space_Blaster_Ndbtfab.webp', 'MP5', 'Space Blaster', 'rare', 1.00, 'NULL'),
(78, 'Charm_Owl_of_Athena_HkFAuGI.webp', 'Charm', 'Owl of Athena', 'rare', 12.00, 'NULL'),
(79, 'Gloves_Geometric_jySyuhd.webp', 'Gloves', 'Geometric', 'gold', 4899.00, 'NULL'),
(80, 'Fang_Obsidian.webp', 'Fang', 'Obsidian', 'arcane', 4000.00, 'NULL'),
(81, 'Gloves_Punk_OldI0tX.webp', 'Gloves', 'Punk', 'gold', 2200.00, 'NULL'),
(82, 'Karambit_Year_Of_The_Tiger_NY0zFiV.webp', 'Karambit', 'Year Of The Tiger', 'gold', 2110.00, 'NULL'),
(83, 'Tanto_Yakuza_1WreSUB.webp', 'Tanto', 'Yakuza', 'gold', 1519.00, 'NULL'),
(84, 'Kunai_Luxury_3w3TC49.webp', 'Kunai', 'Luxury', 'gold', 1445.00, 'NULL'),
(85, 'Kunai_Augustite_dnadg6W.webp', 'Kunai', 'Augustite', 'gold', 1239.00, 'NULL'),
(86, 'jKommando_Prism_npbEvyL.webp', 'jKommando', 'Prism', 'gold', 1000.00, 'NULL'),
(87, 'Flip_Magnalium.webp', 'Flip', 'Magnalium', 'gold', 840.00, 'NULL'),
(88, 'Charm_Hot_Winter_Party_ThxiWsP.webp', 'Charm', 'Hot Winter Party', 'arcane', 272.00, 'NULL'),
(89, 'Graffiti_Homing_Snowman_DKTdbTP.webp', 'Graffiti', 'Homing Snowman', 'arcane', 10.00, 'NULL'),
(90, 'FAMAS_Monster_KN73ryu.webp', 'FAMAS', 'Monster', 'legendary', 2149.00, 'NULL'),
(91, 'AKR_Scylla_1ikTA4o.webp', 'AKR', 'Scylla', 'legendary', 150.00, 'NULL'),
(92, 'M16_4_Years_KSW3IO3.webp', 'M16', '4 Years', 'legendary', 202.96, 'NULL'),
(93, 'UMP45_Cyberpunk_2B3DMqz.webp', 'UMP45', 'Cyberpunk', 'epic', 77.55, 'NULL'),
(94, 'TEC-9_Restless_XE2A5Ff.webp', 'TEC-9', 'Restless', 'epic', 110.00, 'NULL'),
(95, 'M16_Retro_Arcade_ATFPe5V.webp', 'M16', 'Retro Arcade', 'epic', 165.00, 'NULL'),
(96, 'Sticker_Green_Sinister_rKgDrUF.webp', 'Sticker', 'Green Sinister', 'epic', 334.00, 'NULL'),
(97, 'Sticker_Party_Rabbit_UvdJ5dg.webp', 'Sticker', 'Party Rabbit', 'epic', 295.00, 'NULL'),
(98, 'TEC-9_Tie_Dye_yDXqOYF.webp', 'TEC-9', 'Tie Dye', 'epic', 5.80, 'NULL'),
(99, 'M60_Spaceware.webp', 'M60', 'Spaceware', 'epic', 10.99, 'NULL'),
(100, 'Graffiti_Ban_rsKm0e9.webp', 'Graffiti', 'Ban', 'epic', 7.50, 'NULL'),
(101, 'Sticker_Shadow_Kitsune_awfm0aK.webp', 'Sticker', 'Shadow Kitsune', 'rare', 94.87, 'NULL'),
(102, 'Charm_Haradashi_pVyH4PU.webp', 'Charm', 'Haradashi', 'rare', 22.79, 'NULL'),
(103, 'Charm_Spirit_caaixA0.webp', 'Charm', 'Spirit', 'rare', 21.50, 'NULL'),
(104, 'Sticker_Venomtail.webp', 'Sticker', 'Venomtail', 'rare', 14.00, 'NULL'),
(105, 'Charm_Candy_Cane_d6uNORo.webp', 'Charm', 'Candy Cane', 'rare', 12.50, 'NULL'),
(106, 'Sticker_Zen_Chip_Color_n40CakK.webp', 'Sticker', 'Zen Chip Color', 'arcane', 4198.00, 'NULL'),
(107, 'Butterfly_Dragon_Glass_FtPL4cB.webp', 'Butterfly', 'Dragon Glass', 'gold', 2070.00, 'NULL'),
(108, 'FAMAS_Fury_m4p5e4J.webp', 'FAMAS', 'Fury', 'arcane', 427.94, 'NULL'),
(109, 'M4A1_Bubblegum_ODEnewN.webp', 'M4A1', 'Bubblegum', 'arcane', 308.00, 'NULL'),
(110, 'Kunai_Snow_Camo_CXHw4pk.webp', 'Kunai', 'Snow Camo', 'gold', 1500.00, 'NULL'),
(111, 'Kukri_Constellations_tEwk0lM.webp', 'Kukri', 'Constellations', 'gold', 720.00, 'NULL'),
(112, 'Charm_Meowgical_Genie.webp', 'Charm', 'Meowgical Genie', 'arcane', 330.00, 'NULL'),
(113, 'TEC-9_Necromancer_OYqTVSD.webp', 'TEC-9', 'Necromancer', 'legendary', 2100.00, 'NULL'),
(114, 'M110_Harbinger.webp', 'M110', 'Harbinger', 'legendary', 370.00, 'NULL'),
(115, 'M4A1_Mermaid_fQxl7Ot.webp', 'M4A1', 'Mermaid', 'legendary', 450.00, 'NULL'),
(116, 'Sticker_Demonic_Beast_Color_FQZigd8.webp', 'Sticker', 'Demonic Beast Color', 'legendary', 238.00, 'NULL'),
(117, 'Sticker_Rudolf_VjrjGUC.webp', 'Sticker', 'Rudolf', 'legendary', 149.00, 'NULL'),
(118, 'M4A1_Serpent.webp', 'M4A1', 'Serpent', 'epic', 270.00, 'NULL'),
(119, 'P90_Ghoul_O4P1UAC.webp', 'P90', 'Ghoul', 'epic', 82.80, 'NULL'),
(120, 'P350_Neon_wSgB3eL.webp', 'P350', 'Neon', 'epic', 85.62, 'NULL'),
(121, 'Sticker_Fire_Color_R0hC5t7.webp', 'Sticker', 'Fire Color', 'epic', 345.00, 'NULL'),
(122, 'Sticker_Winter_Sport_Color_OqhIYjV.webp', 'Sticker', 'Winter Sport Color', 'epic', 180.00, 'NULL'),
(123, 'AWM_Poseidon_8nniHrW.webp', 'AWM', 'Poseidon', 'epic', 9.95, 'NULL'),
(124, 'MP7_Offroad_tOjtGAK.webp', 'MP7', 'Offroad', 'epic', 10.60, 'NULL'),
(125, 'MAC10_Wild_Rage.webp', 'MAC10', 'Wild Rage', 'epic', 2.50, 'NULL'),
(126, 'SPAS_Vibe_xSNfLvE.webp', 'SPAS', 'Vibe', 'epic', 10.00, 'NULL'),
(127, 'AKR12_Transistor_OdgRw2J.webp', 'AKR12', 'Transistor', 'rare', 18.69, 'NULL'),
(128, 'Sticker_Shooter_f5Wttl2.webp', 'Sticker', 'Shooter', 'rare', 95.50, 'NULL'),
(129, 'FS_Royal_Frost_kvncPe5.webp', 'F/S', 'Royal Frost', 'rare', 10.48, 'NULL'),
(130, 'Charm_Antidote_iK2zVny.webp', 'Charm', 'Antidote', 'rare', 20.00, 'NULL'),
(131, 'M9_Bayonet_Blue_Blood_XNpZ4M2.webp', 'M9 Bayonet', 'Blue Blood', 'arcane', 7996.00, 'NULL'),
(132, 'Gloves_Neuro_eH7Q1kn.webp', 'Gloves', 'Neuro', 'gold', 6350.00, 'NULL'),
(133, 'Karambit_Claw_aQMZVoP.webp', 'Karambit', 'Claw', 'gold', 5700.00, 'NULL'),
(134, 'Karambit_Cold_Flame_QdCb68P.webp', 'Karambit', 'Cold Flame', 'gold', 1860.00, 'NULL'),
(135, 'AKR_Tag_King_YTBK9Zq.webp', 'AKR', 'Tag King', 'arcane', 300.00, 'NULL'),
(136, 'Tanto_Dojo_bPPrhJS.webp', 'Tanto', 'Dojo', 'gold', 1400.00, 'NULL'),
(137, 'Tanto_Retro_Arcade_JTdCGsc.webp', 'Tanto', 'Retro Arcade', 'gold', 800.00, 'NULL'),
(138, 'Charm_Santa_Globe_9G9VXLX.webp', 'Charm', 'Santa Globe', 'legendary', 170.00, 'NULL'),
(139, 'USP_Digital_Burst_6heyjew.webp', 'USP', 'Digital Burst', 'epic', 545.00, 'NULL'),
(140, 'Sticker_4_Years_Metallic_6zPyfIy.webp', 'Sticker', '4 Years Metallic', 'epic', 220.00, 'NULL'),
(141, 'Graffiti_Ace.webp', 'Graffiti', 'Ace', 'epic', 5.45, 'NULL'),
(142, 'USP_2_Years_KVMwLKN.webp', 'USP', '2 Years', 'rare', 395.00, 'NULL'),
(143, 'TEC-9_Reactor_KaSjsHT.webp', 'TEC-9', 'Reactor', 'rare', 14.35, 'NULL'),
(144, 'Sticker_Winter_Sport_Xzgjf9l.webp', 'Sticker', 'Winter Sport', 'rare', 105.98, 'NULL'),
(145, 'P350_Autumn_BDaRRoA.webp', 'P350', 'Autumn', 'rare', 9.99, 'NULL'),
(146, 'AKR_Evolution_QkHZjwH.webp', 'AKR', 'Evolution', 'rare', 0.73, 'NULL'),
(147, 'M4_Minotaur_y7hL7ne.webp', 'M4', 'Minotaur', 'rare', 2.10, 'NULL'),
(148, 'Sticker_Be_Cool_TZZVbAW.webp', 'Sticker', 'Be Cool', 'rare', 40.89, 'NULL'),
(149, 'Charm_Classified_ucMnjka.webp', 'Charm', 'Classified', 'rare', 13.99, 'NULL'),
(150, 'Sticker_Sultry.webp', 'Sticker', 'Sultry', 'rare', 13.00, 'NULL'),
(151, 'M4A1_Year_Of_The_Tiger_kq2pWM1.webp', 'M4A1', 'Year Of The Tiger', 'arcane', 6700.00, 'NULL'),
(152, 'MP7_Blizzard_fW72kLy.webp', 'MP7', 'Blizzard', 'arcane', 2150.00, 'NULL'),
(153, 'Flip_Stone_Cold_Esikn3P.webp', 'Flip', 'Stone Cold', 'gold', 6133.00, 'NULL'),
(154, 'Berettas_Royal_Rose.webp', 'Berettas', 'Royal Rose', 'arcane', 420.00, 'NULL'),
(155, 'Sticker_Winter_Fun_Color_a5uh3pg.webp', 'Sticker', 'Winter Fun Color', 'arcane', 2370.00, 'NULL'),
(156, 'Flip_Dragon_Glass_LqvZRBz.webp', 'Flip', 'Dragon Glass', 'gold', 1400.00, 'NULL'),
(157, 'Flip_Vortex_sVxgGwb.webp', 'Flip', 'Vortex', 'gold', 1400.00, 'NULL'),
(158, 'Kunai_Reaper_9LzQZ6G.webp', 'Kunai', 'Reaper', 'gold', 1245.00, 'NULL'),
(159, 'Flip_Holiday_Frost.webp', 'Flip', 'Holiday Frost', 'gold', 999.00, 'NULL'),
(160, 'Gloves_Handcraft_nmOJwPZ.webp', 'Gloves', 'Handcraft', 'gold', 950.00, 'NULL'),
(161, 'Kukri_Antique_Silver_7M58unm.webp', 'Kukri', 'Antique Silver', 'gold', 790.00, 'NULL'),
(162, 'Kukri_Digital_Burst_074Lu2A.webp', 'Kukri', 'Digital Burst', 'gold', 770.00, 'NULL'),
(163, 'Scorpion_Starfall_tALou4R.webp', 'Scorpion', 'Starfall', 'gold', 730.00, 'NULL'),
(164, 'P90_Nebula.webp', 'P90', 'Nebula', 'arcane', 488.88, 'NULL'),
(165, 'P350_Radiation_Iu0U2av.webp', 'P350', 'Radiation', 'legendary', 1780.00, 'NULL'),
(166, 'M16_Triumphant_WNjhQg2.webp', 'M16', 'Triumphant', 'legendary', 411.00, 'NULL'),
(167, 'M16_Muraena_y7JdqM6.webp', 'M16', 'Muraena', 'legendary', 370.00, 'NULL'),
(168, 'Sticker_Big_Boy_sAur0AN.webp', 'Sticker', 'Big Boy', 'legendary', 595.00, 'NULL'),
(169, 'MAC10_Fatal_Combo_IGCSDJ0.webp', 'MAC10', 'Fatal Combo', 'legendary', 70.00, 'NULL'),
(170, 'Chibi_Esperto_Cyx8IGJ.webp', 'Chibi', 'Esperto', 'legendary', 77.00, 'NULL'),
(171, 'Sticker_Wyrm_Color.webp', 'Sticker', 'Wyrm Color', 'legendary', 60.00, 'NULL'),
(172, 'Sticker_Penguin_MAOh56p.webp', 'Sticker', 'Penguin', 'epic', 1411.00, 'NULL'),
(173, 'MP5_Reactor_PTosyhM.webp', 'MP5', 'Reactor', 'epic', 180.00, 'NULL'),
(174, 'Charm_Ammunition_0MvrkOl.webp', 'Charm', 'Ammunition', 'epic', 72.06, 'NULL'),
(175, 'FAMAS_Beagle_iG2TFEc.webp', 'FAMAS', 'Beagle', 'epic', 13.00, 'NULL'),
(176, 'Charm_4_Years_Silver_p8wYNzP.webp', 'Charm', '4 Years Silver', 'epic', 29.00, 'NULL'),
(177, 'Charm_Baby_Penguin_xb27RcP.webp', 'Charm', 'Baby Penguin', 'rare', 33.00, 'NULL'),
(178, 'Charm_Insectoid.webp', 'Charm', 'Insectoid', 'rare', 20.00, 'NULL'),
(179, 'AWM_Stickerbomb_1jC5rbm.webp', 'AWM', 'Stickerbomb', 'arcane', 348.99, 'NULL'),
(180, 'P350_Tag_King_wgHE4is.webp', 'P350', 'Tag King', 'legendary', 29.47, 'NULL'),
(181, 'USP_Chameleon_JryVPdO.webp', 'USP', 'Chameleon', 'legendary', 24.00, 'NULL'),
(182, 'Desert_Eagle_Dragon_Glass_00Qdhv9.webp', 'Desert Eagle', 'Dragon Glass', 'epic', 17.00, 'NULL'),
(183, 'Sticker_Sea_of_Death_HbV4Bzx.webp', 'Sticker', 'Sea of Death', 'epic', 49.99, 'NULL'),
(184, 'AKR12_Steam_Beast_n9MpPnh.webp', 'AKR12', 'Steam Beast', 'epic', 2.34, 'NULL'),
(185, 'Sticker_Candy_Cane_sZExAhb.webp', 'Sticker', 'Candy Cane', 'rare', 198.98, 'NULL'),
(186, 'AKR_Nano_mOynoj6.webp', 'AKR', 'Nano', 'rare', 3.30, 'NULL'),
(187, 'Desert_Eagle_Morgan_7ueJAOI.webp', 'Desert Eagle', 'Morgan', 'rare', 112.00, 'NULL'),
(188, 'M4_PRO_gzo4msk.webp', 'M4', 'PRO', 'rare', 6.98, 'NULL'),
(189, 'M4A1_Kitsune_f0M9aiN.webp', 'M4A1', 'Kitsune', 'rare', 0.44, 'NULL'),
(190, 'M60_Demonic_Fog_hm2ODO7.webp', 'M60', 'Demonic Fog', 'rare', 3.70, 'NULL'),
(191, 'TEC-9_Needle_oNXfsPb.webp', 'TEC-9', 'Needle', 'rare', 0.41, 'NULL'),
(192, 'TEC-9_Tropic_Cj6HzWp.webp', 'TEC-9', 'Tropic', 'rare', 0.37, 'NULL'),
(193, 'M16_Facet_nZH96rh.webp', 'M16', 'Facet', 'uncommon', 1.22, 'NULL'),
(194, 'P350_Skull_h1FgK4D.webp', 'P350', 'Skull', 'uncommon', 0.62, 'NULL'),
(195, 'P350_Nano_GKgJQE0.webp', 'P350', 'Nano', 'uncommon', 0.35, 'NULL'),
(196, 'G22_Yellow_Line_fp07oWn.webp', 'G22', 'Yellow Line', 'uncommon', 0.31, 'NULL'),
(197, 'AWM_Elevation_g5v7OpZ.webp', 'AWM', 'Elevation', 'uncommon', 0.19, 'NULL'),
(198, 'MP5_Dusk_VAxiZQk.webp', 'MP5', 'Dusk', 'uncommon', 0.08, 'NULL'),
(199, 'TEC-9_Aurora_rpdrcKq.webp', 'TEC-9', 'Aurora', 'uncommon', 0.07, 'NULL'),
(200, 'MP7_Dawn_Sm5IYFM.webp', 'MP7', 'Dawn', 'uncommon', 0.07, 'NULL'),
(201, 'M4_Powergame_20vNrs7.webp', 'M4', 'Powergame', 'uncommon', 0.07, 'NULL'),
(202, 'UMP45_Pixel_wAV9EgV.webp', 'UMP45', 'Pixel', 'common', 0.29, 'NULL'),
(203, 'USP_Line_wtjTVoT.webp', 'USP', 'Line', 'common', 0.28, 'NULL'),
(204, 'SM1014_Northern_Camouflage_fr4SdTw.webp', 'SM1014', 'Northern Camouflage', 'common', 0.24, 'NULL'),
(205, 'SM1014_Branches_rzAYjW0.webp', 'SM1014', 'Branches', 'common', 0.14, 'NULL'),
(206, 'Desert_Eagle_Glory_5JGLF61.webp', 'Desert Eagle', 'Glory', 'common', 0.05, 'NULL'),
(207, 'FS_Zap_ysnJjEV.webp', 'F/S', 'Zap', 'common', 0.05, 'NULL'),
(208, 'M110_Tech_Shard_gIf373O.webp', 'M110', 'Tech Shard', 'common', 0.04, 'NULL'),
(209, 'M40_Impale_yHA4eud.webp', 'M40', 'Impale', 'common', 0.03, 'NULL'),
(210, 'G22_Casual_iQMhjJh.webp', 'G22', 'Casual', 'legendary', 20.00, 'NULL'),
(211, 'AKR12_4_Years_CRqTK3W.webp', 'AKR12', '4 Years', 'legendary', 114.99, 'NULL'),
(212, 'Chibi_Juggernaut_kCb2610.webp', 'Chibi', 'Juggernaut', 'legendary', 75.00, 'NULL'),
(213, 'Charm_Grumpy_Tiger_HTul9BN.webp', 'Charm', 'Grumpy Tiger', 'legendary', 53.00, 'NULL'),
(214, 'M4_Grand_Prix_FZb7gmu.webp', 'M4', 'Grand Prix', 'epic', 12.35, 'NULL'),
(215, 'Sticker_Ghost_Lantern_Color_gNRVpEk.webp', 'Sticker', 'Ghost Lantern Color', 'epic', 93.92, 'NULL'),
(216, 'P350_4_Years_pFvofSm.webp', 'P350', '4 Years', 'epic', 37.99, 'NULL'),
(217, 'FAMAS_Anger_fM15ae9.webp', 'FAMAS', 'Anger', 'epic', 2.45, 'NULL'),
(218, 'SPAS_Zeus_lAGdg4C.webp', 'SPAS', 'Zeus', 'epic', 4.15, 'NULL'),
(219, 'Charm_Antique_Vase_F74MuOU.webp', 'Charm', 'Antique Vase', 'epic', 17.20, 'NULL'),
(220, 'UMP45_Cerberus_nfeeLSH.webp', 'UMP45', 'Cerberus', 'epic', 2.09, 'NULL'),
(221, 'AKR_Carbon_N1QAjeK.webp', 'AKR', 'Carbon', 'rare', 23.00, 'NULL'),
(222, 'Charm_Brainless_RA21kD3.webp', 'Charm', 'Brainless', 'rare', 94.93, 'NULL'),
(223, 'AKR12_Armored_OVCrul2.webp', 'AKR12', 'Armored', 'rare', 8.49, 'NULL'),
(224, 'UMP45_Geometric_6aJXy6z.webp', 'UMP45', 'Geometric', 'rare', 5.40, 'NULL'),
(225, 'M110_Z-07_M.A.R.K.S.M.A.N._hLTl12w.webp', 'M110', 'Z-07 M.A.R.K.S.M.A.N.', 'rare', 12.50, 'NULL'),
(226, 'Sticker_Hound_of_Hades_tPBcQc9.webp', 'Sticker', 'Hound of Hades', 'rare', 20.00, 'NULL'),
(227, 'Charm_Mind_Blowing_Gift_YFbzcgk.webp', 'Charm', 'Mind Blowing Gift', 'rare', 18.82, 'NULL'),
(228, 'Sticker_AWM_Master_isOIRGV.webp', 'Sticker', 'AWM Master', 'rare', 17.00, 'NULL'),
(229, 'M40_Stickerbomb_V7VuOYZ.webp', 'M40', 'Stickerbomb', 'rare', 9.69, 'NULL'),
(230, 'Graffiti_Pegus_0T8NKLA.webp', 'Graffiti', 'Pegus', 'rare', 6.00, 'NULL'),
(231, 'SM1014_Quake_Bb5ugJt.webp', 'SM1014', 'Quake', 'uncommon', 0.61, 'NULL'),
(232, 'M40_PRO_ydDVDsg.webp', 'M40', 'PRO', 'uncommon', 0.54, 'NULL'),
(233, 'AKR_Worm_P4s7XsT.webp', 'AKR', 'Worm', 'uncommon', 0.34, 'NULL'),
(234, 'USP_Fiend_wGnYbzI.webp', 'USP', 'Fiend', 'uncommon', 0.09, 'NULL'),
(235, 'AKR_Tiger_D2gdf2b.webp', 'AKR', 'Tiger', 'common', 0.89, 'NULL'),
(236, 'M4_Tiger_voqT2lq.webp', 'M4', 'Tiger', 'common', 0.50, 'NULL'),
(237, 'P350_Savannah_iPg0ijo.webp', 'P350', 'Savannah', 'common', 0.34, 'NULL'),
(238, 'P90_Pilot_ngTFKh2.webp', 'P90', 'Pilot', 'common', 0.20, 'NULL'),
(239, 'UMP45_Iron_1F2EMo1.webp', 'UMP45', 'Iron', 'common', 0.15, 'NULL'),
(240, 'M9_Bayonet_Dragon_Glass_5W01iuN.webp', 'M9 Bayonet', 'Dragon Glass', 'arcane', 29222.00, 'NULL'),
(241, 'Stiletto_Tie_Dye_eookk0u.webp', 'Stiletto', 'Tie Dye', 'gold', 1770.00, 'NULL'),
(242, 'SM1014_Wave_4f7k4z7.webp', 'SM1014', 'Wave', 'rare', 1.29, 'NULL'),
(243, 'FabM_Hercules_3avw7AG.webp', 'FabM', 'Hercules', 'rare', 0.64, 'NULL'),
(244, 'SPAS_Griffin_vm4HbUL.webp', 'SPAS', 'Griffin', 'rare', 0.65, 'NULL'),
(245, 'Desert_Eagle_Ace_t4oVCp8.webp', 'Desert Eagle', 'Ace', 'rare', 0.39, 'NULL'),
(246, 'AKR12_Mechanic_BkOxY3m.webp', 'AKR12', 'Mechanic', 'uncommon', 0.75, 'NULL'),
(247, 'FAMAS_Gunsmoke_FscUFlZ.webp', 'FAMAS', 'Gunsmoke', 'uncommon', 0.07, 'NULL'),
(248, 'Desert_Eagle_Thunder_D8VtIhq.webp', 'Desert Eagle', 'Thunder', 'common', 0.35, 'NULL'),
(249, 'G22_Pixel_Camouflage_Tf6CfR5.webp', 'G22', 'Pixel Camouflage', 'common', 0.30, 'NULL'),
(250, 'G22_Pattern_IknhHjt.webp', 'G22', 'Pattern', 'common', 0.21, 'NULL'),
(251, 'FabM_Waste_JFaS6co.webp', 'FabM', 'Waste', 'common', 0.20, 'NULL'),
(252, 'TEC-9_Dalmatian_x4caNjU.webp', 'TEC-9', 'Dalmatian', 'common', 0.17, 'NULL'),
(253, 'FN_FAL_Aquamarine_94WvXNB.webp', 'FN FAL', 'Aquamarine', 'common', 0.16, 'NULL'),
(254, 'G22_Scale_SzgyxKO.webp', 'G22', 'Scale', 'common', 0.05, 'NULL'),
(255, 'M60_Turret_aWVg1iR.webp', 'M60', 'Turret', 'common', 0.05, 'NULL'),
(256, 'FN_FAL_Acid_Carbon_zN8l8f3.webp', 'FN FAL', 'Acid Carbon', 'common', 0.04, 'NULL'),
(257, 'SM1014_Blaster_Fxll5wA.webp', 'SM1014', 'Blaster', 'common', 0.04, 'NULL'),
(258, 'FabM_Cursed_Fire_fgiYhuz.webp', 'FabM', 'Cursed Fire', 'common', 0.04, 'NULL'),
(259, 'MP7_Thorn_d8SPA9d.webp', 'MP7', 'Thorn', 'common', 0.04, 'NULL'),
(260, 'M40_Cursed_Fire_819o5ZZ.webp', 'M40', 'Cursed Fire', 'common', 0.03, 'NULL'),
(261, 'AKR_Dragon_r7NRQJN.webp', 'AKR', 'Dragon', 'arcane', 351.00, 'NULL'),
(262, 'AKR_Treasure_Hunter_tsrFxRQ.webp', 'AKR', 'Treasure Hunter', 'arcane', 4999.00, 'NULL'),
(263, 'AKR_Mirage_Menace.webp', 'AKR', 'Mirage Menace', 'arcane', 2000.00, 'NULL'),
(264, 'AKR12_Riot_C26JuYP.webp', 'AKR12', 'Riot', 'arcane', 2000.00, 'NULL'),
(265, 'M4A1_Paladin.webp', 'M4A1', 'Paladin', 'arcane', 1100.00, 'NULL'),
(266, 'M4_Pixel_Storm_3lzmbX4.webp', 'M4', 'Pixel Storm', 'arcane', 474.00, 'NULL'),
(267, 'AKR_Digital_Burst_vynf3fA.webp', 'AKR', 'Digital Burst', 'legendary', 1830.00, 'NULL'),
(268, 'AKR_2_Years_Red_cCyudol.webp', 'AKR', '2 Years Red', 'legendary', 8699.00, 'NULL'),
(269, 'AKR12_Railgun_q0Kk70X.webp', 'AKR12', 'Railgun', 'legendary', 760.00, 'NULL'),
(270, 'M4A1_Immortal_nLfHrYO.webp', 'M4A1', 'Immortal', 'legendary', 580.00, 'NULL'),
(271, 'M4_Necromancer_fd4B16O.webp', 'M4', 'Necromancer', 'legendary', 660.69, 'NULL'),
(272, 'AKR12_Geometric_7teF3Kf.webp', 'AKR12', 'Geometric', 'legendary', 407.00, 'NULL'),
(273, 'AKR_Necromancer_WfU7Cty.webp', 'AKR', 'Necromancer', 'legendary', 196.00, 'NULL'),
(274, 'M4A1_K.I.N.G._v7.03_Nc4FpVK.webp', 'M4A1', 'K.I.N.G. v7.03', 'legendary', 338.00, 'NULL'),
(275, 'AKR_Fabric_Storm_KNRr9Th.webp', 'AKR', 'Fabric Storm', 'legendary', 730.00, 'NULL'),
(276, 'AKR12_Ashbringer.webp', 'AKR12', 'Ashbringer', 'legendary', 89.99, 'NULL'),
(277, 'M4_Revival_zk52m1f.webp', 'M4', 'Revival', 'legendary', 104.00, 'NULL'),
(278, 'M4_Night_Wolf_L1StpbM.webp', 'M4', 'Night Wolf', 'legendary', 33.98, 'NULL'),
(279, 'M4_Lizard_dN1WC5D.webp', 'M4', 'Lizard', 'legendary', 16.00, 'NULL'),
(280, 'AKR_Night_Fury_AqSfLeY.webp', 'AKR', 'Night Fury', 'epic', 225.00, 'NULL'),
(281, 'AKR_Sport_qDYHNK8.webp', 'AKR', 'Sport', 'epic', 66.00, 'NULL'),
(282, 'M4_Predator_uswBHsJ.webp', 'M4', 'Predator', 'epic', 183.74, 'NULL'),
(283, 'M4A1_Sour_Lv2iXBA.webp', 'M4A1', 'Sour', 'epic', 4.00, 'NULL'),
(284, 'AKR12_Pixel_Camouflage_Mf5I5o4.webp', 'AKR12', 'Pixel Camouflage', 'rare', 22.41, 'NULL'),
(285, 'AKR12_Flow_8XuS1x5.webp', 'AKR12', 'Flow', 'rare', 30.00, 'NULL'),
(286, 'Gloves_Autumn_sZHONuv.webp', 'Gloves', 'Autumn', 'gold', 7000.00, 'NULL'),
(287, 'Gloves_Retro_Wave_DQmbJ4s.webp', 'Gloves', 'Retro Wave', 'gold', 2988.00, 'NULL'),
(288, 'Gloves_X-Ray.webp', 'Gloves', 'X-Ray', 'gold', 1992.00, 'NULL'),
(289, 'Gloves_Year_Of_The_Tiger_zGV0c4t.webp', 'Gloves', 'Year Of The Tiger', 'gold', 1750.00, 'NULL'),
(290, 'Gloves_Raider_CsbpCTe.webp', 'Gloves', 'Raider', 'gold', 1700.00, 'NULL'),
(291, 'Gloves_Champion_tYgEfDf.webp', 'Gloves', 'Champion', 'gold', 1699.00, 'NULL'),
(292, 'Gloves_Royal_Rose.webp', 'Gloves', 'Royal Rose', 'gold', 1690.00, 'NULL'),
(293, 'Gloves_Templar.webp', 'Gloves', 'Templar', 'gold', 1640.00, 'NULL'),
(294, 'Gloves_Burning_Fists_XF5RKFT.webp', 'Gloves', 'Burning Fists', 'gold', 1550.00, 'NULL'),
(295, 'Gloves_Fossil_kC048ne.webp', 'Gloves', 'Fossil', 'gold', 1325.00, 'NULL'),
(296, 'Gloves_Dragon_Scale.webp', 'Gloves', 'Dragon Scale', 'gold', 1200.00, 'NULL'),
(297, 'Gloves_Acid_Icn8OjI.webp', 'Gloves', 'Acid', 'gold', 1090.00, 'NULL'),
(298, 'Gloves_Onyx.webp', 'Gloves', 'Onyx', 'gold', 1050.00, 'NULL'),
(299, 'Gloves_Steam_Rider_iFwOG7P.webp', 'Gloves', 'Steam Rider', 'gold', 1039.00, 'NULL'),
(300, 'Gloves_Thug_loARvrH.webp', 'Gloves', 'Thug', 'gold', 1000.00, 'NULL'),
(301, 'Gloves_Tan_Hide.webp', 'Gloves', 'Tan Hide', 'gold', 724.00, 'NULL'),
(302, 'Gloves_Camo_hYBEonI.webp', 'Gloves', 'Camo', 'gold', 620.00, 'NULL'),
(303, 'Karambit_Gold_tw204NE.webp', 'Karambit', 'Gold', 'gold', 91260.00, 'NULL'),
(304, 'Dual_Daggers_Harmony_a9Tsokd.webp', 'Dual Daggers', 'Harmony', 'gold', 86000.00, 'NULL'),
(305, 'M9_Bayonet_Universe_lYvxxF1.webp', 'M9 Bayonet', 'Universe', 'arcane', 17000.00, 'NULL'),
(306, 'M9_Bayonet_Scratch_3eVW7JS.webp', 'M9 Bayonet', 'Scratch', 'arcane', 13330.00, 'NULL'),
(307, 'M9_Bayonet_Frozen_T0K5yn2.webp', 'M9 Bayonet', 'Frozen', 'arcane', 8000.00, 'NULL'),
(308, 'M9_Bayonet_Kumo_1XrZ3HV.webp', 'M9 Bayonet', 'Kumo', 'arcane', 5900.00, 'NULL'),
(309, 'M9_Bayonet_Ancient_EvVMeVN.webp', 'M9 Bayonet', 'Ancient', 'arcane', 5600.00, 'NULL'),
(310, 'Karambit_Universe_8oTd14S.webp', 'Karambit', 'Universe', 'gold', 3450.00, 'NULL'),
(311, 'Butterfly_Kumo_KoCaXHm.webp', 'Butterfly', 'Kumo', 'gold', 3299.00, 'NULL'),
(312, 'Karambit_Dragon_Glass_CjYCpaN.webp', 'Karambit', 'Dragon Glass', 'gold', 3195.00, 'NULL'),
(313, 'M9_Bayonet_Digital_Burst_SyixJ75.webp', 'M9 Bayonet', 'Digital Burst', 'arcane', 3170.00, 'NULL'),
(314, 'Karambit_Frozen_rIBAc75.webp', 'Karambit', 'Frozen', 'gold', 3150.00, 'NULL'),
(315, 'Kunai_Poison_49NhHLQ.webp', 'Kunai', 'Poison', 'gold', 2999.00, 'NULL'),
(316, 'Karambit_Scratch_Hfep5J9.webp', 'Karambit', 'Scratch', 'gold', 2893.00, 'NULL'),
(317, 'Karambit_Snow_Camo_INlqeXR.webp', 'Karambit', 'Snow Camo', 'gold', 2815.00, 'NULL'),
(318, 'Karambit_Purple_Camo_WomqK6I.webp', 'Karambit', 'Purple Camo', 'gold', 2310.00, 'NULL'),
(319, 'Butterfly_Cold_Flame_B921PxP.webp', 'Butterfly', 'Cold Flame', 'gold', 2296.00, 'NULL'),
(320, 'Butterfly_Legacy_U0hmUiD.webp', 'Butterfly', 'Legacy', 'gold', 2218.75, 'NULL'),
(321, 'Butterfly_Fire_Storm_ZUQhcAQ.webp', 'Butterfly', 'Fire Storm', 'gold', 2150.00, 'NULL'),
(322, 'jKommando_Frozen_D0JFHHt.webp', 'jKommando', 'Frozen', 'gold', 1988.00, 'NULL'),
(323, 'Kunai_Bone_TkrZTQR.webp', 'Kunai', 'Bone', 'gold', 1793.93, 'NULL'),
(324, 'Butterfly_Black_Widow_F3IzIB4.webp', 'Butterfly', 'Black Widow', 'gold', 1750.00, 'NULL'),
(325, 'Kunai_Radiation_UxaSZ4W.webp', 'Kunai', 'Radiation', 'gold', 1650.00, 'NULL'),
(326, 'Tanto_Pearl_Abyss_kULE7hY.webp', 'Tanto', 'Pearl Abyss', 'gold', 1510.90, 'NULL'),
(327, 'Tanto_Restless_xgBC0Dz.webp', 'Tanto', 'Restless', 'gold', 1435.55, 'NULL'),
(328, 'Tanto_Malachite_5Ti2Rp7.webp', 'Tanto', 'Malachite', 'gold', 1425.00, 'NULL'),
(329, 'jKommando_Augustite_DAH0oGk.webp', 'jKommando', 'Augustite', 'gold', 1400.00, 'NULL'),
(330, 'Kunai_Cold_Flame_gn9lZJk.webp', 'Kunai', 'Cold Flame', 'gold', 1360.00, 'NULL'),
(331, 'Stiletto_Damascus_GKb08M4.webp', 'Stiletto', 'Damascus', 'gold', 1355.00, 'NULL'),
(332, 'jKommando_Luxury_M201wlE.webp', 'jKommando', 'Luxury', 'gold', 1350.00, 'NULL'),
(333, 'Stiletto_Viper_dhzgivT.webp', 'Stiletto', 'Viper', 'gold', 1346.00, 'NULL'),
(334, 'Stiletto_Soul_Devourer_d8SgH3y.webp', 'Stiletto', 'Soul Devourer', 'gold', 1300.00, 'NULL'),
(335, 'Flip_Frozen_7t8lr0H.webp', 'Flip', 'Frozen', 'gold', 1286.00, 'NULL'),
(336, 'Tanto_Transistor_DnZVUVt.webp', 'Tanto', 'Transistor', 'gold', 1275.00, 'NULL'),
(337, 'jKommando_Reaper_NsHZ4Ua.webp', 'jKommando', 'Reaper', 'gold', 1266.00, 'NULL'),
(338, 'Flip_Arctic_NxGy66R.webp', 'Flip', 'Arctic', 'gold', 1250.00, 'NULL'),
(339, 'Tanto_Flow_m57iiG5.webp', 'Tanto', 'Flow', 'gold', 1220.00, 'NULL'),
(340, 'jKommando_Ancient_0Kq9zFk.webp', 'jKommando', 'Ancient', 'gold', 1150.00, 'NULL'),
(341, 'Flip_Snow_Camo_WvVqPd8.webp', 'Flip', 'Snow Camo', 'gold', 1100.00, 'NULL'),
(342, 'Dual_Daggers_Jaws_9NhFObo.webp', 'Dual Daggers', 'Jaws', 'gold', 1050.00, 'NULL'),
(343, 'Dual_Daggers_Acid_Ob239bu.webp', 'Dual Daggers', 'Acid', 'gold', 1040.00, 'NULL'),
(344, 'Dual_Daggers_Demonic_Steel_vCn30sY.webp', 'Dual Daggers', 'Demonic Steel', 'gold', 995.00, 'NULL'),
(345, 'Dual_Daggers_Molten_FBwge46.webp', 'Dual Daggers', 'Molten', 'gold', 994.00, 'NULL'),
(346, 'Kunai_Prism_TPCLX5w.webp', 'Kunai', 'Prism', 'gold', 915.00, 'NULL'),
(347, 'Kukri_Ares_57HJVS3.webp', 'Kukri', 'Ares', 'gold', 890.00, 'NULL'),
(348, 'Scorpion_Cold_Flame_goZeXes.webp', 'Scorpion', 'Cold Flame', 'gold', 855.00, 'NULL'),
(349, 'Kukri_Divine_Power_Ns47MCh.webp', 'Kukri', 'Divine Power', 'gold', 840.00, 'NULL'),
(350, 'Scorpion_Holiday_Frost_CPhPsFV.webp', 'Scorpion', 'Holiday Frost', 'gold', 781.25, 'NULL'),
(351, 'Scorpion_Scratch_xtpMAUc.webp', 'Scorpion', 'Scratch', 'gold', 770.00, 'NULL'),
(352, 'Kukri_Prophet_x4IYMF2.webp', 'Kukri', 'Prophet', 'gold', 755.00, 'NULL'),
(353, 'Dual_Daggers_Retro_Arcade_MiwUP3B.webp', 'Dual Daggers', 'Retro Arcade', 'gold', 740.00, 'NULL'),
(354, 'Kukri_Gold_Trim_4lH4mCJ.webp', 'Kukri', 'Gold Trim', 'gold', 722.00, 'NULL'),
(355, 'Scorpion_Sea_Eye_mtRevfC.webp', 'Scorpion', 'Sea Eye', 'gold', 720.00, 'NULL'),
(356, 'Scorpion_Veil_K3TU9BL.webp', 'Scorpion', 'Veil', 'gold', 713.00, 'NULL'),
(357, 'Gift_Box_New_Year_2019_rd7alrG.webp', 'Gift Box', 'New Year 2019', 'gold', 45260.00, 'NULL'),
(359, 'Sticker_Gold_Skull_FhBv2cA.webp', 'Sticker', 'Gold Skull', 'arcane', 175320.00, 'NULL'),
(360, 'Desert_Eagle_Aureate_wwQtoR8.webp', 'Desert Eagle', 'Aureate', 'arcane', 125000.00, 'NULL'),
(361, 'Sticker_Metal_Rat_bPBfeWQ.webp', 'Sticker', 'Metal Rat', 'arcane', 125000.00, 'NULL'),
(362, 'AWM_Treasure_Hunter_es1R1ar.webp', 'AWM', 'Treasure Hunter', 'arcane', 106100.00, 'NULL'),
(363, 'Sticker_Punisher_46DXLOG.webp', 'Sticker', 'Punisher', 'arcane', 95510.00, 'NULL'),
(364, 'Sticker_Snow_Queen_TgoyvRs.webp', 'Sticker', 'Snow Queen', 'arcane', 93750.00, 'NULL'),
(365, 'Sticker_Z9_Mask_Color_bqwVrrD.webp', 'Sticker', 'Z9 Mask Color', 'arcane', 73250.00, 'NULL'),
(366, 'M40_Monster_fLZQHHr.webp', 'M40', 'Monster', 'arcane', 22534.00, 'NULL'),
(367, 'Sticker_Radiate_Heat_iMqNsWz.webp', 'Sticker', 'Radiate Heat', 'arcane', 46800.00, 'NULL'),
(368, 'G22_Frozen_pUe2nLH.webp', 'G22', 'Frozen', 'arcane', 18875.00, 'NULL'),
(369, 'Sticker_Neon_Color_R91itDJ.webp', 'Sticker', 'Neon Color', 'arcane', 26400.00, 'NULL'),
(370, 'Sticker_Frosty_Storm_eF2pn96.webp', 'Sticker', 'Frosty Storm', 'arcane', 19590.00, 'NULL'),
(371, 'Sticker_Phoenix_Blazon_Color_K67ZY0t.webp', 'Sticker', 'Phoenix Blazon Color', 'arcane', 15277.00, 'NULL'),
(372, 'Charm_Reaper_Scythe_rudJ3H4.webp', 'Charm', 'Reaper Scythe', 'arcane', 10825.00, 'NULL'),
(373, 'AWM_Genesis_XAlbRXR.webp', 'AWM', 'Genesis', 'arcane', 529.00, 'NULL'),
(374, 'Sticker_Lion_Lord.webp', 'Sticker', 'Lion Lord', 'arcane', 860.00, 'NULL'),
(375, 'Charm_Harp_1pfQvcs.webp', 'Charm', 'Harp', 'arcane', 520.00, 'NULL'),
(376, 'Charm_Byakko_J8OcQEb.webp', 'Charm', 'Byakko', 'arcane', 319.00, 'NULL'),
(377, 'AWM_Sport_V2_6W7CGiC.webp', 'AWM', 'Sport V2', 'legendary', 58750.00, 'NULL'),
(378, 'Sticker_Infernal_Skull_YNQggDU.webp', 'Sticker', 'Infernal Skull', 'legendary', 18750.00, 'NULL'),
(379, 'Sticker_Z9_Mask_CWqLBXw.webp', 'Sticker', 'Z9 Mask', 'legendary', 18088.00, 'NULL'),
(380, 'Sticker_Cookie_Killer_Os5BpRt.webp', 'Sticker', 'Cookie Killer', 'legendary', 16523.00, 'NULL'),
(381, 'Charm_V2_7PjCIxH.webp', 'Charm', 'V2', 'legendary', 12875.00, 'NULL'),
(382, 'MP7_2_Years_Red_7e249Bc.webp', 'MP7', '2 Years Red', 'legendary', 746.00, 'NULL'),
(383, 'Sticker_Zone9_us3Vz1O.webp', 'Sticker', 'Zone9', 'legendary', 459.00, 'NULL'),
(384, 'USP_Genesis_fWjAM4q.webp', 'USP', 'Genesis', 'epic', 36250.00, 'NULL'),
(385, 'Sticker_Feed_D2V03UI.webp', 'Sticker', 'Feed', 'epic', 7200.00, 'NULL'),
(386, 'G22_Relic_OHIOhVP.webp', 'G22', 'Relic', 'rare', 22500.00, 'NULL'),
(387, 'P350_Forest_Spirit_WGZaLik.webp', 'P350', 'Forest Spirit', 'arcane', 399.99, 'NULL'),
(388, 'Chibi_Psycho_rhfPTQD.webp', 'Chibi', 'Psycho', 'legendary', 145.00, 'NULL'),
(389, 'Desert_Eagle_Dust_Devil.webp', 'Desert Eagle', 'Dust Devil', 'epic', 107.00, 'NULL'),
(390, 'UMP45_Spirit_iaUDzvT.webp', 'UMP45', 'Spirit', 'epic', 10.00, 'NULL'),
(391, 'Charm_Ice-cream_Van_LcKhqan.webp', 'Charm', 'Ice-cream Van', 'epic', 30.00, 'NULL'),
(392, 'Desert_Eagle_Infection_M3DvhHy.webp', 'Desert Eagle', 'Infection', 'rare', 2.46, 'NULL'),
(393, 'USP_Purple_Camo_g8fjBAb.webp', 'USP', 'Purple Camo', 'rare', 0.41, 'NULL'),
(394, 'MP7_Banana_IH57WNJ.webp', 'MP7', 'Banana', 'rare', 1.09, 'NULL'),
(395, 'SM1014_Facet_kFIie27.webp', 'SM1014', 'Facet', 'uncommon', 2.00, 'NULL'),
(396, 'G22_Inferno_fzRHZuw.webp', 'G22', 'Inferno', 'uncommon', 0.52, 'NULL'),
(397, 'Stiletto_Flux.webp', 'Stiletto', 'Flux', 'gold', 1300.00, 'NULL'),
(398, 'Sticker_Legends_Gold_QISbBQZ.webp', 'Sticker', 'Legends Gold', 'arcane', 680.00, 'NULL'),
(399, 'AWM_Dragon_nAFznyu.webp', 'AWM', 'Dragon', 'legendary', 41.00, 'NULL'),
(400, 'MP7_Lich_yCOJTEt.webp', 'MP7', 'Lich', 'legendary', 15.90, 'NULL'),
(401, 'P90_Z-50_F.U.J.I.N._YnrSACh.webp', 'P90', 'Z-50 F.U.J.I.N.', 'epic', 18.50, 'NULL'),
(402, 'Graffiti_Thumbs-down_hQWyTwi.webp', 'Graffiti', 'Thumbs-down!', 'epic', 60.00, 'NULL'),
(403, 'G22_White_Carbon_Yb1reqS.webp', 'G22', 'White Carbon', 'rare', 63.00, 'NULL'),
(404, 'FS_Zone_N10zj2n.webp', 'F/S', 'Zone', 'rare', 12.00, 'NULL'),
(405, 'P350_Rally_2gnx8Xf.webp', 'P350', 'Rally', 'rare', 5.00, 'NULL'),
(406, 'Sticker_PRO_xwExp3O.webp', 'Sticker', 'PRO', 'rare', 25.93, 'NULL'),
(407, 'FabM_Death_Herald_o9PqxxM.webp', 'FabM', 'Death Herald', 'rare', 3.55, 'NULL'),
(408, 'USP_Ignite_k8hCpi2.webp', 'USP', 'Ignite', 'rare', 0.43, 'NULL'),
(409, 'G22_Starfall_eHybU3v.webp', 'G22', 'Starfall', 'rare', 0.40, 'NULL'),
(410, 'Graffiti_Golden_Roger_NyvfrGh.webp', 'Graffiti', 'Golden Roger', 'legendary', 88.00, 'NULL'),
(411, 'SPAS_Taint_PSKblj2.webp', 'SPAS', 'Taint', 'legendary', 18.65, 'NULL'),
(412, 'Berettas_Damascus_ZWg4ZVw.webp', 'Berettas', 'Damascus', 'legendary', 16.00, 'NULL'),
(413, 'UMP45_Gas_hxl7Pr7.webp', 'UMP45', 'Gas', 'epic', 48.70, 'NULL'),
(414, 'SPAS_Raider_Ytt9DMC.webp', 'SPAS', 'Raider', 'epic', 43.00, 'NULL'),
(415, 'M4_Demon_vWMHPgR.webp', 'M4', 'Demon', 'rare', 0.40, 'NULL'),
(416, 'Desert_Eagle_Winner_VpOnJYv.webp', 'Desert Eagle', 'Winner', 'uncommon', 0.64, 'NULL'),
(417, 'M110_Year_Of_The_Tiger_4LMJnm3.webp', 'M110', 'Year Of The Tiger', 'legendary', 52.89, 'NULL'),
(418, 'P90_R.O.N.I.N._mk9_vvkRelH.webp', 'P90', 'R.O.N.I.N. mk9', 'legendary', 52.00, 'NULL'),
(419, 'UMP45_White_Carbon_52THzd4.webp', 'UMP45', 'White Carbon', 'epic', 61.28, 'NULL'),
(420, 'M40_Arctic_O9tV1vX.webp', 'M40', 'Arctic', 'rare', 39.00, 'NULL'),
(421, 'M110_Cyber_5a89cPB.webp', 'M110', 'Cyber', 'rare', 0.39, 'NULL'),
(422, 'Charm_Long_Run_Gold_itfC8es.webp', 'Charm', 'Long Run Gold', 'arcane', 115.00, 'NULL'),
(423, 'Sticker_Iron_Ox_VSCLuen.webp', 'Sticker', 'Iron Ox', 'legendary', 2585.00, 'NULL'),
(424, 'SM1014_Necromancer_yKljCAw.webp', 'SM1014', 'Necromancer', 'legendary', 120.00, 'NULL'),
(425, 'Sticker_Province_JHs22lI.webp', 'Sticker', 'Province', 'legendary', 365.99, 'NULL'),
(426, 'Sticker_The_King_yFDI8Uj.webp', 'Sticker', 'The King', 'legendary', 199.90, 'NULL'),
(427, 'TEC-9_Fable_KHQlWT3.webp', 'TEC-9', 'Fable', 'legendary', 15.00, 'NULL'),
(428, 'P350_Raider_hnBUZdl.webp', 'P350', 'Raider', 'epic', 97.00, 'NULL'),
(429, 'Desert_Eagle_Piranha_gmYyIqf.webp', 'Desert Eagle', 'Piranha', 'epic', 2.30, 'NULL'),
(430, 'M60_Steam_Beast_Mc1ucd9.webp', 'M60', 'Steam Beast', 'epic', 2.45, 'NULL'),
(431, 'UMP45_Shark_HvE4RjH.webp', 'UMP45', 'Shark', 'rare', 5.40, 'NULL'),
(432, 'P90_Radiation_2nbxpVz.webp', 'P90', 'Radiation', 'uncommon', 2.00, 'NULL'),
(433, 'Desert_Eagle_Venator_euDzKFe.webp', 'Desert Eagle', 'Venator', 'arcane', 103.00, 'NULL'),
(434, 'MP7_2_Years_xokzfNn.webp', 'MP7', '2 Years', 'epic', 311.11, 'NULL'),
(435, 'FN_FAL_Christmas_Symbol_QOIIgYd.webp', 'FN FAL', 'Christmas Symbol', 'epic', 68.00, 'NULL'),
(436, 'P90_Clash_9k29s4U.webp', 'P90', 'Clash', 'epic', 2.00, 'NULL'),
(437, 'FabM_Parrot_xqxUupe.webp', 'FabM', 'Parrot', 'epic', 6.00, 'NULL'),
(438, 'AWM_Phoenix_yeYdmC8.webp', 'AWM', 'Phoenix', 'rare', 21.00, 'NULL'),
(439, 'Berettas_Soul_Devourer_PHjNONp.webp', 'Berettas', 'Soul Devourer', 'rare', 0.40, 'NULL'),
(440, 'Sticker_Gorgon_yBlBKYH.webp', 'Sticker', 'Gorgon', 'arcane', 648.00, 'NULL'),
(441, 'Graffiti_Gold_Skull_DXd7GKz.webp', 'Graffiti', 'Gold Skull', 'arcane', 40.00, 'NULL'),
(442, 'UMP45_Winged_A251a10.webp', 'UMP45', 'Winged', 'legendary', 50.99, 'NULL'),
(443, 'Charm_Soul_pdvrMzv.webp', 'Charm', 'Soul', 'legendary', 109.97, 'NULL'),
(444, 'MAC10_Constellations_yO7oEcI.webp', 'MAC10', 'Constellations', 'legendary', 19.85, 'NULL'),
(445, 'SM1014_Pathfinder_wR44M5d.webp', 'SM1014', 'Pathfinder', 'rare', 25.63, 'NULL'),
(446, 'M16_Needle_a2RJLSw.webp', 'M16', 'Needle', 'rare', 0.40, 'NULL'),
(447, 'M40_Grip_hXt8N87.webp', 'M40', 'Grip', 'rare', 0.39, 'NULL'),
(448, 'P90_Oops_ZQ3rdqa.webp', 'P90', 'Oops', 'legendary', 23.25, 'NULL'),
(449, 'TEC-9_Stickerbomb_TwUZNt2.webp', 'TEC-9', 'Stickerbomb', 'epic', 40.00, 'NULL'),
(450, 'FN_FAL_Tactical_v15PiB9.webp', 'FN FAL', 'Tactical', 'epic', 2.20, 'NULL'),
(451, 'M40_Beagle_hewJwXZ.webp', 'M40', 'Beagle', 'rare', 4.88, 'NULL'),
(452, 'P350_Oni_ZyeHnHa.webp', 'P350', 'Oni', 'rare', 0.39, 'NULL'),
(453, 'Graffiti_Exactly_YprglbT.webp', 'Graffiti', 'Exactly!', 'rare', 3.75, 'NULL'),
(455, 'Karambit_Nebula.webp', 'Karambit', 'Nebula', 'gold', 2550.00, 'NULL'),
(456, 'Butterfly_Glitch.webp', 'Butterfly', 'Glitch', 'gold', 1820.00, 'NULL'),
(457, 'Charm_Oni_4QnDi6m.webp', 'Charm', 'Oni', 'arcane', 328.00, 'NULL'),
(458, 'Charm_Kitsune_Mask_nMLDAvb.webp', 'Charm', 'Kitsune Mask', 'arcane', 255.00, 'NULL'),
(459, 'Graffiti_Ochpochmak_hBFaE1F.webp', 'Graffiti', 'Ochpochmak', 'arcane', 11.00, 'NULL'),
(460, 'Sticker_Flake_Holo_hY9OK5V.webp', 'Sticker', 'Flake Holo', 'legendary', 835.00, 'NULL'),
(461, 'Chibi_Chill.webp', 'Chibi', 'Chill', 'legendary', 170.00, 'NULL'),
(462, 'Charm_Secret_Data_8qylYZO.webp', 'Charm', 'Secret Data', 'legendary', 90.00, 'NULL'),
(463, 'Sticker_Fireborn_Dragon_Gold.webp', 'Sticker', 'Fireborn Dragon Gold', 'legendary', 75.00, 'NULL'),
(464, 'Graffiti_Trophy.webp', 'Graffiti', 'Trophy', 'legendary', 4.80, 'NULL'),
(465, 'Charm_Karambit_Gold_CE6izi4.webp', 'Charm', 'Karambit Gold', 'epic', 201.00, 'NULL'),
(466, 'Chibi_Crunch_EQqHPMt.webp', 'Chibi', 'Crunch', 'epic', 83.00, 'NULL'),
(467, 'Sticker_Z9_Project_GrmTWZz.webp', 'Sticker', 'Z9 Project', 'rare', 260.00, 'NULL'),
(468, 'Graffiti_RIP.webp', 'Graffiti', 'RIP', 'rare', 7.00, 'NULL'),
(470, 'AWM_BOOM_EXREwSz.webp', 'AWM', 'BOOM', 'arcane', 180.00, 'NULL'),
(471, 'Sticker_Phoenix_Blazon_Gold_uF9vMSG.webp', 'Sticker', 'Phoenix Blazon Gold', 'legendary', 2148.00, 'NULL'),
(472, 'Desert_Eagle_Orochi_t4Zr126.webp', 'Desert Eagle', 'Orochi', 'legendary', 25.95, 'NULL'),
(473, 'Charm_Spray_5_Gold_ZHhOxPD.webp', 'Charm', 'Spray 5 Gold', 'legendary', 33.98, 'NULL'),
(474, 'Sticker_Smoke_Grenade_Y1SNBuQ.webp', 'Sticker', 'Smoke Grenade', 'epic', 1096.00, 'NULL'),
(475, 'M60_Y-20_R.A.I.J.I.N._P2R5F5H.webp', 'M60', 'Y-20 R.A.I.J.I.N.', 'epic', 8.31, 'NULL'),
(476, 'Graffiti_High_5_fpJ4PpL.webp', 'Graffiti', 'High 5', 'epic', 1.97, 'NULL'),
(477, 'Chibi_Dummy_7Rm6BGA.webp', 'Chibi', 'Dummy', 'rare', 32.40, 'NULL'),
(479, 'MAC10_Argo_dxOWYOW.webp', 'MAC10', 'Argo', 'arcane', 410.00, 'NULL'),
(480, 'FAMAS_Christmas_Symbol_nGADo5s.webp', 'FAMAS', 'Christmas Symbol', 'legendary', 244.99, 'NULL'),
(481, 'Sticker_Striped_Zodiac_0MalMP4.webp', 'Sticker', 'Striped Zodiac', 'epic', 115.15, 'NULL'),
(482, 'SM1014_Arctic_2bVW6ll.webp', 'SM1014', 'Arctic', 'rare', 47.30, 'NULL'),
(483, 'Desert_Eagle_Red_Dragon_XxpAWFI.webp', 'Desert Eagle', 'Red Dragon', 'rare', 9.00, 'NULL'),
(484, 'FS_Enforcer_WEejxyb.webp', 'F/S', 'Enforcer', 'rare', 7.05, 'NULL'),
(486, 'FN_FAL_Phoenix_Risen_Kd19NTg.webp', 'FN FAL', 'Phoenix Risen', 'arcane', 2680.00, 'NULL'),
(487, 'M16_Shogun_Stripes_1ZSpqnH.webp', 'M16', 'Shogun Stripes', 'arcane', 209.00, 'NULL'),
(488, 'Charm_Hannya_jLGGj06.webp', 'Charm', 'Hannya', 'arcane', 508.98, 'NULL'),
(489, 'Charm_Vampire_Bat_442DMun.webp', 'Charm', 'Vampire Bat', 'legendary', 1215.00, 'NULL'),
(491, 'AWM_2_Years_Red_JV4dkzM.webp', 'AWM', '2 Years Red', 'arcane', 7500.00, 'NULL'),
(492, 'Sticker_Infected_k9d5tut.webp', 'Sticker', 'Infected', 'arcane', 1887.00, 'NULL'),
(493, 'FabM_BOOM_q0qOGtk.webp', 'FabM', 'BOOM', 'arcane', 99.68, 'NULL'),
(494, 'Sticker_Ambush_vGKXkK3.webp', 'Sticker', 'Ambush', 'rare', 59.70, 'NULL'),
(495, 'Sticker_Jubilee_5_rtJDt4M.webp', 'Sticker', 'Jubilee 5', 'rare', 22.81, 'NULL'),
(497, 'Graffiti_Toxic_6vGtCp6.webp', 'Graffiti', 'Toxic', 'legendary', 6.29, 'NULL'),
(498, 'Graffiti_Tough_Guy_GyFXDWs.webp', 'Graffiti', 'Tough Guy', 'legendary', 4.50, 'NULL'),
(499, 'M110_Flow_PSmJSGh.webp', 'M110', 'Flow', 'epic', 15.00, 'NULL'),
(500, 'MP5_Northern_Fury_rIx1JEj.webp', 'MP5', 'Northern Fury', 'rare', 20.40, 'NULL'),
(501, 'UMP45_4_Years_IzZHHlz.webp', 'UMP45', '4 Years', 'rare', 6.20, 'NULL'),
(503, 'Desert_Eagle_Yakuza_8HoaVFS.webp', 'Desert Eagle', 'Yakuza', 'arcane', 3774.00, 'NULL'),
(504, 'Sticker_Zone9_Color_2DNhxK7.webp', 'Sticker', 'Zone9 Color', 'arcane', 4000.00, 'NULL'),
(505, 'Sticker_Breeze_Color_wCSt0Hr.webp', 'Sticker', 'Breeze Color', 'arcane', 2390.00, 'NULL'),
(506, 'MAC10_Shogun_Stripes_N8qZHzh.webp', 'MAC10', 'Shogun Stripes', 'legendary', 19.19, 'NULL'),
(507, 'Graffiti_Beware_of_Zombies_IQFWBUF.webp', 'Graffiti', 'Beware of Zombies', 'epic', 7.70, 'NULL'),
(508, 'SPAS_Octopus_M7oV2dT.webp', 'SPAS', 'Octopus', 'legendary', 217.00, 'NULL'),
(509, 'Sticker_Sandstone_es9ZBwr.webp', 'Sticker', 'Sandstone', 'legendary', 410.00, 'NULL'),
(510, 'Charm_Biohazard_dMKPBOw.webp', 'Charm', 'Biohazard', 'epic', 94.00, 'NULL'),
(511, 'M40_Quake_ad6jV0Z.webp', 'M40', 'Quake', 'epic', 19.14, 'NULL'),
(512, 'Sticker_Minotaur_zmaPurW.webp', 'Sticker', 'Minotaur', 'epic', 26.00, 'NULL'),
(513, 'Graffiti_Cooldown_09OpWg9.webp', 'Graffiti', 'Cooldown', 'epic', 2.05, 'NULL'),
(514, 'Sticker_Headshot_Zone_kt0gaPw.webp', 'Sticker', 'Headshot Zone', 'rare', 30.00, 'NULL'),
(515, 'FS_Camo_Storm_vXJGDyC.webp', 'F/S', 'Camo Storm', 'rare', 28.57, 'NULL'),
(516, 'Desert_Eagle_Blood_0JrphMw.webp', 'Desert Eagle', 'Blood', 'uncommon', 1.99, 'NULL'),
(517, 'Fang_Relic.webp', 'Fang', 'Relic', 'arcane', 4200.00, 'NULL'),
(518, 'FN_FAL_Basilisk_brCb5q0.webp', 'FN FAL', 'Basilisk', 'epic', 80.00, 'NULL'),
(519, 'Sticker_Jellyfish_Color_hH0q75u.webp', 'Sticker', 'Jellyfish Color', 'epic', 153.00, 'NULL'),
(520, 'Sticker_Dracula_xJoYLA2.webp', 'Sticker', 'Dracula', 'rare', 1700.00, 'NULL'),
(521, 'MP5_Gorgon_qs2AjV7.webp', 'MP5', 'Gorgon', 'arcane', 509.00, 'NULL'),
(522, 'SM1014_Fatal_Combo_rrPqDHY.webp', 'SM1014', 'Fatal Combo', 'legendary', 435.00, 'NULL'),
(523, 'M16_Iron_Will_Dovykbw.webp', 'M16', 'Iron Will', 'legendary', 350.00, 'NULL'),
(524, 'M60_Grunge_rD6jwmv.webp', 'M60', 'Grunge', 'legendary', 25.00, 'NULL'),
(525, 'FAMAS_Autumn_8hkCQh3.webp', 'FAMAS', 'Autumn', 'epic', 17.00, 'NULL'),
(526, 'TEC-9_Splash_Ht05g4O.webp', 'TEC-9', 'Splash', 'rare', 9.00, 'NULL'),
(527, 'Sticker_Pack_Halloween_2019_YI7HDxD.webp', 'Sticker Pack', 'Halloween 2019', 'gold', 9400.00, 'NULL'),
(528, 'FS_Poison_kjL9oXo.webp', 'F/S', 'Poison', 'arcane', 14950.00, 'NULL'),
(529, 'MP5_Zone_FsLSQkj.webp', 'MP5', 'Zone', 'legendary', 800.00, 'NULL'),
(530, 'Sticker_Ghoul_1l1z4Zg.webp', 'Sticker', 'Ghoul', 'legendary', 8750.00, 'NULL'),
(531, 'USP_Stickerbomb_VELb4iG.webp', 'USP', 'Stickerbomb', 'legendary', 160.00, 'NULL'),
(532, 'Charm_Black_Spot_t1vY30H.webp', 'Charm', 'Black Spot', 'epic', 24800.00, 'NULL'),
(533, 'Sticker_Demon_Flame_Drcx7ul.webp', 'Sticker', 'Demon Flame', 'rare', 115.00, 'NULL'),
(534, 'MP7_Graffity_YSNjfdD.webp', 'MP7', 'Graffity', 'legendary', 32.50, 'NULL'),
(535, 'Sticker_Sector_B_WTFclQj.webp', 'Sticker', 'Sector B', 'epic', 745.00, 'NULL'),
(536, 'FS_Demonic_Fog_cQXPYi0.webp', 'F/S', 'Demonic Fog', 'epic', 22.00, 'NULL'),
(537, 'FS_Tactical_IsDztIF.webp', 'F/S', 'Tactical', 'rare', 0.40, 'NULL'),
(538, 'MP7_Stickerbomb_X6gUm4d.webp', 'MP7', 'Stickerbomb', 'legendary', 46.80, 'NULL'),
(539, 'Sticker_Disco_Party_I20q7CI.webp', 'Sticker', 'Disco Party', 'epic', 110.00, 'NULL'),
(540, 'Charm_Ballistic_Mask_jOYjXHp.webp', 'Charm', 'Ballistic Mask', 'epic', 87.00, 'NULL'),
(541, 'Charm_Trident_VkOQhCm.webp', 'Charm', 'Trident', 'rare', 15.00, 'NULL'),
(542, 'AKR12_Aurora_kv2Pg7g.webp', 'AKR12', 'Aurora', 'uncommon', 0.80, 'NULL'),
(543, 'P90_Fissure_YbeE5Rm.webp', 'P90', 'Fissure', 'common', 0.41, 'NULL'),
(544, 'Sticker_Brick_yDiP4uO.webp', 'Sticker', 'Brick', 'epic', 156.00, 'NULL'),
(545, 'MP7_Palace_Vxg02QE.webp', 'MP7', 'Palace', 'epic', 2.30, 'NULL'),
(546, 'Desert_Eagle_Predator_HsSIE6e.webp', 'Desert Eagle', 'Predator', 'rare', 23.00, 'NULL'),
(547, 'Sticker_DEagle_Master_xMzVbVG.webp', 'Sticker', 'DEagle Master', 'rare', 16.50, 'NULL'),
(548, 'Charm_Sea_of_Death_0pCNBI1.webp', 'Charm', 'Sea of Death', 'arcane', 1028.00, 'NULL'),
(549, 'Sticker_Sakura_Color_DzGRT44.webp', 'Sticker', 'Sakura Color', 'arcane', 4986.00, 'NULL'),
(550, 'Sticker_Sunset_Gold_AIGrFsQ.webp', 'Sticker', 'Sunset Gold', 'legendary', 394.00, 'NULL'),
(551, 'M40_Constellations_aLo4Tau.webp', 'M40', 'Constellations', 'legendary', 51.00, 'NULL'),
(552, 'Charm_Scarecrow_eon07f7.webp', 'Charm', 'Scarecrow', 'epic', 250.55, 'NULL'),
(553, 'Chibi_Peace_QYrKkez.webp', 'Chibi', 'Peace', 'epic', 26.00, 'NULL'),
(554, 'Sticker_Not_Today_AAeca3m.webp', 'Sticker', 'Not Today', 'rare', 125.00, 'NULL'),
(555, 'AWM_Scratch_GQnzWwb.webp', 'AWM', 'Scratch', 'rare', 11.24, 'NULL'),
(556, 'Charm_Imperial_Coin_xKlZGQd.webp', 'Charm', 'Imperial Coin', 'rare', 38.70, 'NULL'),
(557, 'FabM_Flight_BV6TZhN.webp', 'FabM', 'Flight', 'rare', 4.77, 'NULL'),
(559, 'Charm_Year_of_Ox_0YjTB5h.webp', 'Charm', 'Year of Ox', 'arcane', 4399.00, 'NULL'),
(560, 'Charm_Golden_Dragon_oYQjm5E.webp', 'Charm', 'Golden Dragon', 'arcane', 3349.00, 'NULL'),
(561, 'Sticker_Dragon_GD1Sdoq.webp', 'Sticker', 'Dragon', 'arcane', 2199.00, 'NULL'),
(562, 'Graffiti_Zombie_Attack_967ThfD.webp', 'Graffiti', 'Zombie Attack', 'arcane', 358.70, 'NULL'),
(563, 'Graffiti_Victory_Bubble_pje1K3h.webp', 'Graffiti', 'Victory Bubble', 'arcane', 325.00, 'NULL'),
(564, 'P350_Blizzard_5tCwlk9.webp', 'P350', 'Blizzard', 'legendary', 750.00, 'NULL'),
(565, 'Charm_Long_Run_RRDcdeG.webp', 'Charm', 'Long Run', 'legendary', 32.00, 'NULL'),
(566, 'Graffiti_Spy_Bxf9Ba2.webp', 'Graffiti', 'Spy', 'legendary', 20.00, 'NULL'),
(567, 'USP_Stone_Cold_jbLv8JA.webp', 'USP', 'Stone Cold', 'epic', 1140.00, 'NULL'),
(568, 'Sticker_Winter_Duelist_4YACM7Y.webp', 'Sticker', 'Winter Duelist', 'epic', 1059.00, 'NULL'),
(569, 'Charm_Katana_XgFbN4U.webp', 'Charm', 'Katana', 'epic', 86.49, 'NULL'),
(570, 'Charm_Zombiemaki_F4ura0b.webp', 'Charm', 'Zombiemaki', 'epic', 26.00, 'NULL'),
(571, 'Charm_Grenade_niwx7ex.webp', 'Charm', 'Grenade', 'rare', 42.79, 'NULL'),
(572, 'Charm_Gingerbread_jvSGnm1.webp', 'Charm', 'Gingerbread', 'rare', 31.49, 'NULL'),
(573, 'Sticker_Thunderbolt_LNpQYAP.webp', 'Sticker', 'Thunderbolt', 'rare', 20.50, 'NULL'),
(574, 'Sticker_Cyclops_u65pLfm.webp', 'Sticker', 'Cyclops', 'rare', 19.00, 'NULL'),
(575, 'USP_Geometric_nstQ9LP.webp', 'USP', 'Geometric', 'arcane', 3200.00, 'NULL'),
(576, 'Sticker_Province_Gold_ryrW8B0.webp', 'Sticker', 'Province Gold', 'arcane', 3950.00, 'NULL'),
(577, 'Graffiti_Hoplite_Strength_8pqsA0r.webp', 'Graffiti', 'Hoplite Strength', 'arcane', 345.00, 'NULL'),
(578, 'Charm_Halloween_Spirit_eDRmxzT.webp', 'Charm', 'Halloween Spirit', 'legendary', 1340.00, 'NULL'),
(579, 'MAC10_Melt_Away_FcfxWbO.webp', 'MAC10', 'Melt Away', 'legendary', 40.00, 'NULL'),
(580, 'Sticker_Anticamper_znDAaMI.webp', 'Sticker', 'Anticamper', 'epic', 5399.00, 'NULL'),
(581, 'Sticker_Kitsune_6P1aTnY.webp', 'Sticker', 'Kitsune', 'rare', 67.64, 'NULL'),
(582, 'Sticker_Drop_The_Bomb_pjGdNBV.webp', 'Sticker', 'Drop The Bomb', 'legendary', 5858.58, 'NULL'),
(583, 'Sticker_Spirit_House_Color_LR1LEGA.webp', 'Sticker', 'Spirit House Color', 'legendary', 186.00, 'NULL'),
(584, 'Sticker_Hound_of_Hades_Color_q9W5q6y.webp', 'Sticker', 'Hound of Hades Color', 'legendary', 85.00, 'NULL'),
(585, 'Sticker_Devilish_I8y49Fh.webp', 'Sticker', 'Devilish', 'epic', 14500.00, 'NULL'),
(586, 'Sticker_Gangsta_Pumpkin_9fc7I9M.webp', 'Sticker', 'Gangsta Pumpkin', 'epic', 3495.00, 'NULL'),
(587, 'Charm_Gift_Catcher_HVCP28x.webp', 'Charm', 'Gift Catcher', 'rare', 33.00, 'NULL'),
(588, 'Charm_Ochpochmak_oYlaH46.webp', 'Charm', 'Ochpochmak', 'arcane', 15000.00, 'NULL'),
(589, 'Sticker_Sandstone_Gold_5X6Uv0d.webp', 'Sticker', 'Sandstone Gold', 'arcane', 8900.00, 'NULL'),
(590, 'Sticker_Mad_Bat_BpzwXMp.webp', 'Sticker', 'Mad Bat', 'legendary', 9500.00, 'NULL'),
(591, 'Sticker_With_Love_swR8e13.webp', 'Sticker', 'With Love', 'legendary', 74.98, 'NULL'),
(592, 'Sticker_Zeus_YHLLI9R.webp', 'Sticker', 'Zeus', 'legendary', 57.00, 'NULL'),
(593, 'Sticker_Snot_my3Q7fI.webp', 'Sticker', 'Snot', 'epic', 6999.00, 'NULL'),
(594, 'Charm_Suspicious_Spider_CpUmgKe.webp', 'Charm', 'Suspicious Spider', 'arcane', 21248.00, 'NULL'),
(595, 'Sticker_Rust_Metallic_szueH0I.webp', 'Sticker', 'Rust Metallic', 'arcane', 4196.00, 'NULL'),
(596, 'Charm_Legends_Gold_ZE9hHwV.webp', 'Charm', 'Legends Gold', 'arcane', 830.00, 'NULL'),
(597, 'Sticker_Batrider_6AidPnz.webp', 'Sticker', 'Batrider', 'legendary', 15000.00, 'NULL'),
(598, 'M16_Winged_GQ53pFx.webp', 'M16', 'Winged', 'legendary', 510.00, 'NULL'),
(599, 'Sticker_Hurry_Ghost_HRkLXtq.webp', 'Sticker', 'Hurry Ghost', 'epic', 8875.00, 'NULL'),
(600, 'Sticker_Biohazard_ITlrd1o.webp', 'Sticker', 'Biohazard', 'epic', 1798.00, 'NULL'),
(601, 'Sticker_-28_FcKaGA6.webp', 'Sticker', '-28', 'epic', 55.00, 'NULL'),
(602, 'Sticker_Golden_Ox_ZbU0rJa.webp', 'Sticker', 'Golden Ox', 'arcane', 20820.00, 'NULL'),
(603, 'Fang_Serpent.webp', 'Fang', 'Serpent', 'arcane', 4050.00, 'NULL');
INSERT INTO `skins` (`id`, `img`, `title`, `name`, `rarity`, `cost`, `collection`) VALUES
(604, 'Fang_Flare.webp', 'Fang', 'Flare', 'arcane', 3800.00, 'NULL'),
(605, 'Sticker_Neon_Dragon_Color_UCz3qa5.webp', 'Sticker', 'Neon Dragon Color', 'arcane', 3498.00, 'NULL'),
(606, 'Sticker_Shadow_Kitsune_Color_HxCmXIo.webp', 'Sticker', 'Shadow Kitsune Color', 'arcane', 2796.00, 'NULL'),
(607, 'Charm_Sunstrike_Gold.webp', 'Charm', 'Sunstrike Gold', 'arcane', 350.00, 'NULL'),
(608, 'M16_Dust_Devil.webp', 'M16', 'Dust Devil', 'legendary', 615.00, 'NULL'),
(609, 'Sticker_Explorpion_Color.webp', 'Sticker', 'Explorpion Color', 'legendary', 207.00, 'NULL'),
(610, 'Charm_Thunderbolt_GnneY5F.webp', 'Charm', 'Thunderbolt', 'legendary', 193.00, 'NULL'),
(611, 'Sticker_Accordeon_eA8FLM5.webp', 'Sticker', 'Accordeon', 'epic', 2100.00, 'NULL'),
(612, 'Sticker_Target_FVcWvr1.webp', 'Sticker', 'Target', 'epic', 195.00, 'NULL'),
(613, 'Sticker_Entry_Kill_xv5qicm.webp', 'Sticker', 'Entry Kill', 'epic', 59.91, 'NULL'),
(614, 'Sticker_Searing_Assassin.webp', 'Sticker', 'Searing Assassin', 'epic', 44.00, 'NULL'),
(615, 'Sticker_Rush_Q9EM1k8.webp', 'Sticker', 'Rush', 'rare', 1998.00, 'NULL'),
(616, 'Charm_SHURIKEN_olmceTd.webp', 'Charm', 'SHURIKEN', 'rare', 85.00, 'NULL'),
(617, 'Charm_Snow_Bear_vZamtpd.webp', 'Charm', 'Snow Bear', 'arcane', 3089.00, 'NULL'),
(618, 'Sticker_Samurai_Gl3x7Ix.webp', 'Sticker', 'Samurai', 'arcane', 1529.00, 'NULL'),
(619, 'Charm_Inugami_CksyNDp.webp', 'Charm', 'Inugami', 'arcane', 443.99, 'NULL'),
(620, 'AWM_Winter_Sport_9z6QkPh.webp', 'AWM', 'Winter Sport', 'legendary', 7860.00, 'NULL'),
(621, 'Sticker_Mad_Santa_ZutmQTp.webp', 'Sticker', 'Mad Santa', 'legendary', 18285.00, 'NULL'),
(622, 'USP_2_Years_Red_RK5dHCq.webp', 'USP', '2 Years Red', 'epic', 1900.00, 'NULL'),
(623, 'Sticker_Rebirth_Color_CSY3wvH.webp', 'Sticker', 'Rebirth Color', 'epic', 470.00, 'NULL'),
(624, 'Sticker_Mummy_ZwNCO1X.webp', 'Sticker', 'Mummy', 'rare', 1380.00, 'NULL'),
(625, 'Sticker_Endurance_Color_y5hy07m.webp', 'Sticker', 'Endurance Color', 'legendary', 629.00, 'NULL'),
(626, 'Graffiti_You_Infected_6tQnMHq.webp', 'Graffiti', 'You Infected', 'legendary', 14.00, 'NULL'),
(627, 'MP7_Revival_t5wWHwY.webp', 'MP7', 'Revival', 'epic', 12.00, 'NULL'),
(628, 'FS_Wraith_Zdx7RFl.webp', 'F/S', 'Wraith', 'epic', 4.00, 'NULL'),
(629, 'Charm_Count_Paperakula_VHGxgsi.webp', 'Charm', 'Count Paperakula', 'rare', 22.37, 'NULL'),
(630, 'AWM_Gear_ykunVEU.webp', 'AWM', 'Gear', 'legendary', 50.80, 'NULL'),
(631, 'MP7_Space_Blaster_8EgiCic.webp', 'MP7', 'Space Blaster', 'epic', 7.00, 'NULL'),
(632, 'FabM_Reactor_cyMw2dN.webp', 'FabM', 'Reactor', 'rare', 21.00, 'NULL'),
(633, 'FAMAS_Hull_wP2x4ww.webp', 'FAMAS', 'Hull', 'rare', 2.60, 'NULL'),
(634, 'Graffiti_Party_Rabbit_k2Q7Evn.webp', 'Graffiti', 'Party Rabbit', 'rare', 11.20, 'NULL'),
(635, 'Graffiti_Chill_Out_ODAzYoK.webp', 'Graffiti', 'Chill Out!', 'legendary', 2.49, 'NULL'),
(636, 'Graffiti_Thumbs-up_2SF6kQd.webp', 'Graffiti', 'Thumbs-up!', 'epic', 10.00, 'NULL'),
(637, 'Graffiti_Lucky_Number_XcWFT87.webp', 'Graffiti', 'Lucky Number', 'legendary', 2.70, 'NULL'),
(638, 'M110_Stickerbomb_dpNTFmC.webp', 'M110', 'Stickerbomb', 'epic', 16.14, 'NULL'),
(639, 'Graffiti_GG_YlNpgS8.webp', 'Graffiti', 'GG', 'epic', 2.99, 'NULL'),
(640, 'AWM_Sport_LvQQgVq.webp', 'AWM', 'Sport', 'legendary', 2069.00, 'NULL'),
(641, 'M110_Transition_CmRdAN9.webp', 'M110', 'Transition', 'rare', 15.88, 'NULL'),
(642, 'Charm_Spooky_Lantern_A4kwY58.webp', 'Charm', 'Spooky Lantern', 'legendary', 875.00, 'NULL'),
(643, 'Charm_Gingerbread_House_zPbkIjq.webp', 'Charm', 'Gingerbread House', 'epic', 23.96, 'NULL'),
(644, 'Charm_Cold_Bath_Duck_8UTlBrm.webp', 'Charm', 'Cold Bath Duck', 'rare', 10.00, 'NULL'),
(645, 'M110_Celestial_Beast_PhyO4Ib.webp', 'M110', 'Celestial Beast', 'arcane', 1098.00, 'NULL'),
(646, 'M60_Mecha_fNfPbqS.webp', 'M60', 'Mecha', 'arcane', 1484.00, 'NULL'),
(647, 'Sticker_Dune_Color.webp', 'Sticker', 'Dune Color', 'arcane', 820.00, 'NULL'),
(648, 'Sticker_Crown.webp', 'Sticker', 'Crown', 'arcane', 730.00, 'NULL'),
(649, 'Scorpion_Magnalium.webp', 'Scorpion', 'Magnalium', 'gold', 730.00, 'NULL'),
(650, 'Sticker_Oops_Color_8c1hs9z.webp', 'Sticker', 'Oops Color', 'legendary', 149.00, 'NULL'),
(651, 'Graffiti_High_5_Splash_WjarIq0.webp', 'Graffiti', 'High 5 Splash', 'legendary', 5.43, 'NULL'),
(652, 'Charm_Christmas_Fireplace_cevRUq5.webp', 'Charm', 'Christmas Fireplace', 'epic', 23.82, 'NULL'),
(653, 'Sticker_Hazard_MMXGxFg.webp', 'Sticker', 'Hazard', 'rare', 28.00, 'NULL'),
(654, 'Sticker_Wyrm.webp', 'Sticker', 'Wyrm', 'rare', 15.17, 'NULL'),
(655, 'Charm_Charger.webp', 'Charm', 'Charger', 'rare', 11.00, 'NULL'),
(656, 'Charm_Commander_Claus_7AAAl2o.webp', 'Charm', 'Commander Claus', 'arcane', 800.00, 'NULL'),
(657, 'Sticker_Rust_dqRQP0x.webp', 'Sticker', 'Rust', 'legendary', 327.89, 'NULL'),
(658, 'Sticker_Bolide_Color.webp', 'Sticker', 'Bolide Color', 'epic', 36.00, 'NULL'),
(659, 'Sticker_Mirage_Color.webp', 'Sticker', 'Mirage Color', 'epic', 29.00, 'NULL'),
(660, 'Sticker_Snow_King_NSH7YTE.webp', 'Sticker', 'Snow King', 'rare', 1190.00, 'NULL'),
(661, 'Sticker_Infernal_Machine_Color_VS99b8Y.webp', 'Sticker', 'Infernal Machine Color', 'rare', 155.00, 'NULL'),
(662, 'Charm_Winter_Games_NaCf5fP.webp', 'Charm', 'Winter Games', 'rare', 10.50, 'NULL'),
(663, 'Graffiti_Head_Hunter.webp', 'Graffiti', 'Head Hunter', 'rare', 6.50, 'NULL'),
(664, 'Fang_Aureate.webp', 'Fang', 'Aureate', 'arcane', 3700.00, 'NULL'),
(665, 'Graffiti_Meowgical_Genie.webp', 'Graffiti', 'Meowgical Genie', 'arcane', 120.00, 'NULL'),
(666, 'Sticker_4_Years_Color_VxkCtFy.webp', 'Sticker', '4 Years Color', 'legendary', 414.99, 'NULL'),
(667, 'Sticker_Sakura_KEdm8y6.webp', 'Sticker', 'Sakura', 'epic', 214.00, 'NULL'),
(668, 'Charm_Horsemans_Head_qZeRD4D.webp', 'Charm', 'Horseman\'s Head', 'rare', 180.00, 'NULL'),
(669, 'Sticker_Lucky_Star_Zm2BwzD.webp', 'Sticker', 'Lucky Star', 'rare', 17.00, 'NULL'),
(670, 'Charm_Rook_Tower.webp', 'Charm', 'Rook Tower', 'rare', 8.00, 'NULL'),
(671, 'Sticker_Bubblegum_Space_Color.webp', 'Sticker', 'Bubblegum Space', 'arcane', 840.00, 'NULL'),
(672, 'Charm_Stinger.webp', 'Charm', 'Stinger', 'legendary', 150.00, 'NULL'),
(673, 'Graffiti_Oasis.webp', 'Graffiti', 'Oasis', 'legendary', 48.00, 'NULL'),
(674, 'SM1014_Serpent.webp', 'SM1014', 'Serpent', 'epic', 10.00, 'NULL'),
(675, 'Sticker_Legends_Color_tpaGdth.webp', 'Sticker', 'Legends Color', 'epic', 30.00, 'NULL'),
(676, 'Chibi_Santa_Helper_HCaVMhM.webp', 'Chibi', 'Santa Helper', 'epic', 28.00, 'NULL'),
(677, 'Sticker_BOOM_rnAEBc8.webp', 'Sticker', 'BOOM', 'rare', 1330.00, 'NULL'),
(678, 'Sticker_Bonsai_ySocYx9.webp', 'Sticker', 'Bonsai', 'rare', 169.00, 'NULL'),
(679, 'Sticker_Oops_cW31L5i.webp', 'Sticker', 'Oops', 'rare', 28.00, 'NULL'),
(680, 'Sticker_Spare_Gold_yHCkaxD.webp', 'Sticker', 'Spare Gold', 'rare', 18.00, 'NULL'),
(681, 'Charm_Fireborn_Gold.webp', 'Charm', 'Fireborn Gold', 'arcane', 755.00, 'NULL'),
(682, 'Graffiti_Black_Hole.webp', 'Graffiti', 'Black Hole', 'arcane', 327.00, 'NULL'),
(683, 'Graffiti_Mad_Bullet.webp', 'Graffiti', 'Mad Bullet', 'arcane', 16.00, 'NULL'),
(684, 'Charm_Claw_fFw8n5F.webp', 'Charm', 'Claw', 'legendary', 332.00, 'NULL'),
(685, 'Graffiti_Minotaur_bYP4nCF.webp', 'Graffiti', 'Minotaur', 'legendary', 31.00, 'NULL'),
(686, 'Sticker_Humvee_EBySEU1.webp', 'Sticker', 'Humvee', 'epic', 532.00, 'NULL'),
(687, 'Charm_Tracery.webp', 'Charm', 'Tracery', 'epic', 22.53, 'NULL'),
(688, 'Sticker_Zombie_PpzCsDC.webp', 'Sticker', 'Zombie', 'rare', 1299.00, 'NULL'),
(689, 'Charm_Mr_Bowler_37ssS3G.webp', 'Charm', 'Mr Bowler', 'rare', 26.00, 'NULL'),
(690, 'Sticker_Voidhound.webp', 'Sticker', 'Voidhound', 'rare', 16.75, 'NULL'),
(691, 'Fang_Damascus.webp', 'Fang', 'Damascus', 'arcane', 4100.00, 'NULL'),
(692, 'Sticker_AWM_Master_Color_tIeceqT.webp', 'Sticker', 'AWM Master Color', 'legendary', 79.98, 'NULL'),
(693, 'Graffiti_Killer_Shark_kbDzliO.webp', 'Graffiti', 'Killer Shark', 'epic', 29.00, 'NULL'),
(694, 'MP7_Ridge.webp', 'MP7', 'Ridge', 'rare', 5.60, 'NULL'),
(695, 'USP_Mirage_Menace.webp', 'USP', 'Mirage Menace', 'arcane', 1570.00, 'NULL'),
(696, 'Sticker_Sweet_Ammo_ukrH96a.webp', 'Sticker', 'Sweet Ammo', 'legendary', 7695.00, 'NULL'),
(697, 'Berettas_Blazing_Maw.webp', 'Berettas', 'Blazing Maw', 'legendary', 34.85, 'NULL'),
(698, 'Graffiti_Bang.webp', 'Graffiti', 'Bang', 'legendary', 40.00, 'NULL'),
(699, 'Charm_Hoplit_Helmet_87WB69x.webp', 'Charm', 'Hoplit Helmet', 'epic', 21.50, 'NULL'),
(700, 'Charm_Wing_dMLcS87.webp', 'Charm', 'Wing', 'arcane', 3600.00, 'NULL'),
(701, 'AWM_Nebula.webp', 'AWM', 'Nebula', 'arcane', 1290.00, 'NULL'),
(702, 'Charm_Molotov.webp', 'Charm', 'Molotov', 'legendary', 160.94, 'NULL'),
(703, 'Sticker_Z9_Project_Gold_bS6CJUX.webp', 'Sticker', 'Z9 Project Gold', 'epic', 1240.00, 'NULL'),
(704, 'Charm_Compass_lhrH6vX.webp', 'Charm', 'Compass', 'epic', 26.50, 'NULL'),
(705, 'FN_FAL_Leather_sNMKgsN.webp', 'FN FAL', 'Leather', 'rare', 21325.00, 'NULL'),
(706, 'Sticker_Bloody_Clown_WS3HZ14.webp', 'Sticker', 'Bloody Clown', 'rare', 1990.00, 'NULL'),
(707, 'Sticker_Emperors_Guard_ZObGLqM.webp', 'Sticker', 'Emperors Guard', 'rare', 65.00, 'NULL'),
(708, 'Graffiti_Toxic_Play.webp', 'Graffiti', 'Toxic Play', 'arcane', 90.00, 'NULL'),
(709, 'Graffiti_Lion_Lord.webp', 'Graffiti', 'Lion Lord', 'arcane', 13.00, 'NULL'),
(710, 'Sticker_Jubilee_5_Gold_STljEwR.webp', 'Sticker', 'Jubilee 5 Gold', 'legendary', 99.50, 'NULL'),
(711, 'Sticker_Pizza_nypk8w6.webp', 'Sticker', 'Pizza', 'epic', 178.00, 'NULL'),
(712, 'Charm_Radio.webp', 'Charm', 'Radio', 'epic', 95.00, 'NULL'),
(713, 'Graffiti_Stellarshot.webp', 'Graffiti', 'Stellarshot', 'epic', 2.47, 'NULL'),
(714, 'Sticker_Hot_Gun_Color_KpM72J6.webp', 'Sticker', 'Hot Gun Color', 'rare', 223.00, 'NULL'),
(715, 'USP_Griffin.webp', 'USP', 'Griffin', 'rare', 0.43, 'NULL'),
(716, 'Sticker_Fireborn_Dragon.webp', 'Sticker', 'Fireborn Dragon', 'rare', 11.19, 'NULL'),
(717, 'Charm_Peripteros_sk5oQom.webp', 'Charm', 'Peripteros', 'rare', 11.15, 'NULL'),
(718, 'Graffiti_Cactus.webp', 'Graffiti', 'Cactus', 'rare', 4.00, 'NULL'),
(719, 'Graffiti_Hazard_OACuRP5.webp', 'Graffiti', 'Hazard', 'rare', 2.74, 'NULL'),
(720, 'Charms_Pack_Halloween_2020_YB5i1AP.webp', 'Charms Pack', 'Halloween 2020', 'gold', 3499.00, 'NULL'),
(722, 'Charm_Sale_ZxpPVHz.webp', 'Charm', 'Sale', 'legendary', 277.99, 'NULL'),
(723, 'Graffiti_Blue_Fire.webp', 'Graffiti', 'Blue Fire', 'rare', 6.35, 'NULL'),
(724, 'Sticker_Toxic_Color_GEaHOCF.webp', 'Sticker', 'Toxic Color', 'legendary', 5995.00, 'NULL'),
(725, 'Charm_Lamp.webp', 'Charm', 'Lamp', 'legendary', 130.00, 'NULL'),
(726, 'Sticker_DEagle_Master_Color_OZIyHWJ.webp', 'Sticker', 'DEagle Master Color', 'epic', 40.24, 'NULL'),
(727, 'Charm_Olive_Branch_qoWGmls.webp', 'Charm', 'Olive Branch', 'epic', 24.35, 'NULL'),
(728, 'Charm_Friendly_Specter_4daeLL1.webp', 'Charm', 'Friendly Specter', 'rare', 130.00, 'NULL'),
(729, 'Sticker_4_Years_PFEX99c.webp', 'Sticker', '4 Years', 'rare', 98.00, 'NULL'),
(730, 'Graffiti_Firestorm.webp', 'Graffiti', 'Firestorm', 'arcane', 12.00, 'NULL'),
(731, 'Sticker_Grapes_QIyZ1YL.webp', 'Sticker', 'Grapes', 'epic', 269.00, 'NULL'),
(732, 'Sticker_Akuma_xW730Ft.webp', 'Sticker', 'Akuma', 'epic', 135.00, 'NULL'),
(733, 'Charm_Hourglass.webp', 'Charm', 'Hourglass', 'epic', 80.00, 'NULL'),
(734, 'Chibi_War_4CmKJEJ.webp', 'Chibi', 'War', 'epic', 16.00, 'NULL'),
(735, 'Graffiti_Save.webp', 'Graffiti', 'Save', 'epic', 4.85, 'NULL'),
(736, 'Graffiti_Stare.webp', 'Graffiti', 'Stare', 'rare', 10.38, 'NULL'),
(737, 'Sticker_Mad_Orc.webp', 'Sticker', 'Mad Orc', 'rare', 9.80, 'NULL'),
(738, 'Graffiti_Sunstrike.webp', 'Graffiti', 'Sunstrike', 'rare', 4.60, 'NULL'),
(739, 'Sticker_Desert_Snake_Color.webp', 'Sticker', 'Desert Snake Color', 'arcane', 800.00, 'NULL'),
(740, 'Charm_Paladin.webp', 'Charm', 'Paladin', 'epic', 18.79, 'NULL'),
(741, 'Graffiti_Sandman.webp', 'Graffiti', 'Sandman', 'epic', 12.00, 'NULL'),
(742, 'Graffiti_Observer_1YEMHlZ.webp', 'Graffiti', 'Observer', 'epic', 6.90, 'NULL'),
(743, 'Sticker_Sea_Outlaw_vOa5hYQ.webp', 'Sticker', 'Sea Outlaw', 'rare', 31.52, 'NULL'),
(744, 'Graffiti_Mind-blowing_Gift_6wcrBtw.webp', 'Graffiti', 'Mind-blowing Gift', 'rare', 15.00, 'NULL'),
(745, 'Sticker_Crest.webp', 'Sticker', 'Crest', 'rare', 9.54, 'NULL'),
(746, 'Chibi_Joy_XlqHOjm.webp', 'Chibi', 'Joy', 'arcane', 2500.00, 'NULL'),
(747, 'Kunai_Glitch.webp', 'Kunai', 'Glitch', 'gold', 1144.85, 'NULL'),
(748, 'Sticker_Time_Is_Over_Color.webp', 'Sticker', 'Time Is Over Color', 'arcane', 668.00, 'NULL'),
(749, 'Graffiti_Slow.webp', 'Graffiti', 'Slow', 'legendary', 5.55, 'NULL'),
(750, 'Sticker_Carpet_BF8xV8b.webp', 'Sticker', 'Carpet', 'epic', 140.00, 'NULL'),
(751, 'MAC10_Arid.webp', 'MAC10', 'Arid', 'rare', 7.00, 'NULL'),
(752, 'Graffiti_Dislike.webp', 'Graffiti', 'Dislike', 'rare', 4.19, 'NULL'),
(753, 'Sticker_Sea_Outlaw_Color_0AcRLSU.webp', 'Sticker', 'Sea Outlaw Color', 'legendary', 172.99, 'NULL'),
(754, 'Sticker_Phoenix_Color_xnBo3Ec.webp', 'Sticker', 'Phoenix Color', 'epic', 359.00, 'NULL'),
(755, 'Charm_Legends_Silver_cQp57oz.webp', 'Charm', 'Legends Silver', 'rare', 19.00, 'NULL'),
(756, 'Sticker_Sunstrike_Gold.webp', 'Sticker', 'Sunstrike Gold', 'legendary', 120.00, 'NULL'),
(757, 'Sticker_Run_Color.webp', 'Sticker', 'Run! Color', 'legendary', 108.00, 'NULL'),
(758, 'Sticker_Boom_Box_rLWLSDR.webp', 'Sticker', 'Boom Box', 'legendary', 47.00, 'NULL'),
(759, 'Sticker_Endurance_DPStmqv.webp', 'Sticker', 'Endurance', 'epic', 233.00, 'NULL'),
(760, 'Chibi_FID.webp', 'Chibi', 'FID', 'epic', 103.00, 'NULL'),
(761, 'Charm_Ever_Green_Mc7A4gY.webp', 'Charm', 'Ever Green', 'epic', 45.00, 'NULL'),
(762, 'FS_Ophidian.webp', 'F/S', 'Ophidian', 'epic', 4.24, 'NULL'),
(763, 'Sticker_Paladin.webp', 'Sticker', 'Paladin', 'epic', 16.92, 'NULL'),
(764, 'Charm_Spray_5_V5EiBDJ.webp', 'Charm', 'Spray 5', 'epic', 14.49, 'NULL'),
(765, 'Charm_Cutting_Pliers_uU1tPcS.webp', 'Charm', 'Cutting Pliers', 'rare', 228.00, 'NULL'),
(766, 'Sticker_Danger_YJjm4h2.webp', 'Sticker', 'Danger', 'rare', 219.00, 'NULL'),
(767, 'Charm_Fireborn_Silver.webp', 'Charm', 'Fireborn Silver', 'rare', 17.00, 'NULL'),
(768, 'Graffiti_Camper_FII80jW.webp', 'Graffiti', 'Camper', 'rare', 2.00, 'NULL'),
(769, 'Charm_Yokai_lcdKvcc.webp', 'Charm', 'Yokai', 'arcane', 2750.00, 'NULL'),
(770, 'Graffiti_Fail.webp', 'Graffiti', 'Fail', 'arcane', 18.79, 'NULL'),
(771, 'Sticker_Vampirisushi_Color_s6XiiLk.webp', 'Sticker', 'Vampirisushi Color', 'epic', 133.00, 'NULL'),
(772, 'Graffiti_Scorcher.webp', 'Graffiti', 'Scorcher', 'epic', 10.50, 'NULL'),
(773, 'Graffiti_Knife_Kill_fDZoCDF.webp', 'Graffiti', 'Knife Kill', 'epic', 2.30, 'NULL'),
(774, 'P350_Sandspirit.webp', 'P350', 'Sandspirit', 'rare', 6.60, 'NULL'),
(775, 'M40_Wyvern.webp', 'M40', 'Wyvern', 'rare', 0.44, 'NULL'),
(776, 'Graffiti_Firearm.webp', 'Graffiti', 'Firearm', 'rare', 4.50, 'NULL'),
(777, 'Graffiti_Easy_376OVx4.webp', 'Graffiti', 'Easy', 'rare', 2.34, 'NULL'),
(778, 'Charm_Winter_Fun_aFCQS0t.webp', 'Charm', 'Winter Fun', 'legendary', 255.90, 'NULL'),
(779, 'Graffiti_Touch_Down.webp', 'Graffiti', 'Touch Down', 'legendary', 5.29, 'NULL'),
(780, 'Graffiti_Dual_Double.webp', 'Graffiti', 'Dual Double', 'legendary', 3.40, 'NULL'),
(781, 'Chibi_Gift_Thief_tnBXkDm.webp', 'Chibi', 'Gift Thief', 'epic', 28.00, 'NULL'),
(782, 'Graffiti_Blasted.webp', 'Graffiti', 'Blasted', 'epic', 3.98, 'NULL'),
(783, 'Sticker_Snow_Meteor_kGwNr3s.webp', 'Sticker', 'Snow Meteor', 'rare', 13.90, 'NULL'),
(784, 'Graffiti_Octopus_AjSZD8v.webp', 'Graffiti', 'Octopus', 'rare', 8.30, 'NULL'),
(785, 'Sticker_Flake_pbB5Hsx.webp', 'Sticker', 'Flake', 'rare', 169.99, 'NULL'),
(786, 'Sticker_V2_D8t4OCu.webp', 'Sticker', 'V2', 'rare', 22.79, 'NULL'),
(787, 'Sticker_Kunoichi_9cZt9ED.webp', 'Sticker', 'Kunoichi', 'epic', 111.00, 'NULL'),
(788, 'Sticker_FID_Gold.webp', 'Sticker', 'FID Gold', 'legendary', 177.00, 'NULL'),
(789, 'Sticker_Fury_Fire_Color.webp', 'Sticker', 'Fury Fire Color', 'legendary', 116.00, 'NULL'),
(790, 'Berettas_Hexagon.webp', 'Berettas', 'Hexagon', 'epic', 18.96, 'NULL'),
(791, 'Graffiti_Cupid_N5Urx7T.webp', 'Graffiti', 'Cupid', 'epic', 8.00, 'NULL'),
(792, 'Sticker_Jellyfish_lBMyFzi.webp', 'Sticker', 'Jellyfish', 'rare', 42.00, 'NULL'),
(793, 'Sticker_Sandman.webp', 'Sticker', 'Sandman', 'rare', 11.00, 'NULL'),
(794, 'Sticker_Ghosty_OW0Y4sG.webp', 'Sticker', 'Ghosty', 'rare', 1299.00, 'NULL'),
(795, 'UMP45_Arid.webp', 'UMP45', 'Arid', 'rare', 7.00, 'NULL'),
(796, 'Sticker_Nice_Skill_bmW0HiH.webp', 'Sticker', 'Nice Skill', 'rare', 26.97, 'NULL'),
(797, 'Charm_Dragon_Shield.webp', 'Charm', 'Dragon Shield', 'arcane', 699.00, 'NULL'),
(798, 'Sticker_Koi_Color_AFKoxZd.webp', 'Sticker', 'Koi Color', 'legendary', 210.00, 'NULL'),
(799, 'Sticker_Kebab_Joint.webp', 'Sticker', 'Kebab Joint', 'epic', 45.00, 'NULL'),
(800, 'Sticker_Hardcore_Color.webp', 'Sticker', 'Hardcore Color', 'epic', 38.80, 'NULL'),
(801, 'Sticker_Radiation_odL9z1J.webp', 'Sticker', 'Radiation', 'rare', 1600.00, 'NULL'),
(802, 'UMP45_Peaceful_Dream_FXs9Y1G.webp', 'UMP45', 'Peaceful Dream', 'uncommon', 0.07, 'NULL'),
(803, 'UMP45_Pixel_V2_4F6TnlZ.webp', 'UMP45', 'Pixel V2', 'uncommon', 0.07, 'NULL');

-- --------------------------------------------------------

--
-- Структура таблицы `upgrades`
--

CREATE TABLE `upgrades` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_item_id` int(10) UNSIGNED NOT NULL,
  `second_item_id` int(10) UNSIGNED NOT NULL,
  `result` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) NOT NULL,
  `balance` decimal(9,2) UNSIGNED DEFAULT '0.00',
  `replenished` decimal(9,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `coefficient` decimal(3,2) NOT NULL DEFAULT '0.90',
  `sessions` json NOT NULL,
  `oauth` json DEFAULT NULL,
  `reg_time` int(10) UNSIGNED NOT NULL,
  `seen` int(11) NOT NULL DEFAULT '0',
  `referral_code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `invited_by` int(10) UNSIGNED DEFAULT NULL,
  `last_auth_errors` json DEFAULT NULL,
  `cases_last_open` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `balance`, `replenished`, `coefficient`, `sessions`, `oauth`, `reg_time`, `seen`, `referral_code`, `invited_by`, `last_auth_errors`, `cases_last_open`) VALUES
(1, 'davidmejster4@gmail.com', '$2y$10$erlVupJ8OQDmvQen0NtIauV04Qst4QbC.C3symnA7kSJ0KZBYGSFO', 'admin', 7073.27, 1000.00, 0.90, '[{\"ip\": \"::1\", \"ua\": \"8381c048a9d70230af13a12a76663dc4\", \"time\": 1721903814, \"token\": \"cc4da9c9c8c7b7bf2d8260f9ca1d041fa86fa7b9\"}]', NULL, 1719149629, 1721904686, 'AQLD3', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `skins_id` json NOT NULL,
  `pattern` int(10) UNSIGNED NOT NULL,
  `status` varchar(20) CHARACTER SET utf8 NOT NULL,
  `sum` decimal(9,2) UNSIGNED NOT NULL,
  `desc` text,
  `add_time` int(10) UNSIGNED NOT NULL,
  `withdrawal_time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `img` (`img`),
  ADD KEY `name` (`name`),
  ADD KEY `one_open_per` (`one_open_per`),
  ADD KEY `cost` (`cost`),
  ADD KEY `category` (`category`),
  ADD KEY `coefficient` (`coefficient`);

--
-- Индексы таблицы `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skin_win` (`skin_win`),
  ADD KEY `result` (`result`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `gotfrom` (`gotfrom`),
  ADD KEY `type` (`type`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `dropped_from_case` (`dropped_from_case`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pay_system` (`pay_system`),
  ADD KEY `status` (`status`),
  ADD KEY `pay_type` (`pay_type`),
  ADD KEY `promo` (`promo`);

--
-- Индексы таблицы `prizes`
--
ALTER TABLE `prizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `day` (`day`);

--
-- Индексы таблицы `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promo` (`promo`);

--
-- Индексы таблицы `promo_users`
--
ALTER TABLE `promo_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`promo_id`);

--
-- Индексы таблицы `skins`
--
ALTER TABLE `skins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `img` (`img`),
  ADD KEY `title` (`title`),
  ADD KEY `name` (`name`),
  ADD KEY `rarity` (`rarity`),
  ADD KEY `cost` (`cost`),
  ADD KEY `collection` (`collection`);

--
-- Индексы таблицы `upgrades`
--
ALTER TABLE `upgrades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `first_item_id` (`first_item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `result` (`result`),
  ADD KEY `second_item_id` (`second_item_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_code` (`referral_code`),
  ADD KEY `coefficient` (`coefficient`),
  ADD KEY `name` (`name`),
  ADD KEY `seen` (`seen`);

--
-- Индексы таблицы `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pattern` (`pattern`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `prizes`
--
ALTER TABLE `prizes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `promo_users`
--
ALTER TABLE `promo_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `skins`
--
ALTER TABLE `skins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=804;

--
-- AUTO_INCREMENT для таблицы `upgrades`
--
ALTER TABLE `upgrades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
