CREATE TABLE `arah_jalan`
(
  `id_arah_jalan` int
(11) NOT NULL,
  `nama_arah_jalan` varchar
(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

INSERT INTO `arah_jalan` (`id_arah_jalan`,
`nama_arah_jalan`, `created`, `deleted`) VALUES
(1, 'test', '2021-07-10 17:49:13', NULL);

CREATE TABLE `corousel`
(
  `idcorousel` int
(11) NOT NULL,
  `title` varchar
(150) DEFAULT NULL,
  `text` varchar
(250) DEFAULT NULL,
  `img` varchar
(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

INSERT INTO `corousel` (`idcorousel`,
`title`, `text`, `img`, `created`, `deleted`) VALUES
(1, 'Peta', 'Peta Kabupaten Bandung', 'http://localhost:8080/image/corousel/peta.png', '2021-07-09 02:31:56', '2021-07-11 06:01:38'),
(2, 'Peta', 'Dinas Perhubungan Kabupaten Bandung', 'http://localhost:8080/image/corousel/perhubungan.jpg', '2021-07-09 02:39:05', NULL),
(3, NULL, NULL, 'http://localhost:8080/image\\corousel\\dashboard_2.png', '2021-07-11 06:13:59', '2021-07-11 06:14:20'),
(4, NULL, NULL, 'http://localhost:8080/image\\corousel\\map.png', '2021-07-11 06:14:24', '2021-07-11 06:14:27'),
(5, NULL, NULL, 'http://localhost:8080/image\\corousel\\map_1.png', '2021-07-11 06:15:32', '2021-07-11 06:19:28'),
(6, NULL, NULL, 'http://localhost:8080/image\\corousel\\dishubbandung.jpg', '2021-07-11 06:20:23', '2021-07-11 06:20:27'),
(7, NULL, NULL, 'http://localhost:8080/image\\corousel\\dishubbandung.jpg', '2021-07-11 06:20:30', NULL);

CREATE TABLE `desa`
(
  `id_desa` int
(11) NOT NULL,
  `id_kecamatan` int
(11) NOT NULL,
  `kode_desa` varchar
(20) DEFAULT NULL,
  `nama_desa` varchar
(150) NOT NULL,
  `kelurahan` smallint
(3) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);


INSERT INTO `desa` (`id_desa`,
`id_kecamatan`, `kode_desa`, `nama_desa`, `kelurahan`, `created`, `deleted`) VALUES
(1, 1, 'test', 'testest', 1, '2021-07-10 15:41:51', NULL),
(2, 2, 'tes', 'tss', 1, '2021-07-10 16:56:31', NULL);



CREATE TABLE `gambar_terpasang`
(
  `id_gambar_terpasang` int
(11) NOT NULL,
  `id_terpasang` int
(11) NOT NULL,
  `gambar_rambu` varchar
(250) DEFAULT NULL,
  `gambar_koordinat` varchar
(250) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);


CREATE TABLE `jalan`
(
  `id_jalan` int
(11) NOT NULL,
  `id_desa` int
(11) NOT NULL,
  `nama_jalan` varchar
(250) NOT NULL,
  `id_ruas_jalan` int
(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);


INSERT INTO `jalan` (`id_jalan`,
`id_desa`, `nama_jalan`, `id_ruas_jalan`, `created`, `deleted`) VALUES
(1, 1, 'test', 1, '2021-07-11 04:16:37', NULL),
(2, 1, 'tes', 1, '2021-07-10 17:04:46', '2021-07-10 17:37:34');


CREATE TABLE `jenis_perlengkapan`
(
  `id_jenis_pelengkapan` int
(11) NOT NULL,
  `nama_perlengkapan` varchar
(250) NOT NULL,
  `icon_perlengkapan` varchar
(150) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

INSERT INTO `jenis_perlengkapan` (`id_jenis_pelengkapan`,
`nama_perlengkapan`, `icon_perlengkapan`, `created`, `deleted`) VALUES
(1, 'RAMBU', NULL, '2021-07-09 03:33:07', NULL),
(2, 'MARKA', NULL, '2021-07-09 03:33:07', NULL),
(3, 'LAMPU LALU LINTAS', NULL, '2021-07-09 03:33:07', NULL),
(4, 'PENERANGAN JALAN', NULL, '2021-07-09 03:33:07', NULL),
(5, 'ALAT PENGENDALI DAN PENGAMAN PENGGUNA JALAN', NULL, '2021-07-09 03:33:07', NULL),
(6, 'ALAT PENGAWASAN DAN PENGAMANAN JALAN', NULL, '2021-07-09 03:33:07', '2021-07-08 17:00:00'),
(7, 'FASILITAS UNTUK SEPEDA, PEJALAN KAKI DAN PENYANDANG CACAT', NULL, '2021-07-09 03:33:07', NULL),
(8, 'FASILITAS PENDUKUNG LAINYA', NULL, '2021-07-09 03:33:07', NULL),
(9, 'test', '', '2021-07-10 17:54:58', '2021-07-10 17:56:04');


CREATE TABLE `kebutuhan`
(
  `id_kebutuhan` int
(11) NOT NULL,
  `id_arah_jalan` int
(11) NOT NULL,
  `id_perlengkapan` int
(11) NOT NULL,
  `id_ruas_jalan` int
(11) NOT NULL,
  `id_jalan` int
(11) NOT NULL,
  `altitude` varchar
(30) DEFAULT NULL,
  `longitude` varchar
(30) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

--
-- Dumping data untuk tabel `kebutuhan`
--

INSERT INTO `kebutuhan` (`id_kebutuhan`,
`id_arah_jalan`, `id_perlengkapan`, `id_ruas_jalan`, `id_jalan`, `altitude`, `longitude`, `created`, `deleted`) VALUES
(1, 1, 1, 1, 1, '-6.976775', '107.576439', '2021-07-10 22:56:41', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan`
(
  `id_kecamatan` int
(11) NOT NULL,
  `kode_kecamatan` varchar
(20) DEFAULT NULL,
  `nama_kecamatan` varchar
(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`id_kecamatan`,
`kode_kecamatan`, `nama_kecamatan`, `created`, `deleted`) VALUES
(1, '32.04.16', 'Arjasari', '2021-07-09 04:15:39', NULL),
(2, '32.04.32', 'Baleendah', '2021-07-09 04:15:39', NULL),
(3, '32.04.13', 'Banjaran', '2021-07-09 04:15:39', NULL),
(4, '32.04.08', 'Bojongsoang', '2021-07-09 04:15:39', NULL),
(5, '32.04.44', 'Cangkuang', '2021-07-09 04:15:39', NULL),
(6, 'test', 'estser', '2021-07-10 15:19:48', NULL),
(7, 'test', 'estse', '2021-07-10 15:31:53', NULL),
(8, 'test', 'estses', '2021-07-10 15:32:06', '2021-07-10 15:32:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruas_jalan`
--

CREATE TABLE `ruas_jalan`
(
  `id_ruas_jalan` int
(11) NOT NULL,
  `nama_ruas_jalan` varchar
(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

--
-- Dumping data untuk tabel `ruas_jalan`
--

INSERT INTO `ruas_jalan` (`id_ruas_jalan`,
`nama_ruas_jalan`, `created`, `deleted`) VALUES
(1, 'RAYA SOREANG - CIPATIK', '2021-07-09 04:11:07', NULL),
(2, 'testasa', '2021-07-10 17:45:17', '2021-07-10 17:45:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tersedia`
--

CREATE TABLE `tersedia`
(
  `id_tersedia` int
(11) NOT NULL,
  `id_arah_jalan` int
(11) NOT NULL,
  `id_ruas_jalan` int
(11) NOT NULL,
  `id_perlengkapan` int
(11) NOT NULL,
  `id_jalan` int
(11) NOT NULL,
  `gambar_rambu` varchar
(250) DEFAULT NULL,
  `gambar_koordinat` varchar
(250) DEFAULT NULL,
  `kondisi` varchar
(25) NOT NULL,
  `altitude` varchar
(30) DEFAULT NULL,
  `longitude` varchar
(30) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

--
-- Dumping data untuk tabel `tersedia`
--

INSERT INTO `tersedia` (`id_tersedia`,
`id_arah_jalan`,
`id_ruas_jalan`,
`id_perlengkapan`, `id_jalan`, `gambar_rambu`, `gambar_koordinat`, `kondisi`, `altitude`, `longitude`, `created`, `deleted`) VALUES
(1, 1, 1, 1, 1, 'http://localhost:8080/image/rambu/login_6.PNG', 'http://localhost:8080/image/koordinat/map_6.png', 'rusak', '-6.964687', '107.592520', '2021-07-10 21:55:52', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user`
(
  `uid` int
(11) NOT NULL,
  `email` varchar
(250) NOT NULL,
  `password` varchar
(250) NOT NULL,
  `apikey` varchar
(250) DEFAULT NULL,
  `path` varchar
(250) DEFAULT NULL,
  `isblock` tinyint
(250) NOT NULL DEFAULT '0',
  `whitelist` varchar
(250) DEFAULT NULL,
  `blacklist` varchar
(250) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON
UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL
);

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user`
  (`uid`, `email`, `password`, `apikey`, `path`, `isblock`, `whitelist`, `blacklist`, `created`, `deleted`) VALUES
(1, 'admin@email.com', '$2y$10$44skr42aHd3TNrYkqAgYkOqcERd3hfBvJP0ymBrNSK3/78Z/xJlLi', NULL, NULL, 0, NULL, NULL, '2021-06-29 14:42:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `arah_jalan`
--
ALTER TABLE `arah_jalan`
ADD PRIMARY KEY
(`id_arah_jalan`);

--
-- Indeks untuk tabel `corousel`
--
ALTER TABLE `corousel`
ADD PRIMARY KEY
(`idcorousel`);

--
-- Indeks untuk tabel `desa`
--
ALTER TABLE `desa`
ADD PRIMARY KEY
(`id_desa`);

--
-- Indeks untuk tabel `gambar_terpasang`
--
ALTER TABLE `gambar_terpasang`
ADD PRIMARY KEY
(`id_gambar_terpasang`);

--
-- Indeks untuk tabel `jalan`
--
ALTER TABLE `jalan`
ADD PRIMARY KEY
(`id_jalan`);

--
-- Indeks untuk tabel `jenis_perlengkapan`
--
ALTER TABLE `jenis_perlengkapan`
ADD PRIMARY KEY
(`id_jenis_pelengkapan`);

--
-- Indeks untuk tabel `kebutuhan`
--
ALTER TABLE `kebutuhan`
ADD PRIMARY KEY
(`id_kebutuhan`);

--
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
ADD PRIMARY KEY
(`id_kecamatan`);

--
-- Indeks untuk tabel `ruas_jalan`
--
ALTER TABLE `ruas_jalan`
ADD PRIMARY KEY
(`id_ruas_jalan`);

--
-- Indeks untuk tabel `tersedia`
--
ALTER TABLE `tersedia`
ADD PRIMARY KEY
(`id_tersedia`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
ADD PRIMARY KEY
(`uid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `arah_jalan`
--
ALTER TABLE `arah_jalan`
  MODIFY `id_arah_jalan` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `corousel`
--
ALTER TABLE `corousel`
  MODIFY `idcorousel` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `desa`
--
ALTER TABLE `desa`
  MODIFY `id_desa` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gambar_terpasang`
--
ALTER TABLE `gambar_terpasang`
  MODIFY `id_gambar_terpasang` int
(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jalan`
--
ALTER TABLE `jalan`
  MODIFY `id_jalan` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_perlengkapan`
--
ALTER TABLE `jenis_perlengkapan`
  MODIFY `id_jenis_pelengkapan` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kebutuhan`
--
ALTER TABLE `kebutuhan`
  MODIFY `id_kebutuhan` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id_kecamatan` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `ruas_jalan`
--
ALTER TABLE `ruas_jalan`
  MODIFY `id_ruas_jalan` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tersedia`
--
ALTER TABLE `tersedia`
  MODIFY `id_tersedia` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `uid` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
