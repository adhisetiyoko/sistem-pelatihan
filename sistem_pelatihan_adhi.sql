-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Bulan Mei 2025 pada 13.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_pelatihan_adhi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kelamin`
--

CREATE TABLE `jenis_kelamin` (
  `id_jenis_kelamin` char(1) NOT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_kelamin`
--

INSERT INTO `jenis_kelamin` (`id_jenis_kelamin`, `jenis_kelamin`) VALUES
('L', 'Laki-laki'),
('P', 'Perempuan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul_pelatihan`
--

CREATE TABLE `modul_pelatihan` (
  `id_modul` int(11) NOT NULL,
  `nama_modul` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `modul_pelatihan`
--

INSERT INTO `modul_pelatihan` (`id_modul`, `nama_modul`) VALUES
(1, 'Pemrograman'),
(2, 'Desain Grafis'),
(3, 'Animasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta_pelatihan`
--

CREATE TABLE `peserta_pelatihan` (
  `id_peserta` int(11) NOT NULL,
  `nik_peserta` varchar(20) NOT NULL,
  `no_induk_peserta` varchar(20) NOT NULL,
  `nama_peserta` varchar(100) NOT NULL,
  `jenis_kelamin_id` char(1) DEFAULT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `id_modul` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peserta_pelatihan`
--

INSERT INTO `peserta_pelatihan` (`id_peserta`, `nik_peserta`, `no_induk_peserta`, `nama_peserta`, `jenis_kelamin_id`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telp`, `id_modul`, `created_at`, `updated_at`, `status_aktif`) VALUES
(1, '3323091607020002', '2211055', 'Adhi Setiyoko', 'L', 'KABUPATEN TEMANGGUNG', '2002-07-16', 'Banjarsari, RT.01/05 Ngadirejo Temanggung, Jawa Tengah', '085701689957', 1, '2025-05-01 07:50:55', '2025-05-04 10:55:58', 0),
(2, '3323091607020003', '2211056', 'Dian Lestari', 'P', 'Magelang', '2001-05-10', 'Sukoharjo, RT.02/04 Salaman, Magelang, Jawa Tengah', '085701689958', 3, '2025-05-01 09:21:18', '2025-05-04 18:58:31', 1),
(3, '3323091607020004', '2211057', 'Budi Santoso', 'L', 'Solo', '1998-03-21', 'Kebonagung, RT.01/03 Salatiga, Jawa Tengah', '085701689959', 1, '2025-05-01 09:21:18', '2025-05-04 10:56:06', 1),
(4, '3323091607020005', '2211058', 'Siti Aisyah', 'P', 'Blora', '1999-11-05', 'Wonogiri, RT.04/06 Tegalrejo, Magelang, Jawa Tengah', '085701689960', 3, '2025-05-01 09:21:18', '2025-05-04 10:56:13', 1),
(5, '3323091607020006', '2211059', 'Ahmad Zulfikar', 'L', 'KABUPATEN MAGELANG', '1997-08-30', 'Kedu, RT.03/07 Banyumas, Jawa Tengah', '085701689961', 3, '2025-05-01 09:21:18', '2025-05-04 10:56:19', 1),
(6, '3323091607020007', '2211060', 'Rina Suryani', 'P', 'Blora', '1996-12-11', 'Tegalsari, RT.05/02 Blora, Jawa Tengah', '085701689962', 1, '2025-05-01 09:21:18', '2025-05-04 10:56:24', 1),
(7, '3323091607020008', '2211061', 'Cahyo Wibowo', 'L', 'Karanganyar', '2000-09-17', 'Karanganyar, RT.02/03 Solo, Jawa Tengah', '085701689963', 2, '2025-05-01 09:21:18', '2025-05-04 10:56:28', 1),
(8, '3323091607020009', '2211062', 'Lina Pratiwi', 'P', 'Yogyakarta', '2003-04-02', 'Pracimantoro, RT.06/08 Yogyakarta, Jawa Tengah', '085701689964', 1, '2025-05-01 09:21:18', '2025-05-04 10:56:34', 1),
(9, '3323091607020010', '2211063', 'Eko Wahyudi', 'L', 'Klaten', '2002-01-10', 'Sragen, RT.01/02 Klaten, Jawa Tengah', '085701689965', 2, '2025-05-01 09:21:18', '2025-05-04 10:56:43', 1),
(10, '3323091607020011', '2211064', 'Putri Maulani', 'P', 'Boyolali', '2000-02-20', 'Teguh, RT.04/01 Boyolali, Jawa Tengah', '085701689966', 2, '2025-05-01 09:21:18', '2025-05-04 10:56:46', 1),
(11, '3323091607020012', '2211010', 'Adhi', 'L', 'KABUPATEN TEMANGGUNG', '2002-07-16', 'Banjarsari, RT.01/05 Ngadirejo Temanggung, Jawa Tengah', '085701689958', 1, '2025-05-04 17:52:22', '2025-05-04 17:53:03', 1),
(12, '33230916000001', '2121212', 'Uswa', 'P', 'KABUPATEN MAGELANG', '2003-04-21', 'Secang', '089520937978', 1, '2025-05-04 18:52:59', '2025-05-04 18:54:38', 1),
(14, '3323092508000002', '2211067', 'Rina Kartika', 'P', 'Semarang', '2000-08-25', 'Jl. Melati No. 12, Banyumanik, Semarang, Jawa Tengah', '082312345678', 2, '2025-05-03 03:15:00', '2025-05-04 07:20:00', 1),
(15, '3323091607030002', '2211069', 'Adhi Setiyani', 'P', 'KABUPATEN TEMANGGUNG', '2001-12-12', 'Banjarsari', '089383993822', 1, '2025-05-06 01:02:49', '2025-05-06 01:04:08', 1),
(16, '3323091607020001', '2211000', 'as', 'L', 'KABUPATEN TEMANGGUNG', '2002-07-16', 'BJSR', '089383993822', 3, '2025-05-09 05:54:51', '2025-05-09 05:55:09', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_logout` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `ga_secret` varchar(50) DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `last_login`, `is_active`, `last_logout`, `last_activity`, `ga_secret`, `last_login_ip`) VALUES
(1, 'admin', '$2y$10$EonLL1.wtfIbORrrQ6657.nePcSlSYo5rH.CKgyNnH3w9fB/iS./K', 'admin@example.com', '2025-05-01 06:49:20', '2025-05-09 12:56:34', 1, '2025-05-07 08:23:09', '2025-05-09 12:56:34', 'AVQEE7KSX6Q2CVTN', '127.0.0.1'),
(2, 'operator', '$2y$10$ioFw9Ylko2kG680ivn1T4u/HWbtcBYCF7qPXdZ8izxlXULJdOmzXS', 'operator@example.com', '2025-05-01 07:30:15', '2025-05-07 08:23:37', 1, '2025-05-07 08:54:55', '2025-05-07 08:54:55', '75WW7AEY7ZEWBUDU', NULL),
(3, 'supervisor', '$2y$10$ioFw9Ylko2kG680ivn1T4u/HWbtcBYCF7qPXdZ8izxlXULJdOmzXS', 'supervisor@example.com', '2025-05-01 03:45:22', '2025-05-02 10:54:39', 1, '2025-05-02 18:07:05', '2025-05-02 18:07:05', NULL, NULL),
(4, 'manager', '$2y$10$ioFw9Ylko2kG680ivn1T4u/HWbtcBYCF7qPXdZ8izxlXULJdOmzXS', 'manager@example.com', '2025-04-29 02:15:30', '2025-05-02 19:55:22', 1, '2025-05-02 21:47:03', '2025-05-02 21:47:03', NULL, NULL),
(5, 'staff', '$2y$10$ioFw9Ylko2kG680ivn1T4u/HWbtcBYCF7qPXdZ8izxlXULJdOmzXS', 'staff@example.com', '2025-04-28 06:20:45', '2025-05-02 10:28:45', 1, '2025-05-02 10:50:28', '2025-05-02 10:50:28', NULL, NULL),
(6, 'analyst', '$2y$10$ioFw9Ylko2kG680ivn1T4u/HWbtcBYCF7qPXdZ8izxlXULJdOmzXS', 'analyst@example.com', '2025-04-30 04:10:05', NULL, 1, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jenis_kelamin`
--
ALTER TABLE `jenis_kelamin`
  ADD PRIMARY KEY (`id_jenis_kelamin`);

--
-- Indeks untuk tabel `modul_pelatihan`
--
ALTER TABLE `modul_pelatihan`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indeks untuk tabel `peserta_pelatihan`
--
ALTER TABLE `peserta_pelatihan`
  ADD PRIMARY KEY (`id_peserta`),
  ADD UNIQUE KEY `nik_peserta` (`nik_peserta`),
  ADD UNIQUE KEY `no_induk_peserta` (`no_induk_peserta`),
  ADD KEY `modul_id` (`id_modul`),
  ADD KEY `jenis_kelamin` (`jenis_kelamin_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `modul_pelatihan`
--
ALTER TABLE `modul_pelatihan`
  MODIFY `id_modul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peserta_pelatihan`
--
ALTER TABLE `peserta_pelatihan`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peserta_pelatihan`
--
ALTER TABLE `peserta_pelatihan`
  ADD CONSTRAINT `peserta_pelatihan_ibfk_1` FOREIGN KEY (`id_modul`) REFERENCES `modul_pelatihan` (`id_modul`),
  ADD CONSTRAINT `peserta_pelatihan_ibfk_2` FOREIGN KEY (`jenis_kelamin_id`) REFERENCES `jenis_kelamin` (`id_jenis_kelamin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
