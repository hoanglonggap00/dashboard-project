-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 17, 2021 at 04:35 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myDataBase`
--

-- --------------------------------------------------------

--
-- Table structure for table `MyNews`
--

CREATE TABLE `MyNews` (
  `id` int(6) UNSIGNED NOT NULL,
  `news__name` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `news__description` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `news__content` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `news__status` int(1) UNSIGNED DEFAULT 0,
  `news__category` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `news__img` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyNewsCategory`
--

CREATE TABLE `MyNewsCategory` (
  `id` int(6) UNSIGNED NOT NULL,
  `category__name` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `category_parent__id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyNewsTags`
--

CREATE TABLE `MyNewsTags` (
  `id` int(6) UNSIGNED NOT NULL,
  `tag__name` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyNewsTagsLink`
--

CREATE TABLE `MyNewsTagsLink` (
  `id` int(6) UNSIGNED NOT NULL,
  `link__news` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `link__tag` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyProducts`
--

CREATE TABLE `MyProducts` (
  `id` int(6) UNSIGNED NOT NULL,
  `product__name` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `product__description` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `product__content` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `product__status` int(1) UNSIGNED DEFAULT 0,
  `product__category` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `product__img` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyProductsCategory`
--

CREATE TABLE `MyProductsCategory` (
  `id` int(6) UNSIGNED NOT NULL,
  `category__name` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `category_parent__id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyProductsTags`
--

CREATE TABLE `MyProductsTags` (
  `id` int(6) UNSIGNED NOT NULL,
  `tag__name` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyProductsTagsLink`
--

CREATE TABLE `MyProductsTagsLink` (
  `id` int(6) UNSIGNED NOT NULL,
  `link__product` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `link__tag` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyUsers`
--

CREATE TABLE `MyUsers` (
  `id` int(6) UNSIGNED NOT NULL,
  `user__username` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `user__email` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `user__password` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `user__status` int(1) UNSIGNED DEFAULT 0,
  `user__role` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `user__img` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyUsersRoles`
--

CREATE TABLE `MyUsersRoles` (
  `id` int(6) UNSIGNED NOT NULL,
  `role__name` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `role__description` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MyUsersRolesLink`
--

CREATE TABLE `MyUsersRolesLink` (
  `id` int(6) UNSIGNED NOT NULL,
  `link__role` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `link__permission` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `MyNews`
--
ALTER TABLE `MyNews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyNewsCategory`
--
ALTER TABLE `MyNewsCategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyNewsTags`
--
ALTER TABLE `MyNewsTags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyNewsTagsLink`
--
ALTER TABLE `MyNewsTagsLink`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyProducts`
--
ALTER TABLE `MyProducts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyProductsCategory`
--
ALTER TABLE `MyProductsCategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyProductsTags`
--
ALTER TABLE `MyProductsTags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyProductsTagsLink`
--
ALTER TABLE `MyProductsTagsLink`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyUsers`
--
ALTER TABLE `MyUsers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyUsersRoles`
--
ALTER TABLE `MyUsersRoles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MyUsersRolesLink`
--
ALTER TABLE `MyUsersRolesLink`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `MyNews`
--
ALTER TABLE `MyNews`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyNewsCategory`
--
ALTER TABLE `MyNewsCategory`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyNewsTags`
--
ALTER TABLE `MyNewsTags`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyNewsTagsLink`
--
ALTER TABLE `MyNewsTagsLink`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyProducts`
--
ALTER TABLE `MyProducts`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyProductsCategory`
--
ALTER TABLE `MyProductsCategory`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyProductsTags`
--
ALTER TABLE `MyProductsTags`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyProductsTagsLink`
--
ALTER TABLE `MyProductsTagsLink`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyUsers`
--
ALTER TABLE `MyUsers`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyUsersRoles`
--
ALTER TABLE `MyUsersRoles`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MyUsersRolesLink`
--
ALTER TABLE `MyUsersRolesLink`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
