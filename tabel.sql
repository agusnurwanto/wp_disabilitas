-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2022 at 09:40 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_disabillitas`
--

CREATE TABLE `data_disabillitas` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `tempat_lahir` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `status` text DEFAULT NULL,
  `dokumen_kewarganegaraan` varchar(100) DEFAULT NULL,
  `nik` double(20,0) DEFAULT NULL,
  `nomor_kk` double(20,0) DEFAULT NULL,
  `rt_rw` varchar(10) DEFAULT NULL,
  `desa` text DEFAULT NULL,
  `no_hp` double(16,0) DEFAULT NULL,
  `pendidikan_terakhir` varchar(30) DEFAULT NULL,
  `nama_sekolah` text DEFAULT NULL,
  `keterangan_lulus` text DEFAULT NULL,
  `jenis_disabilitas` text DEFAULT NULL,
  `keterangan_disabilitas` varchar(100) DEFAULT NULL,
  `sebab_disabilitas` varchar(100) DEFAULT NULL,
  `diagnosa_medis` varchar(100) DEFAULT NULL,
  `penyakit_lain` varchar(100) DEFAULT NULL,
  `tempat_pengobatan` text DEFAULT NULL,
  `perawat` text DEFAULT NULL,
  `aktivitas` varchar(100) DEFAULT NULL,
  `aktivitas_bantuan` text DEFAULT NULL,
  `perlu_bantu` varchar(50) DEFAULT NULL,
  `alat_bantu` text DEFAULT NULL,
  `alat_yang_dimiliki` text DEFAULT NULL,
  `kondisi_alat` varchar(50) DEFAULT NULL,
  `jaminan_kesehatan` varchar(100) DEFAULT NULL,
  `cara_menggunakan_jamkes` varchar(20) DEFAULT NULL,
  `jaminan_sosial` text DEFAULT NULL,
  `pekerjaan` text DEFAULT NULL,
  `lokasi_bekerja` text DEFAULT NULL,
  `alasan_tidak_bekerja` text DEFAULT NULL,
  `pendapatan_bulan` double DEFAULT NULL,
  `pengeluaran_bulan` double DEFAULT NULL,
  `pendapatan_lain` double DEFAULT NULL,
  `minat_kerja` varchar(20) DEFAULT NULL,
  `keterampilan` text DEFAULT NULL,
  `pelatihan_yang_diikuti` text DEFAULT NULL,
  `pelatihan_yang_diminat` text DEFAULT NULL,
  `status_rumah` text DEFAULT NULL,
  `lantai` varchar(100) DEFAULT NULL,
  `kamar_mandi` varchar(50) DEFAULT NULL,
  `wc` varchar(20) DEFAULT NULL,
  `akses_ke_lingkungan` varchar(50) DEFAULT NULL,
  `dinding` varchar(100) DEFAULT NULL,
  `sarana_air` varchar(100) DEFAULT NULL,
  `penerangan` varchar(100) DEFAULT NULL,
  `desa_paud` text DEFAULT NULL,
  `tk_di_desa` text DEFAULT NULL,
  `kecamatan_slb` text DEFAULT NULL,
  `sd_menerima_abk` text DEFAULT NULL,
  `smp_menerima_abk` text DEFAULT NULL,
  `jumlah_posyandu` int(11) DEFAULT NULL,
  `kader_posyandu` varchar(50) DEFAULT NULL,
  `layanan_kesehatan` text DEFAULT NULL,
  `sosialitas_ke_tetangga` varchar(100) DEFAULT NULL,
  `keterlibatan_berorganisasi` varchar(100) DEFAULT NULL,
  `kegiatan_kemasyarakatan` varchar(100) DEFAULT NULL,
  `keterlibatan_musrembang` varchar(100) DEFAULT NULL,
  `alat_bantu_bantuan` varchar(100) DEFAULT NULL,
  `asal_alat_bantu` text DEFAULT NULL,
  `tahun_pemberian` year(4) DEFAULT NULL,
  `bantuan_uep` int(11) DEFAULT NULL,
  `asal_uep` text DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `lainnya` text DEFAULT NULL,
  `rehabilitas` text DEFAULT NULL,
  `lokasi_rehabilitas` text DEFAULT NULL,
  `tahun_rehabilitas` year(4) DEFAULT NULL,
  `keahlian_khusus` text DEFAULT NULL,
  `prestasi` text DEFAULT NULL,
  `nama_perawat` text DEFAULT NULL,
  `hubungan_dengan_pd` text DEFAULT NULL,
  `nomor_hp` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_disabillitas`
--
ALTER TABLE `data_disabillitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_disabillitas`
--
ALTER TABLE `data_disabillitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
