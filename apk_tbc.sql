-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2022 at 11:56 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apk_tbc`
--

-- --------------------------------------------------------

--
-- Table structure for table `aturan`
--

CREATE TABLE `aturan` (
  `id_aturan` int(11) NOT NULL COMMENT 'aturan_minum_obat',
  `nama_aturan` varchar(128) NOT NULL,
  `deskripsi` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aturan`
--

INSERT INTO `aturan` (`id_aturan`, `nama_aturan`, `deskripsi`) VALUES
(1, 'Tahap intensif tiap hari selama 56 hari RHZE\r\n(150/75/400/275)', 'makan yang banyak agar cepat sembuh');

-- --------------------------------------------------------

--
-- Table structure for table `detail_riwayat`
--

CREATE TABLE `detail_riwayat` (
  `id_detail_riwayat` int(11) NOT NULL,
  `status` enum('sudah','belum') NOT NULL,
  `id_riwayat` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `edukasi`
--

CREATE TABLE `edukasi` (
  `id_edukasi` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `deskripsi` text NOT NULL,
  `image` varchar(32) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 = Artikel.\r\n2 = Video.',
  `url` text NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '0 = Tidak Aktif.\r\n1 = Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `edukasi`
--

INSERT INTO `edukasi` (`id_edukasi`, `title`, `deskripsi`, `image`, `type`, `url`, `is_active`) VALUES
(1, 'MENGENAL FAKTA SEPUTAR TBC', 'Suatu penyakit bakteri menular yang berpotensi serius yang terutama mempengaruhi paru-paru. Bakteri penyebab TB menyebar ketika orang yang terinfeksi batuk atau bersin.\r\n\r\nKebanyakan orang yang terinfeksi dengan bakteri yang menyebabkan tuberkulosis tidak memiliki gejala. Ketika gejala memang terjadi, biasanya berupa batuk (kadang-kadang ada bercak darah), penurunan berat badan, berkeringat di malam hari, dan demam.\r\n\r\nPengobatan tidak selalu diperlukan untuk orang-orang tanpa gejala. Pasien dengan gejala aktif akan membutuhkan perjalanan pengobatan panjang yang melibatkan beberapa antibiotik.', 'image_1605942157.jpg', 1, '', 1),
(2, 'PENULARAN TB', '', 'image_1605942247.jpg', 2, 'odPHyH0gkjc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_penderita`
--

CREATE TABLE `jenis_penderita` (
  `id_jenis_penderita` int(11) NOT NULL,
  `nama_jenis_penderita` varchar(64) NOT NULL,
  `waktu_pengobatan` int(11) NOT NULL COMMENT 'dalam_bentuk_bulan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_penderita`
--

INSERT INTO `jenis_penderita` (`id_jenis_penderita`, `nama_jenis_penderita`, `waktu_pengobatan`) VALUES
(1, 'TB', 6),
(2, 'TB MDR Regimen Jangka Pendek', 12),
(3, 'TB MDR Regimen Individu', 24);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(64) NOT NULL,
  `berat_badan` varchar(16) DEFAULT NULL,
  `fase` varchar(8) NOT NULL,
  `id_aturan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `berat_badan`, `fase`, `id_aturan`) VALUES
(1, 'Kategori 1', '30-37', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kecamatan` int(11) NOT NULL,
  `nama_kecamatan` varchar(64) NOT NULL,
  `id_kota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id_kecamatan`, `nama_kecamatan`, `id_kota`) VALUES
(1, 'Bungursari', NULL),
(2, 'Cibeureum', NULL),
(3, 'Cihideung', NULL),
(4, 'Cipedes', NULL),
(5, 'Indihiang', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `konsultasi_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `received_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `message` text NOT NULL,
  `status_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konsultasi`
--

INSERT INTO `konsultasi` (`konsultasi_id`, `sender_id`, `received_id`, `date`, `message`, `status_id`) VALUES
(1, 5, 6, '2020-10-26 20:38:42', 'Heey!', 2),
(2, 6, 5, '2020-10-26 20:38:47', 'Apa?', 2),
(4, 5, 6, '2020-10-26 20:38:49', 'Ada yang ingin saya tanyakan', 2),
(5, 6, 5, '2020-10-26 20:38:51', 'Tentang apa?', 2),
(52, 5, 6, '2020-11-11 22:51:00', 'tentang kita', 2),
(54, 6, 5, '2020-11-11 22:59:00', 'Lo aja kali', 2);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`) VALUES
(1, 'Rifampisin');

-- --------------------------------------------------------

--
-- Table structure for table `obat_kategori`
--

CREATE TABLE `obat_kategori` (
  `id_obat_kategori` int(11) NOT NULL,
  `jumlah_obat` varchar(8) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat_kategori`
--

INSERT INTO `obat_kategori` (`id_obat_kategori`, `jumlah_obat`, `id_kategori`, `id_obat`) VALUES
(1, '60', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penderita`
--

CREATE TABLE `penderita` (
  `id_penderita` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL COMMENT 'nomor_induk_kependudukan',
  `umur` int(11) NOT NULL,
  `berat_badan` int(11) NOT NULL,
  `tinggi_badan` int(11) NOT NULL,
  `gol_darah` enum('A','B','AB','O') NOT NULL,
  `alamat` varchar(64) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_pmo` int(11) DEFAULT NULL COMMENT 'user_id PMO',
  `id_puskesmas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penderita`
--

INSERT INTO `penderita` (`id_penderita`, `user_id`, `nik`, `umur`, `berat_badan`, `tinggi_badan`, `gol_darah`, `alamat`, `id_kategori`, `id_pmo`, `id_puskesmas`) VALUES
(2, 5, '3271357908642135', 26, 57, 171, 'B', 'Jl. Padasuka No.17, Tawangsari, Tasikmalaya, Jawa Barat', 1, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengawas_minum_obat`
--

CREATE TABLE `pengawas_minum_obat` (
  `id_pmo` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `alamat_pmo` varchar(128) NOT NULL,
  `pekerjaan` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengawas_minum_obat`
--

INSERT INTO `pengawas_minum_obat` (`id_pmo`, `user_id`, `alamat_pmo`, `pekerjaan`) VALUES
(3, 6, 'Jalan Tamansari', 'Perawat');

-- --------------------------------------------------------

--
-- Table structure for table `pengingat_obat`
--

CREATE TABLE `pengingat_obat` (
  `reminder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'user_id (penderita)',
  `id_jenis_penderita` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jam_alarm` varchar(8) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 = proses_pengobatan.\r\n2 = selesai_pengobatan.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengingat_obat`
--

INSERT INTO `pengingat_obat` (`reminder_id`, `user_id`, `id_jenis_penderita`, `tanggal_mulai`, `tanggal_selesai`, `jam_alarm`, `deskripsi`, `status`) VALUES
(18, 5, 1, '2020-08-01', '2021-05-01', '08:00', 'sebelum makan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `puskesmas`
--

CREATE TABLE `puskesmas` (
  `id_puskesmas` int(11) NOT NULL,
  `kode_puskesmas` varchar(128) NOT NULL,
  `nama_puskesmas` varchar(64) NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `alamat` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `puskesmas`
--

INSERT INTO `puskesmas` (`id_puskesmas`, `kode_puskesmas`, `nama_puskesmas`, `id_kecamatan`, `alamat`) VALUES
(1, '0987654321', 'Puskesmas Cipedes', 4, 'Jalan Tawang');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `waktu` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `waktu`, `user_id`, `status`) VALUES
(1, '2020-11-11', 5, 1),
(2, '2020-11-10', 5, 1),
(3, '2020-11-09', 5, 0),
(9, '2020-11-13', 5, 1),
(10, '2020-11-14', 5, 0),
(11, '2020-11-16', 5, 1),
(12, '2020-11-17', 5, 1),
(13, '2020-11-21', 5, 1),
(14, '2020-11-24', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `screening`
--

CREATE TABLE `screening` (
  `screening_id` int(11) NOT NULL,
  `soal` text NOT NULL,
  `ya` varchar(1) NOT NULL,
  `tidak` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `screening`
--

INSERT INTO `screening` (`screening_id`, `soal`, `ya`, `tidak`) VALUES
(1, 'Apakah anda kontak serumah dengan penderita TB ?', '1', '0'),
(2, 'Apakah anda mengalami batuk lebih dari 2 minggu ?', '1', '0'),
(3, 'Apakah anda mengalami penurunan berat badan ?', '1', '0'),
(4, 'Apakah anda melakukan imunisasi BGC ?', '0', '1'),
(5, 'Apakah anda merokok ?', '1', '0'),
(6, 'Apakah anda mengkonsumsi makanan bergizi untuk menjaga kesehatan tubuh ?', '0', '1'),
(7, 'Apakah linkungan rumah anda bersih ?', '0', '1'),
(8, 'Apakah rumah anda memiliki ventilasi untuk akses masuk sinar matahari ?', '0', '1'),
(9, 'Apakah alat makan anda terpisah dengan anggota keluarga lainnya ?', '0', '1'),
(10, 'Apakah anda melakukan olahraga setiap hari ?', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL,
  `setting_value` text NOT NULL,
  `setting_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `setting_name`, `setting_value`, `setting_description`) VALUES
(1, 'PRIVACY_POLICE', '<h3>Kebijakan Privasi</h3><p>Ini adalah Kebijakan Privasi Aplikasi SMART TB</p>', NULL),
(2, 'TERM_SERVICE', '<h3>Ketentuan Layanan</h3><p>Ini adalah Ketentuan Layanan Aplikasi SMART TB</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status_konsultasi`
--

CREATE TABLE `status_konsultasi` (
  `status_konsultasi_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_konsultasi`
--

INSERT INTO `status_konsultasi` (`status_konsultasi_id`, `status`, `deskripsi`) VALUES
(1, 'Terkirim', 'Pesan telah dikirim'),
(2, 'Dibaca', 'Pesan telah dibaca'),
(3, 'Gagal', 'Pesan gagal dikirim');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(64) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `email` varchar(32) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `profile_pic` varchar(32) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `password` varchar(128) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `full_name`, `gender`, `email`, `phone`, `profile_pic`, `date_of_birth`, `password`, `user_type_id`, `date_created`) VALUES
(1, 'Alamsyah Firdaus', 'L', 'alamsyahfirdaus@gmail.com', '089693839624', NULL, '1998-07-31', '202cb962ac59075b964b07152d234b70', 1, '2020-10-17 10:49:13'),
(5, 'Caesar Acquilla', 'L', 'caesaracquilla@gmail.com', '081234098765', 'image_1605943084.png', '1994-08-03', '74ee55083a714aa3791f8d594fea00c9', 2, '2020-09-27 22:28:05'),
(6, 'Dadang Kurnia', 'L', 'dadangkurnia@gmail.com', '081234135797', 'image_1605940400.png', '1985-12-06', '6a204bd89f3c8348afd5c77c717a097a', 3, '2020-11-21 13:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `type_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `type_name`) VALUES
(1, 'Administrator'),
(2, 'Penderita'),
(3, 'Pengawas Minum Obat');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aturan`
--
ALTER TABLE `aturan`
  ADD PRIMARY KEY (`id_aturan`);

--
-- Indexes for table `detail_riwayat`
--
ALTER TABLE `detail_riwayat`
  ADD PRIMARY KEY (`id_detail_riwayat`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_riwayat` (`id_riwayat`);

--
-- Indexes for table `edukasi`
--
ALTER TABLE `edukasi`
  ADD PRIMARY KEY (`id_edukasi`);

--
-- Indexes for table `jenis_penderita`
--
ALTER TABLE `jenis_penderita`
  ADD PRIMARY KEY (`id_jenis_penderita`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `id_aturan` (`id_aturan`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`),
  ADD KEY `id_kota` (`id_kota`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`konsultasi_id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `obat_kategori`
--
ALTER TABLE `obat_kategori`
  ADD PRIMARY KEY (`id_obat_kategori`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indexes for table `penderita`
--
ALTER TABLE `penderita`
  ADD PRIMARY KEY (`id_penderita`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_puskesmas` (`id_puskesmas`),
  ADD KEY `id_pmo` (`id_pmo`);

--
-- Indexes for table `pengawas_minum_obat`
--
ALTER TABLE `pengawas_minum_obat`
  ADD PRIMARY KEY (`id_pmo`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengingat_obat`
--
ALTER TABLE `pengingat_obat`
  ADD PRIMARY KEY (`reminder_id`),
  ADD KEY `id_penderita` (`user_id`),
  ADD KEY `jenis_id` (`id_jenis_penderita`);

--
-- Indexes for table `puskesmas`
--
ALTER TABLE `puskesmas`
  ADD PRIMARY KEY (`id_puskesmas`),
  ADD UNIQUE KEY `kode_puskesmas` (`kode_puskesmas`),
  ADD KEY `id_kecamatan` (`id_kecamatan`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `screening`
--
ALTER TABLE `screening`
  ADD PRIMARY KEY (`screening_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `status_konsultasi`
--
ALTER TABLE `status_konsultasi`
  ADD PRIMARY KEY (`status_konsultasi_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aturan`
--
ALTER TABLE `aturan`
  MODIFY `id_aturan` int(11) NOT NULL AUTO_INCREMENT COMMENT 'aturan_minum_obat', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_riwayat`
--
ALTER TABLE `detail_riwayat`
  MODIFY `id_detail_riwayat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edukasi`
--
ALTER TABLE `edukasi`
  MODIFY `id_edukasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jenis_penderita`
--
ALTER TABLE `jenis_penderita`
  MODIFY `id_jenis_penderita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id_kecamatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `konsultasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `obat_kategori`
--
ALTER TABLE `obat_kategori`
  MODIFY `id_obat_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penderita`
--
ALTER TABLE `penderita`
  MODIFY `id_penderita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengawas_minum_obat`
--
ALTER TABLE `pengawas_minum_obat`
  MODIFY `id_pmo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengingat_obat`
--
ALTER TABLE `pengingat_obat`
  MODIFY `reminder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `puskesmas`
--
ALTER TABLE `puskesmas`
  MODIFY `id_puskesmas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `screening`
--
ALTER TABLE `screening`
  MODIFY `screening_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_konsultasi`
--
ALTER TABLE `status_konsultasi`
  MODIFY `status_konsultasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_riwayat`
--
ALTER TABLE `detail_riwayat`
  ADD CONSTRAINT `detail_riwayat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat_kategori` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_riwayat_ibfk_2` FOREIGN KEY (`id_riwayat`) REFERENCES `riwayat` (`id_riwayat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`id_aturan`) REFERENCES `aturan` (`id_aturan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `obat_kategori`
--
ALTER TABLE `obat_kategori`
  ADD CONSTRAINT `obat_kategori_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `obat_kategori_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penderita`
--
ALTER TABLE `penderita`
  ADD CONSTRAINT `penderita_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penderita_ibfk_2` FOREIGN KEY (`id_puskesmas`) REFERENCES `puskesmas` (`id_puskesmas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penderita_ibfk_3` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pengawas_minum_obat`
--
ALTER TABLE `pengawas_minum_obat`
  ADD CONSTRAINT `pengawas_minum_obat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengingat_obat`
--
ALTER TABLE `pengingat_obat`
  ADD CONSTRAINT `pengingat_obat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengingat_obat_ibfk_2` FOREIGN KEY (`id_jenis_penderita`) REFERENCES `jenis_penderita` (`id_jenis_penderita`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `puskesmas`
--
ALTER TABLE `puskesmas`
  ADD CONSTRAINT `puskesmas_ibfk_1` FOREIGN KEY (`id_kecamatan`) REFERENCES `kecamatan` (`id_kecamatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD CONSTRAINT `riwayat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
