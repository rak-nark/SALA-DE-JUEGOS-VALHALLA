-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2024 a las 01:57:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `valhalla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(5) NOT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `apellidoCliente` varchar(50) NOT NULL,
  `correoCliente` varchar(60) NOT NULL,
  `contrasenaCliente` varchar(80) NOT NULL,
  `rol` enum('usuario','administrador') DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombreCliente`, `apellidoCliente`, `correoCliente`, `contrasenaCliente`, `rol`) VALUES
(1, 'Juanito', 'Alimaña', '', '', 'usuario'),
(2, 'Pedrito', 'Navajas', '', '', 'usuario'),
(3, 'Di Anggelo', 'Larrusso', '', '', 'usuario'),
(4, 'Luca', 'Bianchi', '', '', 'usuario'),
(5, 'Giulia', 'Rossi', '', '', 'usuario'),
(6, 'Marco', 'Esposito', '', '', 'usuario'),
(7, 'Francesca', 'Romano', '', '', 'usuario'),
(8, 'Matteo ', 'Ricci', '', '', 'usuario'),
(9, 'Alessandra ', 'Moretti', '', '', 'usuario'),
(25, 'Alejandro', 'Ale', 'Alejandro@example.com', '$2y$12$.zSlCv2mG9OBkn4uRSldYOWjXMeFVzdS40qtvzx668.FMb74aCMjm', 'usuario'),
(26, 'Jan', 'Forero', 'jan@gmail.com', '$2y$10$SJkKuwyJwkQBWQoazEhc/Oeq0o7tWVB285i2oYpPAMlSGcDgPKQIq', 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consola`
--

CREATE TABLE `consola` (
  `id` int(5) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `disponibilidad` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consola`
--

INSERT INTO `consola` (`id`, `tipo`, `disponibilidad`) VALUES
(1, '360', 0),
(2, '360', 0),
(3, 'one', 1),
(4, 'one', 1),
(5, 'one', 1),
(6, 'one', 1),
(7, 'one', 0),
(8, '360', 1),
(9, '360', 1),
(10, '360', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `id_consola` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`id`, `tipo`, `descripcion`, `id_consola`, `fecha`) VALUES
(1, 'Correctivo', 'mantenimiento corectivo', 1, '2024-07-18'),
(2, 'Preventivo', 'mantenimiento preventivo', 2, '2024-08-18'),
(3, 'Correctivo', 'mantenimiento corectivo', 3, '2024-07-19'),
(4, 'correctivo', 'mantenimiento correctivo', 4, '2024-08-05'),
(5, 'correctivo', 'mantenimiento correctivo', 5, '2024-08-08'),
(6, 'correctivo', 'mantenimiento correctivo', 6, '2024-08-18'),
(7, 'Preventivo', 'mantenimiento preventivo', 7, '2024-08-18'),
(8, 'Preventivo', 'mantenimiento preventivo', 8, '2024-08-28'),
(9, 'Preventivo', 'mantenimiento preventivo', 9, '2024-09-01'),
(10, 'Correctivo', 'mantenimiento correctivo', 10, '2024-09-18'),
(12, 'correctivo', 'mantenimiento correctivo', 1, '2024-09-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(10, 'App\\Models\\User', 2, 'auth_token', '9d08444098ef98419c677e7eff6b017bba2ffcfa3e0aef6357b9ceb915652ff3', '[\"*\"]', NULL, NULL, '2024-11-15 20:39:33', '2024-11-15 20:39:33'),
(11, 'App\\Models\\User', 3, 'auth_token', '697130ed184547eb551f9bb9d9802f97099d023d5631133f9ec657c7ddaed259', '[\"*\"]', NULL, NULL, '2024-11-15 20:45:34', '2024-11-15 20:45:34'),
(28, 'App\\Models\\clienteModelo', 19, 'auth_token', '230e7733f5f787aa67cea5736ae87d5c10bdb7e0ff2c51dbe4c6b26c9498bb7e', '[\"*\"]', NULL, NULL, '2024-12-03 21:31:21', '2024-12-03 21:31:21'),
(29, 'App\\Models\\clienteModelo', 10, 'auth_token', '2a06c551a4a6f951985a34e0478e41eed3b23c4c608dd376359e57d34e7f1a9f', '[\"*\"]', NULL, NULL, '2024-12-03 21:39:02', '2024-12-03 21:39:02'),
(30, 'App\\Models\\clienteModelo', 10, 'auth_token', '812a72a6f6600542e74a7c2ef782796e8fbf6283a16b69a955f267cd5dd96b3e', '[\"*\"]', NULL, NULL, '2024-12-03 22:22:42', '2024-12-03 22:22:42'),
(31, 'App\\Models\\clienteModelo', 20, 'auth_token', '66efa4ef0af00f317054a07058bb0fc120a9f8af1b9635a38de7bfddca141800', '[\"*\"]', NULL, NULL, '2024-12-03 23:18:20', '2024-12-03 23:18:20'),
(32, 'App\\Models\\clienteModelo', 21, 'auth_token', '78786835bdcfe63bffd0913aaf0b7c9cd25ed1c9ae588019014d801142fdf08c', '[\"*\"]', NULL, NULL, '2024-12-03 23:23:16', '2024-12-03 23:23:16'),
(33, 'App\\Models\\clienteModelo', 22, 'auth_token', '92a1f31eb34af7651c7ddf82d8dfa765f337a5d1c170c5bcb94feede5edde5e0', '[\"*\"]', NULL, NULL, '2024-12-04 22:59:54', '2024-12-04 22:59:54'),
(38, 'App\\Models\\clienteModelo', 25, 'auth_token', 'a81e6b554849352128d8eb531ae22fd356145a0634d5b33214a15d36ba074373', '[\"*\"]', NULL, NULL, '2024-12-04 23:11:40', '2024-12-04 23:11:40'),
(39, 'App\\Models\\clienteModelo', 25, 'nombre-del-token', 'ce8eb8a655c4acd5196cd1776ba33922d167a35bdd73d210e8b3581681c1db00', '[\"*\"]', NULL, NULL, '2024-12-04 23:12:29', '2024-12-04 23:12:29'),
(40, 'App\\Models\\clienteModelo', 25, 'nombre-del-token', 'b1b729a786ae93fc3ffb0adad5684cfd94c48c8be749fdc398cd92d6122fce10', '[\"*\"]', NULL, NULL, '2024-12-04 23:13:50', '2024-12-04 23:13:50'),
(41, 'App\\Models\\clienteModelo', 25, 'nombre-del-token', '7c83e7f9ec4671838439ed1973d40052e2270f66786dcc1315f3e0d8c1c5f27e', '[\"*\"]', NULL, NULL, '2024-12-05 19:49:32', '2024-12-05 19:49:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `idPrestamo` int(5) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tiempodeuso` varchar(30) NOT NULL,
  `reserva` int(2) NOT NULL,
  `id_cliente` int(5) NOT NULL,
  `id_consola` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`idPrestamo`, `fecha`, `hora`, `tiempodeuso`, `reserva`, `id_cliente`, `id_consola`) VALUES
(1, '2024-08-18', '12:30:00', '2h', 1, 3, 1),
(2, '2024-08-19', '14:10:00', '2h', 1, 1, 3),
(3, '2024-07-19', '16:50:00', '1h', 0, 2, 2),
(4, '2024-07-19', '12:00:00', '1h', 0, 4, 5),
(5, '2024-07-19', '14:00:00', '2h', 1, 5, 4),
(6, '2024-07-19', '16:00:00', '1h', 1, 6, 7),
(7, '2024-07-19', '17:00:00', '1h', 1, 7, 6),
(8, '2024-07-21', '18:00:00', '3h', 0, 8, 9),
(9, '2024-07-31', '12:30:00', '30', 0, 9, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Alejandro', 'Alejandro@example.com', NULL, '$2y$12$VzggNqKfhKV7NBHrmc1tCeaz5.mCNPjq.Gk.62TrMtCPnACuv7lm6', NULL, '2024-11-14 16:44:09', '2024-11-14 16:44:09'),
(2, 'Felipe', 'Felipe@example.com', NULL, '$2y$12$E712gT8y50E9M/Io4UHPPeAhsFQ06TadOy8wUqZ1TjNNgSMwx/zAC', NULL, '2024-11-15 20:39:33', '2024-11-15 20:39:33'),
(3, 'Jhoan', 'Jhoan@example.com', NULL, '$2y$12$eCd6H05apmfDmzA/C4zEoeqbwvQrWOiBSDcWC9SfiphUxbLgvzVHS', NULL, '2024-11-15 20:45:34', '2024-11-15 20:45:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(5) NOT NULL,
  `fecha` date NOT NULL,
  `monto` int(11) DEFAULT NULL,
  `id_prestamo` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `fecha`, `monto`, `id_prestamo`) VALUES
(1, '2024-08-18', 6000, 1),
(2, '2024-08-19', 6000, 2),
(3, '2024-07-19', 2500, 3),
(4, '2024-07-19', 2500, 4),
(5, '2024-07-19', 6000, 5),
(6, '2024-07-19', 2500, 6),
(7, '2024-07-19', 3000, 7),
(8, '2024-07-21', 9000, 8),
(9, '2024-07-21', 2500, 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `consola`
--
ALTER TABLE `consola`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mantenimiento_consola` (`id_consola`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`idPrestamo`),
  ADD KEY `fk_prestamo_cliente` (`id_cliente`),
  ADD KEY `fk_prestamo_consola` (`id_consola`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venta_prestamo` (`id_prestamo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `consola`
--
ALTER TABLE `consola`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `idPrestamo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `fk_mantenimiento_consola` FOREIGN KEY (`id_consola`) REFERENCES `consola` (`id`);

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `fk_prestamo_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `fk_prestamo_consola` FOREIGN KEY (`id_consola`) REFERENCES `consola` (`id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_prestamo` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamo` (`idPrestamo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
