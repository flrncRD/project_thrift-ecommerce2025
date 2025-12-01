-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 02:12 AM
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
-- Database: `ecomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `pengirim_id` int(11) NOT NULL,
  `penerima_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `pengirim_id`, `penerima_id`, `message`, `createdAt`, `is_read`) VALUES
(1, 2, 2, 'halo', '2025-11-29 19:05:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Elektronik'),
(2, 'Fashion'),
(3, 'Peralatan Rumah'),
(4, 'Olahraga'),
(5, 'Buku');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama_product` varchar(150) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `user_id`, `kategori_id`, `nama_product`, `harga`, `stok`, `description`, `photo`, `status`, `createdAt`) VALUES
(1, 2, 1, 'Headphone Bluetooth Sony', 350000.00, 1, 'Headphone wireless dengan kualitas suara premium.', 'sony_headphone.jpg', 'active', '2025-01-01 03:00:00'),
(2, 2, 2, 'Hoodie Oversize Unisex', 150000.00, 2, 'Hoodie nyaman untuk dipakai sehari-hari.', 'hoodie_unisex.jpg', 'active', '2025-01-02 04:30:00'),
(3, 2, 3, 'Blender Philips 500W', 420000.00, 1, 'Blender kuat cocok untuk jus dan bumbu dapur.', 'blender_philips.jpg', 'active', '2025-01-03 02:45:00'),
(4, 2, 4, 'Sepatu Lari Nike Airmax', 950000.00, 1, 'Sepatu lari ringan dan nyaman untuk olahraga.', 'nike_airmax.jpg', 'active', '2025-01-04 07:20:00'),
(5, 2, 5, 'Novel Laskar Pelangi', 85000.00, 1, 'Novel best-seller karya Andrea Hirata.', 'laskar_pelangi.jpg', 'active', '2025-01-05 09:10:00'),
(6, 2, 3, 'Gelas Lucu', 12000.00, 0, 'Gelas lucu, pemakaian baru\r\ndijual karena bosen ', '1764471785_gelas.jpg', 'inactive', '2025-11-30 03:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jenis_report` enum('User','Product','Transaksi') NOT NULL,
  `reference_id` int(11) NOT NULL,
  `alasan` text DEFAULT NULL,
  `status` enum('reported','accepted','rejected') DEFAULT 'reported',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `user_id`, `jenis_report`, `reference_id`, `alasan`, `status`, `createdAt`) VALUES
(1, 2, 'Product', 4, 'sepatu nike kw', 'accepted', '2025-11-28 06:29:04'),
(2, 2, 'Product', 4, 'cek laporan produk', 'reported', '2025-11-28 06:34:22'),
(3, 2, '', 1, 'kok ga dikirim kirim', 'reported', '2025-11-28 06:49:58'),
(4, 2, 'Product', 3, 'tes', 'reported', '2025-11-28 06:50:58'),
(5, 2, 'User', 2, 'COD nya ga sampe sampe', 'reported', '2025-11-29 17:47:15');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `transaksi_id`, `rating`, `review`, `createdAt`) VALUES
(1, 1, 5, 'test', '2025-11-28 06:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `nama_buyer` varchar(25) NOT NULL,
  `alamat_buyer` text DEFAULT NULL,
  `kota_buyer` varchar(100) DEFAULT NULL,
  `phone_buyer` varchar(20) DEFAULT NULL,
  `jenis_pembayaran` enum('transfer','cod','e-wallet') DEFAULT NULL,
  `jenis_pengiriman` enum('JNE','lion_parcel','instant') NOT NULL,
  `status` enum('terbayar','packing','kirim','terima') NOT NULL DEFAULT 'terbayar',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `buyer_id`, `product_id`, `total_harga`, `qty`, `nama_buyer`, `alamat_buyer`, `kota_buyer`, `phone_buyer`, `jenis_pembayaran`, `jenis_pengiriman`, `status`, `createdAt`) VALUES
(1, 2, 4, 950000.00, 1, 'flo', 'swk', 'sby', '12345678', 'cod', 'lion_parcel', 'terima', '2025-11-27 09:34:03'),
(2, 2, 3, 420000.00, 1, 'flo', 'swk', 'sby', '12345678', 'cod', 'lion_parcel', 'terima', '2025-11-29 10:35:21'),
(3, 2, 5, 85000.00, 1, 'bima', 'bandung', 'Bandung', '0123456789012', 'cod', 'JNE', 'terbayar', '2025-11-29 20:39:50'),
(4, 2, 1, 350000.00, 1, 'Florence Kristalin', 'Jl. Siwalankerto No.121-131,', 'Surabaya', '082139286858', 'cod', 'instant', 'terbayar', '2025-11-29 20:42:33'),
(5, 2, 1, 350000.00, 1, 'Florence Kristalin', 'Jl. Siwalankerto No.121-131,', 'Surabaya', '082139286858', 'cod', 'instant', 'terbayar', '2025-11-29 20:43:12'),
(6, 2, 1, 350000.00, 1, 'Florence Kristalin', 'Jl. Siwalankerto No.121-131,', 'Surabaya', '082139286858', 'cod', 'instant', 'terbayar', '2025-11-29 20:45:17'),
(7, 2, 6, 12000.00, 3, 'timothy', 'Kutisari', 'Surabaya', '0888888888888', 'cod', 'JNE', 'terbayar', '2025-11-30 10:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `role` enum('admin','user') DEFAULT 'user',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `photo`, `alamat`, `kota`, `phone`, `status`, `role`, `createdAt`) VALUES
(1, 'admin0', 'admin0@gmail.com', '$2y$10$LCpWQG9UTQK0js4mVO7PKORSwpvTApXQ.oRMz24f4//viWdidCMDO', '1763826297_Chiki-ChikckenDoll.jpeg', 'admin0siwalankerto', 'admin0sby', '012345678', 'active', 'user', '2025-11-22 15:44:57'),
(2, 'flo', 'flo@gmail.com', '$2y$10$79YgCqYIWU3S0P3RqrN/eOFTDwGYWbovw9e5UiRjJUUT1s80tlMgu', 'belly.jpg', 'surabaya', 'surabaya', '1234567', 'active', 'user', '2025-11-24 11:19:13'),
(3, 'adminflo', 'adminflo@gmail.com', '$2y$10$6ds6J.YDgJk8b8if4wGrC.XTmvMj9eu3gXRCDVBpro72ldIFGNwKy', '1764467988_MARTIN.jpg', 'Siwalankerto', 'Surabaya', '1234567', 'active', 'admin', '2025-11-30 01:59:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengirim_id` (`pengirim_id`),
  ADD KEY `penerima_id` (`penerima_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`pengirim_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`penerima_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
