-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2019. Okt 21. 10:07
-- Kiszolgáló verziója: 10.1.29-MariaDB
-- PHP verzió: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `laravel_vue_image_mosaic`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `file_uploads`
--

CREATE TABLE `file_uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `image_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `file_uploads`
--

INSERT INTO `file_uploads` (`id`, `user_id`, `gallery_id`, `image_name`, `created_at`, `updated_at`) VALUES
(7, 1, 2, 'image_5c59cdc140323_1549389249.jpg', '2019-02-05 16:54:09', '2019-02-05 16:54:09'),
(8, 1, 2, 'image_5c59cdc17ebef_1549389249.jpg', '2019-02-05 16:54:09', '2019-02-05 16:54:09'),
(9, 1, 2, 'image_5c59cdc1eb95f_1549389249.jpg', '2019-02-05 16:54:09', '2019-02-05 16:54:09'),
(10, 1, 2, 'image_5c59cdc230206_1549389250.jpg', '2019-02-05 16:54:10', '2019-02-05 16:54:10'),
(11, 1, 2, 'image_5c59cdc2a5cab_1549389250.jpg', '2019-02-05 16:54:10', '2019-02-05 16:54:10'),
(12, 1, 2, 'image_5c59cdc2e0242_1549389250.jpg', '2019-02-05 16:54:10', '2019-02-05 16:54:10'),
(13, 1, 2, 'image_5c59cdc3224e5_1549389251.jpg', '2019-02-05 16:54:11', '2019-02-05 16:54:11'),
(14, 1, 2, 'image_5c59cdc358db4_1549389251.jpg', '2019-02-05 16:54:11', '2019-02-05 16:54:11'),
(15, 1, 2, 'image_5c59cdc3c666e_1549389251.jpg', '2019-02-05 16:54:11', '2019-02-05 16:54:11'),
(16, 1, 2, 'image_5c59cdc43d416_1549389252.jpg', '2019-02-05 16:54:12', '2019-02-05 16:54:12'),
(17, 1, 2, 'image_5c59cdc52799e_1549389253.jpg', '2019-02-05 16:54:13', '2019-02-05 16:54:13'),
(18, 1, 2, 'image_5c59cdc561873_1549389253.jpg', '2019-02-05 16:54:13', '2019-02-05 16:54:13'),
(19, 1, 2, 'image_5c59cdc5d01b3_1549389253.jpg', '2019-02-05 16:54:13', '2019-02-05 16:54:13'),
(20, 1, 2, 'image_5c59cdc614f1b_1549389254.jpg', '2019-02-05 16:54:14', '2019-02-05 16:54:14'),
(21, 1, 2, 'image_5c59cdc690c3c_1549389254.jpg', '2019-02-05 16:54:14', '2019-02-05 16:54:14'),
(22, 1, 2, 'image_5c59cdc6c942b_1549389254.jpg', '2019-02-05 16:54:14', '2019-02-05 16:54:14'),
(23, 1, 2, 'image_5c59cdc747200_1549389255.jpg', '2019-02-05 16:54:15', '2019-02-05 16:54:15'),
(24, 1, 2, 'image_5c59cdc801442_1549389256.jpg', '2019-02-05 16:54:16', '2019-02-05 16:54:16'),
(25, 1, 2, 'image_5c59cdc83966f_1549389256.jpg', '2019-02-05 16:54:16', '2019-02-05 16:54:16'),
(26, 1, 1, 'image_5c5a996c6baf4_1549441388.jpg', '2019-02-06 07:23:08', '2019-02-06 07:23:08'),
(27, 1, 1, 'image_5c5a996cde320_1549441388.png', '2019-02-06 07:23:08', '2019-02-06 07:23:08'),
(28, 1, 1, 'image_5c5a996d512a3_1549441389.png', '2019-02-06 07:23:09', '2019-02-06 07:23:09'),
(29, 1, 1, 'image_5c5a996d84c69_1549441389.jpg', '2019-02-06 07:23:09', '2019-02-06 07:23:09'),
(30, 1, 1, 'image_5c5a996db5fe4_1549441389.png', '2019-02-06 07:23:09', '2019-02-06 07:23:09'),
(31, 1, 1, 'image_5c5a996e285f6_1549441390.jpg', '2019-02-06 07:23:10', '2019-02-06 07:23:10'),
(32, 1, 1, 'image_5c5a996e59237_1549441390.png', '2019-02-06 07:23:10', '2019-02-06 07:23:10'),
(33, 1, 1, 'image_5c5a996e89df5_1549441390.jpg', '2019-02-06 07:23:10', '2019-02-06 07:23:10'),
(34, 1, 1, 'image_5c5a996ebb522_1549441390.png', '2019-02-06 07:23:10', '2019-02-06 07:23:10'),
(35, 1, 1, 'image_5c5a996ef1c77_1549441390.jpg', '2019-02-06 07:23:11', '2019-02-06 07:23:11'),
(36, 1, 1, 'image_5c5a996f612fe_1549441391.jpg', '2019-02-06 07:23:11', '2019-02-06 07:23:11'),
(37, 1, 1, 'image_5c5a996f946b0_1549441391.png', '2019-02-06 07:23:11', '2019-02-06 07:23:11'),
(38, 1, 1, 'image_5c5a997004e90_1549441392.png', '2019-02-06 07:23:12', '2019-02-06 07:23:12'),
(39, 1, 1, 'image_5c5a9970359bc_1549441392.jpg', '2019-02-06 07:23:12', '2019-02-06 07:23:12'),
(40, 1, 1, 'image_5c5a99706b00c_1549441392.png', '2019-02-06 07:23:12', '2019-02-06 07:23:12'),
(41, 1, 1, 'image_5c5a99709d569_1549441392.jpg', '2019-02-06 07:23:12', '2019-02-06 07:23:12'),
(42, 1, 1, 'image_5c5a9970d1ac9_1549441392.png', '2019-02-06 07:23:12', '2019-02-06 07:23:12'),
(43, 1, 1, 'image_5c5a997112273_1549441393.jpg', '2019-02-06 07:23:13', '2019-02-06 07:23:13'),
(44, 1, 1, 'image_5c5a99714809a_1549441393.png', '2019-02-06 07:23:13', '2019-02-06 07:23:13'),
(45, 1, 1, 'image_5c5a99718189f_1549441393.jpg', '2019-02-06 07:23:13', '2019-02-06 07:23:13'),
(46, 1, 1, 'image_5c5a9971baf90_1549441393.jpg', '2019-02-06 07:23:13', '2019-02-06 07:23:13'),
(47, 1, 1, 'image_5c5a997236b17_1549441394.png', '2019-02-06 07:23:14', '2019-02-06 07:23:14'),
(48, 1, 1, 'image_5c5a9972709a2_1549441394.jpg', '2019-02-06 07:23:14', '2019-02-06 07:23:14'),
(49, 1, 1, 'image_5c5a9973221aa_1549441395.png', '2019-02-06 07:23:15', '2019-02-06 07:23:15'),
(50, 1, 1, 'image_5c5a99735bd10_1549441395.jpg', '2019-02-06 07:23:15', '2019-02-06 07:23:15'),
(51, 1, 1, 'image_5c5a997399504_1549441395.png', '2019-02-06 07:23:15', '2019-02-06 07:23:15'),
(52, 1, 1, 'image_5c5a9973d4207_1549441395.jpg', '2019-02-06 07:23:15', '2019-02-06 07:23:15'),
(53, 1, 1, 'image_5c5a997415ef4_1549441396.jpg', '2019-02-06 07:23:16', '2019-02-06 07:23:16'),
(54, 1, 1, 'image_5c5a9974864fd_1549441396.jpg', '2019-02-06 07:23:16', '2019-02-06 07:23:16'),
(55, 1, 1, 'image_5c5a9974bb8a4_1549441396.jpg', '2019-02-06 07:23:16', '2019-02-06 07:23:16'),
(56, 1, 1, 'image_5c5a99752cf7e_1549441397.jpg', '2019-02-06 07:23:17', '2019-02-06 07:23:17'),
(57, 1, 1, 'image_5c5a9975b1aee_1549441397.jpg', '2019-02-06 07:23:17', '2019-02-06 07:23:17'),
(58, 1, 1, 'image_5c5a9975e2135_1549441397.jpg', '2019-02-06 07:23:17', '2019-02-06 07:23:17'),
(59, 1, 1, 'image_5c5a99761aa78_1549441398.jpg', '2019-02-06 07:23:18', '2019-02-06 07:23:18'),
(60, 1, 1, 'image_5c5a997679053_1549441398.jpg', '2019-02-06 07:23:18', '2019-02-06 07:23:18'),
(61, 1, 1, 'image_5c5a9976a66df_1549441398.jpg', '2019-02-06 07:23:18', '2019-02-06 07:23:18'),
(62, 1, 1, 'image_5c5a9976d2eb9_1549441398.jpg', '2019-02-06 07:23:18', '2019-02-06 07:23:18'),
(63, 1, 1, 'image_5c5a997707151_1549441399.jpg', '2019-02-06 07:23:19', '2019-02-06 07:23:19'),
(64, 1, 1, 'image_5c5a99775cfa9_1549441399.jpg', '2019-02-06 07:23:19', '2019-02-06 07:23:19'),
(65, 1, 1, 'image_5c5a997790283_1549441399.jpg', '2019-02-06 07:23:19', '2019-02-06 07:23:19'),
(66, 1, 1, 'image_5c5a9977c1af8_1549441399.jpg', '2019-02-06 07:23:19', '2019-02-06 07:23:19'),
(67, 1, 1, 'image_5c5a9977efc5d_1549441399.jpg', '2019-02-06 07:23:19', '2019-02-06 07:23:19'),
(68, 1, 1, 'image_5c5a997855323_1549441400.jpg', '2019-02-06 07:23:20', '2019-02-06 07:23:20'),
(69, 1, 1, 'image_5c5a99788575a_1549441400.jpg', '2019-02-06 07:23:20', '2019-02-06 07:23:20'),
(70, 1, 1, 'image_5c5a9978e30c2_1549441400.jpg', '2019-02-06 07:23:20', '2019-02-06 07:23:20'),
(71, 1, 1, 'image_5c5a99791eec1_1549441401.jpg', '2019-02-06 07:23:21', '2019-02-06 07:23:21'),
(72, 1, 1, 'image_5c5a997a0ff64_1549441402.jpg', '2019-02-06 07:23:22', '2019-02-06 07:23:22'),
(73, 1, 1, 'image_5c5a997a760b8_1549441402.jpg', '2019-02-06 07:23:22', '2019-02-06 07:23:22'),
(74, 1, 1, 'image_5c5a997ae0425_1549441402.jpg', '2019-02-06 07:23:22', '2019-02-06 07:23:22'),
(75, 1, 1, 'image_5c5a997bb2fa8_1549441403.jpg', '2019-02-06 07:23:23', '2019-02-06 07:23:23'),
(76, 1, 1, 'image_5c5a997be7ffe_1549441403.jpg', '2019-02-06 07:23:23', '2019-02-06 07:23:23'),
(77, 1, 1, 'image_5c5a997ca0e3a_1549441404.jpg', '2019-02-06 07:23:24', '2019-02-06 07:23:24'),
(78, 1, 1, 'image_5c5a997ccea5e_1549441404.jpg', '2019-02-06 07:23:24', '2019-02-06 07:23:24'),
(79, 1, 1, 'image_5c5a997d095c5_1549441405.jpg', '2019-02-06 07:23:25', '2019-02-06 07:23:25'),
(80, 1, 1, 'image_5c5a997d361a7_1549441405.jpg', '2019-02-06 07:23:25', '2019-02-06 07:23:25'),
(81, 1, 1, 'image_5c5a997d6161f_1549441405.jpg', '2019-02-06 07:23:25', '2019-02-06 07:23:25'),
(82, 1, 1, 'image_5c5a997d91401_1549441405.jpg', '2019-02-06 07:23:25', '2019-02-06 07:23:25'),
(83, 1, 1, 'image_5c5a997e2eaf7_1549441406.jpg', '2019-02-06 07:23:26', '2019-02-06 07:23:26'),
(84, 1, 1, 'image_5c5a997eeadd0_1549441406.jpg', '2019-02-06 07:23:27', '2019-02-06 07:23:27'),
(85, 1, 1, 'image_5c5a997f6baa6_1549441407.jpg', '2019-02-06 07:23:27', '2019-02-06 07:23:27'),
(86, 1, 1, 'image_5c5a997fcd64a_1549441407.jpg', '2019-02-06 07:23:27', '2019-02-06 07:23:27'),
(87, 1, 1, 'image_5c5a998042e8f_1549441408.jpg', '2019-02-06 07:23:28', '2019-02-06 07:23:28'),
(88, 1, 1, 'image_5c5a9980cd618_1549441408.jpg', '2019-02-06 07:23:28', '2019-02-06 07:23:28'),
(89, 1, 1, 'image_5c5a99810b024_1549441409.jpg', '2019-02-06 07:23:29', '2019-02-06 07:23:29'),
(90, 1, 1, 'image_5c5a998138f4b_1549441409.jpg', '2019-02-06 07:23:29', '2019-02-06 07:23:29'),
(91, 1, 1, 'image_5c5a998190d97_1549441409.jpg', '2019-02-06 07:23:29', '2019-02-06 07:23:29'),
(92, 1, 1, 'image_5c5a9981bba09_1549441409.jpg', '2019-02-06 07:23:29', '2019-02-06 07:23:29'),
(93, 1, 1, 'image_5c5a998224efa_1549441410.jpg', '2019-02-06 07:23:30', '2019-02-06 07:23:30'),
(94, 1, 1, 'image_5c5a9982525e7_1549441410.jpg', '2019-02-06 07:23:30', '2019-02-06 07:23:30'),
(95, 1, 1, 'image_5c5a998283b6e_1549441410.jpg', '2019-02-06 07:23:30', '2019-02-06 07:23:30'),
(96, 1, 1, 'image_5c8610d3cc858_1552290003.jpg', '2019-03-11 06:40:04', '2019-03-11 06:40:04'),
(97, 1, 3, 'image_5c8610f06ea2a_1552290032.jpg', '2019-03-11 06:40:33', '2019-03-11 06:40:33'),
(98, 1, 3, 'image_5c8610f7133e8_1552290039.jpg', '2019-03-11 06:40:39', '2019-03-11 06:40:39'),
(99, 1, 3, 'image_5c8610fbb632e_1552290043.jpg', '2019-03-11 06:40:44', '2019-03-11 06:40:44'),
(100, 2, 0, 'image_5c95270f94547_1553278735.jpg', '2019-03-22 17:18:56', '2019-03-22 17:18:56'),
(101, 2, 0, 'image_5c952710d3adb_1553278736.jpg', '2019-03-22 17:18:57', '2019-03-22 17:18:57'),
(103, 1, 0, 'image_5cb177bae561c_1555134394.jpg', '2019-04-13 03:46:36', '2019-04-13 03:46:36'),
(104, 1, 0, 'image_5cb177f8e0254_1555134456.jpg', '2019-04-13 03:47:38', '2019-04-13 03:47:38'),
(105, 1, 0, 'image_5cb178031162d_1555134467.jpg', '2019-04-13 03:47:48', '2019-04-13 03:47:48'),
(106, 1, 0, 'image_5cb17814f17f7_1555134484.jpg', '2019-04-13 03:48:06', '2019-04-13 03:48:06'),
(107, 1, 0, 'image_5cb178ad6895b_1555134637.jpg', '2019-04-13 03:50:39', '2019-04-13 03:50:39'),
(108, 1, 0, 'image_5cb178c8af225_1555134664.jpg', '2019-04-13 03:51:05', '2019-04-13 03:51:05'),
(109, 1, 0, 'image_5cb178d9d1645_1555134681.jpg', '2019-04-13 03:51:22', '2019-04-13 03:51:22'),
(110, 1, 0, 'image_5cb178e5173d4_1555134693.jpg', '2019-04-13 03:51:33', '2019-04-13 03:51:33'),
(111, 1, 0, 'image_5cb178f4b2a8f_1555134708.jpg', '2019-04-13 03:51:50', '2019-04-13 03:51:50'),
(112, 1, 0, 'image_5cb179063c009_1555134726.jpg', '2019-04-13 03:52:07', '2019-04-13 03:52:07'),
(113, 4, 0, 'image_5d8dcf57169ee_1569574743.jpg', '2019-09-27 06:59:03', '2019-09-27 06:59:03');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `galleries`
--

CREATE TABLE `galleries` (
  `id` int(10) UNSIGNED NOT NULL,
  `gallery_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_order` int(11) DEFAULT '1000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `galleries`
--

INSERT INTO `galleries` (`id`, `gallery_name`, `gallery_order`, `created_at`, `updated_at`) VALUES
(0, 'Foo', 1, NULL, NULL),
(1, 'Gallery 1', 1000, NULL, NULL),
(2, 'Gallery 2', 2, NULL, NULL),
(3, 'Gallery 3', 1, NULL, NULL),
(4, 'Gallery 4', 22, NULL, NULL),
(5, 'Gallery 5', 1000, NULL, NULL),
(6, 'Gallery 6', 1000, NULL, NULL),
(7, 'Gallery 7', 1000, NULL, NULL),
(8, 'Gallery 8', 1000, NULL, NULL),
(9, 'Gallery 9', 1000, NULL, NULL),
(10, 'Gallery 10', 1000, NULL, NULL),
(11, 'Gallery 11', 1000, NULL, NULL),
(12, 'Gallery 12', 1000, NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(20, '2014_10_12_000000_create_users_table', 1),
(21, '2014_10_12_100000_create_password_resets_table', 1),
(22, '2018_11_27_125356_create_file_uploads_table', 1),
(23, '2019_02_04_102424_create_galleries_table', 1),
(24, '2019_02_04_104110_create_mosaics_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `mosaics`
--

CREATE TABLE `mosaics` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `mosaics`
--

INSERT INTO `mosaics` (`id`, `user_id`, `image_name`, `created_at`, `updated_at`) VALUES
(3, 1, '1_user_0m2pxnosahd6h6n8g4w1xn_collected.png.png', '2019-04-04 11:30:48', '2019-04-04 11:30:48'),
(4, 1, '1_user_5fdt7a119ze5ls1384vuwa_collected.png.png', '2019-04-04 11:30:49', '2019-04-04 11:30:49'),
(5, 1, '1_user_9fr2wjlwe28v8lnpw97w2l_collected.png.png', '2019-04-04 11:30:50', '2019-04-04 11:30:50'),
(6, 1, 'galaxyskod.jpg.jpg', '2019-04-08 06:14:09', '2019-04-08 06:14:09'),
(7, 1, '2galaxyskod.png.png', '2019-04-08 06:16:55', '2019-04-08 06:16:55'),
(8, 1, '2galaxyskod.png.png', '2019-04-08 06:18:37', '2019-04-08 06:18:37');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `mosaics_kidob`
--

CREATE TABLE `mosaics_kidob` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `mosaics_kidob`
--

INSERT INTO `mosaics_kidob` (`id`, `user_id`, `image_name`, `created_at`, `updated_at`) VALUES
(1, 5, 'wulan8bz5vp9b2jfoqah2u_collected.png', '2019-01-19 13:30:43', '2019-01-19 13:30:43'),
(2, 5, 'rrcuviehzu95sb91695en6_collected.png', '2019-01-19 13:30:50', '2019-01-19 13:30:50'),
(3, 5, '7507na32jx6lrgg3o8cfn_collected.png', '2019-01-19 13:30:57', '2019-01-19 13:30:57'),
(4, 5, 't957tn7ozmml0ga6p2k6k9_collected.png', '2019-01-19 13:31:29', '2019-01-19 13:31:29'),
(5, 5, '5bztybufd720i9nhed2ct8w_collected.png', '2019-01-19 13:37:23', '2019-01-19 13:37:23'),
(6, 5, 'smlrc40woub5fkx4crby7_collected.png', '2019-01-19 13:37:44', '2019-01-19 13:37:44'),
(7, 1, '9x5qjbf4zboj73bni2h1yp_collected.png', '2019-01-23 09:10:02', '2019-01-23 09:10:02'),
(8, 1, '2c4yi4w1cujwu8wnb9jw8s_collected.png', '2019-02-01 16:57:53', '2019-02-01 16:57:53'),
(9, 1, 'jmvhrsoym2hsqqv2mzcu58_collected.png', '2019-02-01 16:58:17', '2019-02-01 16:58:17');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` int(11) DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `admin`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 2, 'admin@test.com', NULL, '$2y$10$5KhHhtaD0LECE4at.yKBA.5cF32F/WTsBXrZgmQiM3ZcIzsRwxzeO', 'c4LCnXwinh4raZz5gh2prAbl1IIWIGum2AJRJFjkCu8944yTgGzYgWXeLmhK', '2019-02-04 10:59:03', '2019-02-04 10:59:03'),
(4, 'Test', 0, 'test@test.com', NULL, '$2y$10$JbrWes85/j4Gn/e2rF1ABOE8BhYAdHmpFAjgKwqMgu14CONMLr/Vm', 'KZU4k8jGJQBa7NL6M2d6sDA1OGPy9Pq9PBhWmuC9EHaXOuYViitgFRCvX4iY', '2019-03-22 17:18:30', '2019-03-22 17:18:30'),
(5, 'Teszt 2', NULL, 'test2@test.com', NULL, '$2y$10$P2DUaZZrDinasFzZQYiu/eebOdL.kpk90DGSmlt39QcWFZZjTMrRi', 'dnybEWzflfQu1ujEH1xDIAF6TMtktyB3g7SYMRCo6CSl9WQUc5w5jQphSa9u', '2019-09-25 09:26:12', '2019-09-25 09:26:12');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_uploads_user_id_index` (`user_id`),
  ADD KEY `file_uploads_gallery_id_index` (`gallery_id`);

--
-- A tábla indexei `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `mosaics`
--
ALTER TABLE `mosaics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mosaics_user_id_index` (`user_id`);

--
-- A tábla indexei `mosaics_kidob`
--
ALTER TABLE `mosaics_kidob`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT a táblához `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT a táblához `mosaics`
--
ALTER TABLE `mosaics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `mosaics_kidob`
--
ALTER TABLE `mosaics_kidob`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
