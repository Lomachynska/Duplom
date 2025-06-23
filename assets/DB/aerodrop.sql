-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Час створення: Квт 11 2025 р., 11:15
-- Версія сервера: 5.7.39
-- Версія PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `aerodrop`
--

-- --------------------------------------------------------

--
-- Структура таблиці `chats`
--

CREATE TABLE `chats` (
  `id` char(36) NOT NULL,
  `user_id_1` char(36) NOT NULL,
  `user_id_2` char(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `chats`
--

INSERT INTO `chats` (`id`, `user_id_1`, `user_id_2`, `created_at`) VALUES
('a096b237-fc7e-4e59-bbd3-15f98909040d', '1ad41cf2-3227-4bf2-b7ed-953538f5782e', 'e00084e9-ddfe-4171-89e7-0465063bb160', '2025-03-10 19:44:32'),
('d9fb29a0-53cf-403a-8a89-7f1dd1d68383', '1ad41cf2-3227-4bf2-b7ed-953538f5782e', 'e00084e9-ddfe-4171-89e7-0465063bb160', '2025-03-10 21:14:38');

-- --------------------------------------------------------

--
-- Структура таблиці `messages`
--

CREATE TABLE `messages` (
  `id` char(36) NOT NULL,
  `chat_id` char(36) NOT NULL,
  `sender_id` char(36) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `sender_id`, `message`, `created_at`) VALUES
('53ea0479-1bfa-4667-a58a-fb449e0bb1ea', 'a096b237-fc7e-4e59-bbd3-15f98909040d', '1ad41cf2-3227-4bf2-b7ed-953538f5782e', 'фівфівфівфів', '2025-03-10 19:44:46'),
('6834cadb-4e8b-4be8-b329-abda2f34c7d8', 'a096b237-fc7e-4e59-bbd3-15f98909040d', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'фівфівфівфів', '2025-03-10 19:44:44'),
('8c0bae32-8963-4c3d-bbc5-0c2e10e4dcbb', 'd9fb29a0-53cf-403a-8a89-7f1dd1d68383', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'фівфівфів', '2025-04-11 09:55:55'),
('92f77909-23f2-40e5-ab67-8c57295d9106', 'd9fb29a0-53cf-403a-8a89-7f1dd1d68383', '1ad41cf2-3227-4bf2-b7ed-953538f5782e', 'http://localhost:8888/order?order_id=5ac967ca-cd5b-4fbc-9143-51f1d6d32bcf', '2025-03-10 21:42:32'),
('a070f650-32dc-4d90-bd13-2278b1941aac', 'd9fb29a0-53cf-403a-8a89-7f1dd1d68383', 'e00084e9-ddfe-4171-89e7-0465063bb160', '123123123', '2025-04-11 09:57:25'),
('c9416163-82b2-444a-812e-75d584c1ad6b', 'a096b237-fc7e-4e59-bbd3-15f98909040d', '1ad41cf2-3227-4bf2-b7ed-953538f5782e', 'фівфів', '2025-03-10 19:44:39'),
('cd961d65-2f88-4d9d-9d11-9d62d6c9a8b3', 'd9fb29a0-53cf-403a-8a89-7f1dd1d68383', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'фівіфвфівфіівфіів', '2025-04-11 09:56:01'),
('d397999f-cf64-4fd6-ad3b-17f016e9c309', 'a096b237-fc7e-4e59-bbd3-15f98909040d', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'фівфівфівфів', '2025-03-10 19:44:49'),
('ed9e22af-542f-4a9b-98ee-bd8c2cb78d52', 'd9fb29a0-53cf-403a-8a89-7f1dd1d68383', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'asdasd', '2025-04-11 10:21:16');

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `executor_id` char(36) DEFAULT NULL,
  `truck_type` varchar(255) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `size` varchar(255) NOT NULL,
  `description` text,
  `start_point` varchar(255) NOT NULL,
  `end_point` varchar(255) NOT NULL,
  `status` enum('pending','in_progress','completed','cancelled') DEFAULT 'pending',
  `price` decimal(10,2) NOT NULL,
  `distance` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `time` varchar(100) NOT NULL,
  `recognition` varchar(255) NOT NULL,
  `delivery_instructions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `executor_id`, `truck_type`, `weight`, `size`, `description`, `start_point`, `end_point`, `status`, `price`, `distance`, `created_at`, `banned`, `time`, `recognition`, `delivery_instructions`) VALUES
('5ac967ca-cd5b-4fbc-9143-51f1d6d32bcf', '1ad41cf2-3227-4bf2-b7ed-953538f5782e', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'food', '1.00', 'lg', 'фівфів', '50.955956,30.891882', '50.952263,30.880637', 'cancelled', '89.00', '0.89', '2025-03-10 17:34:23', 0, '', '', ''),
('69fd6f92-1994-469b-aa9b-3235af641c0d', 'd536fdfd-8f5c-4bbb-bcf6-8f15320b5909', NULL, 'clothing', '1.00', 'lg', 'Тестовий. опис', '50.954482,30.887381', '50.947777,30.878111', 'pending', '99.00', '0.99', '2025-04-11 10:40:46', 0, '2025-04-19T13:40', '12123', '123331231'),
('b08c5b8e-a5a7-4eb9-a23c-21540a038c9a', 'd536fdfd-8f5c-4bbb-bcf6-8f15320b5909', NULL, 'clothing', '1.00', 'sm', '123', '50.95307413976162,30.88565826416016', '50.95077612432229,30.868749618530277', 'pending', '121.00', '1.21', '2025-04-11 10:55:08', 0, '2025-04-19T13:55', '123', '12'),
('ea0771db-b62d-400f-a0aa-afefdae09f6a', '1ad41cf2-3227-4bf2-b7ed-953538f5782e', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'clothing', '4.00', 'sm', '4', '50.948911,30.874748', '50.950155,30.882816', 'completed', '58.00', '0.58', '2025-03-10 21:13:41', 0, '', '', '');

-- --------------------------------------------------------

--
-- Структура таблиці `reviews`
--

CREATE TABLE `reviews` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `order_id` char(36) NOT NULL,
  `information` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `order_id`, `information`, `created_at`) VALUES
('5209f738-0277-4e6d-bbe1-0864ec4cb200', 'e00084e9-ddfe-4171-89e7-0465063bb160', '5ac967ca-cd5b-4fbc-9143-51f1d6d32bcf', 'привіт . готовий виконати твоє замовлення', '2025-03-10 19:44:10'),
('dbfd509c-b2e9-45e0-9d02-706b61fed474', 'e00084e9-ddfe-4171-89e7-0465063bb160', 'ea0771db-b62d-400f-a0aa-afefdae09f6a', '123', '2025-03-10 21:14:09');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer','executor') DEFAULT NULL,
  `information` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `lastName`, `avatar`, `phone`, `email`, `password`, `role`, `information`, `created_at`, `banned`) VALUES
('1ad41cf2-3227-4bf2-b7ed-953538f5782e', '12', '2', NULL, '1', '1@1', '$2y$10$KWt9VMqQ2RAZBVN1bfdTl.9z/QeT/.Yzh2UiwCBht6iqh.ck7.hfm', 'customer', 'adasdasdassd', '2025-03-06 22:02:29', 0),
('569566eb-2320-4db8-9ab0-750f20b60435', 'admin', 'admin', NULL, 'admin', 'admin@admin', '$2y$10$cvHTrAsCMgVCPhHa8fYfS.XZ53kfKL9p1rFINX7sgoVziS24gkc4W', 'admin', '', '2025-03-10 15:58:23', 0),
('d536fdfd-8f5c-4bbb-bcf6-8f15320b5909', '11', '11', NULL, '11', '11@11', '$2y$10$kEHG5alqE3w4dME1Rvgjku8zYeQbJfwkYeiHL2W6/I1zPZXv/62qy', 'customer', '', '2025-04-11 10:29:15', 0),
('e00084e9-ddfe-4171-89e7-0465063bb160', '2', '2', 'uploads/users/67f8eb32584a5_active_avatar.png', '2', '2@2', '$2y$10$O9VFveoZPAJ/gczBcM7A4OUEHioIjQm8gOaVnSY8.VRPa.dg/lRXu', 'executor', '', '2025-03-06 22:35:42', 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_1` (`user_id_1`),
  ADD KEY `user_id_2` (`user_id_2`);

--
-- Індекси таблиці `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_executor_id` (`executor_id`);

--
-- Індекси таблиці `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`user_id_1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`user_id_2`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_executor_id` FOREIGN KEY (`executor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
