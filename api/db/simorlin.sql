-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 04 Jul 2021 pada 13.17
-- Versi server: 8.0.18
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simorlin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `isadmin` tinyint(4) NOT NULL DEFAULT '0',
  `password` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `apikey` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isblock` tinyint(4) NOT NULL DEFAULT '0',
  `path` varchar(250) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '*',
  `whitelist` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blacklist` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`uid`, `email`, `isadmin`, `password`, `apikey`, `isblock`, `path`, `whitelist`, `blacklist`, `created`, `deleted`) VALUES
(1, 'admin@email.com', 1, '$2y$10$761Xglwe2kYeTWon4CVLreGpyvMUoYY9TWYgv2QxUr1f8wfxFcPZi', NULL, 0, '*', NULL, NULL, '2021-07-04 13:13:36', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
