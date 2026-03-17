-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 17, 2026 at 09:27 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bhaiya-housing`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '+880',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interested_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `body_2` longtext COLLATE utf8mb4_unicode_ci,
  `body_3` longtext COLLATE utf8mb4_unicode_ci,
  `body_4` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` longtext COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_path` text COLLATE utf8mb4_unicode_ci,
  `img_paths` json DEFAULT NULL,
  `video_path` text COLLATE utf8mb4_unicode_ci,
  `video_paths` json DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `short` text COLLATE utf8mb4_unicode_ci,
  `location` text COLLATE utf8mb4_unicode_ci,
  `extra` json DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `type`, `parent_id`, `name`, `title`, `body`, `body_2`, `body_3`, `body_4`, `meta_title`, `meta_description`, `meta_keywords`, `img_path`, `img_paths`, `video_path`, `video_paths`, `url`, `start_date`, `end_date`, `short`, `location`, `extra`, `status`, `created_at`, `updated_at`) VALUES
(1, 'settings', NULL, 'Bhaiya Housing is dedicated to building high-quality homes and commercial spaces with trust and excellence. Since 2011, we have been transforming urban living with innovative designs and superior construction.', 'Bhaiya Housing', '<a href=\"https://maps.app.goo.gl/r4vnHY2MjvyDgg316\" target=\"_blank\" style=\"color: rgb(250, 252, 255); text-decoration-line: none; background-color: rgb(21, 32, 24); transition: color 0.3s; margin: 0px; font-family: \"Hanken Grotesk\", Migra, Arial, Helvetica, freesans, sans-serif; font-size: 1vw; line-height: 23.04px; letter-spacing: -1px; outline: none; box-shadow: none;\">Sandwip Baban, 28/A-3 (Level-6th), Toyenbee Circular Road, Motijheel C/A, Dhaka-1000.</a>', '<a href=\"https://maps.app.goo.gl/Ar3HrBerjy7HCdqu9\" target=\"_blank\" style=\"color: rgb(250, 252, 255); text-decoration-line: none; background-color: rgb(21, 32, 24); transition: color 0.3s; margin: 0px; font-family: \"Hanken Grotesk\", Migra, Arial, Helvetica, freesans, sans-serif; font-size: 1vw; line-height: 23.04px; letter-spacing: -1px; outline: none; box-shadow: none;\">Century Trade Center, House # 23 (Level-5th to 8th), Road # 17, Banani C/A, Dhaka-1213</a>', NULL, NULL, NULL, NULL, NULL, 'images/177355166817371.svg', 'null', NULL, NULL, NULL, NULL, NULL, 'info@bhaiyahousing.com', NULL, '\"+880 1922 030 303\"', 1, '2026-03-14 23:14:28', '2026-03-15 01:20:41'),
(2, 'social', NULL, 'fab fa-facebook-f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'fab fa-facebook-f', NULL, NULL, NULL, NULL, NULL, 1, '2026-03-14 23:21:19', '2026-03-14 23:21:19'),
(3, 'social', NULL, 'Twitter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'fab fa-twitter', NULL, NULL, NULL, NULL, NULL, 1, '2026-03-14 23:24:24', '2026-03-14 23:24:24'),
(4, 'social', NULL, 'Youtube', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'fab fa-youtube', NULL, NULL, NULL, NULL, NULL, 1, '2026-03-14 23:24:36', '2026-03-14 23:24:36'),
(5, 'social', NULL, 'Linkdin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'fab fa-linkedin-in', NULL, NULL, NULL, NULL, NULL, 1, '2026-03-14 23:24:51', '2026-03-14 23:24:51'),
(6, 'hero', NULL, 'home-hero', 'We transform your<br> dreams into addresses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356290893771.avif', 'null', NULL, NULL, NULL, NULL, NULL, 'Immerse yourself in the artistry of exceptional spaces with Bhaiya Housing, where each project is a harmonious blend of prestige, elegance, and refined sophistication. Beyond constructing buildings, we meticulously create residential and commercial environments to reflect your aspirations.', NULL, NULL, 1, '2026-03-15 02:21:48', '2026-03-15 02:21:48'),
(7, 'hero', NULL, 'about-hero', 'Building                 <span class=\"italic font-light\">quality</span>                 spaces with                 <span class=\"italic font-light\">excellence & dedication</span>', '<p><span style=\"font-family: \"Hanken Grotesk\"; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(255, 255, 0);\"><font color=\"#000000\" style=\"\">Bhaiya Housing brings over 12 years of expertise in creating premium residential and commercial properties. We deliver spaces that blend innovation, security, and style, tailored to fulfill diverse needs and aspirations.</font></span></p>', '<p><span style=\"font-family: \"Hanken Grotesk\"; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(255, 255, 0);\"><font color=\"#000000\" style=\"\">Our focus on transparent practices, timely delivery, and customer satisfaction shapes our trusted reputation. Through reliable service and fair pricing, we strive to transform your vision into functional and stunning realities.</font></span></p>', NULL, NULL, NULL, NULL, NULL, 'images/177356323078229.png', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 02:27:10', '2026-03-16 22:45:40'),
(8, 'hero', NULL, 'project-herp', 'Where innovation meets quality & trust', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356335394932.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 02:29:13', '2026-03-15 02:29:13'),
(9, 'hero', NULL, 'event-hero', 'Stay informed with Bhaiya Housing Ltd.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356346698883.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 02:31:06', '2026-03-15 02:31:06'),
(10, 'hero', NULL, 'contact-hero', 'We\'re here to assist you with any inquiries', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356353273651.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 02:32:12', '2026-03-15 02:32:12'),
(11, 'building-dreams-for-decades', NULL, NULL, 'Building dreams for decades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356378438462.avif', '[\"images/177356378497067.jpg\", \"images/177356378467559.jpg\"]', NULL, NULL, NULL, NULL, NULL, 'Since 2012, Bhaiya Housing, a distinguished part of Bhaiya Group, has redefined modern infrastructure. Merging architectural brilliance with purposeful design, we craft exquisite homes and commercial spaces that embody aspirations, inspire ambition, and effortlessly adapt to the evolving rhythms of modern life.', NULL, NULL, 1, '2026-03-15 02:36:24', '2026-03-15 02:36:24'),
(12, 'project', NULL, NULL, 'Southern Centre', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356466086747.jpg', 'null', NULL, NULL, NULL, NULL, NULL, 'Residential', 'Plot-17,19 Outer Circular Road, Rajarbagh, Dhaka', NULL, 1, '2026-03-15 02:51:00', '2026-03-15 02:51:00'),
(13, 'project', NULL, NULL, 'Kazi Kuthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356470995890.jpg', 'null', NULL, NULL, NULL, NULL, NULL, 'Residential', '296, Sadhinota Soroni, North Badda, Dhaka-1212', NULL, 1, '2026-03-15 02:51:49', '2026-03-15 02:51:49'),
(14, 'project', NULL, NULL, 'Bhaiya Evening Lights', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356473790147.jpg', 'null', NULL, NULL, NULL, NULL, NULL, 'Commercial', '212, Middle Basabo, Sabujbagh, Dhaka', NULL, 1, '2026-03-15 02:52:17', '2026-03-15 02:52:17'),
(15, 'project', NULL, NULL, 'Momin\'s Magnolia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356479439970.jpg', 'null', NULL, NULL, NULL, NULL, NULL, 'Residential', 'Plot-41, Road-01, Sector-05, Uttara, Dhaka', NULL, 1, '2026-03-15 02:53:14', '2026-03-15 02:53:14'),
(16, 'project', NULL, NULL, 'Rich Ville', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356483518208.jpg', 'null', NULL, NULL, NULL, NULL, NULL, 'Residential', '43/A, Road-4, Block-D, Bashundhara R/A, Dhaka', NULL, 1, '2026-03-15 02:53:55', '2026-03-15 02:53:55'),
(17, 'stories-of-satisfaction', NULL, NULL, 'The stories of satisfaction', '<p><span style=\"color: rgb(36, 24, 67); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(246, 246, 246);\">Bhaiya Housing is devoted to designing inspiring residential and commercial spaces that transcend expectations. With a focus on modern aesthetics, impeccable craftsmanship, and an unwavering commitment to integrity, we create environments that harmoniously balance sophistication and purpose, delivering timeless value.</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356662970908.avif', '[\"images/177356662918764.avif\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 03:23:49', '2026-03-15 03:23:49'),
(18, 'stories-item', NULL, 'Engineer', 'Md. Abul Kalam', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">As an engineer, I pay close attention to construction quality, and this project exceeded my expectations. The materials used are top-notch, and the design is well thought out. I’m particularly pleased with the spacious layouts and modern features.</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356669950893.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 03:24:59', '2026-03-15 03:24:59'),
(19, 'stories-item', NULL, 'Business Man', 'Md. Enamul Haque', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">I invested in a commercial property from this development, and it has proven to be a wise decision. The location is prime, and the development is very professional. My business is already benefiting from the visibility and accessibility of the space.</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356675163367.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 03:25:51', '2026-03-15 03:25:51'),
(20, 'stories-item', NULL, 'Professor', 'Md. Khasro Miah', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">I bought an apartment here because I was looking for a peaceful, secure place for my family. The environment is calm, the quality of the construction is solid, and the neighborhood is great. We’ve settled in comfortably, and it feels like home already.</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356706985548.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 03:31:09', '2026-03-15 03:31:09'),
(21, 'stories-item', NULL, 'Professor', 'Md. Mamun Molla', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">I’ve always wanted a quiet and safe place, and this project gave me just that. The construction is excellent, and the attention to detail shows. I also love the amenities available, and the community here is welcoming. It’s been a really good investment.</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356719911261.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 03:32:57', '2026-03-15 03:33:19'),
(22, 'stories-item', NULL, 'Business Man', 'Md. Mazharul Islam', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">I’m very happy with the commercial space I purchased from this project. The development is well-planned, and the location is perfect for business. The property has attracted good tenants.</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356733524468.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-15 03:35:35', '2026-03-15 03:35:35'),
(23, 'news', NULL, NULL, 'news', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">Bhaiya Housing\'s Latest Project Completion: A New Era of Living</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, NULL, '2026-03-15 15:37:00', NULL, NULL, NULL, NULL, 1, '2026-03-15 03:37:40', '2026-03-15 03:37:40'),
(24, 'news', NULL, NULL, 'news', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">Bhaiya Housing\'s Latest Project Completion: A New Era of Living</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, NULL, '2026-03-15 15:38:00', NULL, NULL, NULL, NULL, 1, '2026-03-15 03:38:11', '2026-03-15 03:38:11'),
(25, 'events', NULL, 'event1', 'events', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">Upcoming Property Showcase: Discover Your Dream Home</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356782251691.jpg', 'null', NULL, NULL, NULL, '2026-03-14 15:39:00', '2026-03-15 15:39:00', NULL, NULL, NULL, 1, '2026-03-15 03:43:42', '2026-03-15 03:43:42'),
(26, 'events', NULL, 'events', 'events', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177356795857457.avif', 'null', NULL, NULL, NULL, '2026-03-15 09:51:00', '2026-03-15 15:45:00', NULL, NULL, NULL, 1, '2026-03-15 03:45:58', '2026-03-15 03:45:58'),
(27, 'partners', NULL, NULL, 'Be a partner, be a patron', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">Partner with us to transform your property into a landmark development.</span></p>', '<p><span style=\"color: rgb(25, 29, 23); font-family: monospace; font-size: 12px; white-space-collapse: preserve; background-color: rgb(250, 253, 244);\">Get in touch to find your dream home with Bhaiya Housing.</span></p>', NULL, NULL, NULL, NULL, NULL, 'images/177356858094926.png', 'null', NULL, NULL, '.', NULL, NULL, 'Contact as Landowner', 'Contact as Customer', '\".\"', 1, '2026-03-15 03:56:20', '2026-03-15 03:56:20'),
(28, 'mission_vision', NULL, 'Mission', 'Building dreams,<br> creating spaces.', '<span style=\"color: rgb(59, 59, 59); font-family: \"Hanken Grotesk\", Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(246, 246, 246);\">Our Mission is to provide our clients with a complete range of real estate services delivered by the very best talents in the real estate sector while maintaining a culture of collegiality in which we help each other to best serve our investors, professionals and our communities.</span>', '<span style=\"color: rgb(59, 59, 59);\">Our Vision is to be the local real estate firm of choice for developers and investors by delivering the ultimate client experience through our expert’s reliability, pursuit of excellence and comprehensive expertise.</span>', NULL, NULL, NULL, NULL, NULL, 'images/177372454743435.png', '[\"images/177372454729969.png\", \"images/177372454783467.png\", \"images/177372454737898.png\", \"images/177372475949043.png\", \"images/177372475955612.png\"]', NULL, NULL, NULL, NULL, NULL, 'Vision', NULL, NULL, 1, '2026-03-16 23:15:47', '2026-03-16 23:31:03'),
(29, 'history-timeline', NULL, NULL, 'History Timeline', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-16 23:47:14', '2026-03-17 00:00:25'),
(30, 'timeline-item', NULL, 'Bhaiya Group', '1972', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372658872080.png', 'null', NULL, NULL, NULL, NULL, NULL, 'Bhaiya Group of Industries is one of Bangladesh’s most prominent and diversified conglomerates, with a legacy spanning over 50 years. Founded by Alhaj Moksud Ali, the group has grown into a multifaceted organization with interests in food manufacturing, real estate, insurance, hospitality, and more.', NULL, NULL, 1, '2026-03-16 23:49:48', '2026-03-17 00:11:36'),
(31, 'timeline-item', NULL, 'Nabisco Biscuit & Bread Factory Ltd', '1983', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372749427272.png', 'null', NULL, NULL, NULL, NULL, NULL, 'Nabisco Biscuit & Bread Factory Ltd. is one of Bangladesh’s oldest and most recognized food manufacturing companies, renowned for its wide range of biscuits, breads, cakes, and confectionery products. Established in the 1950s, the company became a private limited entity in 1983 and operates independently under its own brand name, with no affiliations to international companies.', NULL, NULL, 1, '2026-03-17 00:04:54', '2026-03-17 00:11:50'),
(32, 'timeline-item', NULL, 'Provati Insurance Company Ltd', '1996', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372759541141.jpeg', 'null', NULL, NULL, NULL, NULL, NULL, 'Provati Insurance Company Ltd. is a prominent non-life insurance provider in Bangladesh, established on January 31, 1996, by Alhaj Moksud Ali, who also chaired the Bhaiya Group of Industries. The company commenced operations on April 2, 1996, and is headquartered at Khan Mansion, 11th Floor, 107 Motijheel Commercial Area, Dhaka.', NULL, NULL, 1, '2026-03-17 00:06:35', '2026-03-17 00:12:20'),
(33, 'timeline-item', NULL, 'Pacific Consumer Goods Ltd', '2004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372799963285.png', 'null', NULL, NULL, NULL, NULL, NULL, 'Pacific Consumer Goods Ltd. (PCGL) is a leading Bangladeshi manufacturer and distributor of food and spice products. Founded in 2004 as a sister concern of Bhaiya Group of Industries, the company operates under the flagship brand Desh, with the motto “The Taste of Bangladesh.” PCGL\'s manufacturing facility is located in Laksam, Comilla, and its head office is situated at Khan Mansion (3rd Floor), 107 Motijheel Commercial Area, Dhaka-1000, Bangladesh.', NULL, NULL, 1, '2026-03-17 00:13:19', '2026-03-17 00:13:19'),
(34, 'leaders-message', NULL, NULL, 'Message from leaders', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372852313181.svg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:14:40', '2026-03-17 00:22:03'),
(35, 'leaders-message-item', NULL, 'Chairman', 'Maroof Sattar Ali', '<p><span style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\">At Bhaiya Housing Ltd., we believe that a home is more than just a structure it is where dreams are nurtured and futures are built. Since our founding, our mission has been to create modern, secure, and elegant living spaces that reflect the changing lifestyles of our people.</span><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><span style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\">Our projects, such as Southern Centre in Rajarbagh and Rich Ville in Bashundhara, exemplify our commitment to quality and innovation. We believe that a residence is more than just a structure; it\'s a reflection of one\'s lifestyle and status.</span><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><span style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\">As we continue to grow, our commitment remains strong; to offer excellence in design, quality in construction, and trust in service, our focus remains on delivering exceptional real estate solutions that turn dreams into reality.</span><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><span style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\">We are not just building homes, we are building the future.</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372871920201.avif', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:25:19', '2026-03-17 00:25:19'),
(36, 'leaders-message-item', NULL, 'Managing Director', 'Rashedul Islam Rashed', '<p><span style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\">Bhaiya Housing Ltd. is committed to redefining the real estate landscape in Bangladesh We have listened closely to our customers and responded with thoughtful, well-planned developments that emphasize safety, comfort, and community.</span><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><span style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\">Our projects showcase our dedication to providing comfortable and sophisticated living spaces. Every development reflects our values of innovation, transparency, and care. We focus not only on quality construction but also on the quality of life our residents will experience.</span><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><br style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\"><span style=\"color: rgb(255, 255, 255); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(21, 32, 24);\">We are grateful to our clients, partners, and team members who have placed their trust in us. Together, we will continue to shape a brighter, better future, one home at a time</span></p>', NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372878747304.avif', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:26:27', '2026-03-17 00:26:27'),
(37, 'visionaries', NULL, NULL, 'Meet the Visionaries', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:32:01', '2026-03-17 00:32:01'),
(38, 'visionaries-item', NULL, 'Director', 'Md Mizanur Rahman Ripon', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372930556533.avif', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:35:05', '2026-03-17 00:35:05'),
(39, 'visionaries-item', NULL, 'Director', 'M. O. Quashem Rajib', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372932963402.avif', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:35:29', '2026-03-17 00:35:29'),
(40, 'visionaries-item', NULL, 'Director', 'Md. Suzaul Hasan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372936263195.avif', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:36:02', '2026-03-17 00:36:02'),
(41, 'visionaries-item', NULL, 'Director', 'Dewan Habibul Hasan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372937817898.avif', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:36:18', '2026-03-17 00:36:18'),
(42, 'visionaries-item', NULL, 'Director', 'Md. Zamal Mahmood Siddiq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372939279559.avif', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:36:32', '2026-03-17 00:36:32'),
(43, 'about-bhaiya', NULL, NULL, '<span class=\"font-semibold\">About</span>                    <span class=\" italic block md:inline\">Bhaiya</span>                   <span class=\" italic block\">Housing</span>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177372953179053.avif', '[\"images/177372953163257.avif\"]', NULL, NULL, NULL, NULL, NULL, 'In an overcrowded real estate market, Bhaiya Housing emerged to meet the evolving needs of today’s home and office seekers. As Dhaka expands, many struggle to find safe, secure, and modern living spaces. Bhaiya Housing recognizes this challenge and is committed to providing quality accommodation that meets the demands of a growing city.', NULL, '\"Understanding the shift in real estate trends, Bhaiya Housing delivers more than just buildings—it creates spaces that reflect dreams, aspirations, and modern lifestyles. From homes to offices and commercial spaces, every project is designed with sophistication, functionality, and prestige in mind. Welcome to Bhaiya Housing—where your dreams take shape.\"', 1, '2026-03-17 00:38:51', '2026-03-17 00:41:54'),
(44, 'about-bhaiya-group', NULL, NULL, '<span class=\"font-semibold\">About</span>                    <span class=\"italic\">Bhaiya</span><br>                   <span class=\"italic\">Housing</span>                   <span class=\"font-semibold ml-2\">Group</span>', '<p><span style=\"color: rgb(36, 24, 67); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(246, 246, 246);\">With over 50 years of history, Bhaiya Group of Industries has played a vital role in Bangladesh’s economic growth, witnessing both its challenges and triumphs. As the nation evolved, so did the company, expanding into multiple industries with a strong, strategic presence.</span></p>', '<p><span style=\"color: rgb(36, 24, 67); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(246, 246, 246);\">Driven by visionary leadership, Bhaiya Group focuses on long-term value creation by identifying opportunities and turning them into successful enterprises. Committed to excellence, the Group continues to lead industries with innovation, expertise, and a dedication to core values.</span></p>', NULL, NULL, NULL, NULL, NULL, 'images/177372985253806.avif', '[\"images/177372985230223.jpg\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:44:12', '2026-03-17 00:44:12'),
(45, 'hero', NULL, 'career-hero', 'Join our team – build<br> your future with us', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/177373109069247.jpg', 'null', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-17 00:59:35', '2026-03-17 01:08:02'),
(46, 'career-overview', NULL, NULL, 'test', '<p><span style=\"color: rgb(36, 24, 67); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(246, 246, 246);\">We offer a collaborative work environment where creativity and innovation thrive. With a strong focus on employee development, we provide opportunities for continuous learning and career advancement. Whether you\'re in construction, design, or sales, Bhaiya Housing offers diverse career paths to suit your aspirations.</span></p>', '<p><span style=\"color: rgb(36, 24, 67); font-family: &quot;Hanken Grotesk&quot;, Migra, Arial, Helvetica, freesans, sans-serif; font-size: 19.2px; letter-spacing: -1px; background-color: rgb(246, 246, 246);\">Working at Bhaiya Housing means being part of a trusted brand known for quality and integrity. We value each team member\'s contributions and believe in creating an inclusive, supportive culture. Join us today and make a lasting impact on the future of real estate in Bangladesh.</span></p>', NULL, NULL, NULL, NULL, NULL, 'images/177373209627701.avif', '[\"images/177373209636466.avif\"]', NULL, NULL, NULL, NULL, NULL, 'At Bhaiya Housing, we believe in nurturing talent and providing a platform for growth. Our team is driven by a shared vision of delivering excellence in real estate, and we’re always on the lookout for passionate professionals to join us in shaping the future of urban living.', NULL, NULL, 1, '2026-03-17 01:21:36', '2026-03-17 01:21:36'),
(47, 'job-position', NULL, 'sales-executive', 'Sales Executive', '<div style=\"margin-bottom: 60px; color: rgb(36, 24, 67); font-family: \" hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\"><h3 style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; font-size: 20px; color: rgb(24, 29, 36);\">Job Summary</h3><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-family: \" hanken=\"\" grotesk\",=\"\" migra,=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" line-height:=\"\" 24px;=\"\" letter-spacing:=\"\" -0.38px;=\"\" color:=\"\" rgb(10,=\"\" 14,=\"\" 18);\"=\"\">The Project Manager will oversee and manage the planning, execution, and completion of real estate development projects. The role requires effective leadership, coordination with cross-functional teams, and ensuring timely delivery within budget and quality standards.</p></div><div style=\"margin-bottom: 60px; color: rgb(36, 24, 67); font-family: \" hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\"><h3 style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; font-size: 20px; color: rgb(24, 29, 36);\">Key Responsibilities</h3><ul><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Plan and manage project timelines, scope, and budgets</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Collaborate with architects, engineers, and contractors</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Monitor project progress and resolve issues</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Report to senior management on project status</li></ul><div hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\" style=\"margin-bottom: 60px;\"><h3 style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; color: rgb(24, 29, 36); font-size: 20px;\">Qualifications</h3><ul><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Bachelor’s degree in Business, or related field</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">2+ years of project management experience</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Strong leadership and communication skills</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Proficiency in project management software</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">PMP certification preferred</li></ul></div><div hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\" style=\"margin-bottom: 60px;\"><h3 style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; color: rgb(24, 29, 36); font-size: 20px;\">Work Conditions & Benefits</h3><ul><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Competitive salary with performance bonuses</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Health insurance and wellness benefits</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Opportunities for career development and training</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Collaborative and inclusive work environment</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Flexible working conditions and paid time off</li></ul></div></div>', 'Full Time', '<p>2+ years</p>', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, NULL, NULL, NULL, 'We are looking for a dynamic and result-driven Sales Executive to join our team. The ideal candidate will have strong communication skills and a passion for real estate, driving sales through client engagement and market expertise.', 'Dhaka, Bangladesh', '\"Management\"', 1, '2026-03-17 01:44:49', '2026-03-17 02:29:02'),
(48, 'job-position', NULL, 'site-engineer', 'Site Engineer', '<div style=\"margin-bottom: 60px; color: rgb(36, 24, 67); font-family: \" hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\"><h3 style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; font-size: 20px; color: rgb(24, 29, 36);\">Job Summary</h3><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-family: \" hanken=\"\" grotesk\",=\"\" migra,=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" line-height:=\"\" 24px;=\"\" letter-spacing:=\"\" -0.38px;=\"\" color:=\"\" rgb(10,=\"\" 14,=\"\" 18);\"=\"\">The Project Manager will oversee and manage the planning, execution, and completion of real estate development projects. The role requires effective leadership, coordination with cross-functional teams, and ensuring timely delivery within budget and quality standards.</p></div><div style=\"margin-bottom: 60px; color: rgb(36, 24, 67); font-family: \" hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\"><h3 style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; font-size: 20px; color: rgb(24, 29, 36);\">Key Responsibilities</h3><ul><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Plan and manage project timelines, scope, and budgets</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Collaborate with architects, engineers, and contractors</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Monitor project progress and resolve issues</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Report to senior management on project status</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\"><div hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\" style=\"letter-spacing: normal; margin-bottom: 60px; color: rgb(36, 24, 67);\"></div></li></ul><p style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\"></p><div hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\" style=\"letter-spacing: normal; margin-bottom: 60px; color: rgb(36, 24, 67);\"><ul></ul></div><p></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; color: rgb(24, 29, 36); font-size: 20px;\">Qualifications</p><ul><li style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; color: rgb(24, 29, 36); font-size: 20px;\"><span style=\"color: rgb(10, 14, 18); letter-spacing: -0.38px; font-size: 16px; font-weight: 400;\">&nbsp; &nbsp;Bachelor’s degree in Business, or related field</span></li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\"><span style=\"letter-spacing: -0.38px;\">2+ years of project management experience</span></li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Strong leadership and communication skills</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Proficiency in project management software</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">PMP certification preferred</li></ul><p style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\"></p><div hanken=\"\" grotesk\",=\"\" migra,=\"\" \"albert=\"\" sans\",=\"\" arial,=\"\" helvetica,=\"\" freesans,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(246,=\"\" 246,=\"\" 246);\"=\"\" style=\"letter-spacing: normal; margin-bottom: 60px; color: rgb(36, 24, 67);\"><ul></ul></div><p></p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-weight: 700; line-height: 22px; color: rgb(24, 29, 36); font-size: 20px;\">Work Conditions &amp; Benefits</p><ul><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Competitive salary with performance bonuses</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Health insurance and wellness benefits</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Opportunities for career development and training</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Collaborative and inclusive work environment</li><li style=\"list-style: none; color: rgb(10, 14, 18); line-height: 24px; letter-spacing: -0.38px; margin-bottom: 10px; position: relative; padding-left: 10px;\">Flexible working conditions and paid time off</li></ul></div>', 'Full Time', '<p>2+ years</p>', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, NULL, NULL, NULL, 'We are hiring a skilled Site Engineer to oversee construction projects and ensure quality execution. The ideal candidate should have strong technical expertise and a keen eye for detail in construction and project management.', 'Dhaka, Bangladesh', '\"Management\"', 1, '2026-03-17 01:44:57', '2026-03-17 02:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` bigint UNSIGNED NOT NULL,
  `event_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `content_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `content_id`, `name`, `phone`, `email`, `subject`, `resume`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 47, 'test', '21563697874', 'test@gmail.com', 'applicants', 'uploads/resumes/1773737928_2575.pdf', 0, '2026-03-17 02:58:48', '2026-03-17 02:58:48'),
(2, 47, 'test123', '21563697874', 'test1@gmail.com', 'applicants', 'uploads/resumes/1773738720_8413.pdf', 0, '2026-03-17 03:12:00', '2026-03-17 03:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_12_145624_create_contents_table', 1),
(5, '2025_12_12_145641_create_images_table', 1),
(6, '2026_01_12_085238_event_registrations', 1),
(7, '2026_01_12_114327_create_contacts_table', 1),
(8, '2026_03_17_083019_create_job_applications_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zh6cq9ziPhW5Avr9ZhvSjIoJ4ZpbHpp6ji7nxWcR', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoicGtSd2N2R2lBTjc1ZFF2cWR1RWZZbThjNkZ0NWNYNDFJbVFNNzFYbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hYm91dCI7czo1OiJyb3V0ZSI7czoxMToiZnJvbnQuYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NzM3MjEzMjA7fX0=', 1773739453);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '2026-03-15 05:01:26', '$2y$12$0pqCP3.f4q4SnN6bJ3clR.GK0am3SecwOVXfN8BW86JAsrDO2.K0G', NULL, '2026-03-15 05:01:26', '2026-03-15 05:01:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contents_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_content_id_foreign` (`content_id`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `contents_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
