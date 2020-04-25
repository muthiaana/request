-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2019 at 09:05 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ecrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_divisi`
--

CREATE TABLE `ecrm_divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_divisi`
--

INSERT INTO `ecrm_divisi` (`id_divisi`, `nama_divisi`) VALUES
(1, 'software engineer mobile'),
(2, 'software engineer web'),
(3, 'software engineer desktop');

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_kategori_masalah`
--

CREATE TABLE `ecrm_kategori_masalah` (
  `id_kat_masalah` varchar(20) NOT NULL,
  `kategorimasalah` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_kategori_masalah`
--

INSERT INTO `ecrm_kategori_masalah` (`id_kat_masalah`, `kategorimasalah`) VALUES
('KM0001', 'bb'),
('KM0003', 'asdasd'),
('KM0004', 'sadasdas'),
('KM0005', 'Eror Printer');

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_menu`
--

CREATE TABLE `ecrm_menu` (
  `id_menu` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_menu`
--

INSERT INTO `ecrm_menu` (`id_menu`, `menu`, `icon`, `status`) VALUES
(1, 'Admin', 'fas fa-fw fa-user-tie', 1),
(3, 'Menu', 'fas fa-fw fa-tasks', 0),
(12, 'User', 'halflings-icon user', 0),
(13, 'Request', 'fas fa-registered', 1),
(14, 'KategoriMasalah', 'fas fa-file-alt', 1),
(15, 'NewUser', 'fas fa-user-plus', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_menu_access`
--

CREATE TABLE `ecrm_menu_access` (
  `id_access` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_menu_access`
--

INSERT INTO `ecrm_menu_access` (`id_access`, `id_role`, `id_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3),
(9, 1, 8),
(16, 1, 10),
(17, 1, 11),
(18, 1, 12),
(19, 2, 12),
(20, 1, 13),
(21, 1, 14),
(22, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_menu_sub`
--

CREATE TABLE `ecrm_menu_sub` (
  `id_sub` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_menu_sub`
--

INSERT INTO `ecrm_menu_sub` (`id_sub`, `id_menu`, `title`, `url`, `status`) VALUES
(1, 1, 'Dashboard', 'Admin', 1),
(2, 2, 'Profile', 'User', 0),
(3, 2, 'Edit Profile', 'user/edit', 0),
(4, 3, 'Menu Management', 'Menu', 0),
(5, 3, 'Submenu Management', 'Menu/subMenu', 0),
(8, 1, 'Role Access', 'Admin/role', 1),
(18, 1, 'User Role', 'Admin/user_role', 1),
(21, 12, 'Edit', 'User/edit', 1),
(22, 12, 'Change Password', 'User/change_pass', 1),
(23, 13, 'Request', 'Request/show_list_requestit', 1),
(24, 14, 'Kategori Masalah', 'KategoriMasalah/show_list_masalah', 1),
(25, 15, 'New User', 'NewUser/show_list_users', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_request_it`
--

CREATE TABLE `ecrm_request_it` (
  `NoTiket` varchar(40) NOT NULL,
  `username` varchar(128) NOT NULL,
  `ketmasalah` varchar(50) NOT NULL,
  `kategorimasalah` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL,
  `prioritas` enum('Tidak Mendesak','Normal','Mendesak') NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_request_it`
--

INSERT INTO `ecrm_request_it` (`NoTiket`, `username`, `ketmasalah`, `kategorimasalah`, `tanggal`, `prioritas`, `waktu`) VALUES
('RQ19121700001', 'admin', 'TIDAK BISA BUKA F', '1', '2019-12-17 18:50:00', 'Normal', '0000-00-00 00:00:00'),
('RQ19121800001', 'admin', 'TIDAK BISA BUKA F', '1', '2019-12-18 19:40:00', 'Normal', '0000-00-00 00:00:00'),
('RQ19121800002', 'admin', 'TIDAK BISA BUKA F', '2', '2019-12-18 19:48:00', 'Normal', '0000-00-00 00:00:00'),
('RQ19121800003', 'admin', 'TIDAK BISA BUKA F', '1', '2019-12-18 19:55:00', 'Normal', '0000-00-00 00:00:00'),
('RQ19121800004', 'admin', 'TIDAK BISA BUKA F', '1', '2019-12-18 19:55:00', 'Tidak Mendesak', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_users`
--

CREATE TABLE `ecrm_users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `status` int(10) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_users`
--

INSERT INTO `ecrm_users` (`id_user`, `name`, `username`, `image`, `password`, `id_role`, `id_divisi`, `status`, `date_created`) VALUES
(1, 'admin', 'admin', 'profile.jpg', '$2y$10$.qmqU2Ct9t7W.O2olC7Osed.BScUEC7L0cx.cJDvSJKrhW9ucBv02', 1, 1, 1, '2019-12-17 00:00:00'),
(22, 'muthia', 'muthia', 'default.jpg', '$2y$10$.qmqU2Ct9t7W.O2olC7Osed.BScUEC7L0cx.cJDvSJKrhW9ucBv02', 1, 1, 1, '2019-12-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ecrm_user_role`
--

CREATE TABLE `ecrm_user_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecrm_user_role`
--

INSERT INTO `ecrm_user_role` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'karyawan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ecrm_divisi`
--
ALTER TABLE `ecrm_divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `ecrm_kategori_masalah`
--
ALTER TABLE `ecrm_kategori_masalah`
  ADD PRIMARY KEY (`id_kat_masalah`);

--
-- Indexes for table `ecrm_menu`
--
ALTER TABLE `ecrm_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `ecrm_menu_access`
--
ALTER TABLE `ecrm_menu_access`
  ADD PRIMARY KEY (`id_access`);

--
-- Indexes for table `ecrm_menu_sub`
--
ALTER TABLE `ecrm_menu_sub`
  ADD PRIMARY KEY (`id_sub`);

--
-- Indexes for table `ecrm_request_it`
--
ALTER TABLE `ecrm_request_it`
  ADD PRIMARY KEY (`NoTiket`);

--
-- Indexes for table `ecrm_users`
--
ALTER TABLE `ecrm_users`
  ADD PRIMARY KEY (`id_user`,`username`);

--
-- Indexes for table `ecrm_user_role`
--
ALTER TABLE `ecrm_user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ecrm_divisi`
--
ALTER TABLE `ecrm_divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ecrm_menu`
--
ALTER TABLE `ecrm_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ecrm_menu_access`
--
ALTER TABLE `ecrm_menu_access`
  MODIFY `id_access` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ecrm_menu_sub`
--
ALTER TABLE `ecrm_menu_sub`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ecrm_users`
--
ALTER TABLE `ecrm_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ecrm_user_role`
--
ALTER TABLE `ecrm_user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
