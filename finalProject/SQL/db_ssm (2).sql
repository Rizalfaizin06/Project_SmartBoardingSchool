-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Mar 2023 pada 17.04
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ssm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `idDetailUser` int(11) NOT NULL,
  `saldo` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_admin`
--

INSERT INTO `tbl_admin` (`idDetailUser`, `saldo`) VALUES
(0, 9765500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_category`
--

CREATE TABLE `tbl_category` (
  `idCategory` int(1) NOT NULL,
  `namaCategory` varchar(20) NOT NULL,
  `idUserCat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_category`
--

INSERT INTO `tbl_category` (`idCategory`, `namaCategory`, `idUserCat`) VALUES
(1, 'Makanan', 2),
(2, 'Minuman', 2),
(3, 'Camilan', 2),
(7, 'Snack', 2),
(9, 'Mak', 16),
(10, 'Min', 16),
(11, 'Sna', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_log`
--

CREATE TABLE `tbl_log` (
  `idLog` int(11) NOT NULL,
  `uuidPengirim` varchar(50) NOT NULL,
  `saldoPengirim` int(9) NOT NULL,
  `uuidPenerima` varchar(50) NOT NULL,
  `saldoPenerima` int(9) NOT NULL,
  `jumlahTransfer` int(9) NOT NULL,
  `waktuTransfer` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_log`
--

INSERT INTO `tbl_log` (`idLog`, `uuidPengirim`, `saldoPengirim`, `uuidPenerima`, `saldoPenerima`, `jumlahTransfer`, `waktuTransfer`) VALUES
(19, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 9760500, '1acd98ed-43be-46c7-883d-6e355eea29b0', 252804, 3000, '2023-04-05 17:54:39'),
(20, '30896a11-e01d-4b6c-bf05-29b2ede3cea7', 647196, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 9757500, 7000, '2023-04-05 18:12:39'),
(21, '30896a11-e01d-4b6c-bf05-29b2ede3cea7', 640196, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 9764500, 10000, '2023-03-06 18:19:10'),
(22, '30896a11-e01d-4b6c-bf05-29b2ede3cea7', 630196, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 9774500, 1000, '2023-03-05 18:20:13'),
(23, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 9775500, '1acd98ed-43be-46c7-883d-6e355eea29b0', 255804, 5000, '2023-03-05 18:21:02'),
(24, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 9770500, '1acd98ed-43be-46c7-883d-6e355eea29b0', 260804, 1000, '2023-03-05 18:21:28'),
(25, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 9769500, '1acd98ed-43be-46c7-883d-6e355eea29b0', 261804, 4000, '2024-03-05 18:21:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `idMenu` int(11) NOT NULL,
  `namaMenu` varchar(20) NOT NULL,
  `hargaMenu` int(9) NOT NULL,
  `gambarMenu` varchar(20) NOT NULL,
  `idCategory` int(1) NOT NULL,
  `idPenjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`idMenu`, `namaMenu`, `hargaMenu`, `gambarMenu`, `idCategory`, `idPenjual`) VALUES
(1, 'Soto Semarang', 5000, 'soto.png', 1, 2),
(2, 'Bakmoi', 10000, 'bakmoi.png', 1, 2),
(3, 'Cappuccino Latte', 16000, 'cappuccino.png', 2, 2),
(4, 'Milkshake', 13500, 'milkshake.png', 2, 2),
(5, 'Lemon Tea', 8000, 'lemontea.png', 2, 2),
(6, 'Gorengan', 6000, 'gorengan.png', 3, 2),
(7, 'Soto Semarang', 5000, 'soto.png', 1, 4),
(8, 'Bakmoi', 10000, 'bakmoi.png', 1, 4),
(9, 'Milkshake', 13500, 'milkshake.png', 2, 4),
(16, 'Taro', 5232, '63f5d53224117.png', 7, 2),
(20, 'Mak1', 122, '63f5dc273ad13.jpg', 9, 16),
(21, 'mak 2', 1222, '63f5dc3710616.jpg', 9, 16),
(22, 'Min', 11221, '63f5dc4d51581.png', 10, 16),
(23, 'Snack', 123, '63f5dc6679c96.jpg', 11, 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_notifikasi`
--

CREATE TABLE `tbl_notifikasi` (
  `idNotif` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `messageNotif` varchar(100) NOT NULL,
  `jumlahPermintaan` int(9) NOT NULL,
  `waktuNotif` datetime NOT NULL,
  `statusNotif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_notifikasi`
--

INSERT INTO `tbl_notifikasi` (`idNotif`, `idUser`, `messageNotif`, `jumlahPermintaan`, `waktuNotif`, `statusNotif`) VALUES
(1, 3, 'Pah.. minta tambahan buat makan..', 85000, '2023-02-20 15:27:49', 1),
(2, 3, 'Hdhddhdd\r\nDudjdj', 2000, '2023-02-20 15:27:49', 1),
(3, 3, 'Hdhddhdd\r\nDudjdj', 2000, '2023-02-20 15:27:49', 1),
(4, 3, 'Pah.. minta lagi dong, plisss', 120000, '2023-02-20 15:27:49', 1),
(5, 3, 'Pah.. minta tambahan', 25000, '2023-02-20 15:27:49', 1),
(6, 3, 'Pah.. minta buat beli teh', 5000, '2023-02-20 15:27:49', 1),
(7, 14, 'Pah.. testing nih..', 50000, '2023-02-20 15:27:49', 1),
(8, 3, 'pahh..?', 1000, '2023-02-20 15:27:49', 1),
(9, 3, 'Pah minta tambahan 100k dong', 100000, '2023-02-20 15:27:49', 1),
(10, 3, 'sdfrsdf ', 3456456, '2023-02-20 15:27:49', 1),
(11, 3, 'Pahhh.. Mintaa', 10000, '2023-02-20 15:27:49', 1),
(12, 3, '', 0, '2023-02-20 15:27:49', 1),
(13, 3, 'sdfsdfwerqwr', 1000, '2023-02-20 15:27:49', 1),
(14, 3, 'Halo', 9000, '2023-02-20 15:27:49', 1),
(15, 3, 'thr', 1000, '2023-02-20 15:27:49', 1),
(16, 3, 'lagi', 3000, '2023-02-20 15:27:49', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_orangtua`
--

CREATE TABLE `tbl_orangtua` (
  `idDetailUser` int(11) NOT NULL,
  `idAnak` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_orangtua`
--

INSERT INTO `tbl_orangtua` (`idDetailUser`, `idAnak`) VALUES
(5, 3),
(8, 14),
(12, 18),
(14, 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_order`
--

CREATE TABLE `tbl_order` (
  `idOrder` int(11) NOT NULL,
  `idPenjual` int(6) NOT NULL DEFAULT 0,
  `idPembeli` int(6) NOT NULL DEFAULT 0,
  `waktuOrder` datetime NOT NULL DEFAULT current_timestamp(),
  `statusOrder` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_order`
--

INSERT INTO `tbl_order` (`idOrder`, `idPenjual`, `idPembeli`, `waktuOrder`, `statusOrder`) VALUES
(2, 2, 5, '2023-02-18 17:14:26', 1),
(3, 2, 5, '2023-02-18 17:16:27', 1),
(6, 2, 3, '2023-02-20 00:21:55', 1),
(7, 2, 3, '2023-02-20 00:26:20', 1),
(8, 4, 3, '2023-02-20 00:26:42', 1),
(9, 2, 3, '2023-02-20 00:27:22', 1),
(10, 4, 3, '2023-02-20 01:11:28', 1),
(11, 4, 5, '2023-02-20 01:42:15', 1),
(12, 2, 3, '2023-02-20 01:52:02', 1),
(13, 4, 3, '2023-02-20 02:06:01', 1),
(14, 2, 5, '2023-02-20 02:26:43', 1),
(15, 2, 3, '2023-02-20 10:42:10', 1),
(16, 2, 3, '2023-02-20 10:46:39', 1),
(25, 2, 3, '2023-02-21 00:34:39', 1),
(26, 2, 3, '2023-02-21 00:35:13', 1),
(28, 2, 3, '2023-02-21 00:36:36', 1),
(30, 2, 14, '2023-02-21 22:30:09', 1),
(35, 2, 3, '2023-02-22 10:03:41', 1),
(36, 2, 3, '2023-02-22 15:46:31', 1),
(37, 2, 3, '2023-02-22 23:47:30', 1),
(38, 2, 3, '2023-02-22 23:47:45', 1),
(39, 2, 3, '2023-02-22 23:53:35', 1),
(40, 2, 3, '2023-02-22 23:55:07', 1),
(41, 2, 3, '2023-02-22 23:59:08', 1),
(46, 2, 3, '2023-02-23 01:44:40', 1),
(47, 2, 3, '2023-02-23 01:45:21', 1),
(48, 2, 3, '2023-02-23 01:46:30', 1),
(51, 2, 3, '2023-02-23 01:55:25', 1),
(53, 2, 3, '2023-01-23 03:03:07', 1),
(54, 2, 3, '2023-01-23 03:05:27', 1),
(58, 2, 3, '2023-01-27 13:38:18', 1),
(59, 2, 3, '2024-02-28 11:41:22', 1),
(60, 4, 3, '2024-02-28 11:41:51', 1),
(61, 2, 3, '2023-02-28 21:59:11', 1),
(62, 4, 3, '2023-02-28 22:01:04', 1),
(64, 2, 3, '2023-03-02 23:12:06', 1),
(65, 2, 5, '2023-03-02 23:15:18', 1),
(66, 2, 5, '2023-03-06 10:43:33', 1),
(67, 2, 5, '2023-03-06 10:46:45', 1),
(69, 2, 3, '2023-03-06 10:50:53', 1),
(71, 2, 3, '2023-03-06 13:42:06', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjual`
--

CREATE TABLE `tbl_penjual` (
  `idDetailUser` int(11) NOT NULL,
  `namaToko` varchar(20) NOT NULL,
  `logoToko` varchar(20) NOT NULL DEFAULT 'defaultProfile.jpg',
  `saldo` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_penjual`
--

INSERT INTO `tbl_penjual` (`idDetailUser`, `namaToko`, `logoToko`, `saldo`) VALUES
(1, 'Kantin Chuwi', 'defaultProfile.jpg', 652196),
(3, 'Kantin SR', 'defaultProfile.jpg', 410500),
(9, 'Kantin BDZ', '63f510973eebd.png', 0),
(10, 'asdfffffffffffffffff', '63f5f30d42af2.jpg', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pesan`
--

CREATE TABLE `tbl_pesan` (
  `idPesan` int(11) NOT NULL,
  `idOrder` int(4) NOT NULL DEFAULT 0,
  `idMenu` int(4) NOT NULL,
  `jumlahPesan` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pesan`
--

INSERT INTO `tbl_pesan` (`idPesan`, `idOrder`, `idMenu`, `jumlahPesan`) VALUES
(4, 2, 1, 1),
(5, 2, 6, 2),
(6, 3, 4, 4),
(9, 6, 1, 1),
(10, 6, 2, 1),
(11, 7, 1, 1),
(12, 8, 9, 11),
(13, 9, 6, 5),
(14, 10, 9, 4),
(15, 11, 9, 1),
(16, 11, 8, 1),
(17, 12, 5, 2),
(18, 12, 6, 2),
(19, 12, 1, 2),
(20, 13, 8, 5),
(21, 14, 4, 1),
(22, 14, 6, 1),
(23, 15, 6, 2),
(24, 15, 5, 4),
(25, 16, 1, 3),
(29, 18, 1, 5),
(33, 20, 2, 1),
(34, 20, 4, 1),
(35, 20, 3, 1),
(36, 21, 2, 1),
(37, 21, 4, 1),
(38, 21, 3, 1),
(39, 21, 5, 1),
(40, 21, 6, 1),
(51, 25, 1, 1),
(52, 25, 2, 1),
(53, 26, 5, 1),
(55, 28, 1, 1),
(57, 30, 2, 1),
(58, 30, 5, 1),
(59, 30, 3, 1),
(71, 35, 1, 1),
(72, 35, 2, 1),
(73, 35, 4, 1),
(87, 36, 16, 1),
(88, 37, 1, 1),
(89, 38, 1, 1),
(90, 39, 1, 1),
(91, 40, 1, 1),
(92, 41, 1, 1),
(102, 46, 1, 1),
(103, 47, 1, 2),
(104, 47, 3, 1),
(105, 48, 1, 2),
(106, 48, 3, 1),
(111, 51, 1, 1),
(112, 51, 3, 1),
(114, 53, 1, 1),
(115, 53, 2, 1),
(116, 54, 4, 1),
(123, 58, 16, 1),
(124, 59, 1, 1),
(125, 60, 7, 1),
(126, 60, 8, 1),
(127, 61, 16, 1),
(128, 61, 1, 1),
(129, 62, 9, 1),
(135, 64, 5, 1),
(136, 64, 6, 1),
(137, 65, 3, 1),
(138, 66, 1, 1),
(139, 67, 5, 1),
(141, 69, 1, 1),
(143, 71, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `idDetailUser` int(6) NOT NULL,
  `idOrangTua` int(6) NOT NULL,
  `saldo` int(9) NOT NULL,
  `spendingLimit` int(9) NOT NULL,
  `additionalLimit` int(9) NOT NULL DEFAULT 0,
  `rfidUser` varchar(20) NOT NULL DEFAULT '0',
  `pinUser` varchar(6) NOT NULL DEFAULT '111111'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`idDetailUser`, `idOrangTua`, `saldo`, `spendingLimit`, `additionalLimit`, `rfidUser`, `pinUser`) VALUES
(2, 9, 255804, 25000, 0, '7088951A', '111111'),
(4, 5, 790500, 17000, 0, '7026461A', '111111'),
(7, 15, 96000, 0, 0, 'asd', '111111'),
(11, 19, 0, 0, 0, '34', '111111'),
(13, 21, 0, 0, 0, '7026461A', '111111');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `idUser` int(11) NOT NULL,
  `uuidUser` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `realName` varchar(20) NOT NULL,
  `tempatLahir` varchar(20) NOT NULL DEFAULT '-',
  `tanggalLahir` date NOT NULL,
  `alamat` varchar(255) NOT NULL DEFAULT '-',
  `nomorTelfon` varchar(20) NOT NULL DEFAULT '-',
  `email` varchar(20) NOT NULL,
  `profileImage` varchar(20) NOT NULL DEFAULT 'defaultProfile.jpg',
  `role` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `idDetailUser` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`idUser`, `uuidUser`, `username`, `password`, `realName`, `tempatLahir`, `tanggalLahir`, `alamat`, `nomorTelfon`, `email`, `profileImage`, `role`, `status`, `idDetailUser`) VALUES
(1, '4b939a1c-364f-40e4-89ec-afd4a5eb3825', 'admin', '$2y$10$W0wsCDd4EKV8.XrppUmMf.iGKZywjvJ1HkuylcNvn9JLH3V74RrEm', 'ADMIN', '', '0000-00-00', '', '', '', 'gb.jpg', 1, 1, 0),
(2, '30896a11-e01d-4b6c-bf05-29b2ede3cea7', 'jual', '$2y$10$W0wsCDd4EKV8.XrppUmMf.iGKZywjvJ1HkuylcNvn9JLH3V74RrEm', 'Penjualll', '', '0000-00-00', '', '', '', 'defaultProfile.jpg', 2, 1, 1),
(3, '1acd98ed-43be-46c7-883d-6e355eea29b0', 'beli', '$2y$10$/g/e5K4f5sJwICP1nd8I9.YWJErAjKbfPZzFUOi8fy42RxUS5.lZC', 'Rizal Faizin Firdaus', 'Grobogan', '2002-12-31', '', '', '', 'defaultProfile.jpg', 3, 1, 2),
(4, '186ca2b8-55e4-43ca-9dfe-846eadf3685c', 'jual2', '$2y$10$i9m90ruBFHZ/3bP7GH8DheP9OToFsagXA0f38QaBdRxge0tXgT5cG', 'Penjualll222', '', '0000-00-00', '', '', '', 'defaultProfile.jpg', 2, 1, 3),
(5, '24fa8732-e56f-4e98-9826-729d5f1b421f', 'beli2', '$2y$10$N8GxsMjooKd/Jnd.rI91jusrMmLt1juTL2201gNsU4weItBo8LUFK', 'Pembelii22', '', '0000-00-00', '', '', '', 'defaultProfile.jpg', 3, 1, 4),
(9, '1acd98ed-43be-46c7-46c7-6e355eea29b0', 'ortu', '$2y$10$/g/e5K4f5sJwICP1nd8I9.YWJErAjKbfPZzFUOi8fy42RxUS5.lZC', 'Nama Orang Tua', 'Grobogan', '2002-12-31', '', '', '', 'defaultProfile.jpg', 4, 1, 5),
(14, '2a8699e1-8e1b-415d-8be8-5ef88e02be0a', 'siswa5', '$2y$10$.YShaR1DZEGGkFB73CJm0.nyDb7tv6oAcg22FgaGNJ6zeo74I6WPW', 'siswa5', '', '0000-00-00', '', '', 'siswa5', '63f4df0e0b8be.jpg', 3, 1, 7),
(15, '4633175f-2144-4d02-84f5-7ee65e6bdc1a', 'ortu5', '$2y$10$UgNKnJwDwucrDz5XhCpF1ubciliENtPVlx.VdgzYVEnJMzhQ5nRx.', 'ortu5', '', '0000-00-00', '', '', 'ortu5', '63f4df0e0bf45.jpg', 4, 1, 8),
(16, '3240f7c7-807a-49a9-8660-93386f22a6f6', 'jual3', '$2y$10$KWV2X6wbFeekcQfGu9znFuHP85vVlPz1fLtT7XizE/Xqiddb.m.RW', 'asfdsfadsadfsfad', '', '0000-00-00', '', '', 'asdffsd', '63f510973e37f.png', 2, 1, 9),
(17, '869fbea5-27bb-4e3f-b3da-27aa46f00454', 'jual5', '$2y$10$H4dYR7RhaImUL/0b1RYbUOWSCZGaEcYlsF2eCI5Kz6/1jrhbydN9S', 'sdf', '', '0000-00-00', '', '', 'asf', '63f5f30d424c7.png', 2, 1, 10),
(18, 'e53ad0c6-7d41-4d85-9ca7-952769deb754', 'siswa', '$2y$10$Uqhdl84ykZQpVFKGk2zkqesiHVLE0FRkBi/qXjgAjhUCNduywmeLm', 'Danang Santoso', 'Grobogan', '2002-01-01', 'Jln. Gajah Mada No. 111 Lk. Kauman Kel. Wirosari Kec. Wirosari Rt. 02 Rw. 07 Gg. Ahmad Yani', '08999999999', 'danangsanss@gmail.co', '63f600a99aa08.jpg', 3, 0, 11),
(19, '01c00f80-559d-4fee-9a70-8ce3af38d13e', 'orangtua', '$2y$10$8VpyHCiIvjBqGBir4KqBX./G/c6Mr0Hsi3SZgO7nErjArc/cxBp06', 'Sujiwo Rogo Kusumo', 'Grobogan', '1966-02-23', 'Jln. Pahlawan No. 155 Lk. Kusuma Kel. Bakti Kec. Purwodadi Rt. 03 Rw. 09 Gg. Bekasi', '081222222222', 'sijirogo@gmail.com', '63f600a99b049.jpg', 4, 0, 12),
(20, 'd73ca182-277e-4e01-89ed-7e5216ba2cfa', 'a', '$2y$10$F8xCKdpaqNG.g7UhrJYpreFniZ5jrbqvK.CtzEIdInaXpzJPIbNO6', 'fffffffffffffff', '', '0000-00-00', '', '', 'f', 'defaultProfile.jpg', 3, 1, 13),
(21, '644535f1-f171-48c1-8882-c8d71c1c7924', 'b', '$2y$10$IlPlLKfY5IgqsdyEiWLFXeaF3trpUBBRs9TuNhYkXKih7WyHib.zu', 'asss', '', '0000-00-00', '', '', 'asd', 'defaultProfile.jpg', 4, 1, 14);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`idDetailUser`);

--
-- Indeks untuk tabel `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indeks untuk tabel `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`idLog`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`idMenu`),
  ADD KEY `idCategory` (`idCategory`),
  ADD KEY `idPenjual` (`idPenjual`);

--
-- Indeks untuk tabel `tbl_notifikasi`
--
ALTER TABLE `tbl_notifikasi`
  ADD PRIMARY KEY (`idNotif`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeks untuk tabel `tbl_orangtua`
--
ALTER TABLE `tbl_orangtua`
  ADD PRIMARY KEY (`idDetailUser`),
  ADD KEY `idAnak` (`idAnak`);

--
-- Indeks untuk tabel `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`idOrder`),
  ADD KEY `idPenjual` (`idPenjual`);

--
-- Indeks untuk tabel `tbl_penjual`
--
ALTER TABLE `tbl_penjual`
  ADD PRIMARY KEY (`idDetailUser`);

--
-- Indeks untuk tabel `tbl_pesan`
--
ALTER TABLE `tbl_pesan`
  ADD PRIMARY KEY (`idPesan`),
  ADD KEY `idMenu` (`idMenu`),
  ADD KEY `idOrder` (`idOrder`);

--
-- Indeks untuk tabel `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`idDetailUser`),
  ADD KEY `idOrangTua` (`idOrangTua`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `idDetailUser_2` (`idDetailUser`),
  ADD UNIQUE KEY `idDetailUser_3` (`idDetailUser`),
  ADD UNIQUE KEY `uuidUser` (`uuidUser`),
  ADD KEY `idDetailUser` (`idDetailUser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `idCategory` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `tbl_notifikasi`
--
ALTER TABLE `tbl_notifikasi`
  MODIFY `idNotif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `idOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `tbl_pesan`
--
ALTER TABLE `tbl_pesan`
  MODIFY `idPesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_pesan`
--
ALTER TABLE `tbl_pesan`
  ADD CONSTRAINT `tbl_pesan_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `tbl_menu` (`idMenu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
