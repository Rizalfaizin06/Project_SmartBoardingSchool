-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Feb 2023 pada 13.54
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
(0, 9950000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_category`
--

CREATE TABLE `tbl_category` (
  `idCategory` int(1) NOT NULL,
  `namaCategory` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_category`
--

INSERT INTO `tbl_category` (`idCategory`, `namaCategory`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Camilan');

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
(1, '1', 234234, '11', 234234, 23424, '2023-02-19 10:42:21'),
(2, '3', 234234, '11', 234234, 23424, '2023-02-19 12:42:12'),
(3, '3', 234234, '11', 234234, 23424, '2023-02-19 16:44:35'),
(4, '3', 234234, '11', 234234, 23424, '2023-02-19 16:45:03'),
(5, 'ADMIN', 9940000, 'Rizal Faizin Firdaus', 987000, 3000, '2023-02-19 17:06:26'),
(6, 'ADMIN', 9937000, 'Penjualll', 103000, 5000, '2023-02-19 17:15:11'),
(7, 'Penjualll', 98000, 'ADMIN', 9942000, 8000, '2023-02-19 17:35:00');

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
(9, 'Milkshake', 13500, 'milkshake.png', 2, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_orangtua`
--

CREATE TABLE `tbl_orangtua` (
  `idDetailUser` int(11) NOT NULL,
  `idAnak` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 2, 5, '2023-02-18 17:16:27', 1);

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
(1, 'Rizals Company Lab', 'defaultProfile.jpg', 90000),
(3, 'Rizals Company Lab22', 'defaultProfile.jpg', 107500);

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
(6, 3, 4, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `idDetailUser` int(6) NOT NULL,
  `idOrangTua` int(6) NOT NULL,
  `saldo` int(9) NOT NULL,
  `spendingLimit` int(9) NOT NULL,
  `additionalLimit` int(9) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`idDetailUser`, `idOrangTua`, `saldo`, `spendingLimit`, `additionalLimit`) VALUES
(2, 1, 990000, 25000, 0),
(4, 2, 862500, 17000, 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `idUser` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `realName` varchar(20) NOT NULL,
  `tempatLahir` varchar(20) NOT NULL,
  `tanggalLahir` date NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nomorTelfon` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `profileImage` varchar(20) NOT NULL DEFAULT 'defaultProfile.jpg',
  `role` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `idDetailUser` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`idUser`, `username`, `password`, `realName`, `tempatLahir`, `tanggalLahir`, `alamat`, `nomorTelfon`, `email`, `profileImage`, `role`, `status`, `idDetailUser`) VALUES
(1, 'admin', '$2y$10$W0wsCDd4EKV8.XrppUmMf.iGKZywjvJ1HkuylcNvn9JLH3V74RrEm', 'ADMIN', '', '0000-00-00', '', '', '', 'gb.jpg', 1, 1, 0),
(2, 'jual', '$2y$10$W0wsCDd4EKV8.XrppUmMf.iGKZywjvJ1HkuylcNvn9JLH3V74RrEm', 'Penjualll', '', '0000-00-00', '', '', '', 'defaultProfile.jpg', 2, 1, 1),
(3, 'beli', '$2y$10$/g/e5K4f5sJwICP1nd8I9.YWJErAjKbfPZzFUOi8fy42RxUS5.lZC', 'Rizal Faizin Firdaus', '', '0000-00-00', '', '', '', 'defaultProfile.jpg', 3, 1, 2),
(4, 'jual2', '$2y$10$i9m90ruBFHZ/3bP7GH8DheP9OToFsagXA0f38QaBdRxge0tXgT5cG', 'Penjualll222', '', '0000-00-00', '', '', '', 'defaultProfile.jpg', 2, 1, 3),
(5, 'beli2', '$2y$10$N8GxsMjooKd/Jnd.rI91jusrMmLt1juTL2201gNsU4weItBo8LUFK', 'Pembelii22', '', '0000-00-00', '', '', '', 'defaultProfile.jpg', 3, 1, 4);

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
  ADD KEY `idDetailUser` (`idDetailUser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `idOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_pesan`
--
ALTER TABLE `tbl_pesan`
  MODIFY `idPesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
