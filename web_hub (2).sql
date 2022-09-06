-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2022 at 01:29 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `main_cat`
--

CREATE TABLE `main_cat` (
  `cat_id` int(10) NOT NULL,
  `cat_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_cat`
--

INSERT INTO `main_cat` (`cat_id`, `cat_name`) VALUES
(1, 'Electronics'),
(2, 'Local dishes'),
(3, 'WallClocks'),
(5, 'photo frames'),
(6, 'Articles'),
(8, 'showPiece'),
(9, 'Women Wears'),
(10, 'Men Wears'),
(12, 'Cards');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pro_id` int(10) NOT NULL,
  `pro_name` text NOT NULL,
  `cat_id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `pro_img1` text NOT NULL,
  `pro_img2` text NOT NULL,
  `pro_img3` text NOT NULL,
  `pro_img4` text NOT NULL,
  `pro_feature1` text NOT NULL,
  `pro_feature2` text NOT NULL,
  `pro_feature3` text NOT NULL,
  `pro_feature4` text NOT NULL,
  `pro_feature5` text NOT NULL,
  `pro_price` text NOT NULL,
  `pro_model` text NOT NULL,
  `pro_warranty` text NOT NULL,
  `pro_keyword` text NOT NULL,
  `pro_added_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pro_id`, `pro_name`, `cat_id`, `sub_cat_id`, `pro_img1`, `pro_img2`, `pro_img3`, `pro_img4`, `pro_feature1`, `pro_feature2`, `pro_feature3`, `pro_feature4`, `pro_feature5`, `pro_price`, `pro_model`, `pro_warranty`, `pro_keyword`, `pro_added_date`) VALUES
(14, 'iphone 11 pro_max', 1, 1, 'images (12).jpeg', 'images (13).jpeg', 'images (11).jpeg', 'images (15).jpeg', '8gb ram', '1tb Internal Staorage', 'follow come ear piece', 'follow come ear pod and charger', 'Support Dual Windows', 'N145000', 'iPhone RIO-AL00', '2years', 'iPhone, Mobile Phones, Electronics, Gadget, Phones ', '2022-08-30 12:22:54'),
(19, 'Women Wears', 9, 9, 'sli1.jpg', 'sli2.jpg', 'sli3.jpg', 'sli4.jpg', 'Foot-Friendly', 'Unique Style Design', 'Water Friendly', 'Light Weight Summer Essentials', 'Soft and Sturdy', '1,500', 'SR6239', '1year', 'Slippers, Women Wears, Easy Wears', '2022-08-30 12:49:11'),
(20, 'Men Wears', 10, 10, 'shoe1.jpeg', 'shoe3.jpeg', 'shoe4.jpeg', 'show2.jpeg', 'Synthetic Nubuck Upper', 'Comfortable Textile Lining', 'Synthetic Leather', 'Comfort Sockliner', 'Rubber outsole with Vulcanised look', '9,000', 'MRV263', '3years', 'Shoes, Men Wears, Easy Wears, Canvas', '2022-08-30 12:54:10'),
(22, 'Rechargeable Fan', 1, 1, 'images (39).jpeg', 'images (38).jpeg', 'images (40).jpeg', 'images (41).jpeg', 'Rechargeable 1500mAH Lithium battery', 'Works 2.5 - 8.5 hours on full charge', 'Foldable and Compact Design', 'Convenient to hold hand', 'Adjustable Speed Settings', '9,000', 'FNR7826', '1year', 'Fan, Rechargeable Fan, Deck Fan, Hand Held Fan, Foldable Fan', '2022-09-02 22:11:36'),
(23, 'Microphone', 1, 1, 'images (8).png', 'images (34).jpeg', 'images (28).jpeg', 'images (37).jpeg', 'XLR Condenser Microphone', '34 mm Large Diaphragm', 'Cardioid Studio Mic', 'Recorder ', 'Podcasting', '5,000', 'MRV263', '2years', 'Microphones, Studio Mic, Recording Mic, Voice Over Mic', '2022-09-06 05:58:58'),
(24, 'Cooking Pots', 2, 2, 'images (10).jpeg', 'download.jpeg', 'download1.jpeg', 'download2.jpeg', 'Stainless Non-Steel Kit', 'Cooking-Set', 'European Cooking Design', 'Tempered Glass Lid', 'Red-Pot and Pan Set', '5,000', 'iPot62-764', '2years', 'Pot, Cooking Pot, Kitchen Utensils, Stainless Steel Set, Glass Pot', '2022-09-06 06:02:42'),
(25, 'Electric Clipper', 1, 1, 'images (27).jpeg', 'images (23).jpeg', 'clipper1.png', 'images (22).jpeg', 'Adjustable Stainless Steel Blade', '34 mm Large Diaphragm', 'Stainless Steel Cutter', 'ABS Body', 'Electric Hair Clipper 6 in 1 Set', '5,000', '#clipper234', '1year', 'Clipper, Wireless clipper, Rechargeable clipper, Electric Clipper, Complete set clipper', '2022-09-06 12:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `sub_cat`
--

CREATE TABLE `sub_cat` (
  `sub_cat_id` int(10) NOT NULL,
  `sub_cat_name` text NOT NULL,
  `cat_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_cat`
--

INSERT INTO `sub_cat` (`sub_cat_id`, `sub_cat_name`, `cat_id`) VALUES
(30, 'computer', 1),
(31, 'Emergency Lights', 1),
(32, 'Clipper', 1),
(33, 'Mobile Phone', 1),
(34, 'Microphones', 1),
(35, 'Mugs', 2),
(36, 'LED Bulbs', 1),
(37, 'Birthday Cards', 12),
(38, 'Anniversary  card', 12),
(39, 'Laptops', 1),
(40, 'Slippers', 9),
(41, 'Sniker', 10),
(42, 'Rechargeable Fan', 1),
(43, 'Microphones', 1),
(44, 'Pots', 2),
(45, 'Wrist Watch', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `main_cat`
--
ALTER TABLE `main_cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `sub_cat`
--
ALTER TABLE `sub_cat`
  ADD PRIMARY KEY (`sub_cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `main_cat`
--
ALTER TABLE `main_cat`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pro_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sub_cat`
--
ALTER TABLE `sub_cat`
  MODIFY `sub_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
