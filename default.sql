-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 27 Jul 2024 pada 08.21
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_v3`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cron_history`
--

CREATE TABLE `cron_history` (
  `id` int(11) NOT NULL,
  `last_date_sync` varchar(100) NOT NULL,
  `total_data` varchar(100) NOT NULL,
  `cabang_id` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_hapus_barang`
--

CREATE TABLE `log_hapus_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_sensor`
--

CREATE TABLE `log_sensor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_meja` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `cabang_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meja`
--

CREATE TABLE `meja` (
  `id_meja` bigint(20) UNSIGNED NOT NULL,
  `nama_meja` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Id_pesanan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `meja`
--

INSERT INTO `meja` (`id_meja`, `nama_meja`, `Status`, `Id_pesanan`, `created_at`, `updated_at`) VALUES
(1, 'Meja1 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2024-05-14 11:53:22'),
(2, 'Meja2 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2024-05-02 11:18:42'),
(3, 'Meja3 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2024-05-02 11:19:10'),
(4, 'Meja4 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-27 04:13:54'),
(5, 'Meja5 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-27 04:13:54'),
(6, 'Meja6 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-27 04:13:54'),
(7, 'Meja7 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-26 06:17:22'),
(8, 'Meja8 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-27 04:13:54'),
(9, 'Meja9 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-27 04:13:46'),
(10, 'Meja10 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-27 04:13:44'),
(11, 'Meja11 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-19 12:01:13'),
(12, 'Meja12 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-26 06:18:44'),
(13, 'Meja13 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-09 14:45:24'),
(14, 'Meja14 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-09 14:45:24'),
(15, 'Meja15 Cafe', 'Kosong', 0, '2022-01-10 05:36:14', '2023-12-26 06:19:34'),
(16, 'Meja16 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(17, 'Meja17 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(18, 'Meja18 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(19, 'Meja19 Cafe 	', 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(20, 'Meja20 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(21, 'Meja21 Cafe 	', 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(22, 'Meja22 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(23, 'Meja23 Cafe 	', 'Kosong', 0, NULL, '2024-05-07 05:57:37'),
(24, 'Meja24 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(25, 'Meja25 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(26, 'Meja26 Cafe 	', 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(27, 'Meja27 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(28, 'Meja28 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(29, 'Meja29 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(30, 'Meja30 Cafe 	', 'Kosong', 0, NULL, '2023-12-19 12:01:08'),
(31, 'Meja31 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24'),
(32, 'Meja32 Cafe 	', 'Kosong', 0, NULL, '2023-12-09 14:45:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mejabiliard`
--

CREATE TABLE `mejabiliard` (
  `id_meja_biliard` bigint(20) UNSIGNED NOT NULL,
  `namameja` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jammulai` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sisadurasi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jamselesai` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_order_biliard` int(11) NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mejabiliard`
--

INSERT INTO `mejabiliard` (`id_meja_biliard`, `namameja`, `jammulai`, `durasi`, `sisadurasi`, `jamselesai`, `id_order_biliard`, `status`, `flag`, `created_at`, `updated_at`) VALUES
(1, 'Meja1', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2024-07-19 07:48:04'),
(2, 'Meja2', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2024-05-01 22:26:47'),
(3, 'Meja3', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-28 13:14:28'),
(4, 'Meja4', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-27 04:13:57'),
(5, 'Meja5', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-27 04:13:57'),
(6, 'Meja6', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-27 04:13:57'),
(7, 'Meja7', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-27 04:13:57'),
(8, 'Meja8', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-27 04:13:57'),
(9, 'Meja9', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-27 04:13:57'),
(10, 'Meja10', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-27 04:13:54'),
(11, 'Meja11', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:17'),
(12, 'Meja12', '0', '120,00', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-26 06:18:54'),
(13, 'Meja13', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(14, 'Meja14', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(15, 'Meja15', '0', '120,00', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-26 06:19:45'),
(16, 'Meja16', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(17, 'Meja17', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(18, 'Meja18', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(19, 'Meja19', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:17'),
(20, 'Meja20', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(21, 'Meja21', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:17'),
(22, 'Meja22', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(23, 'Meja23', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2024-05-06 16:07:36'),
(24, 'Meja24', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2024-05-07 07:46:16'),
(25, 'Meja25', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(26, 'Meja26', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:17'),
(27, 'Meja27', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(28, 'Meja28', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(29, 'Meja29', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:13'),
(30, 'Meja30', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:17'),
(31, 'Meja31', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:08'),
(32, 'Meja32', '0', '0', '0', '0', 0, 'Kosong', 0, NULL, '2023-12-19 12:01:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `Id_Menu` bigint(20) UNSIGNED NOT NULL,
  `Nama_menu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `jenis` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`Id_Menu`, `Nama_menu`, `Harga`, `stok`, `jenis`, `created_at`, `updated_at`, `kategori`) VALUES
(2, 'Teh Tawar', 6000, 0, 'Tidak Update Stok', '2022-04-04 09:13:51', '2023-08-24 12:08:50', ''),
(4, 'Jeruk/Es Jeruk', 10000, 0, 'Tidak Update Stok', '2022-04-04 09:14:40', '2023-09-02 20:55:07', ''),
(5, 'Lemon Tea Hot / Cool', 15000, 0, 'Tidak Update Stok', '2022-04-04 09:14:54', '2023-10-10 07:48:49', ''),
(6, 'Soda Susu', 15000, 0, 'Tidak Update Stok', '2022-04-04 09:15:24', '2023-09-02 20:54:52', ''),
(18, 'Sprite', 8500, 28, 'Update Stok', '2022-04-04 09:19:06', '2023-11-29 09:55:55', ''),
(19, 'Frestea', 8000, 5, 'Update Stok', '2022-04-04 09:19:29', '2023-08-24 12:38:20', ''),
(20, 'Pulpy', 9090, 0, 'Tidak Update Stok', '2022-04-04 09:19:44', '2022-07-16 08:07:30', ''),
(42, 'Matcha Avocado Coffe Kosong', 9999, 0, 'Tidak Update Stok', '2022-04-04 09:27:45', '2023-08-24 11:46:30', ''),
(44, 'Cookies and Cream', 20000, 0, 'Tidak Update Stok', '2022-04-04 09:28:36', '2022-04-04 09:28:36', ''),
(64, 'Telor Ceplok', 6000, 0, 'Tidak Update Stok', '2022-04-04 09:38:09', '2023-08-24 12:32:52', ''),
(65, 'Coca cola Botol', 8500, 100, 'Update Stok', '2022-04-04 09:38:25', '2024-02-26 12:19:34', 'Minuman'),
(66, 'Fanta Straw botol', 8500, 12, 'Update Stok', '2022-04-04 09:39:05', '2023-10-04 07:57:32', ''),
(67, 'Good Day Mochacino 250ml', 10000, 6, 'Update Stok', '2022-04-04 09:39:22', '2023-08-24 12:26:07', ''),
(70, 'Good Day Cappucino 250ml', 10000, 5, 'Update Stok', '2022-04-04 14:29:49', '2023-08-24 12:24:43', ''),
(71, 'Minute Maid Pulpy Orange', 11000, 12, 'Update Stok', '2022-04-04 14:51:53', '2023-09-04 05:14:15', ''),
(74, 'Coca Cola Kaleng', 10000, 6, 'Update Stok', '2022-04-05 10:15:01', '2023-08-24 12:13:16', ''),
(77, 'Air Mineral', 7000, 15, 'Update Stok', '2022-04-05 11:52:18', '2024-05-02 11:16:45', ''),
(78, 'Lemon Squash', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:52:40', '2023-08-24 12:12:08', ''),
(79, 'Strawberry Squash', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:53:16', '2023-08-24 12:12:05', ''),
(81, 'Melon squash', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:53:55', '2023-08-24 12:12:02', ''),
(84, 'Mangga Squash', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:55:46', '2023-08-24 12:11:59', ''),
(85, 'Coctail Virgin', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:56:23', '2023-08-24 12:11:43', ''),
(86, 'Coctail Blue Moon', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:56:41', '2023-08-24 12:11:41', ''),
(87, 'Coctail Leccy', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:56:56', '2023-08-24 12:11:38', ''),
(88, 'Coctail Strawberry Field', 18000, 0, 'Tidak Update Stok', '2022-04-05 11:57:31', '2023-08-24 12:11:35', ''),
(89, 'Milo Hot / Cool', 12000, 0, 'Tidak Update Stok', '2022-04-06 08:26:40', '2023-08-24 12:11:15', ''),
(90, 'Coklat Hot / Cool', 16000, 0, 'Tidak Update Stok', '2022-04-06 08:27:20', '2023-08-24 11:47:33', ''),
(93, 'Susu Coklat/Putih', 12000, 9, 'Update Stok', '2022-04-06 08:29:27', '2023-12-04 03:02:34', ''),
(94, 'Milk Base Huzelnut', 20000, 0, 'Tidak Update Stok', '2022-04-06 08:29:53', '2023-08-24 12:10:51', ''),
(96, 'Milk Base Caramel', 20000, 0, 'Tidak Update Stok', '2022-04-06 08:30:43', '2023-08-24 12:10:48', ''),
(97, 'Milk Base Vanilla', 20000, 0, 'Tidak Update Stok', '2022-04-06 08:31:05', '2023-08-24 12:10:44', ''),
(98, 'Milk Base Strawberry', 20000, 0, 'Tidak Update Stok', '2022-04-06 08:31:28', '2023-08-24 12:10:41', ''),
(99, 'Milk Base Coco', 20000, 0, 'Tidak Update Stok', '2022-06-10 09:03:56', '2023-08-24 12:10:38', ''),
(100, 'Milk Base Original', 20000, 0, 'Tidak Update Stok', '2022-06-10 09:04:12', '2023-08-24 12:10:35', ''),
(101, 'Milk Base Green Tea', 20000, 0, 'Tidak Update Stok', '2022-06-10 09:04:32', '2023-08-24 12:10:32', ''),
(102, 'Milk Base Taro', 20000, 0, 'Tidak Update Stok', '2022-06-23 12:39:49', '2023-08-24 12:10:29', ''),
(103, 'Jeruk Nipis', 10000, 0, 'Tidak Update Stok', '2022-07-02 11:57:46', '2023-08-24 12:10:06', ''),
(114, 'Jus Buah Naga', 18000, 0, 'Tidak Update Stok', '2022-07-16 10:00:56', '2023-08-24 11:50:48', ''),
(115, 'Jus Strawberry', 18000, 0, 'Tidak Update Stok', '2022-07-16 10:01:07', '2023-08-24 11:50:45', ''),
(116, 'Jus Melon', 18000, 0, 'Tidak Update Stok', '2022-07-16 10:01:26', '2023-08-24 11:50:39', ''),
(118, 'Jus Mangga', 18000, 0, 'Tidak Update Stok', '2022-07-28 08:12:32', '2023-08-24 11:50:34', ''),
(119, 'Thai Tea Hot / Cool', 16000, 0, 'Tidak Update Stok', '2022-07-28 08:12:48', '2023-08-24 12:32:00', ''),
(120, 'Lemon Tea Hot / Cool', 13000, 0, 'Tidak Update Stok', '2022-07-28 08:14:04', '2023-08-24 12:31:38', ''),
(121, 'Teh Tarik - Leccy Tea', 15000, 0, 'Tidak Update Stok', '2022-07-28 08:14:26', '2023-08-24 12:09:00', ''),
(122, 'Teh Hot / Cool', 8000, 0, 'Tidak Update Stok', '2022-07-28 08:15:30', '2023-08-24 12:09:21', ''),
(123, 'Mochacino', 17000, 0, 'Tidak Update Stok', '2022-07-28 08:22:51', '2023-08-24 11:46:53', ''),
(124, 'Coffimix', 12000, 0, 'Tidak Update Stok', '2022-07-28 08:23:18', '2023-08-24 12:08:17', ''),
(125, 'Hazzelnut Coffee', 17000, 0, 'Tidak Update Stok', '2022-07-28 08:24:42', '2023-08-24 11:45:50', ''),
(126, 'Caramel Coffee', 17000, 0, 'Tidak Update Stok', '2022-07-28 08:24:56', '2023-08-24 11:45:19', ''),
(127, 'Vietnam Drip', 16000, 0, 'Tidak Update Stok', '2022-07-29 12:39:01', '2023-08-24 12:07:28', ''),
(128, 'Latte', 16000, 0, 'Tidak Update Stok', '2022-07-31 16:40:26', '2023-08-24 12:07:12', ''),
(129, 'Cappucino Hot / Cool', 15000, 0, 'Tidak Update Stok', '2022-08-18 12:05:52', '2023-08-24 12:06:22', ''),
(130, 'Americano Black Vanta', 15000, 0, 'Tidak Update Stok', '2022-08-18 13:53:53', '2023-08-24 12:32:26', ''),
(131, 'Black Coffee', 12000, 0, 'Tidak Update Stok', '2022-08-24 09:54:27', '2023-08-24 11:45:12', ''),
(132, 'Pisang Goreng Coklat Keju', 24000, 0, 'Tidak Update Stok', '2022-08-24 09:55:32', '2023-08-24 12:05:41', ''),
(133, 'Pisang Goreng Keju', 23000, 0, 'Tidak Update Stok', '2022-08-30 08:40:52', '2023-08-24 12:05:36', ''),
(134, 'Pisang Goreng Coklat', 21000, 0, 'Tidak Update Stok', '2022-08-30 08:41:28', '2023-08-24 12:05:13', ''),
(135, 'Roti Canai Telur Bombay', 26000, 0, 'Tidak Update Stok', '2022-08-30 08:42:30', '2023-08-24 12:04:43', ''),
(136, 'Roti Canai Telur', 25000, 0, 'Tidak Update Stok', '2022-08-30 08:42:51', '2023-08-24 12:04:54', ''),
(137, 'Roti Canai Coklat Keju', 25000, 0, 'Tidak Update Stok', '2022-08-30 08:43:30', '2023-08-24 12:04:32', ''),
(138, 'Roti Canai Keju', 25000, 0, 'Tidak Update Stok', '2022-09-03 08:19:53', '2023-08-24 12:04:28', ''),
(139, 'Roti Canai Coklat', 22000, 0, 'Tidak Update Stok', '2022-09-03 08:20:12', '2023-08-24 12:04:18', ''),
(140, 'Roti Canai Susu', 20000, 0, 'Tidak Update Stok', '2022-09-03 08:20:25', '2023-08-24 12:04:12', ''),
(141, 'Roti Maryam Coklat / Keju', 25000, 0, 'Tidak Update Stok', '2022-09-03 08:20:39', '2023-08-24 12:03:47', ''),
(143, 'Roti Maryam Keju', 24000, 0, 'Tidak Update Stok', '2022-09-03 08:21:44', '2023-08-24 12:03:41', ''),
(144, 'Roti Maryam Coklat', 22000, 0, 'Tidak Update Stok', '2022-09-03 08:22:14', '2023-08-24 12:03:31', ''),
(145, 'Roti Maryam Susu', 22000, 0, 'Tidak Update Stok', '2022-09-03 08:22:32', '2023-08-24 12:03:28', ''),
(146, 'Roti Bakar Coklat Keju', 24000, 0, 'Tidak Update Stok', '2022-09-03 08:22:52', '2023-08-24 12:02:15', ''),
(147, 'Roti Bakar Keju', 23000, 0, 'Tidak Update Stok', '2022-09-03 08:23:35', '2023-08-24 12:02:10', ''),
(148, 'Roti Bakar Coklat', 22000, 0, 'Tidak Update Stok', '2022-09-03 08:24:06', '2023-08-24 12:02:05', ''),
(149, 'Snack Platter (Kentang,Sosis,Nugget)', 25000, 0, 'Tidak Update Stok', '2022-09-03 08:24:36', '2023-08-24 12:01:10', ''),
(150, 'Kebab Mini', 15000, 0, 'Tidak Update Stok', '2022-09-03 16:38:29', '2023-08-24 12:00:40', ''),
(151, 'Burger', 17500, 0, 'Tidak Update Stok', '2022-09-10 10:48:53', '2023-08-24 12:00:27', ''),
(152, 'Martabak Mie', 16000, 0, 'Tidak Update Stok', '2022-11-04 13:31:00', '2023-08-24 12:00:10', ''),
(153, 'Tahu bakso', 16000, 0, 'Tidak Update Stok', '2022-11-07 09:43:03', '2023-08-24 12:00:04', ''),
(154, 'Tahu Goreng', 16000, 0, 'Tidak Update Stok', '2022-11-14 15:33:50', '2023-08-24 11:59:57', ''),
(155, 'Tempe Goreng', 16000, 0, 'Tidak Update Stok', '2022-11-23 09:26:07', '2023-08-24 11:59:51', ''),
(156, 'Risol', 15000, 0, 'Tidak Update Stok', '2022-11-23 09:30:30', '2023-08-24 11:59:15', ''),
(157, 'Cireng', 15000, 0, 'Tidak Update Stok', '2022-11-23 09:34:44', '2023-08-24 11:59:09', ''),
(158, 'Nugget', 15000, 0, 'Tidak Update Stok', '2022-11-23 11:44:08', '2023-08-24 11:58:52', ''),
(159, 'French Fries Keju', 20000, 0, 'Tidak Update Stok', '2022-12-18 10:19:30', '2023-08-24 11:58:40', ''),
(160, 'French Fries Original', 17500, 0, 'Tidak Update Stok', '2023-02-09 11:00:45', '2023-08-24 11:58:25', ''),
(161, 'Mie Geprek ( Nasi Mie Telur )', 24000, 0, 'Tidak Update Stok', '2023-02-09 11:01:12', '2023-08-24 11:49:48', ''),
(162, 'Bakmi Goreng Spesial', 24000, 0, 'Tidak Update Stok', '2023-02-09 11:01:23', '2023-08-24 11:49:35', ''),
(163, 'Bakmi Godog', 22000, 0, 'Tidak Update Stok', '2023-02-09 11:01:37', '2023-08-24 11:49:28', ''),
(164, 'Nasi Goreng Magelangan', 25000, 0, 'Tidak Update Stok', '2023-02-09 11:02:00', '2023-08-24 11:48:54', ''),
(165, 'Nasi Goreng Spesial', 23000, 0, 'Tidak Update Stok', '2023-02-17 08:22:13', '2023-08-24 11:48:48', ''),
(167, 'Nasi Goreng Rempah', 24000, 0, 'Tidak Update Stok', '2023-03-17 08:29:29', '2023-08-24 11:48:41', ''),
(169, 'Nasi Goreng Kari', 24000, 0, 'Tidak Update Stok', '2023-04-25 15:45:25', '2023-08-24 11:48:36', ''),
(170, 'Nasi Goreng Jawa', 22000, 0, 'Tidak Update Stok', '2023-04-30 14:37:15', '2023-08-24 11:48:29', ''),
(173, 'Nasi Kebuli Kambing', 38000, 0, 'Tidak Update Stok', '2023-05-06 11:50:29', '2023-08-24 11:57:59', ''),
(174, 'Nasi Kebuli Ayam', 28000, 0, 'Tidak Update Stok', '2023-05-06 11:50:50', '2023-08-24 11:57:51', ''),
(175, 'Nasi Kebuli Telur', 19000, 0, 'Tidak Update Stok', '2023-05-07 13:53:50', '2023-08-24 11:57:36', ''),
(176, 'Nasi Kebuli Polos', 16000, 0, 'Tidak Update Stok', '2023-05-07 13:54:33', '2023-08-24 11:57:26', ''),
(177, 'Nasi Putih', 7500, 0, 'Tidak Update Stok', '2023-05-21 12:53:33', '2023-08-24 11:57:14', ''),
(178, 'Nasi Iso', 24000, 0, 'Tidak Update Stok', '2023-05-21 12:54:25', '2023-08-24 11:56:58', ''),
(179, 'Nasi Paru', 24000, 0, 'Tidak Update Stok', '2023-06-11 13:40:21', '2023-08-24 11:56:52', ''),
(180, 'Nasi Ayam Lombok Ijo', 25000, 0, 'Tidak Update Stok', '2023-06-15 15:34:44', '2023-08-24 11:56:39', ''),
(182, 'Nasi Ayam Goreng', 25000, 0, 'Tidak Update Stok', '2023-08-21 09:58:22', '2023-08-24 11:56:33', ''),
(183, 'LA Light', 36000, 0, 'Tidak Update Stok', '2023-08-23 09:54:15', '2023-11-09 03:58:54', ''),
(184, 'LA Menthol', 33000, 0, 'Tidak Update Stok', '2023-08-23 09:54:43', '2023-11-09 03:59:25', ''),
(185, 'LA Ice', 36000, 0, 'Tidak Update Stok', '2023-08-23 09:54:58', '2023-11-09 03:58:46', ''),
(186, 'LA Bold 20', 39000, 0, 'Tidak Update Stok', '2023-08-23 09:55:14', '2023-11-09 03:59:17', ''),
(187, 'LA Bold 12', 25000, 0, 'Tidak Update Stok', '2023-08-23 09:55:30', '2023-08-24 11:55:33', ''),
(188, 'Djarum Super 12', 30000, 0, 'Tidak Update Stok', '2023-08-23 09:55:50', '2023-11-10 03:17:22', ''),
(189, 'Djarum Super 16', 34000, 0, 'Tidak Update Stok', '2023-08-23 09:56:01', '2023-11-09 04:00:54', ''),
(190, 'Djarum Black (Filter, Cappucino)', 31000, 0, 'Tidak Update Stok', '2023-08-23 09:56:23', '2023-11-09 03:59:07', ''),
(191, 'Djarum Super WAVE 12', 22000, 0, 'Tidak Update Stok', '2023-08-23 09:56:37', '2023-11-09 04:00:40', ''),
(192, 'Djarum MLD 20', 37000, 0, 'Tidak Update Stok', '2023-08-23 09:56:56', '2023-11-09 04:00:34', ''),
(193, 'Djarum MLD 16', 32000, 0, 'Tidak Update Stok', '2023-08-23 09:57:11', '2023-11-09 04:00:20', ''),
(194, 'Djarum MLD 12', 25000, 0, 'Tidak Update Stok', '2023-08-23 09:57:24', '2023-11-09 04:00:12', ''),
(195, 'Korek Api', 6000, 0, 'Tidak Update Stok', '2023-08-23 09:57:37', '2023-08-24 11:53:15', ''),
(196, 'LA Purple', 36000, 0, 'Tidak Update Stok', '2023-08-23 14:10:15', '2023-11-09 03:58:02', ''),
(197, 'Sampoerna MILD', 35000, 0, 'Tidak Update Stok', '2023-08-23 15:02:33', '2023-08-24 11:52:56', ''),
(198, 'ESSE Change Blue', 38000, 0, 'Tidak Update Stok', '2023-08-23 15:06:25', '2023-08-24 11:52:46', ''),
(199, 'Rokok Signature', 29000, 0, 'Update Stok', '2023-08-23 15:07:14', '2023-12-09 13:18:19', 'Makanan'),
(200, 'Rokok Filter', 29000, 0, 'Tidak Update Stok', '2023-08-23 15:07:24', '2023-08-24 11:52:23', ''),
(201, 'Djarum Super', 30000, 0, 'Tidak Update Stok', '2023-08-23 15:07:50', '2023-11-09 04:00:06', ''),
(202, 'Sarung tangan', 35000, 100, 'Tidak Update Stok', '2023-08-24 08:28:59', '2023-08-24 08:28:59', ''),
(203, 'Pocari sweat 500 ml', 10000, 6, 'Update Stok', '2023-08-25 07:31:42', '2023-09-01 12:18:57', ''),
(204, 'Telur Ceplok', 5000, 0, 'Tidak Update Stok', '2023-08-25 08:21:23', '2023-09-01 12:19:37', ''),
(205, 'You-C 1000', 12000, 12, 'Tidak Update Stok', '2023-08-25 16:57:42', '2023-08-25 16:57:42', ''),
(206, 'Telor dadar', 5000, 0, 'Tidak Update Stok', '2023-08-25 18:56:42', '2023-09-01 12:19:19', ''),
(207, 'ES Batu', 2000, 0, 'Tidak Update Stok', '2023-09-04 05:14:59', '2023-09-04 05:14:59', ''),
(208, 'Air Es / hangat', 4000, 0, 'Tidak Update Stok', '2023-09-04 05:15:42', '2023-09-04 05:15:42', ''),
(209, 'Nutriboost Strawberry', 9000, 12, 'Update Stok', '2023-09-04 07:43:50', '2023-09-04 07:45:02', ''),
(210, 'Nutriboost Orange', 9000, 12, 'Update Stok', '2023-09-04 07:44:12', '2023-09-04 07:44:50', ''),
(211, 'On Bold', 28000, 12, 'Update Stok', '2023-09-28 09:35:51', '2023-10-16 13:52:35', ''),
(213, 'Fanta Orange Botol', 8500, 0, 'Tidak Update Stok', '2023-10-04 07:57:00', '2023-10-04 07:57:00', ''),
(214, 'Rokok On Line', 28000, 0, 'Tidak Update Stok', '2023-10-18 13:38:01', '2023-10-18 13:38:01', ''),
(215, 'Green Sand', 12000, 0, 'Tidak Update Stok', '2023-11-01 08:19:54', '2023-11-01 08:19:54', ''),
(217, 'Susu Putih', 12, 1, 'Update Stok', '2023-12-04 08:25:53', '2023-12-04 08:25:53', 'Makanan'),
(218, 'Marlboro Merah', 48000, 10, 'Update Stok', '2023-12-08 02:08:04', '2023-12-08 02:08:04', 'Makanan'),
(219, 'Esse Juice', 38000, 6, 'Update Stok', '2023-12-08 02:08:43', '2023-12-08 02:08:43', 'Makanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_01_12_044938_create_meja_table', 2),
(6, '2022_01_12_045248_create_menu_table', 2),
(7, '2022_01_12_045408_create_pesanan_table', 2),
(8, '2022_01_12_054407_create_pesanan_detail_table', 2),
(9, '2022_01_12_054916_create_mejabiliard_table', 2),
(10, '2022_01_12_055315_create_paketbiliard_table', 3),
(11, '2022_01_12_055427_create_order_biliard_table', 4),
(12, '2022_01_12_055844_create_orderbiliarddetail_table', 5),
(13, '2014_10_12_200000_add_two_factor_columns_to_users_table', 6),
(14, '2022_01_12_081630_create_sessions_table', 6),
(15, '2022_01_14_134335_update_order_biliard_table', 7),
(16, '2022_01_18_052626_update_pesanan_table', 8),
(17, '2022_03_07_180831_update_paket_billiard', 9),
(18, '2023_07_24_174919_create_log_sensor_table', 10),
(19, '2023_07_24_175826_create_log_sensor_table', 11),
(20, '2023_07_25_071439_create_log_sensor_table', 12),
(21, '2023_07_25_085915_create_log_sensor_table', 13),
(22, '2023_07_25_110632_add_type_to_paketbiliard_table', 14),
(23, '2023_07_26_094049_create_log_hapus_barang_table', 15),
(26, '2023_08_06_100453_add_id_cabang_to_order_biliard_table', 16),
(27, '2023_08_06_100537_add_id_cabang_to_log_hapus_barang_table', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orderbiliarddetail`
--

CREATE TABLE `orderbiliarddetail` (
  `id_order_biliard_detail` bigint(20) UNSIGNED NOT NULL,
  `id_order_biliard` int(11) NOT NULL,
  `id_paket_biliard` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `menit` decimal(12,2) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `seting` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` tinyint(4) NOT NULL,
  `cabang_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_biliard`
--

CREATE TABLE `order_biliard` (
  `id_order_biliard` bigint(20) UNSIGNED NOT NULL,
  `id_meja_biliard` int(11) NOT NULL,
  `totaljam` decimal(8,2) NOT NULL,
  `diskon` int(11) NOT NULL,
  `totalharga` decimal(10,2) NOT NULL,
  `totalbayar` decimal(10,2) NOT NULL,
  `diterima` int(11) NOT NULL,
  `kembali` decimal(10,2) NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalflag` int(11) NOT NULL,
  `customer` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_pesanan` int(11) NOT NULL,
  `uuid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waiter_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paketbiliard`
--

CREATE TABLE `paketbiliard` (
  `id_paket_biliard` bigint(20) UNSIGNED NOT NULL,
  `nama_paket` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `durasi` int(11) NOT NULL,
  `keterangan` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `paketbiliard`
--

INSERT INTO `paketbiliard` (`id_paket_biliard`, `nama_paket`, `harga`, `durasi`, `keterangan`, `created_at`, `updated_at`, `type`) VALUES
(47, 'Siang Regular', 35000, 60, 'Siang', '2023-08-22 06:58:03', '2023-08-22 06:58:03', 'siang'),
(48, 'Malam Regular', 40000, 60, 'Malam', '2023-08-22 06:58:40', '2023-08-22 06:58:40', 'malam'),
(49, 'Joy Malam', 60000, 60, 'Meja Joy', '2023-08-22 06:58:56', '2023-08-22 15:25:38', 'malam'),
(50, 'Joy Siang', 50000, 60, 'Meja Joy', '2023-08-22 06:59:11', '2023-08-22 07:00:03', 'siang'),
(51, 'Free', 0, 60, 'Free', '2023-08-22 06:59:24', '2023-08-22 06:59:24', 'custom'),
(52, 'Maintenance', 0, 60, 'Maintenance', '2023-08-22 06:59:35', '2023-08-22 06:59:44', 'custom'),
(53, '2 Jam Gratis 1 Jam', 35000, 120, '2 Jam Gratis 1 Jam', '2023-08-22 07:02:21', '2023-11-13 20:12:28', 'custom'),
(55, '1Jam Free 1 Jam', 35000, 120, '1 Jam Free 1 Jam', '2023-08-29 05:28:23', '2023-11-15 06:05:59', 'siang'),
(56, '2 Jam Free 1 Jam', 80000, 180, '2 Jam Free 1 Jam Malam', '2023-08-29 14:11:50', '2023-11-15 06:06:20', 'malam'),
(57, 'Ladies Free', 0, 60, 'Ladies Free', '2023-09-01 07:12:54', '2023-09-01 07:12:54', 'custom'),
(58, 'Paket Malam Free Kopi/Teh 2 Gls per Meja', 40000, 60, 'Open Table Start Jam 01.00 - CLose', '2023-09-11 07:25:07', '2023-09-11 07:25:07', 'malam'),
(60, 'PAKET PROMO 2 JAM 50K', 50000, 120, 'PROMO 2 JAM 50K', '2023-11-01 05:09:00', '2023-11-01 05:09:00', 'siang'),
(61, 'Paket Private Coach', 200000, 120, 'Free es teh / mineral', '2023-11-09 08:20:57', '2023-11-09 08:20:57', 'siang'),
(62, '6 Menit', 4000, 6, 'jam tambahan sampe close', '2023-11-13 20:08:50', '2023-11-13 20:08:50', 'malam'),
(63, '12 Menit', 8000, 12, 'jam tambahan', '2023-11-13 20:09:12', '2023-11-13 20:09:12', 'malam'),
(64, '18 Menit', 12000, 18, 'jam tambahan', '2023-11-13 20:09:28', '2023-11-13 20:09:33', 'malam'),
(65, '24 Menit', 16000, 24, 'jam tambahan', '2023-11-13 20:09:49', '2023-11-13 20:09:49', 'malam'),
(66, '30 Menit', 20000, 30, 'jam tambahan', '2023-11-13 20:10:16', '2023-11-13 20:10:16', 'malam'),
(67, '15 Menit', 10000, 15, 'jam Tambahan', '2023-11-13 20:10:39', '2023-11-13 20:10:39', 'malam'),
(69, 'Malam Minggu Regular', 45000, 60, 'Khusus Malam Minggu', '2023-12-02 04:41:54', '2023-12-02 04:41:54', 'malam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `Id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `Id_meja` int(11) NOT NULL,
  `TotalItem` int(11) NOT NULL,
  `TotalHarga` int(11) NOT NULL,
  `Diskon` int(11) NOT NULL,
  `ppn` int(11) DEFAULT NULL,
  `TotalBayar` int(11) NOT NULL,
  `Diterima` int(11) NOT NULL,
  `Kembali` int(11) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waiter_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_pesanan_detail` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `cabang_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CNnntMErmFxpmamgiLwupGD6qIhCA1UyU9vtxazS', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVjh4eVRuTXNrVzducDNzQVlRT2NZREFHanB2RjNaYWFXNGI3NE5GQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAwOiJodHRwOi8vbG9jYWxob3N0L2Rza3ktYWRtaW4ta2FzaXIvcHVibGljL2xhcG9yYW4vZXhjZWwtYmlsaWFyZC8yMDI0LTA1LTA3JTIwMDA6MDAvMjAyNC0wNS0wNyUyMDIzOjU5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCR0RmFYTHNZbTEvUmI3aU5EN21FMlMua1h6V0pLVks1YXVXLktJbXpqbFplcTd3WTRyVUU2dSI7fQ==', 1715068012),
('2N45P52BLjxQvVYzk1AvLrqBHLxSSgekUBlSjqbc', 5, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVUh6cFBCN3VQNlplUjVONXptYVpYOElJamFFNXBUaGZub2FoTUczZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9sb2NhbGhvc3QvZHNreS1hZG1pbi1rYXNpci9wdWJsaWMvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJhJDEyJHpiRTdDQ0EyaEJNdG5aaHdJUG1qMS5FcktNbmJvRXNwUXpKSnZKTUV3Sk1JQ1dWZ3Zrb1hLIjt9', 1715072834),
('zhl6QHQqZwbFTh52cf7c9Jd60vuW7otikwZnC64Z', 5, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRURjUkFidDZ5bnFUN0pEQWRFOVRPYUQ0Szd2WVVxcW1VaWJBckE2aSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly9sb2NhbGhvc3QvZHNreS1hZG1pbi1rYXNpci9wdWJsaWMvb3JkZXJiaWxpYXJkL2NldGFrLzI2MDEzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJhJDEyJHpiRTdDQ0EyaEJNdG5aaHdJUG1qMS5FcktNbmJvRXNwUXpKSnZKTUV3Sk1JQ1dWZ3Zrb1hLIjt9', 1715327485),
('NQoMbJUOrNSbnWL9kdViy14D3yh4nFPsqx244kjb', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidEFFQUI4OERDOVJ2MEE1WUxXdHpXeW9KMmhrMEtRRGJzbHJjRDV1NCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1715687609),
('DPyhz3tSyt8arjwetlETt3cDarx8var4ZujXoR0J', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVUVqeG1xRkhpMVh4aFlldENlRkdWbHJ6N0dxUmlDMDB2TTJCWlJOMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9sb2NhbGhvc3QvZHNreS1hZG1pbi1rYXNpci9wdWJsaWMvbGFwb3JhbmJpbGlhcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJHRGYVhMc1ltMS9SYjdpTkQ3bUUyUy5rWHpXSktWSzVhdVcuS0ltempsWmVxN3dZNHJVRTZ1Ijt9', 1721375564);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `level`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`, `cabang_id`) VALUES
(1, 'kasir', 'kasir@gmail.com', NULL, '$2y$10$yFz5MiXg3ntwMU4Od269c.Qg1NPB4LV9dC5vNN1FHrr4SDBQHHvvO', 1, NULL, NULL, NULL, '2022-01-12 04:21:21', '2024-03-16 09:23:45', 'cilacap_1'),
(3, 'Admin', 'admin@gmail.com', NULL, '$2y$10$SmdYUkJYIBDVArh093Ga1ORNjEb5bsd6P6pWLOYENRUokca/eukwe', 2, NULL, NULL, NULL, '2022-04-02 03:23:22', '2023-10-10 10:49:19', 'cilacap_1'),
(4, 'Sensen', 'sensen@gmail.com', NULL, '$2y$10$SmdYUkJYIBDVArh093Ga1ORNjEb5bsd6P6pWLOYENRUokca/eukwe', 3, NULL, NULL, NULL, '2022-04-02 03:23:22', '2023-12-09 04:06:25', 'cilacap_1'),
(5, 'cashier', 'cashier@gmail.com', NULL, '$2a$12$zbE7CCA2hBMtnZhwIPmj1.ErKMnboEspQzJJvJMEwJMICWVgvkoXK', 1, NULL, NULL, NULL, '2022-04-02 03:23:22', '2024-05-10 07:51:04', 'cilacap_1'),
(6, 'kitchen', 'kitchen@gmail.com', NULL, '$2a$12$kByu.qOiT.me5tENRjMSyuB.u2mxlMOKaHQ0mcNYp.k4LmsEt9JD6', 5, NULL, NULL, NULL, '2022-04-02 03:23:22', '2023-08-29 06:13:07', 'cilacap_1'),
(7, 'manager', 'manager@gmail.com', NULL, '$2a$12$K/QBXn3jsZFjhyBvMBx1Wuh4Pce7CJxxGoV2.Aoyo3tnWg1hIVCIa', 4, NULL, NULL, NULL, '2022-04-02 03:23:22', '2024-05-02 04:16:47', 'cilacap_1'),
(8, 'waiters', 'waiters@gmail.com', NULL, '$2y$10$nkgDPxfcKfKHtTOII/R6oe6kZwyPupg2IjFyJaWWDcg6VRYfNKPdC', 6, NULL, NULL, NULL, '2022-04-02 03:23:22', '2023-08-29 09:24:23', 'cilacap_1'),
(10, 'admin 2', 'admin2@gmail.com', NULL, '$2y$10$931EkC9Pu5wKu5zMvTwPlOvnAmfDQxznN4Ur5hJ792Mtp2r5kpA2m', 2, NULL, NULL, NULL, '2023-08-20 02:59:42', '2023-09-02 20:51:13', 'Jogja Billiard'),
(11, 'uud', 'uud@gmail.com', NULL, '$2y$10$tFaXLsYm1/Rb7iND7mE2S.kXzWJKVK5auW.KImzjlZeq7wY4rUE6u', 3, NULL, NULL, NULL, '2023-08-21 11:08:54', '2024-07-19 07:49:19', 'Jogja Billiard'),
(12, 'uud2', 'uud2@gmail.com', NULL, '$2y$10$jiTYsdYR/bH6ouNORWQgsu9D94r6IaJlOdkshpNI8piIzIg/umHLq', 1, NULL, NULL, NULL, '2023-08-21 11:09:47', '2023-08-23 05:38:05', 'Jogja Billiard'),
(13, 'ayu', 'ayuwanghu032@gmail.com', NULL, '$2y$10$WAQAVvY7uO39Ne6Pu763H.GUHGNzhtGmQm1EEjGDy6qN9GnAae/6m', 1, NULL, NULL, NULL, '2023-08-22 04:45:36', '2023-12-07 12:31:17', 'Jogja Billiard'),
(18, 'ika', 'ikamutiara@gmail.com', NULL, '$2y$10$0A5cvSG/wYRKCPI7O9fx8eDvWf3fO3qpVP3edgA8Q45Lbedyj2oX6', 4, NULL, NULL, NULL, '2023-08-22 05:17:44', '2023-12-09 09:50:25', 'Jogja Billiard'),
(19, 'mutiara', 'mutiarani@gmail.com', NULL, '$2y$10$gAD.nnl0iAmgqk.bY87bOO1G3IIZq1NTA1UP6BkqzeoFncbrRdZqi', 2, NULL, NULL, NULL, '2023-08-22 05:44:15', '2023-09-06 15:42:28', 'Jogja Billiard'),
(22, 'Andri Givano', 'andri@gmail.com', NULL, '$2y$10$dxS/4hs04oDoSKgsDcMnzOEQ3KFYGXZoZW8r9Wvc1akqTQ/66muM2', 6, NULL, NULL, NULL, '2023-08-22 06:31:58', '2023-08-24 17:42:25', 'Jogja Billiard'),
(23, 'pikren piberwan', 'pikren@gmail.com', NULL, '$2y$10$9hSkQfj.Ps0ZdaANFLRvHefO7ldN2D0xz4IKshXywNB5OBLwNgC2O', 6, NULL, NULL, NULL, '2023-08-22 06:32:39', '2023-08-22 06:32:39', 'Jogja Billiard'),
(24, 'fahreza', 'fahreza@gmail.com', NULL, '$2y$10$JuFtu.mESWRAjcXA1f2dwuGKxuY2iydSFFQJGU2U/sFBaFYkEKzPK', 5, NULL, NULL, NULL, '2023-08-22 06:43:19', '2023-08-22 06:45:57', 'Jogja Billiard'),
(25, 'faid', 'faid@gmail.com', NULL, '$2y$10$o9SQYUzbRr2XV7THRkk3U.d.DSK6ZVHs77NOyFHGCRcloay9FGRK6', 5, NULL, NULL, NULL, '2023-08-22 06:43:48', '2023-08-22 06:53:52', 'Jogja Billiard'),
(26, 'wati', 'wati@gmail.com', NULL, '$2y$10$xoiyrZ4GTAACUPMwR0RUl.n3lVpR0vc6qrVL/vROhZzlOzHCnlv7W', 5, NULL, NULL, NULL, '2023-08-22 06:50:51', '2023-08-22 06:50:51', 'Jogja Billiard'),
(28, 'rama', 'rama@gmail.com', NULL, '$2y$10$9WHNiCL8me9NwCl3GOp7Oe5pN2OXZ/FdhP8w.8DY8tvURNZii8mYu', 4, NULL, NULL, NULL, '2023-08-23 19:45:29', '2023-08-26 09:24:45', 'Jogja Billiard'),
(29, 'Wahyu', 'wahyu@gmail.com', NULL, '$2y$10$OiNHAQNMHVcAxIzI9P/YA.FVbCMNiciF6e3fvi7XpMlChN/XniihO', 3, NULL, NULL, NULL, '2023-08-30 04:17:35', '2023-08-30 04:20:24', 'Jogja Billiard'),
(31, 'Diva Yusania Putri', 'dipayusania@gmail.com', NULL, '$2y$10$huqjFPmNnRrV1liG25FWaO4qB9tlYlrHcxnqZs3vC3tbucOoCE3aC', 1, NULL, NULL, NULL, '2023-09-01 08:24:37', '2023-09-03 11:54:58', 'Jogja Billiard'),
(32, 'Aida Novita', 'novita@gmail.com', NULL, '$2y$10$guHVXszKe8cC/f5iRGeeGuR8dZrshiaLT5piSUbrvGj5txPPfoP7a', 1, NULL, NULL, NULL, '2023-09-03 05:21:14', '2023-12-09 13:37:03', 'Jogja Billiard'),
(35, 'ramadhan', 'ramadhan@gmail.com', NULL, '$2y$10$azhSjex37xz82jgi8BhEou94nzQdoPkJkrfPSZXNpi3HC0svVhS7O', 1, NULL, NULL, NULL, '2023-09-23 10:39:20', '2023-09-23 10:39:49', 'Jogja Billiard'),
(36, 'M Andri Ashari', 'm.andri.ashari@gmail.com', NULL, '$2y$10$MQN94ucB9n7a1P3IcFeoue8a/IldhSqKLakcrn/dLjvSGg34VUb1.', 3, NULL, NULL, NULL, '2023-09-24 04:48:00', '2023-12-04 07:49:03', 'Jogja Billiard'),
(37, 'Arista Harundja Banyo', 'aristaharunja@gmail.com', NULL, '$2y$10$f3WRPobPq.Vl9rU3uSBuVuVglLyzqnCi5tGmGuCmiRwt50vb9jUbe', 1, NULL, NULL, NULL, '2023-09-24 04:49:12', '2023-12-09 11:56:26', 'Jogja Billiard'),
(43, 'Egy Fauzan Perdana', 'egyfp@gmail.com', NULL, '$2y$10$fP7V6E9PCsE//mS2r4pejOTUTRnMpseKsYVxyN9jIKi5nUBl3iDsS', 3, NULL, NULL, NULL, '2023-10-10 10:01:20', '2023-12-05 19:27:33', 'Jogja Billiard'),
(45, 'egy fauzan perdana', 'egyfp77@gmail.com', NULL, '$2y$10$qJpjmPWpHWC2MYZkcoMEBetiy7oUILwFya7P3Y7uNgMWrvEe12yvK', 2, NULL, NULL, NULL, '2023-10-10 10:42:26', '2023-12-02 04:40:46', 'Jogja Billiard'),
(48, 'Egy Fauzan Perdana', 'egyfp58@gmail.com', NULL, '$2y$10$n9evskPyCI3C9eTqgEt1teI3laTb/Go6nrMM5y4bVEVouyGCvLayW', 1, NULL, NULL, NULL, '2023-10-25 04:51:26', '2023-12-05 19:56:43', 'Jogja Billiard'),
(50, 'Kartika Rizkia', 'rizkiar856@gmail.com', NULL, '$2y$10$1oISsBKG66.TjH91BePV5OtEa2Lg.cDQ27qRtGp38QZP01w80.8VC', 1, NULL, NULL, NULL, '2023-10-29 11:55:37', '2023-12-08 11:54:02', 'Jogja Billiard'),
(51, 'm sufyan juliandi indra jaya', 'jayajgok12345@gmail.com', NULL, '$2y$10$3nZhlPCAjtvGRt2k9MyY9.jHdC7aHa/oT9//IMCnvl1xLfkcMbiQ.', 2, NULL, NULL, NULL, '2023-11-01 08:34:04', '2023-12-09 06:06:55', 'Jogja Billiard'),
(55, 'Egy Fauzan P', 'egyfp058@gmail.com', NULL, '$2y$10$VhbymyGRS0BRNk5OLO0WdeObsbBuFyOtQjAqhtDwBLkEebYKP3sEe', 4, NULL, NULL, NULL, '2023-11-02 13:52:01', '2023-12-05 12:50:07', 'Jogja Billiard'),
(56, 'Herfinda Nur Aidy', 'findaaidy@gmail.com', NULL, '$2y$10$I9/j0oi4BrWYDKvElJJyx.MQebLqHUsHazu/P.IygLctFWpOtwExq', 1, NULL, NULL, NULL, '2023-11-05 11:25:50', '2023-12-09 13:35:46', 'Jogja Billiard'),
(57, 'Netania Christiani', 'netaniach@gmail.com', NULL, '$2y$10$4uUM4hkVp9Y02m6M6Ykw0.7wzhRdgpFb42yPEppV6MUbr3g87qBUy', 2, NULL, NULL, NULL, '2023-11-22 03:06:31', '2023-11-22 03:06:31', 'Jogja Billiard'),
(58, 'Yoga', 'fchyoga@gmail.com', NULL, '$2y$10$DWNEUMpGTPV0VkWXt2ikJO0D5hpWYuICqsy3VDxd1BDAdCmnecivu', 2, NULL, NULL, NULL, '2023-11-23 03:13:08', '2023-12-04 07:45:49', 'Jogja Billiard'),
(61, 'Yoga', 'fchyoga2@gmail.com', NULL, '$2y$10$569kn/L8bOXv3ht8cN3.AOF/6ZMOvnWc9eJmaBWVjsYu2FPeIPT4m', 4, NULL, NULL, NULL, '2023-11-23 03:16:23', '2023-11-23 03:16:23', 'Jogja Billiard'),
(62, 'Andri', 'm.andri.ashari2@gmail.com', NULL, '$2y$10$xXkFWyu3lEILdZrPq8baJedOFkh1.qZHlJPjypja1l/lFPNW57jqi', 2, NULL, NULL, NULL, '2023-11-23 06:35:06', '2023-11-23 06:35:06', 'Jogja Billiard'),
(84, 'Jaya', 'jayajgok1234@gmail.com', NULL, '$2y$10$kl.C7B3P9.XCNuAl97MLHOoPQhAeliZG54KCxHN/4JqbVBFlWHviS', 4, NULL, NULL, NULL, '2023-12-03 07:11:31', '2023-12-05 08:42:08', 'Jogja Billiard'),
(86, 'Test Manager', 'yoga@gmail.com', NULL, '$2y$10$DuGTxH0vXog4ZDTS9HE00.enzBXsj5Xdmb98Eetag0if0jBlR7tzq', 4, NULL, NULL, NULL, '2023-12-04 07:49:39', '2023-12-04 07:49:55', 'Jogja Billiard'),
(88, 'Neta', 'Netania@gmail.com', NULL, '$2y$10$xjzdzF7hZrY5S2BGZR9WBO3jyx6Q0hsT50OT7Df/MMGau/aC/KXl6', 1, NULL, NULL, NULL, '2023-12-05 04:04:04', '2023-12-08 12:51:37', 'Jogja Billiard'),
(92, 'ika', 'ikamutiarani@gmail.com', NULL, '$2y$10$NP8LM1cRbFUQjRRpDlD1k.EnWREltOWypSsBXkf.wKTvqzvFjJZiG', 1, NULL, NULL, NULL, '2023-12-09 04:08:35', '2023-12-09 04:23:05', 'Jogja Billiard');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cron_history`
--
ALTER TABLE `cron_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `log_hapus_barang`
--
ALTER TABLE `log_hapus_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_sensor`
--
ALTER TABLE `log_sensor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`),
  ADD UNIQUE KEY `meja_id_meja_unique` (`id_meja`);

--
-- Indeks untuk tabel `mejabiliard`
--
ALTER TABLE `mejabiliard`
  ADD PRIMARY KEY (`id_meja_biliard`),
  ADD UNIQUE KEY `mejabiliard_id_meja_biliard_unique` (`id_meja_biliard`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Id_Menu`),
  ADD UNIQUE KEY `menu_id_menu_unique` (`Id_Menu`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orderbiliarddetail`
--
ALTER TABLE `orderbiliarddetail`
  ADD PRIMARY KEY (`id_order_biliard_detail`),
  ADD UNIQUE KEY `orderbiliarddetail_id_order_biliard_detail_unique` (`id_order_biliard_detail`);

--
-- Indeks untuk tabel `order_biliard`
--
ALTER TABLE `order_biliard`
  ADD PRIMARY KEY (`id_order_biliard`),
  ADD UNIQUE KEY `order_biliard_id_order_biliard_unique` (`id_order_biliard`);

--
-- Indeks untuk tabel `paketbiliard`
--
ALTER TABLE `paketbiliard`
  ADD PRIMARY KEY (`id_paket_biliard`),
  ADD UNIQUE KEY `paketbiliard_id_paket_biliard_unique` (`id_paket_biliard`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`Id_pesanan`),
  ADD UNIQUE KEY `pesanan_id_pesanan_unique` (`Id_pesanan`);

--
-- Indeks untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_pesanan_detail`),
  ADD UNIQUE KEY `pesanan_detail_id_pesanan_detail_unique` (`id_pesanan_detail`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cron_history`
--
ALTER TABLE `cron_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_hapus_barang`
--
ALTER TABLE `log_hapus_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_sensor`
--
ALTER TABLE `log_sensor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT untuk tabel `mejabiliard`
--
ALTER TABLE `mejabiliard`
  MODIFY `id_meja_biliard` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `Id_Menu` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `orderbiliarddetail`
--
ALTER TABLE `orderbiliarddetail`
  MODIFY `id_order_biliard_detail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `order_biliard`
--
ALTER TABLE `order_biliard`
  MODIFY `id_order_biliard` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `paketbiliard`
--
ALTER TABLE `paketbiliard`
  MODIFY `id_paket_biliard` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `Id_pesanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_pesanan_detail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
