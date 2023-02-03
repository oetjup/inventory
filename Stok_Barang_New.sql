-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 20, 2022 at 03:04 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `stok_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('s2ftff9som59jp0037sn8a1d8ck812bf', '::1', 1656944450, 0x5f5f63695f6c6173745f726567656e65726174657c693a313635363934343434393b5573657249447c733a313a2231223b557365727c733a31333a2241646d696e6973747261746f72223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313634323234333036342e706e67223b),
('q2nn4r5rugd4ngt2vre94ued9m2lc0gc', '::1', 1656944794, 0x5f5f63695f6c6173745f726567656e65726174657c693a313635363934343739343b5573657249447c733a313a2231223b557365727c733a31333a2241646d696e6973747261746f72223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313634323234333036342e706e67223b),
('rvleopj5ms5v2ik59st3ft0u1k635oae', '::1', 1656945243, 0x5f5f63695f6c6173745f726567656e65726174657c693a313635363934353234333b5573657249447c733a313a2231223b557365727c733a31333a2241646d696e6973747261746f72223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313634323234333036342e706e67223b),
('dqduktrpifch6a0app2v2smmdphpdip9', '::1', 1656946220, 0x5f5f63695f6c6173745f726567656e65726174657c693a313635363934363232303b5573657249447c733a313a2231223b557365727c733a31333a2241646d696e6973747261746f72223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313634323234333036342e706e67223b),
('94pq0sa39ee5vsq64i3gd86o85e4p8l7', '::1', 1656946294, 0x5f5f63695f6c6173745f726567656e65726174657c693a313635363934363232303b5573657249447c733a313a2231223b557365727c733a31333a2241646d696e6973747261746f72223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313634323234333036342e706e67223b),
('rpsliat1ev1issbcqul1fi66fg244sqr', '::1', 1656946934, 0x5f5f63695f6c6173745f726567656e65726174657c693a313635363934363839363b5573657249447c733a313a2231223b557365727c733a31333a2241646d696e6973747261746f72223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313634323234333036342e706e67223b),
('udrlehdj8q5rrseuvlc8tah1f8ivnf6h', '::1', 1663591225, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333539313232353b),
('cp3tm7khjdqa3drmugsrs2jie7fh7q81', '::1', 1663594559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636333539343535333b5573657249447c733a313a2231223b557365727c733a31333a2241646d696e6973747261746f72223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313634323234333036342e706e67223b);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `kode_barang` varchar(6) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT '0',
  `harga` double NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `id_kat_barang` int(2) NOT NULL,
  `satuan_barang` varchar(255) NOT NULL,
  `kode_hs` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`kode_barang`, `nama_barang`, `brand`, `stok`, `harga`, `active`, `id_kat_barang`, `satuan_barang`, `kode_hs`) VALUES
('ADVSPK', 'Advance Speaker 2.0 Mini', 'Advance', 2, 0, 'Y', 1, 'KGM', '3206111010'),
('CTR810', 'Cartridge 810', 'Canon', 17, 0, 'Y', 2, 'GRM', '3206111678'),
('CTR811', 'Cartridge 811', 'Canon', 2, 0, 'Y', 1, 'PCE', '3206111222'),
('FDS16G', 'Flashdisk Sandisk 16 GB', 'Sandisk', 10, 70000, 'Y', 1, 'GRM', ''),
('FDT16G', 'Flashdisk Toshiba 16 GB', 'Toshiba', 6, 60000, 'Y', 1, 'KGM', ''),
('FME001', 'Fan Murago Ergostand', 'Murago', 3, 80000, 'Y', 1, 'KGM', ''),
('KB2308', 'Keyboard Votre KB2308', 'Votre', 4, 45000, 'Y', 2, 'KGM', ''),
('LH001', 'Kain', 'Cigondewah', 0, 10000, 'Y', 1, 'KGM', ''),
('LH002', 'Benang', 'Cigondewah', 0, 10000, 'Y', 2, 'KGM', ''),
('LH003', 'Kancing Hitam Putih', 'YKK', 0, 0, 'Y', 2, 'PCE', ''),
('LH004', 'Resleting', 'YKK', 0, 0, 'Y', 3, 'GRM', ''),
('LH005', 'Roll Back', 'New Brand', 0, 0, 'Y', 1, 'KGM', '3206111441'),
('LH1002', 'Kain warna polos', 'Non Brand', 120, 0, 'Y', 1, 'MTR', '3206111222'),
('MDMUSB', 'Modem USB Flash Unlimited', 'Telkomsel', 2, 175000, 'Y', 1, 'KGM', ''),
('SP2120', 'Speaker Logitect 2120', 'Logitech', 4, 140000, 'Y', 1, 'KGM', ''),
('SPTR14', 'Screen Protector 14 Inch', 'Centro', 2, 12000, 'Y', 3, 'PCE', ''),
('TNTF1', 'Tinta F1', 'F1', 8, 26000, 'Y', 4, 'KGM', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_pembelian`
--

CREATE TABLE `tbl_detail_pembelian` (
  `id_pembelian` varchar(20) NOT NULL,
  `id_barang` varchar(6) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `harga` double NOT NULL,
  `hpp` int(11) NOT NULL,
  `bm` int(11) NOT NULL,
  `bmt` int(11) NOT NULL,
  `pph` int(11) NOT NULL,
  `ppn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_detail_pembelian`
--

INSERT INTO `tbl_detail_pembelian` (`id_pembelian`, `id_barang`, `qty`, `harga`, `hpp`, `bm`, `bmt`, `pph`, `ppn`) VALUES
('ID1644415247', 'CTR810', 5, 0, 0, 0, 0, 0, 0),
('ID1644416415', 'CTR810', 10, 0, 0, 0, 0, 0, 0),
('ID1656944895', 'LH1002', 120, 0, 120000, 1200, 1200, 14000, 12000);

--
-- Triggers `tbl_detail_pembelian`
--
DELIMITER $$
CREATE TRIGGER `pembelian_barang` AFTER INSERT ON `tbl_detail_pembelian` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok + new.qty
    WHERE b.kode_barang = new.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_pembelian` AFTER DELETE ON `tbl_detail_pembelian` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok - old.qty
    WHERE b.kode_barang = old.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_penjualan`
--

CREATE TABLE `tbl_detail_penjualan` (
  `id_penjualan` varchar(20) NOT NULL,
  `id_barang` varchar(6) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_detail_penjualan`
--

INSERT INTO `tbl_detail_penjualan` (`id_penjualan`, `id_barang`, `qty`, `harga`) VALUES
('ID1646093327', 'KB2308', 1, 45000);

--
-- Triggers `tbl_detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `penjualan_barang` AFTER INSERT ON `tbl_detail_penjualan` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok - new.qty
    WHERE b.kode_barang = new.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_penjualan` AFTER DELETE ON `tbl_detail_penjualan` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok + old.qty
    WHERE b.kode_barang = old.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_produksi`
--

CREATE TABLE `tbl_detail_produksi` (
  `id_produksi` int(11) NOT NULL,
  `id_barang` varchar(6) NOT NULL,
  `qty` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_detail_produksi`
--

INSERT INTO `tbl_detail_produksi` (`id_produksi`, `id_barang`, `qty`) VALUES
(1646105918, 'FME001', 1),
(1646105918, 'KB2308', 1);

--
-- Triggers `tbl_detail_produksi`
--
DELIMITER $$
CREATE TRIGGER `produksi_proses` AFTER INSERT ON `tbl_detail_produksi` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok - new.qty
    WHERE b.kode_barang = new.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_produksi_proses` AFTER DELETE ON `tbl_detail_produksi` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok + old.qty
    WHERE b.kode_barang = old.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kat_barang`
--

CREATE TABLE `tbl_kat_barang` (
  `id_kat_barang` int(2) NOT NULL,
  `kode_kat_barang` varchar(255) NOT NULL,
  `nama_kat_barang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kat_barang`
--

INSERT INTO `tbl_kat_barang` (`id_kat_barang`, `kode_kat_barang`, `nama_kat_barang`) VALUES
(1, '1', 'Bahan Baku'),
(2, '2', 'Bahan Penolong'),
(3, '3', 'Hasil Produksi'),
(4, '4', 'Scrapt');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pabean`
--

CREATE TABLE `tbl_pabean` (
  `id_pabean` int(5) NOT NULL,
  `kode_dok` varchar(5) NOT NULL,
  `nomor_aju` varchar(26) NOT NULL,
  `nomor_daftar` varchar(6) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `jenis_dok` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pabean`
--

INSERT INTO `tbl_pabean` (`id_pabean`, `kode_dok`, `nomor_aju`, `nomor_daftar`, `tanggal_daftar`, `jenis_dok`) VALUES
(1, 'BC20', '05050020670020220101000001', '000002', '2022-01-17', '1'),
(3, 'BC40', '05050020670020220101000002', '000002', '2022-02-04', '1'),
(4, 'BC40', '05050040670020220101000001', '123457', '2022-02-04', '1'),
(5, 'BC40', '05050020670020220101000008', '000009', '2022-02-03', '1'),
(7, 'BC20', '05050020670020220101000065', '000023', '2022-02-01', '1'),
(9, 'BC40', '05050040670020220101000009', '887698', '2022-02-04', '1'),
(11, 'BC20', '05050040670020220101000007', '123456', '2022-02-04', '1'),
(12, 'BC20', '05050040670020220101000006', '123456', '2022-02-04', '1'),
(13, 'BC20', '05050040670020220101000004', '123456', '2022-02-04', '1'),
(14, 'BC20', '05050040670020220101000003', '123457', '2022-02-04', '1'),
(15, 'BC30', '05050030670020220101000031', '000031', '2022-02-05', '0'),
(16, 'BC41', '05050020670020220101000040', '000040', '2022-02-04', '0'),
(17, 'BC30', '05050030670020220101000002', '123456', '2022-02-03', '0'),
(19, 'BC41', '05050041670020220101004141', '000041', '2022-02-08', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembelian`
--

CREATE TABLE `tbl_pembelian` (
  `id_pembelian` varchar(20) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `id_supplier` varchar(15) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pabean` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pembelian`
--

INSERT INTO `tbl_pembelian` (`id_pembelian`, `tgl_pembelian`, `id_supplier`, `id_user`, `id_pabean`) VALUES
('ID1644415247', '2022-02-01', 'ID1595997179', 1, 1),
('ID1644416415', '2022-02-09', 'ID1643931841', 1, 3),
('ID1656944895', '2022-07-04', 'ID1643933852', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `id_penjualan` varchar(20) NOT NULL,
  `nama_pembeli` varchar(30) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pabean` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`id_penjualan`, `nama_pembeli`, `tgl_penjualan`, `id_user`, `id_pabean`) VALUES
('ID1646093327', 'CV Maju Terus', '2022-03-01', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produksi`
--

CREATE TABLE `tbl_produksi` (
  `id_produksi` int(11) NOT NULL,
  `no_produksi` varchar(11) NOT NULL,
  `tgl_produksi` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipe_produksi` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_produksi`
--

INSERT INTO `tbl_produksi` (`id_produksi`, `no_produksi`, `tgl_produksi`, `id_user`, `tipe_produksi`) VALUES
(1646105918, 'PIN16461059', '2022-03-01', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` varchar(15) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telp`) VALUES
('ID1595997179', 'Aipel Computer', 'Ds. Manyar, Sidoarjo', '085731109556'),
('ID1595998788', 'Sarana Informasi  Computer', 'Jl. Soekarno Hatta No 219 A', '085722907653'),
('ID1643931841', 'Sinar Jaya', 'Jl Raya Bandung - Cirebon KM 22', '081220809754'),
('ID1643931873', 'Berkah Makmur', 'Jl. Merdeka No 15 B', '087812345678'),
('ID1643933852', 'Tabah Sentosa', 'Ds Mekarwangi RT 005 RW 007', '081220809754');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `foto` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `level` enum('admin','pegawai') NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `fullname`, `password`, `alamat`, `hp`, `foto`, `level`, `active`, `last_login`) VALUES
(1, 'admin', 'Administrator', '$2y$08$BO41OJFfhPPPzjKdWw2I6OyUElK1mkD43UVt1ss6J1xrVUExC1lRy', '', '', 'foto1642243064.png', 'admin', 'Y', '2022-09-19 20:35:53'),
(2, 'pegawai', 'Pegawai', '$2y$10$bZkYvXB4K93BWcR05e92r.Vcyq1PrnGFtzougX0LdN5bLaGY/1gPa', 'Jl. Semeru No.90', '085731109355', 'foto1596071469.png', 'pegawai', 'Y', '2020-07-18 15:18:43'),
(6, 'user2', 'Pegawai Kedua', '$2y$10$swIMV3E0b6nRrDXnyBgjO.tN7vMLNmYf6Zm76CG.TO7WH9sZU5LTm', 'Jl. Nanas No. 24, Pace - Nganjuk', '085731109355', 'foto1595054714.png', 'pegawai', 'Y', '2020-07-22 07:59:43'),
(7, 'yusuf', 'yusuf', '$2y$10$iBTTQRMMAaYc2q9iFKv8/.1rvU36mA2amJk6a5rFjM4WLWXXMKN3m', 'Bandung Kota Bunga', '0857123456', 'default.jpg', 'pegawai', 'Y', '2022-01-15 16:20:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `tbl_kat_barang`
--
ALTER TABLE `tbl_kat_barang`
  ADD PRIMARY KEY (`id_kat_barang`);

--
-- Indexes for table `tbl_pabean`
--
ALTER TABLE `tbl_pabean`
  ADD PRIMARY KEY (`id_pabean`);

--
-- Indexes for table `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `tbl_produksi`
--
ALTER TABLE `tbl_produksi`
  ADD PRIMARY KEY (`id_produksi`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_kat_barang`
--
ALTER TABLE `tbl_kat_barang`
  MODIFY `id_kat_barang` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_pabean`
--
ALTER TABLE `tbl_pabean`
  MODIFY `id_pabean` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_produksi`
--
ALTER TABLE `tbl_produksi`
  MODIFY `id_produksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1646105919;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
