-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Okt 2025 pada 11.33
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
-- Database: `my5edb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(13,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `created_by`, `created`, `modified`) VALUES
(14, 'SSD Samsung 500GB', 'SSD NVMe untuk performa tinggi', 850000.00, 12, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(15, 'Harddisk WD 1TB', 'Harddisk internal SATA 1TB', 650000.00, 8, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(16, 'RAM Team Elite 8GB DDR4', 'RAM DDR4 gaming standar', 420000.00, 20, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(17, 'Monitor LG 24 Inch', 'Monitor IPS 75Hz Full HD', 1750000.00, 5, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(18, 'Keyboard Mechanical Redragon', 'Switch Outemu Blue clicky', 450000.00, 14, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(19, 'Mouse Logitech G102', 'Mouse gaming RGB', 240000.00, 25, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(20, 'Power Supply 550W', 'PSU 80Plus Bronze Bersertifikat', 750000.00, 7, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(21, 'Laptop Acer Aspire 3', 'Laptop kuliah/kerja i3 11th Gen', 6250000.00, 3, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(22, 'VGA RTX 3060 12GB', 'Kartu grafis gaming mid-high', 5900000.00, 4, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32'),
(23, 'Casing Gaming RGB', 'Casing mid-tower dengan RGB', 550000.00, 9, 4, '2025-10-30 10:22:32', '2025-10-30 10:22:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin_gudang',
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `activation_token` varchar(128) DEFAULT NULL,
  `reset_token` varchar(128) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `status`, `activation_token`, `reset_token`, `reg_date`, `modified`) VALUES
(2, 'marshellfitriawan195@gmail.com', '$2y$10$MGd28xZ1sZ6RrQBg2KnzpuKKF85Y4U7RYxy.aMNfY.qIk4S6tcq.e', 'Marshell Devilito Fitriawan', 'admin_gudang', 'active', NULL, NULL, '2025-10-30 07:42:23', '2025-10-30 10:06:44'),
(4, 'admin1@example.com', '$2y$10$jXVQmKoPS715DbbylBrUhOfaP7u0iDdxqS5F6BcEpZT60uB/XksHe', 'Admin Utama', 'admin', 'active', NULL, NULL, '2025-10-30 10:22:32', '2025-10-30 10:22:32');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_users` (`created_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
