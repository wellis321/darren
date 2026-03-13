-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 13, 2026 at 03:16 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `darrenn`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `budget` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('new','contacted','confirmed','declined') COLLATE utf8mb4_general_ci DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `body` text COLLATE utf8mb4_general_ci,
  `meta_description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `slug`, `title`, `body`, `meta_description`, `updated_at`) VALUES
(1, 'about', 'About Darren', 'Darren Connell is a Scottish stand-up comedian, podcaster and actor from Glasgow, best known for playing Bobby Muir in the BBC Scotland mockumentary series Scot Squad — a role that earned him a BAFTA Scotland New Talent Award nomination for Best Actor in 2015.\r\n\r\nConnell grew up in Springburn in Glasgow. He started performing stand-up whilst juggling a full-time job collecting trolleys at Morrisons and Asda until fellow comedian Kevin Bridges convinced him to quit and pursue comedy full-time.\r\n\r\nSince then, Connell has hosted many solo shows across the UK including an appearance at the Edinburgh Fringe Festival. His shows include Trolleywood (2016), No Filter (2017), Abandon All Hope (2019) — which sold out at the Glasgow Comedy Festival — and My Name Is Darren Connell and This Is My Self-Tape.\r\n\r\nAs of 2019, he hosted The Darren Connell Show podcast on Glasgow Live, featuring guests including Grado, Loki and Greg Hemphill. In September 2021, he launched Straight White Whale with producer Paul Shields. He has also worked on Glaswegions Anonymous.', 'Learn about Darren Connell - Scottish comedian, actor and BAFTA-nominated star of Scot Squad.', '2026-03-13 14:29:17'),
(5, 'about_quote', 'About - Quote', '\"Truthful and very funny.\"', NULL, '2026-03-13 14:36:30'),
(6, 'about_intro', 'About - Intro', 'Hailing from Glasgow, Darren has taken the comedy scene by storm with his raw, high-energy style and relatable storytelling.', NULL, '2026-03-13 14:36:30'),
(7, 'about_journey', 'About - The Journey', 'From open mic nights in dusty Glasgow basements to the bright lights of the Edinburgh Fringe. Darren\'s rise wasn\'t accidental—it was forged in the fires of honest observation and a relentless work ethic. Best known for his breakout role as Bobby in the BBC hit Scot Squad, he\'s proven he can command both the screen and the stage.', NULL, '2026-03-13 14:36:30'),
(8, 'about_comedy_style', 'About - Comedy Style', 'High-octane, unfiltered, and unapologetically Glaswegian. Darren\'s comedy doesn\'t just ask for a laugh—it demands one. He finds the absurdity in the everyday and the heartbreak in the hilarious.', NULL, '2026-03-13 14:36:30'),
(9, 'about_personal', 'About - Personal Life', 'When he\'s not making people howl with laughter, Darren is a passionate advocate for mental health and staying grounded in his roots. He\'s a man of the people, for the people, usually found with a coffee in hand planning his next big move.', NULL, '2026-03-13 14:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `venue` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `venue_city` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `ticket_url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `is_featured` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `venue`, `venue_city`, `event_date`, `event_time`, `ticket_url`, `description`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Darren Connell: Cancelled', 'Blackfriars of Bell Street', 'Glasgow', '2026-06-14', '17:30:00', 'https://wegottickets.com/event/693930', 'After his nationwide tour was abruptly pulled from under him, Darren Connell is doing what he does best: turning chaos into comedy. His new show, Cancelled, lands at Blackfriars — raw, restless and very, very funny. Door 5pm, show 5:30pm. 18+.', 1, '2026-03-12 22:34:04', '2026-03-12 22:34:04'),
(2, 'Darren Connell: Cancelled', 'Blackfriars of Bell Street', 'Glasgow', '2026-06-14', '17:30:00', 'https://wegottickets.com/event/693930', 'After his nationwide tour was abruptly pulled from under him, Darren Connell is doing what he does best: turning chaos into comedy. His new show, Cancelled, lands at Blackfriars — raw, restless and very, very funny. Door 5pm, show 5:30pm. 18+.', 1, '2026-03-12 22:39:01', '2026-03-12 22:39:01'),
(3, 'Glaswegians Anonymous Live! Ep:2', 'SEC (Clyde Auditorium / The Armadillo)', 'Glasgow', '2026-06-20', '19:00:00', 'https://www.ents24.com/glasgow-events/the-scottish-event-centre-and-clyde-auditorium-the-armadillo/glaswegians-anonymous-live-ep2/7399913', 'Gary Faulds and Darren Connell are taking the podcast to the stunning SEC Glasgow, for episode 2. Expect chaos, carnage, and plenty of laughs - this is Glaswegians Anonymous like you\'ve never seen it before!', 1, '2026-03-12 22:39:01', '2026-03-12 22:39:01');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int NOT NULL,
  `type` enum('video','image','podcast') COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `embed_code` text COLLATE utf8mb4_general_ci,
  `description` text COLLATE utf8mb4_general_ci,
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `type`, `title`, `url`, `embed_code`, `description`, `sort_order`, `created_at`) VALUES
(1, 'video', 'Crowd Work', 'https://www.youtube.com/watch?v=yGhz51GFeRs', '<iframe width=\"100%\" height=\"315\" src=\"https://www.youtube.com/embed/yGhz51GFeRs\" title=\"Darren Connell - Crowd Work\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 'Raw crowd work from Darren Connell.', 0, '2026-03-12 22:33:14'),
(2, 'video', 'Crowd Work', 'https://www.youtube.com/watch?v=yGhz51GFeRs', '<iframe width=\"100%\" height=\"315\" src=\"https://www.youtube.com/embed/yGhz51GFeRs\" title=\"Darren Connell - Crowd Work\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 'Raw crowd work from Darren Connell.', 0, '2026-03-13 14:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `podcast_episodes`
--

CREATE TABLE `podcast_episodes` (
  `id` int NOT NULL,
  `podcast_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `episode_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `episode_url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `embed_code` text COLLATE utf8mb4_general_ci,
  `description` text COLLATE utf8mb4_general_ci,
  `release_date` date DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `podcast_episodes`
--

INSERT INTO `podcast_episodes` (`id`, `podcast_name`, `episode_title`, `episode_url`, `embed_code`, `description`, `release_date`, `sort_order`, `created_at`) VALUES
(1, 'Glaswegians Anonymous', 'The Deep Fried Mars Bar Myth', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', NULL, NULL, NULL, 3, '2026-03-13 14:49:40'),
(2, 'Glaswegians Anonymous', 'Taxis, Kebabs and Late Nights', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', NULL, NULL, NULL, 2, '2026-03-13 14:49:40'),
(3, 'Glaswegians Anonymous', 'Why Does It Always Rain on Me?', 'https://open.spotify.com/show/0hjOxRAlk3A9CVt1KFlmpI', NULL, NULL, NULL, 1, '2026-03-13 14:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int NOT NULL,
  `quote` text COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT '0',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `quote`, `author`, `role`, `is_featured`, `sort_order`, `created_at`) VALUES
(1, 'A natural with a real bright future.', 'Kevin Bridges', 'Comedian', 1, 0, '2026-03-12 21:10:10'),
(2, 'A natural with a real bright future.', 'Kevin Bridges', 'Comedian', 1, 0, '2026-03-12 21:15:28'),
(3, 'A natural with a real bright future.', 'Kevin Bridges', 'Comedian', 1, 0, '2026-03-12 21:24:07'),
(4, 'A natural with a real bright future.', 'Kevin Bridges', 'Comedian', 1, 0, '2026-03-13 14:27:24'),
(5, 'A natural with a real bright future.', 'Kevin Bridges', 'Comedian', 1, 0, '2026-03-13 14:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `name`, `created_at`) VALUES
(1, 'admin@darrenconnell.com', '$2y$12$nucWLvKmqAaQha6Em2uU7e1pPXOH4Enzaj2BTEjYSNjtEU4PD65Hi', 'Darren Connell', '2026-03-12 21:10:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_event_date` (`event_date`),
  ADD KEY `idx_featured` (`is_featured`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `podcast_episodes`
--
ALTER TABLE `podcast_episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_podcast` (`podcast_name`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_featured` (`is_featured`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `podcast_episodes`
--
ALTER TABLE `podcast_episodes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
