-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2026 at 10:02 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_sd`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `sampul` varchar(255) DEFAULT NULL,
  `file_buku` varchar(255) NOT NULL,
  `deskripsi` text,
  `tanggal_upload` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `pengarang`, `kategori`, `kelas`, `sampul`, `file_buku`, `deskripsi`, `tanggal_upload`) VALUES
(4, 'Legenda Timun Mas', 'Maulana Arrosyid', 'Dongeng', 'Semua', 'cover_1786377657_6844.png', 'buku_1786377657_4212.pdf', 'Timun Mas adalah cerita rakyat asal Jawa Tengah tentang seorang anak perempuan yang lahir dari buah mentimun emas', '2026-08-10 23:00:57'),
(5, 'Si Kancil dan Buaya', 'Tim Cerita Rakyat Nusantara', 'Dongeng', 'Semua', 'cover_1786378391_5658.png', 'buku_1786378391_5110.pdf', 'Dongeng anak tentang kecerdikan, keberanian, dan pentingnya tidak mudah percaya', '2026-08-10 23:13:11'),
(6, 'Sejarah Kemerdekaan Indonesia', 'Tim Sejarah Indonesia', 'sejarah', 'Semua', 'cover_1786378775_5175.png', 'buku_1786378775_5034.pdf', 'peristiwa menuju dan setelah Proklamasi Kemerdekaan', '2026-08-10 23:19:35'),
(8, 'Sistem Tata Surya', 'Tim Sains Nusantara', 'Sains', '3', 'cover_1786379320_8066.png', 'buku_1786379320_5004.pdf', 'Matahari, planet, dan benda langit lainnya', '2026-08-10 23:28:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
