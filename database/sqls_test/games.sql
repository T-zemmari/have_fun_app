-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-07-2024 a las 07:40:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `have_fun_2024_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `route_name` varchar(255) NOT NULL,
  `url_img` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `free_or_paid` int(11) NOT NULL,
  `show_in_web` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `games`
--

INSERT INTO `games` (`id`, `name`, `description`, `route_name`, `url_img`, `active`, `free_or_paid`, `show_in_web`, `created_at`, `updated_at`) VALUES
(1, 'Tetris', NULL, 'tetris_one', '/assets/uploads/imgs/games/1721310866_tetris_1.png', 1, 1, 1, '2024-07-18 11:54:26', '2024-07-18 12:01:32'),
(2, 'Ajedrez', NULL, 'ajedrez', '/assets/uploads/imgs/games/1721312512_chess_1.png', 1, 1, 1, '2024-07-18 12:21:52', '2024-07-18 12:21:52'),
(3, 'Sudoku', NULL, 'sudoku_one', '/assets/uploads/imgs/games/1721312526_sudoku_1.png', 1, 1, 1, '2024-07-18 12:22:06', '2024-07-18 12:22:06'),
(4, 'Memo 1', NULL, 'memo_1', '/assets/uploads/imgs/games/1721312543_memo_1.png', 1, 1, 1, '2024-07-18 12:22:23', '2024-07-18 12:22:23'),
(5, 'Damas', NULL, 'damas', '/assets/uploads/imgs/games/1721312562_damas_1.png', 1, 1, 1, '2024-07-18 12:22:42', '2024-07-18 12:22:42'),
(6, 'Bullet Game', NULL, 'bullet_game', '/assets/uploads/imgs/games/1721312587_img_1.png', 1, 1, 1, '2024-07-18 12:23:07', '2024-07-18 12:23:07'),
(7, 'Tresor Hunt', NULL, 'treasure_hunt', '/assets/uploads/imgs/games/1721314430_bg_1.png', 1, 1, 1, '2024-07-18 12:53:50', '2024-07-18 12:53:50'),
(8, 'Adventure one', NULL, 'adventure_one', '/assets/uploads/imgs/games/background.png', 1, 1, 1, '2024-07-19 07:50:46', '2024-07-19 09:18:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
