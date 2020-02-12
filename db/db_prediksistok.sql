-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Feb 2020 pada 14.03
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_prediksistok`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_prakiraan`
--

CREATE TABLE `t_prakiraan` (
  `id_prakiraan` int(1) NOT NULL,
  `prakiraanawal` float(20,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_prakiraan`
--

INSERT INTO `t_prakiraan` (`id_prakiraan`, `prakiraanawal`) VALUES
(1, 26000.230);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_stok`
--

CREATE TABLE `t_stok` (
  `id` bigint(20) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `aktual` float(20,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_stok`
--

INSERT INTO `t_stok` (`id`, `bulan`, `tahun`, `aktual`) VALUES
(4, 1, 2020, 25000.000),
(10, 2, 2020, 27000.000),
(11, 3, 2020, 26500.439);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_prakiraan`
--
ALTER TABLE `t_prakiraan`
  ADD PRIMARY KEY (`id_prakiraan`);

--
-- Indeks untuk tabel `t_stok`
--
ALTER TABLE `t_stok`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_stok`
--
ALTER TABLE `t_stok`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
