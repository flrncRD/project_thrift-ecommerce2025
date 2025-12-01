-- phpMyAdmin SQL Dump
-- version 5.2.1
-- Host: 127.0.0.1
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbproyek25`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `role` enum('admin','user') DEFAULT 'user',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user` (Password: 123)
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `photo`, `alamat`, `kota`, `phone`, `status`, `role`, `createdAt`) VALUES
(1, 'admin', 'admin@pindahand.com', '$2y$10$LCpWQG9UTQK0js4mVO7PKORSwpvTApXQ.oRMz24f4//viWdidCMDO', NULL, 'Kantor Pusat', 'Surabaya', '081234567890', 'active', 'admin', NOW()),
(2, 'seller', 'seller@gmail.com', '$2y$10$LCpWQG9UTQK0js4mVO7PKORSwpvTApXQ.oRMz24f4//viWdidCMDO', NULL, 'Jl. Mawar No. 10', 'Bandung', '081299998888', 'active', 'user', NOW()),
(3, 'buyer', 'buyer@gmail.com', '$2y$10$LCpWQG9UTQK0js4mVO7PKORSwpvTApXQ.oRMz24f4//viWdidCMDO', NULL, 'Jl. Melati No. 55', 'Jakarta', '081277776666', 'active', 'user', NOW());

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Pakaian Pria'),
(2, 'Pakaian Wanita'),
(3, 'Outerwear'),
(4, 'Sepatu'),
(5, 'Tas & Aksesoris'),
(6, 'Elektronik Vintage');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama_product` varchar(150) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `user_id`, `kategori_id`, `nama_product`, `harga`, `stok`, `description`, `photo`, `status`, `createdAt`) VALUES
(1, 2, 3, 'Vintage Denim Jacket Levis', 250000.00, 1, 'Kondisi 9/10, warna masih pekat. Size L. Original vintage.', 'jaket_denim.jpg', 'active', NOW()),
(2, 2, 4, 'Nike Air Force 1 White', 450000.00, 1, 'Pemakaian wajar, no box. Size 42.', 'nike_af1.jpg', 'active', NOW()),
(3, 2, 1, 'Kemeja Flannel Uniqlo', 120000.00, 3, 'Bahan adem, motif kotak-kotak. Tersedia size M dan L.', 'flannel.jpg', 'active', NOW()),
(4, 2, 6, 'Kamera Analog Canon', 850000.00, 0, 'Lensa bersih, fungsi normal. Minus lecet pemakaian. (SOLD OUT)', 'kamera.jpg', 'active', NOW());

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `nama_buyer` varchar(100) DEFAULT NULL,
  `alamat_buyer` text DEFAULT NULL,
  `kota_buyer` varchar(100) DEFAULT NULL,
  `phone_buyer` varchar(20) DEFAULT NULL,
  `jenis_pembayaran` enum('transfer','cod','e-wallet') DEFAULT NULL,
  `transfer` varchar(255) DEFAULT NULL,
  `jenis_pengiriman` enum('jne','lion_parcel','instant') DEFAULT NULL,
  `status` enum('Terbayar','Packing','Kirim','Selesai','Batal') DEFAULT 'Terbayar',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `buyer_id` (`buyer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `buyer_id`, `product_id`, `total_harga`, `qty`, `nama_buyer`, `alamat_buyer`, `kota_buyer`, `phone_buyer`, `jenis_pembayaran`, `jenis_pengiriman`, `status`, `createdAt`) VALUES
(1, 3, 2, 450000.00, 1, 'Buyer Demo', 'Jl. Melati No 55', 'Jakarta', '081277776666', 'transfer', 'jne', 'Selesai', NOW()),
(2, 3, 3, 240000.00, 2, 'Buyer Demo', 'Jl. Melati No 55', 'Jakarta', '081277776666', 'cod', 'instant', 'Kirim', NOW());

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pengirim_id` int(11) NOT NULL,
  `penerima_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `pengirim_id` (`pengirim_id`),
  KEY `penerima_id` (`penerima_id`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`pengirim_id`) REFERENCES `user` (`id`),
  CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`penerima_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `pengirim_id`, `penerima_id`, `message`, `is_read`, `createdAt`) VALUES
(1, 3, 2, 'Halo gan, sepatu nikenya masih ada?', 1, NOW()),
(2, 2, 3, 'Masih ada kak, silakan diorder.', 0, NOW());

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `transaksi_id`, `rating`, `review`, `createdAt`) VALUES
(1, 1, 5, 'Barang mantap sesuai deskripsi! Seller gercep.', NOW());

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `jenis_report` enum('User','Product','Transaksi') NOT NULL,
  `reference_id` int(11) NOT NULL,
  `alasan` text DEFAULT NULL,
  `status` enum('Reported','Accepted','Rejected') DEFAULT 'Reported',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;