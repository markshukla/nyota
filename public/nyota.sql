-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2023 at 07:08 PM
-- Server version: 5.7.37-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `postermaker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(1400) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `profile_pic` varchar(1000) DEFAULT NULL,
  `password` varchar(1000) NOT NULL,
  `role` varchar(1000) DEFAULT NULL,
  `permissions` longtext,
  `active` int(11) NOT NULL DEFAULT '0' COMMENT '1=deactive',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `profile_pic`, `password`, `role`, `permissions`, `active`, `updated_at`, `created_at`) VALUES
(1, 'admin', 'test@gmail.com', 'uploads/profile/61cb91a9-e024-4643-a3f4-ca5fef244eaa.png', '$2y$10$pGDqbmTLd69atOsE81KOz.gx5EZrTe8n1HskL4AIeg/D01PPkXF1y', 'Super', '{\"section\":\"true\",\"category\":\"true\",\"posts\":\"true\",\"greeting\":\"true\",\"video\":\"true\",\"slider\":\"true\",\"frame\":\"true\",\"subscription\":\"true\",\"offerdialog\":\"true\",\"pushnotification\":\"true\",\"contacts\":\"true\",\"transaction\":\"true\",\"user\":\"true\",\"setting\":\"true\",\"admin\":\"true\"}', 0, '2023-06-06 22:33:14', '2022-11-02 11:18:12'),
(14, 'demo', 'demo@gmail.com', 'uploads/profile/9b98f807-e9e2-48c2-96bc-81c2657fad61.png', '$2y$10$QRuaJV1zr5Jt2auhwTiYIOrvZ696TpyAPjcIip2Gs7B.laidB0KXe', 'Demo', '{\"section\":\"true\",\"category\":\"true\",\"posts\":\"true\",\"greeting\":\"true\",\"video\":\"true\",\"slider\":\"true\",\"frame\":\"true\",\"subscription\":\"true\",\"offerdialog\":\"true\",\"pushnotification\":\"true\",\"contacts\":\"true\",\"transaction\":\"true\",\"user\":\"true\",\"setting\":\"true\",\"admin\":\"true\"}', 0, '2023-02-16 06:23:58', '2022-12-31 06:55:52');

-- --------------------------------------------------------

--
-- Table structure for table `background`
--

CREATE TABLE `background` (
  `id` int(11) NOT NULL,
  `item_url` varchar(1000) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `background`
--

INSERT INTO `background` (`id`, `item_url`, `updated_at`, `created_at`) VALUES
(2, 'uploads/posts/933288a8-ba58-4e6d-bd6f-4a28d5f8ec11.jpg', '2023-04-28 21:12:58', '2023-04-28 21:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `business_card_digital`
--

CREATE TABLE `business_card_digital` (
  `id` int(11) NOT NULL,
  `title` varchar(1100) NOT NULL,
  `thumb_url` varchar(1100) NOT NULL,
  `blade_name` varchar(1000) DEFAULT NULL,
  `premium` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_card_digital`
--

INSERT INTO `business_card_digital` (`id`, `title`, `thumb_url`, `blade_name`, `premium`, `status`, `updated_at`, `created_at`) VALUES
(5, 'card1', 'uploads/thumbnail/e426215a-73c6-451a-8698-e6b720a8b172.JPG', 'card1', 0, 0, '2023-02-16 07:08:43', '2023-02-16 07:08:43'),
(6, 'card2', 'uploads/thumbnail/bb5e2ed3-b1d0-4b8c-a2cf-0284bd52dc40.JPG', 'card2', 0, 0, '2023-02-16 07:09:50', '2023-02-16 07:09:50'),
(7, 'card3', 'uploads/thumbnail/fa301dde-fcd4-4ce7-87ee-cb130f85067a.JPG', 'card3', 0, 0, '2023-02-16 07:10:11', '2023-02-16 07:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `business_card_tamplate`
--

CREATE TABLE `business_card_tamplate` (
  `id` int(11) NOT NULL,
  `title` varchar(1100) NOT NULL,
  `thumb_url` varchar(1100) NOT NULL,
  `json` text NOT NULL,
  `premium` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_card_tamplate`
--

INSERT INTO `business_card_tamplate` (`id`, `title`, `thumb_url`, `json`, `premium`, `status`, `updated_at`, `created_at`) VALUES
(6, 'card1', 'uploads/thumbnail/d04fc5f7-cb98-49a1-b18e-3a404e72bffe.jpg', '{\"name\":\"card\",\"path\":\" card\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"card\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"uploads\\/tamplate\\/businesscard\\/card1\\/skins\\/card\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1290,\"height\":813},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":54,\"name\":\"company\",\"x\":697,\"y\":522,\"width\":403,\"height\":42,\"text\":\"Vistic Solutions\"},{\"type\":\"image\",\"src\":\"uploads\\/tamplate\\/businesscard\\/card1\\/skins\\/card\\/logo.png\",\"name\":\"logo\",\"x\":789,\"y\":237,\"width\":219,\"height\":213},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"number\",\"x\":144,\"y\":225,\"width\":232,\"height\":23,\"text\":\"+916263020998\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"email\",\"x\":145,\"y\":327,\"width\":523,\"height\":30,\"text\":\"altafmansuri.devloper@gmail.com\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"website\",\"x\":143,\"y\":450,\"width\":299,\"height\":23,\"text\":\"visticsolutuins.com\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"address\",\"x\":150,\"y\":562,\"width\":518,\"height\":29,\"text\":\"Mandsaur,Madhya Pradesh (India)\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"name\",\"x\":822,\"y\":592,\"width\":253,\"height\":23,\"text\":\"yourname\"}]}', 0, 0, '2023-02-16 07:05:58', '2023-02-15 16:35:44'),
(7, 'card2', 'uploads/thumbnail/ca776993-7d73-4244-91ce-ef86c2ac8d6d.jpg', '{\"name\":\"card\",\"path\":\" card\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"card\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"uploads\\/tamplate\\/businesscard\\/card2\\/skins\\/card\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1290,\"height\":813},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0x000000\",\"size\":36,\"name\":\"company\",\"x\":789,\"y\":562,\"width\":272,\"height\":28,\"text\":\"Vistic Solutions\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":36,\"name\":\"name\",\"x\":132,\"y\":121,\"width\":272,\"height\":28,\"text\":\"Vistic Solutions\"},{\"type\":\"text\",\"font\":\"ArialNarrow\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":28,\"name\":\"designation\",\"x\":133,\"y\":159,\"width\":201,\"height\":22,\"text\":\"Vistic Solutions seo\"},{\"type\":\"image\",\"src\":\"uploads\\/tamplate\\/businesscard\\/card2\\/skins\\/card\\/logo.png\",\"name\":\"logo\",\"x\":815,\"y\":297,\"width\":219,\"height\":213,\"effects\":{\"dropShadowMulti\":[],\"innerShadowMulti\":[],\"solidFill\":{\"color\":\"0xff5408\"},\"gradientFillMulti\":[],\"frameFXMulti\":[]}},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"number\",\"x\":206,\"y\":329,\"width\":232,\"height\":23,\"text\":\"+916263020998\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"email\",\"x\":207,\"y\":445,\"width\":323,\"height\":30,\"text\":\"devloper@gmail.com\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"website\",\"x\":209,\"y\":550,\"width\":299,\"height\":23,\"text\":\"visticsolutuins.com\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"center\",\"lineHeight\":124,\"color\":\"0xFFFFFF\",\"size\":32,\"name\":\"address\",\"x\":211,\"y\":665,\"width\":276,\"height\":29,\"text\":\"Mandsaur,Madhya \"}]}', 0, 0, '2023-02-16 07:06:15', '2023-02-15 17:07:50');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(140) DEFAULT NULL,
  `about` text,
  `image` varchar(1000) DEFAULT NULL,
  `language` varchar(1000) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number` varchar(1000) NOT NULL,
  `message` varchar(10000) NOT NULL,
  `type` varchar(1000) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `frames`
--

CREATE TABLE `frames` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `thumbnail` varchar(1000) DEFAULT NULL,
  `json` text NOT NULL,
  `ratio` varchar(1000) DEFAULT NULL,
  `premium` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `type` varchar(1000) NOT NULL DEFAULT 'business',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frames`
--

INSERT INTO `frames` (`id`, `title`, `thumbnail`, `json`, `ratio`, `premium`, `category_id`, `status`, `type`, `updated_at`, `created_at`) VALUES
(45, 'Personal1', 'uploads/thumbnail/fd7acbe4-8e92-4ffc-83a6-ea9195129e91.jpg', '{\"name\":\"personal\",\"path\":\" personal\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"personal\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Personal1\\/skins\\/personal\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1280,\"height\":1280},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Personal1\\/skins\\/personal\\/logo.png\",\"name\":\"logo\",\"x\":986,\"y\":989,\"width\":272,\"height\":291},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Personal1\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"uppercase\":true,\"color\":\"0x000000\",\"size\":65,\"name\":\"name\",\"x\":77,\"y\":1148,\"width\":449,\"height\":44,\"text\":\"Rahul SHARMA\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Personal1\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"uppercase\":true,\"color\":\"0xFFFFFF\",\"size\":39,\"name\":\"number\",\"x\":87,\"y\":1232,\"width\":271,\"height\":26,\"text\":\"+916263020998\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Personal1\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"color\":\"0xFFFFFF\",\"size\":39,\"name\":\"email\",\"x\":464,\"y\":1229,\"width\":422,\"height\":34,\"text\":\"visticsolution@gmail.com\"}]}', '1:1', 0, 4, 0, 'business', '2023-04-10 11:24:08', '2023-04-10 11:24:08'),
(46, 'frame1', 'uploads/thumbnail/22373910-e19a-43c6-892a-6ac96052c972.jpg', '{\"name\":\"frame\",\"path\":\" frame\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"frame\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame1\\/skins\\/frame\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1200,\"height\":1200},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame1\\/skins\\/frame\\/location_logo.png\",\"name\":\"location_logo\",\"x\":153,\"y\":1136,\"width\":46,\"height\":45},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame1\\/skins\\/frame\\/web_logo.png\",\"name\":\"web_logo\",\"x\":821,\"y\":1068,\"width\":48,\"height\":48},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame1\\/skins\\/frame\\/logo.png\",\"name\":\"logo\",\"x\":60,\"y\":53,\"width\":205,\"height\":203},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame1\\/skins\\/frame\\/email_logo.png\",\"name\":\"email_logo\",\"x\":397,\"y\":1068,\"width\":49,\"height\":48},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame1\\/skins\\/frame\\/phone_logo.png\",\"name\":\"phone_logo\",\"x\":77,\"y\":1068,\"width\":48,\"height\":48},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame1\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"number\",\"x\":142,\"y\":1081,\"width\":213,\"height\":21,\"text\":\"+916263020998\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame1\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"email\",\"x\":466,\"y\":1080,\"width\":339,\"height\":28,\"text\":\"visticsolution@gmail.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame1\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"website\",\"x\":890,\"y\":1078,\"width\":229,\"height\":28,\"text\":\"nyota.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame1\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":41,\"name\":\"address\",\"x\":210,\"y\":1143,\"width\":858,\"height\":36,\"text\":\"Bangalore,Akshya Nagar 1st Block 1st Cross, India\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame1\\/fonts\\/DesignerRegular.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0x00A3C5\",\"size\":48,\"name\":\"company\",\"x\":719,\"y\":53,\"width\":437,\"height\":35,\"text\":\"Poster Banao\"}]}', '1:1', 0, 4, 0, 'business', '2023-04-10 11:15:53', '2023-04-10 11:15:53'),
(47, 'frame2', 'uploads/thumbnail/74f4328f-2ffb-489c-a359-24dc3f3431c5.jpg', '{\"name\":\"frame\",\"path\":\" frame\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"frame\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame2\\/skins\\/frame\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1200,\"height\":1200},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame2\\/skins\\/frame\\/logo.png\",\"name\":\"logo\",\"x\":60,\"y\":53,\"width\":205,\"height\":203},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame2\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0x193308\",\"size\":31,\"name\":\"number\",\"x\":938,\"y\":1099,\"width\":213,\"height\":21,\"text\":\"+916263020998\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame2\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"email\",\"x\":118,\"y\":1096,\"width\":339,\"height\":28,\"text\":\"visticsolution@gmail.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame2\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"right\",\"lineHeight\":85,\"color\":\"0x193308\",\"size\":31,\"name\":\"website\",\"x\":922,\"y\":100,\"width\":230,\"height\":28,\"text\":\"nyota.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame2\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":41,\"name\":\"address\",\"x\":120,\"y\":1151,\"width\":858,\"height\":36,\"text\":\"Bangalore,Akshya Nagar 1st Block 1st Cross, India\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame2\\/fonts\\/CopperplateGothic-Bold.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFC400\",\"size\":48,\"name\":\"company\",\"x\":764,\"y\":53,\"width\":389,\"height\":35,\"text\":\"Poster Banao\"}]}', '1:1', 0, 4, 0, 'business', '2023-04-10 11:16:45', '2023-04-10 11:16:45'),
(48, 'frame3', 'uploads/thumbnail/e208da47-a087-4166-8ac4-688f0696dc6f.jpg', '{\"name\":\"frame\",\"path\":\" frame\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"frame\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame3\\/skins\\/frame\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1200,\"height\":1200},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame3\\/skins\\/frame\\/logo.png\",\"name\":\"logo\",\"x\":59,\"y\":49,\"width\":187,\"height\":187},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame3\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"email\",\"x\":518,\"y\":1096,\"width\":339,\"height\":28,\"text\":\"visticsolution@gmail.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame3\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"number\",\"x\":927,\"y\":1098,\"width\":213,\"height\":21,\"text\":\"+916263020998\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame3\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"right\",\"lineHeight\":85,\"color\":\"0x193308\",\"size\":31,\"name\":\"website\",\"x\":38,\"y\":252,\"width\":230,\"height\":28,\"text\":\"nyota.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame3\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0x000000\",\"size\":40,\"name\":\"address\",\"x\":104,\"y\":1157,\"width\":1080,\"height\":35,\"text\":\"28, Manish Ngr Shop Centre, 4 Bunglow, Nr Indian Oil, Andheri \"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame3\\/fonts\\/CopperplateGothic-Bold.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":35,\"name\":\"company\",\"x\":70,\"y\":1097,\"width\":287,\"height\":25,\"text\":\"Poster Banao\"}]}', '1:1', 0, 4, 0, 'business', '2023-04-10 11:17:29', '2023-04-10 11:17:29'),
(49, 'frame4', 'uploads/thumbnail/876e3236-4050-4064-88d8-1f9f07881808.jpg', '{\"name\":\"frame\",\"path\":\" frame\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"frame\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame4\\/skins\\/frame\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1200,\"height\":1200},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame4\\/skins\\/frame\\/logo.png\",\"name\":\"logo\",\"x\":35,\"y\":23,\"width\":187,\"height\":187},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame4\\/skins\\/frame\\/twit.png\",\"name\":\"twit\",\"x\":1140,\"y\":22,\"width\":47,\"height\":47},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame4\\/skins\\/frame\\/face.png\",\"name\":\"face\",\"x\":1031,\"y\":23,\"width\":47,\"height\":47},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame4\\/skins\\/frame\\/insta.png\",\"name\":\"insta\",\"x\":1085,\"y\":22,\"width\":48,\"height\":47},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame4\\/skins\\/frame\\/whats.png\",\"name\":\"whats\",\"x\":976,\"y\":22,\"width\":47,\"height\":47},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame4\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"email\",\"x\":828,\"y\":1068,\"width\":339,\"height\":28,\"text\":\"visticsolution@gmail.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame4\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":31,\"name\":\"number\",\"x\":94,\"y\":1066,\"width\":339,\"height\":28,\"text\":\"+91123456789\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame4\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"right\",\"lineHeight\":85,\"color\":\"0x111C7E\",\"size\":32,\"name\":\"website\",\"x\":868,\"y\":70,\"width\":321,\"height\":29,\"text\":\"www.nyota.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame4\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"lineHeight\":85,\"color\":\"0x111C7E\",\"size\":40,\"name\":\"address\",\"x\":61,\"y\":1132,\"width\":1080,\"height\":35,\"text\":\"28, Manish Ngr Shop Centre, 4 Bunglow, Nr Indian Oil, Andheri \"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame4\\/fonts\\/Ranille-Normal-Regular.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"lineHeight\":85,\"color\":\"0x111C7E\",\"size\":45,\"name\":\"company\",\"x\":450,\"y\":1060,\"width\":299,\"height\":34,\"text\":\"Poster Banao\"}]}', '1:1', 0, 4, 0, 'business', '2023-04-10 11:18:05', '2023-04-10 11:18:05'),
(50, 'frame5', 'uploads/thumbnail/a5d64569-0d0c-42c4-9b97-cbcabb817aae.jpg', '{\"name\":\"frame\",\"path\":\" frame\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"frame\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame5\\/skins\\/frame\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1200,\"height\":1200},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/frame5\\/skins\\/frame\\/logo.png\",\"name\":\"logo\",\"x\":35,\"y\":23,\"width\":187,\"height\":187},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame5\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0x000000\",\"size\":28,\"name\":\"email\",\"x\":470,\"y\":1114,\"width\":312,\"height\":25,\"text\":\"visticsolution@gmail.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame5\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0x000000\",\"size\":28,\"name\":\"number\",\"x\":48,\"y\":1117,\"width\":195,\"height\":19,\"text\":\"+916263020998\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame5\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"left\",\"lineHeight\":85,\"color\":\"0x000000\",\"size\":28,\"name\":\"website\",\"x\":914,\"y\":1114,\"width\":288,\"height\":20,\"text\":\"www.visticsolution.com\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame5\\/fonts\\/Calibri.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"lineHeight\":85,\"color\":\"0xFFFFFF\",\"size\":33,\"name\":\"address\",\"x\":145,\"y\":1162,\"width\":899,\"height\":29,\"text\":\"28, Manish Ngr Shop Centre, 4 Bunglow, Nr Indian Oil, Andheri \"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/frame5\\/fonts\\/Ranille.ttf\",\"weight\":\"bold\",\"justification\":\"center\",\"lineHeight\":85,\"color\":\"0x111C7E\",\"size\":45,\"name\":\"company\",\"x\":868,\"y\":42,\"width\":299,\"height\":34,\"text\":\"Poster Banao\"}]}', '1:1', 0, 4, 0, 'business', '2023-04-10 11:20:38', '2023-04-10 11:20:38'),
(51, 'Political', 'uploads/thumbnail/0898272c-3d8e-4c85-92e9-c336d87053ec.jpg', '{\"name\":\"political\",\"path\":\" political\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"political\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Political\\/skins\\/political\\/poitical.png\",\"name\":\"poitical\",\"x\":0,\"y\":0,\"width\":1280,\"height\":1280},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Political\\/skins\\/political\\/whatsapp.png\",\"name\":\"whatsapp\",\"x\":948,\"y\":1234,\"width\":42,\"height\":42},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Political\\/skins\\/political\\/facebook.png\",\"name\":\"facebook\",\"x\":22,\"y\":1234,\"width\":42,\"height\":42},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Political\\/skins\\/political\\/instagram.png\",\"name\":\"instagram\",\"x\":640,\"y\":1234,\"width\":41,\"height\":42},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Political\\/skins\\/political\\/twitter.png\",\"name\":\"twitter\",\"x\":329,\"y\":1234,\"width\":42,\"height\":42},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Political\\/skins\\/political\\/partylogo.png\",\"name\":\"partylogo\",\"x\":917,\"y\":967,\"width\":263,\"height\":244},{\"type\":\"image\",\"src\":\"\\/uploads\\/frame\\/Political\\/skins\\/political\\/logo.png\",\"name\":\"logo\",\"x\":54,\"y\":892,\"width\":318,\"height\":340},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Political\\/fonts\\/Calibri-Bold.ttf\",\"justification\":\"left\",\"uppercase\":true,\"color\":\"0xFFFFFF\",\"size\":57,\"name\":\"name\",\"x\":421,\"y\":1134,\"width\":383,\"height\":38,\"text\":\"Rahul SHARMA\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Political\\/fonts\\/Arial-BoldMT.ttf\",\"justification\":\"left\",\"uppercase\":true,\"color\":\"0xFFFFFF\",\"size\":36,\"name\":\"designation\",\"x\":421,\"y\":1191,\"width\":353,\"height\":25,\"text\":\"Your designation\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Political\\/fonts\\/Calibri.ttf\",\"justification\":\"center\",\"color\":\"0xFFFFFF\",\"size\":34,\"name\":\"facebook_1\",\"x\":80,\"y\":1244,\"width\":170,\"height\":23,\"text\":\"rahulsharma\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Political\\/fonts\\/Calibri.ttf\",\"justification\":\"center\",\"color\":\"0xFFFFFF\",\"size\":34,\"name\":\"twitter_1\",\"x\":386,\"y\":1243,\"width\":170,\"height\":23,\"text\":\"rahulsharma\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Political\\/fonts\\/Calibri.ttf\",\"justification\":\"center\",\"color\":\"0xFFFFFF\",\"size\":34,\"name\":\"instagram_1\",\"x\":696,\"y\":1243,\"width\":170,\"height\":23,\"text\":\"rahulsharma\"},{\"type\":\"text\",\"font\":\"\\/uploads\\/frame\\/Political\\/fonts\\/Calibri.ttf\",\"justification\":\"center\",\"color\":\"0xFFFFFF\",\"size\":34,\"name\":\"whatsapp_1\",\"x\":996,\"y\":1245,\"width\":222,\"height\":21,\"text\":\"+916263020998\"}]}', '1:1', 0, 4, 0, 'business', '2023-04-10 11:22:22', '2023-04-10 11:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `frame_category`
--

CREATE TABLE `frame_category` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frame_category`
--

INSERT INTO `frame_category` (`id`, `name`, `status`, `updated_at`, `created_at`) VALUES
(2, 'Political', 0, '2022-12-26 19:01:06', '2022-12-20 15:56:26'),
(4, 'Business', 0, '2023-04-10 11:32:49', '2023-01-14 07:59:28');

-- --------------------------------------------------------

--
-- Table structure for table `greeting_posts`
--

CREATE TABLE `greeting_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(1400) NOT NULL,
  `thumb_url` varchar(10000) NOT NULL,
  `item_url` varchar(1000) NOT NULL,
  `slug` varchar(1000) DEFAULT NULL,
  `premium` int(11) NOT NULL DEFAULT '0' COMMENT '1-premium',
  `type` varchar(100) NOT NULL DEFAULT 'image' COMMENT 'image,video',
  `language` varchar(1000) DEFAULT NULL,
  `section_id` int(11) DEFAULT '0',
  `orientation` varchar(100) DEFAULT NULL,
  `height` int(11) DEFAULT '0',
  `width` int(11) DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `greeting_section`
--

CREATE TABLE `greeting_section` (
  `id` int(11) NOT NULL,
  `name` varchar(140) NOT NULL,
  `language` varchar(1000) DEFAULT NULL,
  `orders` int(11) DEFAULT '0',
  `post_using` varchar(1000) DEFAULT NULL,
  `keyword` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invitation_card`
--

CREATE TABLE `invitation_card` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `thumb_url` varchar(1000) NOT NULL,
  `json` text NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `premium` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invitation_card`
--

INSERT INTO `invitation_card` (`id`, `title`, `thumb_url`, `json`, `category_id`, `premium`, `status`, `updated_at`, `created_at`) VALUES
(2, 'weddingtamplate1', 'uploads/thumbnail/cde45ad9-41cd-41df-8812-ab186250e57e.jpeg', '{\"name\":\"inv\",\"path\":\" inv\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"inv\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"uploads\\/tamplate\\/invitationcard\\/weddingtamplate1\\/skins\\/inv\\/background.png\",\"name\":\"background\",\"x\":-78,\"y\":-58,\"width\":1337,\"height\":1776},{\"type\":\"text\",\"font\":\"MyriadPro-Regular\",\"justification\":\"center\",\"uppercase\":true,\"lineHeight\":88,\"color\":\"0x404040\",\"size\":94,\"name\":\"subtitle\",\"x\":305,\"y\":151,\"width\":588,\"height\":65,\"text\":\"Save the date\"},{\"type\":\"text\",\"font\":\"MyriadPro-Regular\",\"justification\":\"left\",\"uppercase\":true,\"color\":\"0x404040\",\"size\":45,\"name\":\"date1\",\"x\":755,\"y\":1452,\"width\":90,\"height\":30,\"text\":\"2022\"},{\"type\":\"text\",\"font\":\"Judson-Bold\",\"justification\":\"left\",\"uppercase\":true,\"color\":\"0x404040\",\"size\":45,\"name\":\"date2\",\"x\":756,\"y\":1413,\"width\":145,\"height\":28,\"text\":\"MARCH\"},{\"type\":\"text\",\"font\":\"Judson-Bold\",\"justification\":\"center\",\"uppercase\":true,\"color\":\"0x404040\",\"size\":117,\"name\":\"date3\",\"x\":579,\"y\":1412,\"width\":100,\"height\":71,\"text\":\"12\"},{\"type\":\"text\",\"font\":\"Judson-Bold\",\"justification\":\"right\",\"uppercase\":true,\"color\":\"0x404040\",\"size\":45,\"name\":\"time\",\"x\":407,\"y\":1455,\"width\":95,\"height\":28,\"text\":\"17:00\"},{\"type\":\"text\",\"font\":\"Judson-Bold\",\"justification\":\"right\",\"uppercase\":true,\"color\":\"0x404040\",\"size\":45,\"name\":\"day\",\"x\":298,\"y\":1413,\"width\":206,\"height\":28,\"text\":\"SATURDAY\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"center\",\"lineHeight\":61,\"color\":\"0x404040\",\"size\":181,\"name\":\"girl\",\"x\":481,\"y\":840,\"width\":331,\"height\":212,\"text\":\"Sofia\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"center\",\"lineHeight\":61,\"color\":\"0x404040\",\"size\":93,\"name\":\"_\",\"x\":673,\"y\":801,\"width\":69,\"height\":70,\"text\":\"&\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"center\",\"lineHeight\":61,\"color\":\"0x404040\",\"size\":181,\"name\":\"boy\",\"x\":335,\"y\":646,\"width\":354,\"height\":214,\"text\":\"Jhon\"}]}', 2, 1, 0, '2023-02-16 07:14:45', '2023-01-29 12:56:26'),
(4, 'weddingcard1', 'uploads/thumbnail/87077ec2-3a53-40ae-9947-e71e01b941e8.jpg', '{\"name\":\"psdfile\",\"path\":\" psdfile\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"psdfile\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"image\",\"src\":\"uploads\\/tamplate\\/invitationcard\\/weddingcard1\\/skins\\/psdfile\\/background.png\",\"name\":\"background\",\"x\":0,\"y\":0,\"width\":1080,\"height\":1350},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":25,\"name\":\"your_invited_to\",\"x\":384,\"y\":176,\"width\":239,\"height\":18,\"text\":\"Your Invited To\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":25,\"name\":\"addre\",\"x\":237,\"y\":996,\"width\":605,\"height\":23,\"text\":\"Road no 25, Sundar Ngr Mp, Bhopal, India\"},{\"type\":\"text\",\"font\":\"ArialMT\",\"justification\":\"center\",\"color\":\"0xA81000\",\"size\":25,\"name\":\"qutes\",\"x\":269,\"y\":1100,\"width\":529,\"height\":114,\"text\":\"One day, in your search for happiness\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":31,\"name\":\"the_wedding_of\",\"x\":354,\"y\":225,\"width\":299,\"height\":28,\"text\":\"The Wedding Of\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":41,\"name\":\"date\",\"x\":333,\"y\":918,\"width\":379,\"height\":37,\"text\":\"October 8, 2023\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":31,\"name\":\"time\",\"x\":358,\"y\":865,\"width\":321,\"height\":22,\"text\":\"8 AM To 12:00 PM\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":140,\"name\":\"sean\",\"x\":265,\"y\":365,\"width\":320,\"height\":127,\"text\":\"Sean\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":140,\"name\":\"amile\",\"x\":493,\"y\":635,\"width\":320,\"height\":118,\"text\":\"Amile\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":105,\"name\":\"and\",\"x\":505,\"y\":523,\"width\":60,\"height\":79,\"text\":\"&\"}]}', 2, 0, 0, '2023-02-16 07:12:21', '2023-02-14 06:05:40'),
(5, 'invitationcard2', 'uploads/thumbnail/47fc38ce-7af5-42d9-a293-19e2c36c9f8c.jpg', '{\"name\":\"psdfile\",\"path\":\" psdfile\\/\",\"info\":{\"description\":\"Normal\",\"file\":\"psdfile\",\"date\":\"sRGB\",\"title\":\"\",\"author\":\"\",\"keywords\":\"\",\"generator\":\"Export Kit v1.2.8\"},\"layers\":[{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":27,\"name\":\"your_invited_to\",\"x\":384,\"y\":188,\"width\":239,\"height\":20,\"text\":\"Your Invited To\"},{\"type\":\"image\",\"src\":\"uploads\\/tamplate\\/invitationcard\\/invitationcard2\\/skins\\/psdfile\\/background.png\",\"name\":\"background\",\"x\":-5,\"y\":0,\"width\":1080,\"height\":1450},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":27,\"name\":\"addre\",\"x\":237,\"y\":1029,\"width\":605,\"height\":25,\"text\":\"Road no 25, Sundar Ngr Mp, Bhopal, India\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":33,\"name\":\"the_wedding_of\",\"x\":60,\"y\":242,\"width\":298,\"height\":31,\"text\":\"The Wedding Of\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":44,\"name\":\"date\",\"x\":345,\"y\":961,\"width\":379,\"height\":39,\"text\":\"October 8, 2023\"},{\"type\":\"text\",\"font\":\"Arial-BoldMT\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":33,\"name\":\"time\",\"x\":379,\"y\":907,\"width\":321,\"height\":24,\"text\":\"8 AM To 12:00 PM\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":150,\"name\":\"sean\",\"x\":149,\"y\":346,\"width\":320,\"height\":137,\"text\":\"Sean\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":142,\"name\":\"amile\",\"x\":362,\"y\":625,\"width\":305,\"height\":120,\"text\":\"Amile\"},{\"type\":\"text\",\"font\":\"GreatVibes-Regular\",\"justification\":\"left\",\"color\":\"0x000000\",\"size\":113,\"name\":\"and\",\"x\":396,\"y\":511,\"width\":60,\"height\":86,\"text\":\"&\"}]}', 2, 0, 0, '2023-02-16 07:14:06', '2023-02-14 06:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `invitation_category`
--

CREATE TABLE `invitation_category` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invitation_category`
--

INSERT INTO `invitation_category` (`id`, `name`, `image`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Event', 'uploads/posts/a9c73593-6f26-46a4-a5ff-4166d5a980d8.jpg', 0, '2023-01-29 11:57:28', '2023-01-29 10:17:48'),
(2, 'Wedding Invitation Card', 'uploads/posts/301326b1-7643-41ae-8080-3a0746075dda.jpg', 0, '2023-01-29 12:53:45', '2023-01-29 12:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `language_name` varchar(1000) NOT NULL,
  `language_code` varchar(1000) NOT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `language_name`, `language_code`, `image`, `status`, `updated_at`, `created_at`) VALUES
(4, 'English', 'en', 'uploads/posts/911a7314-ea2e-4358-85ef-ada71322eed8.png', 0, '2023-02-16 06:34:29', '2022-12-20 12:40:21'),
(5, 'Hindi', 'hi', 'uploads/posts/3d37bfb5-83a5-492c-a9ba-fd60b3f5d908.jpg', 0, '2023-02-16 06:29:44', '2022-12-24 12:32:26'),
(6, 'Gujarati', 'gu', 'uploads/posts/fcb1459d-c4d1-4343-b33b-d3ef42c70189.jpg', 0, '2023-02-16 06:34:58', '2023-01-06 08:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `logos`
--

CREATE TABLE `logos` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `code` text NOT NULL,
  `premium` int(11) NOT NULL DEFAULT '0',
  `thumb_url` varchar(1000) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `type` varchar(1000) NOT NULL DEFAULT 'business',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logos`
--

INSERT INTO `logos` (`id`, `title`, `code`, `premium`, `thumb_url`, `category_id`, `status`, `type`, `updated_at`, `created_at`) VALUES
(1, 'Medical', '<!DOCTYPE html>\r\n<html>\r\n  <head>\r\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n    <link href=\"https://fonts.googleapis.com/css2?family=Alkatra&display=swap\" rel=\"stylesheet\">\r\n    <style>\r\n      .container {\r\n        display: flex;\r\n        justify-content: center;\r\n        align-items: center;\r\n        flex-direction: column;\r\n        height: 100vh;\r\n        /* set height of container to full viewport height */\r\n      }\r\n\r\n      .name {\r\n        margin: 0px;\r\n        font-weight: bold;\r\n        font-size: 20px;\r\n        font-family: \'Alkatra\', cursive;\r\n      }\r\n\r\n      img {\r\n        max-width: 50%;\r\n        /* ensure image does not exceed the width of the container */\r\n      }\r\n    </style>\r\n  </head>\r\n  <body>\r\n    <div class=\"container\">\r\n      <img src=\"https://i.pinimg.com/originals/85/95/f4/8595f4b711e503bc72fe396e5043e0c2.png\" alt=\"Image description\">\r\n      <p class=\"name\" id=\"name\">Poster Banao</p>\r\n    </div>\r\n    <script>\r\n      function changeName(val) {\r\n        document.getElementById(\'name\').innerHTML = val;\r\n      }\r\n    </script>\r\n  </body>\r\n</html>', 0, 'uploads/logos/0bedd691-d384-4832-bceb-292e05b0d100.png', 5, 0, 'business', '2023-04-05 21:52:06', '2023-04-03 11:24:35'),
(2, 'medical & hospital', '<!DOCTYPE html>\r\n<html>\r\n  <head>\r\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n    <link href=\"https://fonts.googleapis.com/css2?family=Teko&display=swap\" rel=\"stylesheet\">\r\n    <style>\r\n      .container {\r\n        display: flex;\r\n        justify-content: center;\r\n        align-items: center;\r\n        flex-direction: column;\r\n        height: 100vh;\r\n        /* set height of container to full viewport height */\r\n      }\r\n\r\n      .name {\r\n        margin-top: -5px;\r\n        font-weight: bold;\r\n        font-size: 20px;\r\n        font-family: \'Teko\', sans-serif;\r\n      }\r\n\r\n      img {\r\n        max-width: 50%;\r\n        /* ensure image does not exceed the width of the container */\r\n      }\r\n    </style>\r\n  </head>\r\n  <body>\r\n    <div class=\"container\">\r\n      <img src=\"https://cdn-icons-png.flaticon.com/512/822/822143.png\" alt=\"Image description\">\r\n      <p class=\"name\" id=\"name\">Poster Banao</p>\r\n    </div>\r\n    <script>\r\n      function changeName(val) {\r\n        document.getElementById(\'name\').innerHTML = val;\r\n      }\r\n    </script>\r\n  </body>\r\n</html>', 0, 'uploads/logos/095925d1-f1fd-4fa3-b396-daabb366998d.png', 5, 0, 'business', '2023-04-05 21:52:37', '2023-04-03 14:05:40'),
(3, 'Hospital & Medical', '<!DOCTYPE html>\r\n<html>\r\n  <head>\r\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n    <link href=\"https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap\" rel=\"stylesheet\">\r\n    <style>\r\n      .container {\r\n        display: flex;\r\n        justify-content: center;\r\n        align-items: center;\r\n        height: 100vh;\r\n        /* set height of container to full viewport height */\r\n      }\r\n\r\n      .name {\r\n        color: green;\r\n        margin-left: -20px;\r\n        font-weight: bold;\r\n        font-size: 20px;\r\n        font-family: \'Bebas Neue\', cursive;\r\n      }\r\n\r\n      img {\r\n        max-width: 50%;\r\n        /* ensure image does not exceed the width of the container */\r\n      }\r\n    </style>\r\n  </head>\r\n  <body>\r\n    <div class=\"container\">\r\n      <img src=\"https://res.cloudinary.com/dse9nnmqr/image/upload/v1680513734/cropped-favicon-1-removebg-preview_dluizw.png\" alt=\"Image description\">\r\n      <p class=\"name\" id=\"name\">Poster Banao</p>\r\n    </div>\r\n    <script>\r\n      function changeName(val) {\r\n        document.getElementById(\'name\').innerHTML = val;\r\n      }\r\n    </script>\r\n  </body>\r\n</html>', 1, 'uploads/logos/b9f56998-fcbe-4bfd-9a2e-c20607cb4447.png', 5, 0, 'business', '2023-04-05 21:52:59', '2023-04-03 14:27:09'),
(4, 'shop', '<!DOCTYPE html>\r\n<html>\r\n  <head>\r\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n    <link href=\"https://fonts.googleapis.com/css2?family=Righteous&display=swap\" rel=\"stylesheet\">\r\n    <style>\r\n      .container {\r\n        display: flex;\r\n        justify-content: center;\r\n        align-items: center;\r\n        flex-direction: column;\r\n        height: 100vh;\r\n        /* set height of container to full viewport height */\r\n      }\r\n\r\n      .name {\r\n        margin-top: 10px;\r\n        font-weight: bold;\r\n        font-size: 20px;\r\n        font-family: \'Righteous\', cursive;\r\n      }\r\n\r\n      img {\r\n        max-width: 50%;\r\n        /* ensure image does not exceed the width of the container */\r\n      }\r\n    </style>\r\n  </head>\r\n  <body>\r\n    <div class=\"container\">\r\n      <img src=\"https://res.cloudinary.com/dse9nnmqr/image/upload/v1680515898/hand-drawn-shop-local-logo-design_23-2149581475-removebg-preview_rzkh2b.png\">\r\n      <p class=\"name\" id=\"name\">Poster Banao</p>\r\n    </div>\r\n    <script>\r\n      function changeName(val) {\r\n        document.getElementById(\'name\').innerHTML = val;\r\n      }\r\n    </script>\r\n  </body>\r\n</html>', 1, 'uploads/logos/af0b9ffb-451a-4c50-afb7-366ac4357d24.png', 6, 0, 'business', '2023-04-05 21:53:27', '2023-04-03 15:02:29'),
(5, 'mobile & laptop', '<!DOCTYPE html>\r\n<html>\r\n  <head>\r\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n    <link href=\"https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap\" rel=\"stylesheet\">\r\n    <style>\r\n      .container {\r\n        display: flex;\r\n        justify-content: center;\r\n        align-items: center;\r\n        flex-direction: column;\r\n        height: 100vh;\r\n        /* set height of container to full viewport height */\r\n      }\r\n\r\n      .name {\r\n        margin-top: 10px;\r\n        font-weight: bold;\r\n        font-size: 20px;\r\n        font-family: \'Black Ops One\', cursive;\r\n      }\r\n\r\n      img {\r\n        max-width: 50%;\r\n        /* ensure image does not exceed the width of the container */\r\n      }\r\n    </style>\r\n  </head>\r\n  <body>\r\n    <div class=\"container\">\r\n      <img src=\"https://cdn-icons-png.flaticon.com/512/3659/3659898.png\">\r\n      <p class=\"name\" id=\"name\">Poster Banao</p>\r\n    </div>\r\n    <script>\r\n      function changeName(val) {\r\n        document.getElementById(\'name\').innerHTML = val;\r\n      }\r\n    </script>\r\n  </body>\r\n</html>', 0, 'uploads/logos/d0eadace-aa22-4299-a039-e043e9ea940f.png', 7, 0, 'business', '2023-04-05 21:53:52', '2023-04-03 17:05:44'),
(6, 'electronics', '<!DOCTYPE html>\r\n<html>\r\n  <head>\r\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n    <link href=\"https://fonts.googleapis.com/css2?family=Bungee+Shade&display=swap\" rel=\"stylesheet\">\r\n    <style>\r\n      .container {\r\n        display: flex;\r\n        justify-content: center;\r\n        align-items: center;\r\n        flex-direction: column;\r\n        height: 100vh;\r\n        /* set height of container to full viewport height */\r\n      }\r\n\r\n      .name {\r\n        color: rgb(22, 38, 105);\r\n        margin-top: -5px;\r\n        font-weight: bold;\r\n        font-size: 10px;\r\n        font-family: \'Bungee Shade\', cursive;\r\n      }\r\n\r\n      img {\r\n        max-width: 60%;\r\n        /* ensure image does not exceed the width of the container */\r\n      }\r\n    </style>\r\n  </head>\r\n  <body>\r\n    <div class=\"container\">\r\n      <img src=\"https://res.cloudinary.com/dse9nnmqr/image/upload/v1680523777/_Pngtree_electric_mechanical_logo_4167230-removebg-preview_qvnyz8.png\">\r\n      <p class=\"name\" id=\"name\">Poster Banao</p>\r\n    </div>\r\n    <script>\r\n      function changeName(val) {\r\n        document.getElementById(\'name\').innerHTML = val;\r\n      }\r\n    </script>\r\n  </body>\r\n</html>', 0, 'uploads/logos/68e38ef8-fd30-409e-a8f2-81d579ab268a.png', 7, 0, 'business', '2023-04-05 22:03:48', '2023-04-03 17:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `logo_category`
--

CREATE TABLE `logo_category` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logo_category`
--

INSERT INTO `logo_category` (`id`, `name`, `status`, `updated_at`, `created_at`) VALUES
(5, 'Medical & Hospital', 0, '2023-04-03 13:42:55', '2023-04-02 14:47:04'),
(6, 'Grocery & Shop', 0, '2023-04-03 14:51:34', '2023-04-03 14:51:34'),
(7, 'Electronics', 0, '2023-04-03 17:00:17', '2023-04-03 17:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE `music` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(1000) DEFAULT NULL,
  `item_url` text NOT NULL,
  `premium` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `language` varchar(100) NOT NULL DEFAULT 'en',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `music_category`
--

CREATE TABLE `music_category` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `message` varchar(10000) DEFAULT NULL,
  `thumbnail` varchar(1000) DEFAULT NULL,
  `action` varchar(1000) NOT NULL,
  `action_item` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offer_dialog`
--

CREATE TABLE `offer_dialog` (
  `id` int(11) NOT NULL,
  `item_url` varchar(10000) DEFAULT NULL,
  `action` varchar(1000) DEFAULT NULL,
  `action_item` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(1400) NOT NULL,
  `thumb_url` varchar(10000) NOT NULL,
  `frame_url` varchar(1000) DEFAULT NULL,
  `item_url` varchar(1000) NOT NULL,
  `slug` varchar(15) DEFAULT NULL,
  `type` varchar(100) NOT NULL COMMENT 'festival,bussiness',
  `json` text,
  `language` varchar(1000) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `sub_category_id` int(11) DEFAULT '0',
  `section_id` int(11) NOT NULL DEFAULT '0',
  `orientation` varchar(100) DEFAULT NULL,
  `height` int(11) DEFAULT '0',
  `width` int(11) DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `premium` int(11) NOT NULL DEFAULT '0' COMMENT '1=premium',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `promocode`
--

CREATE TABLE `promocode` (
  `id` int(11) NOT NULL,
  `code` varchar(1000) DEFAULT NULL,
  `discount` int(10) DEFAULT '0',
  `total_use` int(10) NOT NULL DEFAULT '10',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `name` varchar(1400) NOT NULL,
  `language` varchar(1000) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `post_using` varchar(1000) DEFAULT NULL,
  `keyword` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `name`, `language`, `orders`, `post_using`, `keyword`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Happy Holi', NULL, 0, NULL, NULL, 0, '2023-02-16 07:17:47', '2023-02-16 07:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `thumb_url` varchar(1000) NOT NULL,
  `old_price` int(11) NOT NULL DEFAULT '0',
  `new_price` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `service_inquiries`
--

CREATE TABLE `service_inquiries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `service_id` int(11) NOT NULL DEFAULT '0',
  `number` varchar(1000) NOT NULL,
  `message` varchar(10000) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `field` varchar(1000) DEFAULT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `field`, `value`, `updated_at`, `created_at`) VALUES
(2, 'app_name', 'Poster Banao', '2022-12-22 09:21:17', '2022-12-22 09:21:29'),
(3, 'company_name', 'VisticSlution', '2022-12-22 08:30:24', '2022-12-22 09:21:29'),
(4, 'app_logo', 'uploads/c794c273-9b69-40c9-93e8-d665ecb1688e.png', '2023-02-26 05:25:28', '2022-12-22 09:21:29'),
(5, 'company_logo', 'uploads/abf65c30-2d13-48c0-ba95-576b44f9d2a5.png', '2023-02-26 05:25:29', '2022-12-22 09:21:29'),
(6, 'contact_number', '+916263020998', '2022-12-22 09:21:17', '2022-12-22 09:21:29'),
(7, 'contact_email', 'rkinfotech.devloper@gmail.com', '2022-12-22 09:21:17', '2022-12-22 09:21:29'),
(8, 'api_key', NULL, '2023-02-25 19:05:43', '2022-12-22 09:21:29'),
(9, 'timezone', 'Asia/Calcutta', '2022-12-22 08:30:24', '2022-12-22 09:21:29'),
(10, 'currency', 'INR', '2023-01-25 05:58:46', '2022-12-22 09:21:29'),
(11, 'google_play', 'false', '2023-02-06 04:37:46', '2022-12-22 09:21:29'),
(12, 'razorpay', 'true', '2023-02-25 08:08:10', '2022-12-22 09:21:29'),
(13, 'razorpay_key', 'rzp_live_G8XcWSNNYtENTp', '2022-12-24 10:09:44', '2022-12-22 09:46:20'),
(14, 'razorpay_secret', '8xahacdNHvIdIgfANw2oeT6z', '2022-12-24 10:09:44', '2022-12-22 09:46:26'),
(15, 'onesignal_app_id', 'c9bd9fe7-7c47-4359-af7a-5825df1b372b', '2023-02-07 03:45:45', '2022-12-22 10:21:01'),
(16, 'onesignal_key', 'MGQ0MDc1NjEtNDNhMC00YTQxLTk4MTAtZWVmYzE2MDczMjg3', '2023-02-07 03:45:45', '2022-12-22 10:21:01'),
(17, 'show_ads', 'true', '2023-02-16 12:30:31', '2022-12-22 10:32:16'),
(18, 'show_admob_banner', 'true', '2022-12-22 10:39:16', '2022-12-22 11:23:03'),
(19, 'admob_banner_id', 'ca-app-pub-9535562418864288/7830411024', '2023-02-19 06:52:18', '2022-12-22 11:23:03'),
(20, 'show_admob_interstital', 'true', '2022-12-22 10:39:16', '2022-12-22 11:23:03'),
(21, 'admob_interstitial_ad', 'ca-app-pub-9535562418864288/2051201238', '2023-02-16 12:30:31', '2022-12-22 11:23:03'),
(22, 'show_admob_rewarded', 'true', '2022-12-22 10:39:16', '2022-12-22 11:23:03'),
(23, 'admob_rewarde_id', 'ca-app-pub-9535562418864288/1752636575', '2023-02-16 13:29:38', '2022-12-22 11:23:03'),
(24, 'show_admob_native', 'true', '2022-12-22 10:39:16', '2022-12-22 11:23:03'),
(25, 'admob_native_id', 'ca-app-pub-9535562418864288/7399166184', '2023-02-16 12:30:31', '2022-12-22 11:23:03'),
(26, 'publisher_id', 'ca-app-pub-9535562418864288~1394787194', '2023-02-19 06:52:18', '2022-12-22 11:31:23'),
(27, 'show_update_dialog', 'false', '2023-02-25 19:15:02', '2022-12-22 11:55:11'),
(28, 'force_update', 'false', '2023-02-25 19:15:02', '2022-12-22 11:55:11'),
(29, 'app_version_code', '17', '2023-02-25 03:17:40', '2022-12-22 11:55:11'),
(30, 'app_link', 'https://play.google.com/store/apps/details?id=com.poster.banao', '2023-02-23 04:10:25', '2022-12-22 11:55:11'),
(31, 'update_information', 'News Update', '2022-12-22 11:02:07', '2022-12-22 11:55:11'),
(32, 'privacypolicy', '<p><span style=\"color: rgb(32, 33, 34); font-family: Poppins; font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\"><span style=\"color: rgb(0, 0, 0); font-family: Poppins;\">privacy policy</span></span><span style=\"color: rgb(32, 33, 34); font-family: Poppins; font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"color: rgb(6, 69, 173); text-decoration: none; background: none rgb(255, 255, 255); font-family: sans-serif; font-weight: 400; letter-spacing: normal; font-size: 14px;\"><span style=\"color: rgb(0, 0, 0); font-family: Poppins;\">privacy law</span></a><span style=\"color: rgb(32, 33, 34); font-family: Poppins; font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"color: rgb(32, 33, 34); font-family: Poppins; font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"color: rgb(6, 69, 173); text-decoration: none; background: none rgb(255, 255, 255); font-family: sans-serif; font-weight: 400; letter-spacing: normal; font-size: 14px;\"><span style=\"color: rgb(0, 0, 0); font-family: Poppins;\">expiry date</span></a><span style=\"color: rgb(32, 33, 34); font-family: Poppins; font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"color: rgb(32, 33, 34); font-family: Poppins; font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"color: rgb(32, 33, 34); font-family: Poppins; font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">A<span style=\"font-weight: bolder; color: rgb(0, 0, 0);\">&nbsp;</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(32, 33, 34); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy policy</span></span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;is a statement or legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">privacy law</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">Personal information can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue, and&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Expiration_date\" title=\"Expiration date\" style=\"font-weight: 400; text-align: var(--bs-body-text-align); font-family: sans-serif; color: rgb(6, 69, 173); text-decoration: none; letter-spacing: normal; background: none rgb(255, 255, 255); font-size: 14px;\"><span style=\"font-family: Poppins; color: rgb(0, 0, 0);\">expiry date</span></a><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; font-size: 11.2px; white-space: nowrap;\">&nbsp;</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">In the case of a business, it is often a statement that declares a party\'s policy on how it collects, stores, and releases personal information it collects. It informs the client what specific information is collected, and whether it is kept confidential, shared with partners, or sold to other firms or enterprises.</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align); font-family: Poppins; color: rgb(32, 33, 34); font-size: 14px;\">&nbsp;Privacy policies typically represent a broader, more generalized treatment, as opposed to data use statements, which tend to be more detailed and specific.</span><br></p>', '2022-12-22 12:14:17', '2022-12-22 12:16:02'),
(33, 'terms_and_condition', '<h6><span style=\"color: rgb(102, 102, 102); font-family: &quot;Clear Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; letter-spacing: normal;\">Lorame 2mg Tablet is a prescription medicine used to treat symptoms of short term anxiety and anxiety disorders. It helps to decrease the abnormal and excessive activity of the nerve cells and </span><span style=\"font-family: &quot;Courier New&quot;;\">﻿</span><span style=\"color: rgb(102, 102, 102); font-family: &quot;Clear Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; letter-spacing: normal;\">calms the brain.</span>Lorame 2mg Tablet is a prescription medicine used to treat symptoms of short term anxiety and anxiety disorders. It helps to decrease the abnormal and excessive activity of the nerve cells and&nbsp;<span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); font-family: &quot;Courier New&quot;;\">﻿</span><span style=\"background-color: var(--bs-card-bg); font-weight: 400; text-align: var(--bs-body-text-align); font-family: &quot;Clear Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(102, 102, 102); font-size: 14px;\">calms the brain.</span>Lorame 2mg Tablet is a prescription medicine used to treat symptoms of short term anxiety and anxiety disorders. It helps to decrease the abnormal and excessive activity of the nerve cells and&nbsp;<span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); font-family: &quot;Courier New&quot;;\">﻿</span><span style=\"background-color: var(--bs-card-bg); font-weight: 400; text-align: var(--bs-body-text-align); font-family: &quot;Clear Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(102, 102, 102); font-size: 14px;\">calms the brain.</span>Lorame 2mg Tablet is a prescription medicine used to treat symptoms of short term anxiety and anxiety disorders. It helps to decrease the abnormal and excessive activity of the nerve cells and&nbsp;<span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); font-family: &quot;Courier New&quot;;\">﻿</span><span style=\"background-color: var(--bs-card-bg); font-weight: 400; text-align: var(--bs-body-text-align); font-family: &quot;Clear Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(102, 102, 102); font-size: 14px;\">calms the brain.</span>Lorame 2mg Tablet is a prescription medicine used to treat symptoms of short term anxiety and anxiety disorders. It helps to decrease the abnormal and excessive activity of the nerve cells and&nbsp;<span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); font-family: &quot;Courier New&quot;;\">﻿</span><span style=\"background-color: var(--bs-card-bg); font-weight: 400; text-align: var(--bs-body-text-align); font-family: &quot;Clear Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(102, 102, 102); font-size: 14px;\">calms the brain.</span>Lorame 2mg Tablet is a prescription medicine used to treat symptoms of short term anxiety and anxiety disorders. It helps to decrease the abnormal and excessive activity of the nerve cells and&nbsp;<span style=\"background-color: var(--bs-card-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); font-family: &quot;Courier New&quot;;\">﻿</span><span style=\"background-color: var(--bs-card-bg); font-weight: 400; text-align: var(--bs-body-text-align); font-family: &quot;Clear Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(102, 102, 102); font-size: 14px;\">calms the brain.</span></h6>', '2022-12-22 12:14:31', '2022-12-22 12:16:02'),
(34, 'show_api_post', 'false', '2022-12-25 08:13:53', '2022-12-25 08:13:53'),
(35, 'single_post_subsciption_amount', '10', '2022-12-26 07:01:10', '2022-12-25 18:05:21'),
(36, 'share_image_url', 'uploads/2ec5af45-a4a6-4c0f-b586-637729c34971.png', '2023-02-26 05:25:29', '2022-12-26 08:46:05'),
(37, 'share_text', 'Poster Banao is #1 Indian Festival Poster Maker App. All Festival, Birthday, Good Morning and many more Post to send wishes and celebrate and make the day more special. download app now below link. download app now below link   \r\n\r\nRefer code - REFER_CODE\r\n\r\nhttps://play.google.com/store/apps/details?id=com.poster.banao', '2023-02-15 07:14:43', '2022-12-26 08:46:05'),
(38, 'refer_earn', 'true', '2023-02-06 05:48:13', '2023-01-21 10:19:04'),
(39, 'refer_bonus', '20', '2023-02-06 04:38:46', '2023-01-21 10:19:04'),
(40, 'refer_subscription_bonus', '10', '2023-01-28 07:04:02', '2023-01-28 07:04:02'),
(41, 'min_withdraw', '25', '2023-02-06 04:38:46', '2023-01-28 07:04:02'),
(42, 'paytm_merchant_key', 'PSJahksICK5B6vcc', '2023-02-25 08:08:10', '2023-02-14 10:57:02'),
(43, 'paytm_merchant_id', 'ydCJof87009802188174', '2023-02-25 08:08:10', '2023-02-14 10:57:02'),
(44, 'paytm', 'true', '2023-02-25 08:08:10', '2023-02-14 15:11:50'),
(45, 'cashfree', 'true', '2023-02-14 15:11:50', '2023-02-14 15:11:50'),
(46, 'cashfree_client_id', '3029768ce26bde777bd8e6db25679203', '2023-02-14 15:12:39', '2023-02-14 15:12:39'),
(47, 'cashfree_client_secret', 'f21030a9126f817f1686884f335148148c224008', '2023-02-14 15:12:39', '2023-02-14 15:12:39'),
(55, 'do_end_point', NULL, '2023-02-22 04:30:17', '2023-02-22 04:30:17'),
(56, 'storage_type', 'local', '2023-02-23 19:32:58', '2023-02-22 04:56:58'),
(57, 'whatsapp_api_key', NULL, '2023-03-12 16:57:17', '2023-03-12 16:57:17'),
(58, 'whatsapp_instance_id', NULL, '2023-03-12 16:57:17', '2023-03-12 16:57:17'),
(59, 'stripe', 'true', '2023-03-24 18:10:19', '2023-03-24 18:10:19'),
(60, 'stripe_public_key', NULL, '2023-03-24 18:10:19', '2023-03-24 18:10:19'),
(61, 'stripe_secret_key', NULL, '2023-03-24 18:10:19', '2023-03-24 18:10:19'),
(62, 'buy_singal_post', 'true', '2023-03-24 18:10:19', '2023-03-24 18:10:19'),
(63, 'watch_and_remove_watermark', 'true', '2023-03-24 18:10:19', '2023-03-24 18:10:19'),
(64, 'whatsapp_otp', 'false', '2023-03-27 20:28:12', '2023-03-27 20:28:12'),
(65, 'auto_festival_notification', NULL, '2023-04-05 18:20:04', '2023-04-05 18:20:04'),
(66, 'posts_limit_status', 'true', '2023-04-07 08:02:47', '2023-04-07 08:02:47'),
(67, 'offline_payment', NULL, '2023-04-07 18:53:07', '2023-04-07 18:53:07'),
(68, 'offline_details', NULL, '2023-04-07 18:53:07', '2023-04-07 18:53:07'),
(69, 'fcm_key', NULL, '2023-06-06 18:54:33', '2023-06-06 18:54:33'),
(70, 'instamojo', 'true', '2023-06-07 13:08:25', '2023-06-07 13:08:25'),
(71, 'client_id', NULL, '2023-06-07 13:08:25', '2023-06-07 13:08:25'),
(72, 'client_secret', NULL, '2023-06-07 13:08:25', '2023-06-07 13:08:25');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `title` varchar(1400) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `action` varchar(1000) DEFAULT NULL,
  `action_item` varchar(1000) DEFAULT NULL,
  `language` varchar(1000) DEFAULT NULL,
  `slider` int(11) DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `title`, `image`, `action`, `action_item`, `language`, `slider`, `status`, `updated_at`, `created_at`) VALUES
(1, 'slider1', 'uploads/thumbnail/1a0eb5a3-3779-4d4c-84b6-19e642619459.png', 'custom', NULL, NULL, 1, 0, '2023-04-29 09:43:24', '2023-04-29 09:43:24'),
(2, 'te', 'uploads/thumbnail/cc821a56-77e9-4257-b1a4-67f83f8cb5f9.png', 'custom', NULL, NULL, 2, 0, '2023-05-01 08:59:38', '2023-05-01 08:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `stickers`
--

CREATE TABLE `stickers` (
  `id` int(11) NOT NULL,
  `category_id` int(100) NOT NULL DEFAULT '0',
  `name` varchar(1400) NOT NULL,
  `item_url` text,
  `premium` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stickers_category`
--

CREATE TABLE `stickers_category` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `name` varchar(1400) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '1',
  `price` int(11) NOT NULL,
  `discount_price` int(11) DEFAULT '0',
  `image` varchar(1000) DEFAULT NULL,
  `details` text,
  `posts_limit` int(11) DEFAULT '10',
  `business_limit` int(11) DEFAULT '5',
  `political_limit` int(11) NOT NULL DEFAULT '0',
  `purchase` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `name`, `type`, `value`, `price`, `discount_price`, `image`, `details`, `posts_limit`, `business_limit`, `political_limit`, `purchase`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Business', 'YEAR', 1, 999, 899, 'uploads/posts/e619170b-70e7-408d-b22e-5cda3a620159.jfif', '[\"Make +1000 Premium Posts \\ud83d\\udc8e\",\"Remove Watermark \\ud83d\\udca6\",\"Add Up to 50 Business \\ud83c\\udfe2\",\"No Ads \\ud83d\\udc1b\",\"High Quality Posts \\ud83c\\udf80\",\"Unlimited Stickers \\ud83c\\udf83\"]', 1000, 50, 10, NULL, 0, '2023-02-25 13:59:00', '2022-11-23 20:10:13'),
(2, 'Silver', 'MONTH', 1, 365, 300, 'uploads/thumbnail/ecbe6c1d-d155-44e8-ae1a-b0479eb9f734.png', '[\"Make +300 Premium Posts \\ud83d\\udc8e\",\"Remove Watermark \\ud83d\\udca6\",\"Add Up to 10 Business \\ud83c\\udfe2\",\"No Ads \\ud83d\\udc1b\",\"High Quality Posts \\ud83c\\udf80\",\"Unlimited Stickers \\ud83c\\udf83\"]', 300, 10, 2, NULL, 0, '2023-02-26 05:06:13', '2022-11-23 20:10:47'),
(4, 'Starter', 'WEEK', 3, 15, 5, 'uploads/posts/9d631917-ae85-48f1-99ad-d74b0346239b.png', '[\"Make 10 Premium Posts \\ud83d\\udc8e\",\"Remove Watermark \\ud83d\\udca6\",\"Add Up to 5 Business \\ud83c\\udfe2\",\"+10 Premium Posts Save \\ud83d\\udcc1\",\"High Quality Posts \\ud83c\\udf80\",\"Unlimited Stickers \\ud83c\\udf83\",\"No Ads \\ud83d\\udc1b\"]', 10, 5, 2, 'test', 0, '2023-02-26 05:05:57', '2022-12-21 06:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT '0',
  `name` varchar(140) DEFAULT NULL,
  `about` text,
  `image` varchar(1000) DEFAULT NULL,
  `language` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan` varchar(1000) NOT NULL,
  `amount` int(11) NOT NULL,
  `promocode` varchar(1000) DEFAULT NULL,
  `payment_type` varchar(1000) NOT NULL,
  `transaction_id` varchar(1000) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `profile_pic` varchar(1000) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `number` varchar(1000) DEFAULT NULL,
  `balance` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `state` varchar(1000) DEFAULT NULL,
  `district` varchar(1000) DEFAULT NULL,
  `refer_id` varchar(1000) DEFAULT NULL,
  `refered` varchar(1000) DEFAULT NULL,
  `designation` text,
  `subscription_name` varchar(1000) DEFAULT NULL,
  `subscription_price` varchar(1000) DEFAULT NULL,
  `subscription_date` varchar(1000) DEFAULT NULL,
  `subscription_end_date` varchar(1000) DEFAULT NULL,
  `posts_limit` int(11) NOT NULL DEFAULT '5',
  `business_limit` int(11) NOT NULL DEFAULT '1',
  `political_limit` int(11) NOT NULL DEFAULT '1',
  `login` varchar(100) DEFAULT NULL,
  `social` varchar(100) DEFAULT NULL,
  `social_id` varchar(100) DEFAULT NULL,
  `auth_token` varchar(5000) DEFAULT NULL,
  `device_token` varchar(5000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1 = Blocked',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `profile_pic`, `email`, `number`, `balance`, `category_id`, `state`, `district`, `refer_id`, `refered`, `designation`, `subscription_name`, `subscription_price`, `subscription_date`, `subscription_end_date`, `posts_limit`, `business_limit`, `political_limit`, `login`, `social`, `social_id`, `auth_token`, `device_token`, `status`, `updated_at`, `created_at`) VALUES
(2, 'Altaf mansuri', 'null', 'altafmansuridevloper31@gmail.com', '333456677888', 0, 0, 'Chhattisgarh', 'Dantewada', '7XE52LYV', NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, 1, NULL, 'google', '114411375286320118620', 'null', 'android', 0, '2023-04-28 22:12:32', '2023-04-28 22:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_bussiness`
--

CREATE TABLE `user_bussiness` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company` varchar(1000) DEFAULT NULL,
  `name` varchar(1000) NOT NULL,
  `about` varchar(1000) DEFAULT NULL,
  `number` varchar(1000) DEFAULT NULL,
  `designation` varchar(1000) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(1000) NOT NULL DEFAULT 'business',
  `website` varchar(1000) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `whatsapp` varchar(1000) DEFAULT NULL,
  `facebook` varchar(1000) DEFAULT NULL,
  `youtube` varchar(1000) DEFAULT NULL,
  `twitter` varchar(1000) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_frame`
--

CREATE TABLE `user_frame` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `item_url` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_post`
--

CREATE TABLE `user_post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_url` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_transaction`
--

CREATE TABLE `user_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `other_user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(1000) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `type` varchar(1000) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_transaction`
--

INSERT INTO `user_transaction` (`id`, `user_id`, `other_user_id`, `title`, `amount`, `type`, `updated_at`, `created_at`) VALUES
(1, 36, 2, 'Vickey raj Join by your refer code ', 20, 'credit', '2023-02-24 05:22:14', '2023-02-24 05:22:14'),
(2, 36, 2, 'Subscription Bonus By Vickey raj', 5, 'credit', '2023-02-24 05:25:02', '2023-02-24 05:25:02'),
(3, 2, 36, 'Subscription Bonus By Altaf mansuri', 37, 'credit', '2023-02-25 09:54:40', '2023-02-25 09:54:40'),
(4, 2, 36, 'Subscription Bonus By Altaf mansuri', 100, 'credit', '2023-02-26 04:11:56', '2023-02-26 04:11:56'),
(5, 2, 36, 'Subscription Bonus By Altaf mansuri', 100, 'credit', '2023-02-26 04:13:54', '2023-02-26 04:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `title` varchar(1400) DEFAULT NULL,
  `thumb_url` varchar(10000) DEFAULT NULL,
  `item_url` varchar(1000) DEFAULT NULL,
  `slug` varchar(15) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL COMMENT 'festival,bussiness',
  `language` varchar(1000) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `section_id` int(11) NOT NULL DEFAULT '0',
  `sub_category_id` int(11) DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `premium` int(11) NOT NULL DEFAULT '0' COMMENT '1=premium',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `video_tamplate`
--

CREATE TABLE `video_tamplate` (
  `id` int(11) NOT NULL,
  `title` varchar(1400) NOT NULL,
  `thumb_url` varchar(10000) NOT NULL,
  `video_url` varchar(1000) NOT NULL,
  `zip_url` text,
  `type` varchar(100) NOT NULL COMMENT 'festival,bussiness',
  `language` varchar(1000) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `premium` int(11) NOT NULL DEFAULT '0' COMMENT '1=premium',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `video_tamplate_category`
--

CREATE TABLE `video_tamplate_category` (
  `id` int(11) NOT NULL,
  `name` varchar(140) DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_message`
--

CREATE TABLE `whatsapp_message` (
  `id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `btn1` varchar(100) DEFAULT NULL,
  `btn1value` varchar(100) DEFAULT NULL,
  `btn1type` varchar(100) DEFAULT NULL,
  `btn2` varchar(100) DEFAULT NULL,
  `btn2value` varchar(100) DEFAULT NULL,
  `btn2type` varchar(100) DEFAULT NULL,
  `footer` varchar(1000) DEFAULT NULL,
  `media` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) NOT NULL DEFAULT 'text',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `upi_id` varchar(1000) DEFAULT NULL,
  `status` varchar(1100) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `background`
--
ALTER TABLE `background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_card_digital`
--
ALTER TABLE `business_card_digital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_card_tamplate`
--
ALTER TABLE `business_card_tamplate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frames`
--
ALTER TABLE `frames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frame_category`
--
ALTER TABLE `frame_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `greeting_posts`
--
ALTER TABLE `greeting_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `greeting_section`
--
ALTER TABLE `greeting_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invitation_card`
--
ALTER TABLE `invitation_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invitation_category`
--
ALTER TABLE `invitation_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo_category`
--
ALTER TABLE `logo_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music_category`
--
ALTER TABLE `music_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_dialog`
--
ALTER TABLE `offer_dialog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocode`
--
ALTER TABLE `promocode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_inquiries`
--
ALTER TABLE `service_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stickers`
--
ALTER TABLE `stickers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stickers_category`
--
ALTER TABLE `stickers_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_bussiness`
--
ALTER TABLE `user_bussiness`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_frame`
--
ALTER TABLE `user_frame`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_post`
--
ALTER TABLE `user_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_transaction`
--
ALTER TABLE `user_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_tamplate`
--
ALTER TABLE `video_tamplate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_tamplate_category`
--
ALTER TABLE `video_tamplate_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whatsapp_message`
--
ALTER TABLE `whatsapp_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `background`
--
ALTER TABLE `background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `business_card_digital`
--
ALTER TABLE `business_card_digital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `business_card_tamplate`
--
ALTER TABLE `business_card_tamplate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frames`
--
ALTER TABLE `frames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `frame_category`
--
ALTER TABLE `frame_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `greeting_posts`
--
ALTER TABLE `greeting_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `greeting_section`
--
ALTER TABLE `greeting_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invitation_card`
--
ALTER TABLE `invitation_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invitation_category`
--
ALTER TABLE `invitation_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logos`
--
ALTER TABLE `logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logo_category`
--
ALTER TABLE `logo_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `music`
--
ALTER TABLE `music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `music_category`
--
ALTER TABLE `music_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_dialog`
--
ALTER TABLE `offer_dialog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promocode`
--
ALTER TABLE `promocode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_inquiries`
--
ALTER TABLE `service_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stickers`
--
ALTER TABLE `stickers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stickers_category`
--
ALTER TABLE `stickers_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_bussiness`
--
ALTER TABLE `user_bussiness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_frame`
--
ALTER TABLE `user_frame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post`
--
ALTER TABLE `user_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_transaction`
--
ALTER TABLE `user_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_tamplate`
--
ALTER TABLE `video_tamplate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_tamplate_category`
--
ALTER TABLE `video_tamplate_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whatsapp_message`
--
ALTER TABLE `whatsapp_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
