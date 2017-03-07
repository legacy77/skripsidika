-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09 Des 2016 pada 04.59
-- Versi Server: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bot_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `uname`, `pass`, `foto`) VALUES
(1, 'andhika', '6ef95621c960af17372d1145d69af6c8', 'PU.jpg'),
(8, 'andhika', '6ef95621c960af17372d1145d69af6c8', 'PU.JPEG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_bot`
--

CREATE TABLE IF NOT EXISTS `audit_bot` (
  `no_pesan` int(4) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `pesan2` varchar(255) NOT NULL,
  `tanggal_hapus` date NOT NULL,
  `no` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `audit_bot`
--

INSERT INTO `audit_bot` (`no_pesan`, `nama`, `pesan`, `pesan2`, `tanggal_hapus`, `no`) VALUES
(61, 'Andhika', 'B403', 'AC rusak', '2016-11-01', 1),
(58, 'Andhika', 'B202', 'spidol,habis', '2016-11-03', 2),
(62, 'Andhika', 'B432', 'Dosen Galak', '2016-11-03', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_temuan`
--

CREATE TABLE IF NOT EXISTS `audit_temuan` (
  `id` int(4) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `lokasi` varchar(4) NOT NULL,
  `tanggal_temuan` date NOT NULL,
  `tanggal_hapus` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `audit_temuan`
--

INSERT INTO `audit_temuan` (`id`, `nama_barang`, `lokasi`, `tanggal_temuan`, `tanggal_hapus`) VALUES
(1, 'HP Lenovo', 'B209', '2016-11-07', '2016-11-07'),
(2, 'Bola', 'B102', '2016-11-07', '2016-11-07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `jenis` text NOT NULL,
  `supplier` text NOT NULL,
  `sisa` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `jenis`, `supplier`, `sisa`, `jumlah`) VALUES
(1, 'Payung', 'payung', '', 30, 33),
(2, 'bangku', 'tempat duduk', 'apa aja', 204, 204),
(3, 'spidol', 'marker', 'marker', 400, 400),
(4, 'Proyektor', 'hardware', 'Benq', 40, 40);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bot`
--

CREATE TABLE IF NOT EXISTS `bot` (
  `no` int(255) NOT NULL,
  `id` int(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `pesan2` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bot`
--

INSERT INTO `bot` (`no`, `id`, `nama`, `waktu`, `tanggal`, `pesan`, `pesan2`) VALUES
(59, 236395409, 'Andhika', '17:28:28', '2016-10-18', 'B202', 'AC panas dan Spidol Habis'),
(60, 236395409, 'Andhika', '18:46:28', '2016-10-18', 'B301', 'Ruangan Panas dan Spidol habis'),
(61, 236395409, 'Andhika', '15:45:29', '2016-12-07', 'B402', 'Spidol hilang');

--
-- Trigger `bot`
--
DELIMITER $$
CREATE TRIGGER `setelah_delete_comment` AFTER DELETE ON `bot`
 FOR EACH ROW INSERT INTO audit_bot
(nama,no_pesan,pesan,pesan2,tanggal_hapus) VALUES (OLD.nama,OLD.no,OLD.pesan,OLD.pesan2,now())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `allDay` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `calendar`
--

INSERT INTO `calendar` (`id`, `title`, `startdate`, `enddate`, `allDay`) VALUES
(0, 'Cat ulang tembok lantai 1', '2016-12-07', '2016-12-10', 'false'),
(1, 'Perbaikan AC, B302', '2016-11-03', '2016-11-03', 'false'),
(2, 'Perbaikan Proyektor', '2016-11-04', '2016-11-04', 'false');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory_rk`
--

CREATE TABLE IF NOT EXISTS `inventory_rk` (
  `id_invent` int(30) NOT NULL,
  `id_barang` int(30) NOT NULL,
  `id_ruangan` int(30) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `nama_ruangan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_rk`
--

CREATE TABLE IF NOT EXISTS `isi_rk` (
  `id` int(30) NOT NULL DEFAULT '0',
  `id_barang` int(30) NOT NULL,
  `id_rk` int(30) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `nama_ruangan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE IF NOT EXISTS `ruangan` (
  `id` int(30) NOT NULL,
  `nama_ruangan` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id`, `nama_ruangan`) VALUES
(1, 'B302'),
(2, 'B202'),
(3, 'B104'),
(4, 'B101'),
(5, 'B102');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jadwal`
--

CREATE TABLE IF NOT EXISTS `tbl_jadwal` (
  `no` int(4) NOT NULL,
  `nama_staff` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `lokasi` varchar(30) NOT NULL,
  `nama_vendor` varchar(30) NOT NULL,
  `staff_vendor` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_jadwal`
--

INSERT INTO `tbl_jadwal` (`no`, `nama_staff`, `tanggal`, `nama_barang`, `lokasi`, `nama_vendor`, `staff_vendor`) VALUES
(1, 'Andhika', '0000-00-00', 'AC', 'B302', 'Hitachi', 'Budi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_temuan`
--

CREATE TABLE IF NOT EXISTS `tb_barang_temuan` (
  `id` int(4) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `ruangan` varchar(4) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_barang_temuan`
--

INSERT INTO `tb_barang_temuan` (`id`, `nama_barang`, `ruangan`, `tanggal`, `waktu`, `status`) VALUES
(1, 'Payung', 'B320', '0000-00-00', '00:00:00', 0),
(2, 'Bola', 'B210', '2016-11-07', '14:47:28', 0),
(4, 'Tempan Pensil', 'B202', '2016-11-07', '14:52:09', 0),
(5, 'Map Merah', 'B302', '2016-11-07', '14:52:19', 0),
(7, 'Baju', 'B102', '2016-11-07', '15:01:10', 0),
(8, 'Buku Accounting', 'B305', '2016-11-07', '15:02:35', 0);

--
-- Trigger `tb_barang_temuan`
--
DELIMITER $$
CREATE TRIGGER `setelah_delete_barang_temuan` AFTER DELETE ON `tb_barang_temuan`
 FOR EACH ROW INSERT INTO audit_temuan
(nama_barang,lokasi,tanggal_temuan,tanggal_hapus)VALUES
(OLD.nama_barang,OLD.ruangan,OLD.tanggal,now())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) unsigned NOT NULL,
  `nama` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `level_user` varchar(150) NOT NULL DEFAULT 'member'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `level_user`) VALUES
(1, 'Andhika', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'Regha', 'member', 'aa08769cdcb26674c6706093503ff0a3', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_bot`
--
ALTER TABLE `audit_bot`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `audit_temuan`
--
ALTER TABLE `audit_temuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bot`
--
ALTER TABLE `bot`
  ADD PRIMARY KEY (`no`,`id`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `inventory_rk`
--
ALTER TABLE `inventory_rk`
  ADD PRIMARY KEY (`id_invent`);

--
-- Indexes for table `isi_rk`
--
ALTER TABLE `isi_rk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jadwal`
--
ALTER TABLE `tbl_jadwal`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tb_barang_temuan`
--
ALTER TABLE `tb_barang_temuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `audit_bot`
--
ALTER TABLE `audit_bot`
  MODIFY `no` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `audit_temuan`
--
ALTER TABLE `audit_temuan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bot`
--
ALTER TABLE `bot`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `inventory_rk`
--
ALTER TABLE `inventory_rk`
  MODIFY `id_invent` int(30) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_jadwal`
--
ALTER TABLE `tbl_jadwal`
  MODIFY `no` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_barang_temuan`
--
ALTER TABLE `tb_barang_temuan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
