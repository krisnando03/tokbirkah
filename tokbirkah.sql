-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Apr 2026 pada 16.20
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokbirkah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `status_kehadiran` enum('hadir','izin','sakit','alpha','cuti','terlambat') NOT NULL DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  `lokasi_masuk` varchar(255) DEFAULT NULL,
  `lokasi_keluar` varchar(255) DEFAULT NULL,
  `total_jam_kerja` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `karyawan_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `status_kehadiran`, `keterangan`, `lokasi_masuk`, `lokasi_keluar`, `total_jam_kerja`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-03-24', '08:29:00', '17:17:00', 'terlambat', NULL, NULL, NULL, 528, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(2, 2, '2026-03-24', '08:54:00', '17:15:00', 'terlambat', NULL, NULL, NULL, 501, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(3, 3, '2026-03-24', '08:06:00', '17:12:00', 'hadir', NULL, NULL, NULL, 546, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(4, 4, '2026-03-24', '08:04:00', '17:11:00', 'hadir', NULL, NULL, NULL, 547, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(5, 5, '2026-03-24', '08:00:00', '17:02:00', 'hadir', NULL, NULL, NULL, 542, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(6, 6, '2026-03-24', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(7, 7, '2026-03-24', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(8, 8, '2026-03-24', '08:06:00', '17:13:00', 'hadir', NULL, NULL, NULL, 547, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(9, 1, '2026-03-25', '08:09:00', '17:06:00', 'hadir', NULL, NULL, NULL, 537, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(10, 2, '2026-03-25', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(11, 3, '2026-03-25', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(12, 4, '2026-03-25', '08:01:00', '17:20:00', 'hadir', NULL, NULL, NULL, 559, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(13, 5, '2026-03-25', '08:46:00', '17:15:00', 'terlambat', NULL, NULL, NULL, 509, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(14, 6, '2026-03-25', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(15, 7, '2026-03-25', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(16, 8, '2026-03-25', '08:07:00', '17:22:00', 'hadir', NULL, NULL, NULL, 555, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(17, 1, '2026-03-26', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(18, 2, '2026-03-26', '08:47:00', '17:16:00', 'terlambat', NULL, NULL, NULL, 509, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(19, 3, '2026-03-26', '08:10:00', '17:28:00', 'hadir', NULL, NULL, NULL, 558, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(20, 4, '2026-03-26', '08:06:00', '17:27:00', 'hadir', NULL, NULL, NULL, 561, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(21, 5, '2026-03-26', '08:07:00', '17:09:00', 'hadir', NULL, NULL, NULL, 542, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(22, 6, '2026-03-26', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(23, 7, '2026-03-26', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(24, 8, '2026-03-26', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(25, 1, '2026-03-27', '08:27:00', '17:09:00', 'terlambat', NULL, NULL, NULL, 522, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(26, 2, '2026-03-27', '08:04:00', '17:23:00', 'hadir', NULL, NULL, NULL, 559, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(27, 3, '2026-03-27', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(28, 4, '2026-03-27', '08:25:00', '17:14:00', 'terlambat', NULL, NULL, NULL, 529, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(29, 5, '2026-03-27', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(30, 6, '2026-03-27', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(31, 7, '2026-03-27', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(32, 8, '2026-03-27', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(33, 1, '2026-03-30', '08:08:00', '17:23:00', 'hadir', NULL, NULL, NULL, 555, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(34, 2, '2026-03-30', '08:06:00', '17:23:00', 'hadir', NULL, NULL, NULL, 557, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(35, 3, '2026-03-30', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(36, 4, '2026-03-30', '08:21:00', '17:20:00', 'terlambat', NULL, NULL, NULL, 539, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(37, 5, '2026-03-30', '08:24:00', '17:09:00', 'terlambat', NULL, NULL, NULL, 525, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(38, 6, '2026-03-30', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(39, 7, '2026-03-30', '08:18:00', '17:28:00', 'terlambat', NULL, NULL, NULL, 550, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(40, 8, '2026-03-30', '08:04:00', '17:26:00', 'hadir', NULL, NULL, NULL, 562, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(41, 1, '2026-03-31', '08:03:00', '17:19:00', 'hadir', NULL, NULL, NULL, 556, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(42, 2, '2026-03-31', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(43, 3, '2026-03-31', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(44, 4, '2026-03-31', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(45, 5, '2026-03-31', '08:00:00', '17:09:00', 'hadir', NULL, NULL, NULL, 549, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(46, 6, '2026-03-31', '08:07:00', '17:15:00', 'hadir', NULL, NULL, NULL, 548, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(47, 7, '2026-03-31', '08:01:00', '17:09:00', 'hadir', NULL, NULL, NULL, 548, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(48, 8, '2026-03-31', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(49, 1, '2026-04-01', '08:01:00', '17:29:00', 'hadir', NULL, NULL, NULL, 568, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(50, 2, '2026-04-01', '08:02:00', '17:15:00', 'hadir', NULL, NULL, NULL, 553, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(51, 3, '2026-04-01', '08:01:00', '17:23:00', 'hadir', NULL, NULL, NULL, 562, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(52, 4, '2026-04-01', '08:33:00', '17:01:00', 'terlambat', NULL, NULL, NULL, 508, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(53, 5, '2026-04-01', '08:01:00', '17:05:00', 'hadir', NULL, NULL, NULL, 544, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(54, 6, '2026-04-01', '08:06:00', '17:21:00', 'hadir', NULL, NULL, NULL, 555, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(55, 7, '2026-04-01', '08:06:00', '17:27:00', 'hadir', NULL, NULL, NULL, 561, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(56, 8, '2026-04-01', '08:04:00', '17:05:00', 'hadir', NULL, NULL, NULL, 541, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(57, 1, '2026-04-02', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(58, 2, '2026-04-02', '08:04:00', '17:07:00', 'hadir', NULL, NULL, NULL, 543, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(59, 3, '2026-04-02', '08:06:00', '17:23:00', 'hadir', NULL, NULL, NULL, 557, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(60, 4, '2026-04-02', '08:06:00', '17:06:00', 'hadir', NULL, NULL, NULL, 540, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(61, 5, '2026-04-02', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(62, 6, '2026-04-02', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(63, 7, '2026-04-02', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(64, 8, '2026-04-02', '08:03:00', '17:18:00', 'hadir', NULL, NULL, NULL, 555, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(65, 1, '2026-04-03', '08:08:00', '17:17:00', 'hadir', NULL, NULL, NULL, 549, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(66, 2, '2026-04-03', '08:04:00', '17:13:00', 'hadir', NULL, NULL, NULL, 549, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(67, 3, '2026-04-03', '08:03:00', '17:05:00', 'hadir', NULL, NULL, NULL, 542, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(68, 4, '2026-04-03', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(69, 5, '2026-04-03', '08:07:00', '17:14:00', 'hadir', NULL, NULL, NULL, 547, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(70, 6, '2026-04-03', '08:02:00', '17:12:00', 'hadir', NULL, NULL, NULL, 550, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(71, 7, '2026-04-03', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(72, 8, '2026-04-03', '08:09:00', '17:30:00', 'hadir', NULL, NULL, NULL, 561, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(73, 1, '2026-04-06', '08:05:00', '17:28:00', 'hadir', NULL, NULL, NULL, 563, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(74, 2, '2026-04-06', '08:10:00', '17:23:00', 'hadir', NULL, NULL, NULL, 553, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(75, 3, '2026-04-06', '08:10:00', '17:00:00', 'hadir', NULL, NULL, NULL, 530, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(76, 4, '2026-04-06', '08:07:00', '17:01:00', 'hadir', NULL, NULL, NULL, 534, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(77, 5, '2026-04-06', '08:09:00', '17:04:00', 'hadir', NULL, NULL, NULL, 535, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(78, 6, '2026-04-06', '08:04:00', '17:24:00', 'hadir', NULL, NULL, NULL, 560, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(79, 7, '2026-04-06', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(80, 8, '2026-04-06', '08:38:00', '17:17:00', 'terlambat', NULL, NULL, NULL, 519, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(81, 1, '2026-04-07', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(82, 2, '2026-04-07', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(83, 3, '2026-04-07', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(84, 4, '2026-04-07', '08:05:00', '17:23:00', 'hadir', NULL, NULL, NULL, 558, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(85, 5, '2026-04-07', '08:02:00', '17:18:00', 'hadir', NULL, NULL, NULL, 556, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(86, 6, '2026-04-07', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(87, 7, '2026-04-07', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(88, 8, '2026-04-07', '08:04:00', '17:19:00', 'hadir', NULL, NULL, NULL, 555, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(89, 1, '2026-04-08', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(90, 2, '2026-04-08', '08:35:00', '17:25:00', 'terlambat', NULL, NULL, NULL, 530, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(91, 3, '2026-04-08', '08:46:00', '17:02:00', 'terlambat', NULL, NULL, NULL, 496, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(92, 4, '2026-04-08', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(93, 5, '2026-04-08', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(94, 6, '2026-04-08', '08:03:00', '17:16:00', 'hadir', NULL, NULL, NULL, 553, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(95, 7, '2026-04-08', '08:04:00', '17:04:00', 'hadir', NULL, NULL, NULL, 540, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(96, 8, '2026-04-08', '08:03:00', '17:04:00', 'hadir', NULL, NULL, NULL, 541, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(97, 1, '2026-04-09', '08:06:00', '17:00:00', 'hadir', NULL, NULL, NULL, 534, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(98, 2, '2026-04-09', '08:07:00', '17:02:00', 'hadir', NULL, NULL, NULL, 535, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(99, 3, '2026-04-09', '08:04:00', '17:03:00', 'hadir', NULL, NULL, NULL, 539, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(100, 4, '2026-04-09', '08:16:00', '17:21:00', 'terlambat', NULL, NULL, NULL, 545, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(101, 5, '2026-04-09', '08:59:00', '17:15:00', 'terlambat', NULL, NULL, NULL, 496, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(102, 6, '2026-04-09', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(103, 7, '2026-04-09', '08:07:00', '17:23:00', 'hadir', NULL, NULL, NULL, 556, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(104, 8, '2026-04-09', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(105, 1, '2026-04-10', '08:10:00', '17:03:00', 'hadir', NULL, NULL, NULL, 533, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(106, 2, '2026-04-10', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(107, 3, '2026-04-10', '08:10:00', '17:18:00', 'hadir', NULL, NULL, NULL, 548, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(108, 4, '2026-04-10', '08:00:00', '17:11:00', 'hadir', NULL, NULL, NULL, 551, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(109, 5, '2026-04-10', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(110, 6, '2026-04-10', '08:02:00', '17:00:00', 'hadir', NULL, NULL, NULL, 538, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(111, 7, '2026-04-10', '08:10:00', '17:18:00', 'hadir', NULL, NULL, NULL, 548, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(112, 8, '2026-04-10', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(113, 1, '2026-04-13', '08:33:00', '17:30:00', 'terlambat', NULL, NULL, NULL, 537, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(114, 2, '2026-04-13', '08:09:00', '17:29:00', 'hadir', NULL, NULL, NULL, 560, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(115, 3, '2026-04-13', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(116, 4, '2026-04-13', '08:07:00', '17:13:00', 'hadir', NULL, NULL, NULL, 546, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(117, 5, '2026-04-13', '08:33:00', '17:03:00', 'terlambat', NULL, NULL, NULL, 510, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(118, 6, '2026-04-13', '08:06:00', '17:28:00', 'hadir', NULL, NULL, NULL, 562, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(119, 7, '2026-04-13', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(120, 8, '2026-04-13', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(121, 1, '2026-04-14', '08:02:00', '17:01:00', 'hadir', NULL, NULL, NULL, 539, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(122, 2, '2026-04-14', '08:08:00', '17:27:00', 'hadir', NULL, NULL, NULL, 559, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(123, 3, '2026-04-14', '08:27:00', '17:16:00', 'terlambat', NULL, NULL, NULL, 529, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(124, 4, '2026-04-14', '08:03:00', '17:28:00', 'hadir', NULL, NULL, NULL, 565, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(125, 5, '2026-04-14', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(126, 6, '2026-04-14', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(127, 7, '2026-04-14', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(128, 8, '2026-04-14', '08:04:00', '17:25:00', 'hadir', NULL, NULL, NULL, 561, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(129, 1, '2026-04-15', '08:05:00', '17:12:00', 'hadir', NULL, NULL, NULL, 547, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(130, 2, '2026-04-15', '08:00:00', '17:17:00', 'hadir', NULL, NULL, NULL, 557, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(131, 3, '2026-04-15', '08:30:00', '17:22:00', 'terlambat', NULL, NULL, NULL, 532, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(132, 4, '2026-04-15', '08:23:00', '17:10:00', 'terlambat', NULL, NULL, NULL, 527, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(133, 5, '2026-04-15', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(134, 6, '2026-04-15', '08:10:00', '17:22:00', 'hadir', NULL, NULL, NULL, 552, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(135, 7, '2026-04-15', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(136, 8, '2026-04-15', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(137, 1, '2026-04-16', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(138, 2, '2026-04-16', '08:05:00', '17:23:00', 'hadir', NULL, NULL, NULL, 558, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(139, 3, '2026-04-16', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(140, 4, '2026-04-16', '08:01:00', '17:27:00', 'hadir', NULL, NULL, NULL, 566, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(141, 5, '2026-04-16', '08:06:00', '17:14:00', 'hadir', NULL, NULL, NULL, 548, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(142, 6, '2026-04-16', '08:01:00', '17:30:00', 'hadir', NULL, NULL, NULL, 569, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(143, 7, '2026-04-16', '08:05:00', '17:00:00', 'hadir', NULL, NULL, NULL, 535, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(144, 8, '2026-04-16', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(145, 1, '2026-04-17', '08:01:00', '17:09:00', 'hadir', NULL, NULL, NULL, 548, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(146, 2, '2026-04-17', '08:01:00', '17:18:00', 'hadir', NULL, NULL, NULL, 557, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(147, 3, '2026-04-17', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(148, 4, '2026-04-17', '08:10:00', '17:05:00', 'hadir', NULL, NULL, NULL, 535, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(149, 5, '2026-04-17', '08:01:00', '17:15:00', 'hadir', NULL, NULL, NULL, 554, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(150, 6, '2026-04-17', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(151, 7, '2026-04-17', '08:10:00', '17:01:00', 'hadir', NULL, NULL, NULL, 531, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(152, 8, '2026-04-17', '08:02:00', '17:07:00', 'hadir', NULL, NULL, NULL, 545, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(153, 1, '2026-04-20', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(154, 2, '2026-04-20', '08:02:00', '17:27:00', 'hadir', NULL, NULL, NULL, 565, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(155, 3, '2026-04-20', '08:02:00', '17:04:00', 'hadir', NULL, NULL, NULL, 542, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(156, 4, '2026-04-20', '08:03:00', '17:10:00', 'hadir', NULL, NULL, NULL, 547, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(157, 5, '2026-04-20', '08:49:00', '17:07:00', 'terlambat', NULL, NULL, NULL, 498, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(158, 6, '2026-04-20', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(159, 7, '2026-04-20', '08:10:00', '17:03:00', 'hadir', NULL, NULL, NULL, 533, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(160, 8, '2026-04-20', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(161, 1, '2026-04-21', '08:04:00', '17:07:00', 'hadir', NULL, NULL, NULL, 543, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(162, 2, '2026-04-21', '08:04:00', '17:30:00', 'hadir', NULL, NULL, NULL, 566, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(163, 3, '2026-04-21', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(164, 4, '2026-04-21', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(165, 5, '2026-04-21', '08:03:00', '17:26:00', 'hadir', NULL, NULL, NULL, 563, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(166, 6, '2026-04-21', '08:08:00', '17:30:00', 'hadir', NULL, NULL, NULL, 562, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(167, 7, '2026-04-21', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(168, 8, '2026-04-21', NULL, NULL, 'alpha', NULL, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(169, 1, '2026-04-22', '08:10:00', '17:02:00', 'hadir', NULL, NULL, NULL, 532, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(170, 2, '2026-04-22', '08:01:00', '17:12:00', 'hadir', NULL, NULL, NULL, 551, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(171, 3, '2026-04-22', '08:08:00', '17:18:00', 'hadir', NULL, NULL, NULL, 550, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(172, 4, '2026-04-22', '08:43:00', '17:29:00', 'terlambat', NULL, NULL, NULL, 526, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(173, 5, '2026-04-22', '08:50:00', '17:17:00', 'terlambat', NULL, NULL, NULL, 507, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(174, 6, '2026-04-22', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(175, 7, '2026-04-22', '08:01:00', '17:29:00', 'hadir', NULL, NULL, NULL, 568, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(176, 8, '2026-04-22', '08:05:00', '17:22:00', 'hadir', NULL, NULL, NULL, 557, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(177, 1, '2026-04-23', NULL, NULL, 'izin', 'Keterangan izin', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(178, 2, '2026-04-23', '08:23:00', '17:08:00', 'terlambat', NULL, NULL, NULL, 525, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(180, 4, '2026-04-23', '08:10:00', '17:29:00', 'hadir', NULL, NULL, NULL, 559, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(181, 5, '2026-04-23', '08:01:00', '17:28:00', 'hadir', NULL, NULL, NULL, 567, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(182, 6, '2026-04-23', '08:07:00', '17:08:00', 'hadir', NULL, NULL, NULL, 541, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(183, 7, '2026-04-23', NULL, NULL, 'sakit', 'Keterangan sakit', NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(184, 8, '2026-04-23', '08:09:00', '17:05:00', 'hadir', NULL, NULL, NULL, 536, '2026-04-23 02:32:22', '2026-04-23 02:32:22'),
(185, 3, '2026-04-23', '09:39:31', '09:39:47', 'terlambat', NULL, NULL, NULL, 0, '2026-04-23 02:39:31', '2026-04-23 02:39:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `jabatan` varchar(100) NOT NULL,
  `departemen` varchar(100) NOT NULL,
  `status` enum('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `tanggal_masuk` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `nip`, `nama`, `email`, `telepon`, `jabatan`, `departemen`, `status`, `tanggal_masuk`, `foto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'KRY-001', 'Budi Santoso', 'budi@gmail.com', '08540069964', 'Manajer', 'Manajemen', 'aktif', '2024-07-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL),
(2, 'KRY-002', 'Siti Rahayu', 'siti@gmail.com', '08756257333', 'Staff HRD', 'HRD', 'aktif', '2024-09-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL),
(3, 'KRY-003', 'Ahmad Fauzi', 'ahmad@gmail.com', '08388803065', 'Programmer', 'IT', 'aktif', '2023-05-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL),
(4, 'KRY-004', 'Dewi Permata', 'dewi@gmail.com', '08548503906', 'Akuntan', 'Keuangan', 'aktif', '2024-04-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL),
(5, 'KRY-005', 'Rudi Hartono', 'rudi@gmail.com', '08849188767', 'Staff Marketing', 'Marketing', 'aktif', '2025-01-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL),
(6, 'KRY-006', 'Nina Kurniawati', 'nina@gmail.com', '08839251553', 'Desainer Grafis', 'IT', 'aktif', '2024-06-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL),
(7, 'KRY-007', 'Eko Prasetyo', 'eko@gmail.com', '08418744183', 'Staff Keuangan', 'Keuangan', 'aktif', '2024-05-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL),
(8, 'KRY-008', 'Rina Susanti', 'rina@gmail.com', '08462747697', 'Sekretaris', 'Manajemen', 'aktif', '2024-12-23', NULL, '2026-04-23 02:32:19', '2026-04-23 02:32:19', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_karyawan_table', 1),
(5, '2024_01_01_000002_create_absensi_table', 1),
(6, '2024_01_01_000003_create_pengaturan_jam_kerja_table', 1),
(7, '2024_01_01_000004_create_pengguna_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_jam_kerja`
--

CREATE TABLE `pengaturan_jam_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_shift` varchar(50) NOT NULL,
  `jam_masuk_normal` time NOT NULL,
  `jam_keluar_normal` time NOT NULL,
  `toleransi_keterlambatan` int(11) NOT NULL DEFAULT 15,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengaturan_jam_kerja`
--

INSERT INTO `pengaturan_jam_kerja` (`id`, `nama_shift`, `jam_masuk_normal`, `jam_keluar_normal`, `toleransi_keterlambatan`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Shift Pagi', '08:00:00', '17:00:00', 15, 1, '2026-04-23 02:32:19', '2026-04-23 02:32:19'),
(2, 'Shift Siang', '13:00:00', '22:00:00', 15, 1, '2026-04-23 02:32:19', '2026-04-23 02:32:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `peran` enum('admin','pengguna') NOT NULL DEFAULT 'pengguna',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `karyawan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `terakhir_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `kata_sandi`, `peran`, `status`, `karyawan_id`, `foto_profil`, `terakhir_login`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 'admin@perusahaan.com', '$2y$12$Y2O1D/aoUAxYfT1rMOgw6e9LqhqXCoB2Nkw1XvrBOgZ2wx/YTbF.e', 'admin', 'aktif', NULL, 'foto-pengguna/nQ9X13BDIAWeJpfl1pbSn09gKfRabrGhw85nrCpj.png', '2026-04-24 04:58:34', NULL, '2026-04-23 02:32:20', '2026-04-24 04:58:34', NULL),
(2, 'Budi Santoso', 'budi.admin@gmail.com', '$2y$12$tDtdbApvj7p3/xz.1cHwUOsDQ6StwB/2TcmZIyVglAM1TJJNGztfq', 'admin', 'aktif', 1, NULL, '2026-04-23 04:28:56', NULL, '2026-04-23 02:32:20', '2026-04-23 04:28:56', NULL),
(3, 'Siti Rahayu', 'siti@gmail.com', '$2y$12$XTkYyR/xJoB0SSpSchf.luGC5JxCPBTg19/d4tF5L.NYjj3QU/FOu', 'pengguna', 'aktif', 2, NULL, '2026-04-23 02:37:37', NULL, '2026-04-23 02:32:20', '2026-04-23 02:37:37', NULL),
(4, 'Ahmad Fauzi', 'ahmad@gmail.com', '$2y$12$hx0ud2y1VFUa/zcMsQUSGex.hbtSVR.P.y2bWhyQ0n1.t/VajL2uC', 'pengguna', 'aktif', 3, NULL, '2026-04-23 03:51:26', NULL, '2026-04-23 02:32:21', '2026-04-23 03:51:26', NULL),
(5, 'Dewi Permata', 'dewi@gmail.com', '$2y$12$.se3U.1wQDHTIb.s5LvHPeH7B7JJZnhYl2lrL9XQvvGWjMJJ89N2u', 'pengguna', 'aktif', 4, NULL, '2026-04-23 02:54:08', NULL, '2026-04-23 02:32:21', '2026-04-23 02:54:08', NULL),
(6, 'Rudi Hartono', 'rudi@gmail.com', '$2y$12$DKw.y9Y3M2qtM5wjQDx3VuHNzQJh6u7AjzJD9WVPr/fWbYnXRvkNq', 'pengguna', 'aktif', 5, NULL, NULL, NULL, '2026-04-23 02:32:22', '2026-04-23 02:32:22', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi_pengguna`
--

CREATE TABLE `sesi_pengguna` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('eEONX2p8K9zws8cpdZqxw9Hw3Pjsj0yWsKUs3S5X', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicm1CZklna0JtS2g3UXBKb0Zqell6QjRsQ1ZTak5yWjBsSnQ5NEZNWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYXN1ayI7czo1OiJyb3V0ZSI7czo1OiJtYXN1ayI7fX0=', 1777032020),
('fD6fAEthcRrnrjgYNV0wNKa4wRCJj9YaKZm7jZvc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW9mcHdoeHpUV0JzT2wzS0ZBaFl3d2ZmbktuTWJzWjlGekdUdFlsMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYXN1ayI7czo1OiJyb3V0ZSI7czo1OiJtYXN1ayI7fX0=', 1776943790);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensi_karyawan_id_tanggal_unique` (`karyawan_id`,`tanggal`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawan_nip_unique` (`nip`),
  ADD UNIQUE KEY `karyawan_email_unique` (`email`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengaturan_jam_kerja`
--
ALTER TABLE `pengaturan_jam_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengguna_email_unique` (`email`),
  ADD KEY `pengguna_karyawan_id_foreign` (`karyawan_id`);

--
-- Indeks untuk tabel `sesi_pengguna`
--
ALTER TABLE `sesi_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sesi_pengguna_user_id_index` (`user_id`),
  ADD KEY `sesi_pengguna_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_jam_kerja`
--
ALTER TABLE `pengaturan_jam_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
