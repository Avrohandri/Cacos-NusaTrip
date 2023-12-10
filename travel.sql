-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Des 2023 pada 03.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `destinasi`
--

CREATE TABLE `destinasi` (
  `id_destinasi` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `subtitle` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `background_image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `destinasi`
--

INSERT INTO `destinasi` (`id_destinasi`, `nama`, `subtitle`, `image`, `deskripsi`, `background_image`) VALUES
(11, 'Yogyakarta', 'Explore the rich history and culture of Yogyakarta.', '1701334358_discover-1.jpg', 'Jogja, tempat di mana sejarah berkisah dalam warna-warna tradisi, dan memelukmu dengan kehangatan kebudayaan yang tak terlupakan.', '1701334358_header_yogyakarta.jpg'),
(16, 'Malang', 'Immerse yourself in the enchanting nature and captivating stories of Malang.', '1701335013_Malang.jpg', 'Malang, kota yang merangkulmu dalam pelukan alamnya yang memesona dan cerita kesejukan yang tak terlupakan.', '1701335013_background_Malang.jpg'),
(18, 'Denpasar', 'Explore the rich history and culture of Denpasar.', '1701335174_Denpasar.jpg', 'Denpasar, di mana pesona pulau Bali menggoda setiap indera, dan keindahan alamnya menari bersama budaya yang kaya.', '1701335174_background_Denpasar.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `discover`
--

CREATE TABLE `discover` (
  `id_discover` int(11) NOT NULL,
  `nama` text NOT NULL,
  `id_destinasi` int(11) NOT NULL,
  `destinasi` text NOT NULL,
  `deskripsi` text NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `discover`
--

INSERT INTO `discover` (`id_discover`, `nama`, `id_destinasi`, `destinasi`, `deskripsi`, `image`) VALUES
(5, 'Keraton Yogyakarta', 11, 'Yogyakarta', 'Melihat kearifan budaya Yogyakarta melalui seni bangunan keraton yang khas dan tradisi kesultanan yang masih dilakukan. ', '1701403870_Keraton_Yogyakarta.jpg'),
(6, 'Pantai Malang', 16, 'Malang', 'Tempat wisata Instagramable tidak hanya berlokasi dataran tinggi, tapi juga di dataran rendah, salah satunya Pantai Parang Dowo.', '1701404176_Pantai_Malang.jpg'),
(7, 'Malioboro', 11, 'Yogyakarta', 'Jelas saja tempat wisata di Jogja yang satu ini wajib ada di nomor 1. Kamu betul-betul belum ke Jogja namanya kalau enggak mampir atau paling enggak lewat Jalan Malioboro!Selain untuk beli oleh-oleh, kamu juga bisa makan-makan di area Malioboro.', '1701404664_Malioboro.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `nama` text NOT NULL,
  `no_telepon` varchar(50) NOT NULL,
  `destinasi` text NOT NULL,
  `tanggal_pemesanan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `nama`, `no_telepon`, `destinasi`, `tanggal_pemesanan`) VALUES
(7, 'Yaman', '089132747', 'Malang', '2023-11-21'),
(8, 'faisol', '0812312312', 'palembang', '2023-12-13'),
(10, 'Syaif', '08412312362', 'semarang', '2023-12-05'),
(11, 'Brian', '081236533454', 'Kaliurang', '2023-12-11'),
(13, 'Bawiko', '087424346', 'ambon', '2023-12-21'),
(14, 'Ino', '082392144', 'yogyakarta', '2004-12-11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `token` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `token`) VALUES
(2, 'user', '$2y$10$VO.g.v3PYEUftFuVJbemLO.iZLIEA46ko9kmFgnq04pCthFsr8zrW', 'a3b0041aa7e856eb1edd52186fd2f3338000aa740edcf0e24953c662b5e9d8f5'),
(4, 'ser', '$2y$10$Gp.LxJ89oOV.leZu2R6/JO27f46MfvP1p43.2Wz91GnlFJ7du965.', 'dbda4621e86d91956a907f8a501e422a1a1d2c8676e0662bbf73059bab985b55'),
(5, 'user', '$2y$10$AUH8fOXN1xQtoGG14tczAeMITMCK7TPI5i/zb8dd0MA4n19oU7Iti', ''),
(6, 'faisol', '$2y$10$87bUe8fNsiP2.WVw/XYlQu9BTWBmGC9Lh7qvBrpHgPSRnBP2AzAWu', '982738618e9633a19b6ad6c9be8ffac50587475fdf0d13911647bd0bf9f46ad8'),
(7, 'Akbar', '$2y$10$Rq9.pH1sLu.pEnIO9pWpeOA//eKFCU2jnZBWcuAsAzamQkJaoEoEu', '5294defe95feaa01985264ef09e94d7538f449664a0624d4ea4cb705738f2242');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `destinasi`
--
ALTER TABLE `destinasi`
  ADD PRIMARY KEY (`id_destinasi`);

--
-- Indeks untuk tabel `discover`
--
ALTER TABLE `discover`
  ADD PRIMARY KEY (`id_discover`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `destinasi`
--
ALTER TABLE `destinasi`
  MODIFY `id_destinasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `discover`
--
ALTER TABLE `discover`
  MODIFY `id_discover` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
