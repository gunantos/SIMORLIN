-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 09 Jul 2021 pada 05.45
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
-- Struktur dari tabel `arah_jalan`
--

CREATE TABLE `arah_jalan` (
  `id_arah_jalan` int(11) NOT NULL,
  `nama_arah_jalan` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `corousel`
--

CREATE TABLE `corousel` (
  `idcorousel` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `text` varchar(250) DEFAULT NULL,
  `img` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `corousel`
--

INSERT INTO `corousel` (`idcorousel`, `title`, `text`, `img`, `created`, `deleted`) VALUES
(1, 'Peta', 'Peta Kabupaten Bandung', 'image/corousel/peta.png', '2021-07-09 02:31:56', NULL),
(2, 'Peta', 'Dinas Perhubungan Kabupaten Bandung', 'image/corousel/perhubungan.jpg', '2021-07-09 02:39:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `desa`
--

CREATE TABLE `desa` (
  `id_desa` int(11) NOT NULL,
  `kode_desa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_desa` varchar(150) NOT NULL,
  `kelurahan` smallint(3) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_terpasang`
--

CREATE TABLE `gambar_terpasang` (
  `id_gambar_terpasang` int(11) NOT NULL,
  `id_terpasang` int(11) NOT NULL,
  `gambar_rambu` varchar(250) DEFAULT NULL,
  `gambar_koordinat` varchar(250) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jalan`
--

CREATE TABLE `jalan` (
  `id_jalan` int(11) NOT NULL,
  `nama_jalan` varchar(250) NOT NULL,
  `id_ruas_jalan` int(11) NOT NULL,
  `altitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_perlengkapan`
--

CREATE TABLE `jenis_perlengkapan` (
  `id_jenis_pelengkapan` int(11) NOT NULL,
  `nama_perlengkapan` varchar(250) NOT NULL,
  `icon_perlengkapan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jenis_perlengkapan`
--

INSERT INTO `jenis_perlengkapan` (`id_jenis_pelengkapan`, `nama_perlengkapan`, `icon_perlengkapan`, `created`, `deleted`) VALUES
(1, 'RAMBU', NULL, '2021-07-09 03:33:07', NULL),
(2, 'MARKA', NULL, '2021-07-09 03:33:07', NULL),
(3, 'LAMPU LALU LINTAS', NULL, '2021-07-09 03:33:07', NULL),
(4, 'PENERANGAN JALAN', NULL, '2021-07-09 03:33:07', NULL),
(5, 'ALAT PENGENDALI DAN PENGAMAN PENGGUNA JALAN', NULL, '2021-07-09 03:33:07', NULL),
(6, 'ALAT PENGAWASAN DAN PENGAMANAN JALAN', NULL, '2021-07-09 03:33:07', '2021-07-08 17:00:00'),
(7, 'FASILITAS UNTUK SEPEDA, PEJALAN KAKI DAN PENYANDANG CACAT', NULL, '2021-07-09 03:33:07', NULL),
(8, 'FASILITAS PENDUKUNG LAINYA', NULL, '2021-07-09 03:33:07', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kecamatan` int(11) NOT NULL,
  `kode_kecamatan` varchar(20) DEFAULT NULL,
  `nama_kecamatan` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`id_kecamatan`, `kode_kecamatan`, `nama_kecamatan`, `created`, `deleted`) VALUES
(1, '32.04.16', 'Arjasari', '2021-07-09 04:15:39', NULL),
(2, '32.04.32', 'Baleendah', '2021-07-09 04:15:39', NULL),
(3, '32.04.13', 'Banjaran', '2021-07-09 04:15:39', NULL),
(4, '32.04.08', 'Bojongsoang', '2021-07-09 04:15:39', NULL),
(5, '32.04.44', 'Cangkuang', '2021-07-09 04:15:39', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruas_jalan`
--

CREATE TABLE `ruas_jalan` (
  `id_ruas_jalan` int(11) NOT NULL,
  `nama_ruas_jalan` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `ruas_jalan`
--

INSERT INTO `ruas_jalan` (`id_ruas_jalan`, `nama_ruas_jalan`, `created`, `deleted`) VALUES
(1, 'RAYA SOREANG - CIPATIK', '2021-07-09 04:11:07', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `terpasang`
--

CREATE TABLE `terpasang` (
  `id_terpasang` int(11) NOT NULL,
  `id_arah_jalan` int(11) NOT NULL,
  `id_perlengkapan` int(11) NOT NULL,
  `id_jalan` int(11) NOT NULL,
  `kondisi` varchar(25) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `apikey` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `path` varchar(250) DEFAULT NULL,
  `isblock` tinyint(250) NOT NULL DEFAULT '0',
  `whitelist` varchar(250) DEFAULT NULL,
  `blacklist` varchar(250) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`uid`, `email`, `password`, `apikey`, `path`, `isblock`, `whitelist`, `blacklist`, `created`, `deleted`) VALUES
(1, 'admin@email.com', '$2y$10$44skr42aHd3TNrYkqAgYkOqcERd3hfBvJP0ymBrNSK3/78Z/xJlLi', NULL, NULL, 0, NULL, NULL, '2021-06-29 14:42:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `arah_jalan`
--
ALTER TABLE `arah_jalan`
  ADD PRIMARY KEY (`id_arah_jalan`);

--
-- Indeks untuk tabel `corousel`
--
ALTER TABLE `corousel`
  ADD PRIMARY KEY (`idcorousel`);

--
-- Indeks untuk tabel `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id_desa`);

--
-- Indeks untuk tabel `gambar_terpasang`
--
ALTER TABLE `gambar_terpasang`
  ADD PRIMARY KEY (`id_gambar_terpasang`);

--
-- Indeks untuk tabel `jalan`
--
ALTER TABLE `jalan`
  ADD PRIMARY KEY (`id_jalan`);

--
-- Indeks untuk tabel `jenis_perlengkapan`
--
ALTER TABLE `jenis_perlengkapan`
  ADD PRIMARY KEY (`id_jenis_pelengkapan`);

--
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`);

--
-- Indeks untuk tabel `ruas_jalan`
--
ALTER TABLE `ruas_jalan`
  ADD PRIMARY KEY (`id_ruas_jalan`);

--
-- Indeks untuk tabel `terpasang`
--
ALTER TABLE `terpasang`
  ADD PRIMARY KEY (`id_terpasang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `arah_jalan`
--
ALTER TABLE `arah_jalan`
  MODIFY `id_arah_jalan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `corousel`
--
ALTER TABLE `corousel`
  MODIFY `idcorousel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `desa`
--
ALTER TABLE `desa`
  MODIFY `id_desa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gambar_terpasang`
--
ALTER TABLE `gambar_terpasang`
  MODIFY `id_gambar_terpasang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jalan`
--
ALTER TABLE `jalan`
  MODIFY `id_jalan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_perlengkapan`
--
ALTER TABLE `jenis_perlengkapan`
  MODIFY `id_jenis_pelengkapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id_kecamatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ruas_jalan`
--
ALTER TABLE `ruas_jalan`
  MODIFY `id_ruas_jalan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `terpasang`
--
ALTER TABLE `terpasang`
  MODIFY `id_terpasang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
