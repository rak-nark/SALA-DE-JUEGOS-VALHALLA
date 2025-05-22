-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2025 a las 18:18:22
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
  `rol` enum('administrador','usuario') DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombreCliente`, `apellidoCliente`, `correoCliente`, `contrasenaCliente`, `rol`) VALUES
(1, 'Juanito', 'Alimaña', 'juanitoalimana@gmail.com', '$2y$10$fELwiODOSzqSaiOJCozJ4unJm6JeLoQvSylWGgHuqbuAG.SbOoj/2', 'administrador'),
(2, 'Pedrito', 'Navajas', 'pedritonavaja@gamil.com', '$2y$10$/gKkAjUpn4mEO0j6HS1lOe6mFkeGCkhkv3gf.07UYVoP9JY4SgpCS', 'administrador'),
(3, 'Di Anggelo', 'Larrusso', 'dianggelo@gmail.com', '$2y$10$tqIyzcMP/dDjOsLuTzczOuju7meEEWPMZgPm8RZueg0QIfI1Gu1qq', 'administrador'),
(4, 'Luca', 'Bianchi', 'luca@gmail.com', '$2y$10$5K8i0JMGgRc8bcrNnbnjwuWw7.NBHDJg9qftEGtZRMpZRQAq.mCdO', 'usuario'),
(5, 'Giulia', 'Rossi', 'rossi@gmail.com', '$2y$10$srgQWXZkc0tFoPhXvZbjA.fR64I8/gBDKEGmeCpR7Okbt3Dbrur5q', 'usuario'),
(6, 'Marco', 'Esposito', 'marquitos@gmail.com', '$2y$10$FhJtJGGeOm613fHUZh113.bDKqq4H/w6/Dha8uka3Z3KMJXOnFlmG', 'usuario'),
(7, 'Francesca', 'Romano', 'francesca@gmail.com', '$2y$12$6BdAqD0hQ9oXmVnqiQuAw.CDWj5XQTyxuIHi6AXppxGHvc4kRt4j2', 'usuario'),
(8, 'Matteo ', 'Ricci', 'matteo@gmail.com', '$2y$10$007GkbfpuGCRM2RKnaIn.O12QFTDP2wpW4Zt7MpDvPZxHxhwknVla', 'usuario'),
(9, 'Alessandra ', 'Moretti', 'alessandra@gmail.com', '$2y$10$cBoB2HaYdZFSiNReKjoGteWtVvTtVLeLGdWqPsxE8OZom67An1LIm', 'usuario'),
(10, 'Reserva Fisica', '', '', '', 'usuario'),
(11, 'Eusstas', 'Kid', 'eusstas@gmail.com', '$2y$10$72ne4zh4XXaBWfyoFumQ8OU2UVgPM1THE6xoqyePasGn1wZ4OTCIi', 'usuario'),
(14, 'manrique', 'asevedo', 'manrique@gmail', '$2y$10$1wmHNBJZ6/aHBYDOB9IkBO0n3XmzlbQdvsFLsPoMgi6nAKaZufC72', 'usuario'),
(15, 'juanito', 'alimaña', 'juanito@gmail', '$2y$10$bVrhD1gCVt7q4aPQ/qL69uO/BmTmU/yh0/bYRLeuLQssehq7.zpO2', 'usuario'),
(16, 'juanito', 'alimaña', 'juanito@gmail', '$2y$10$whYl1cA/uiobJI2Nnh2CH.bTlobxTtSFl7wohcYVDpJ3KoFrJ1Ucq', 'usuario'),
(17, 'juanito', 'alimaña', 'juanito@gmail', '$2y$10$0SKJq9YlQo4byRZFs/Ic5u8get9rPeo5oC5F7mhwEf2VK8Xigvl7m', 'usuario'),
(18, 'juanito', 'alimañas', 'juanitos@gmail', '$2y$10$nwqv7M0TKrXcs7I3obpf6u4AsIQYLOgAt2LSIj4qjC.8OR613RVXq', 'usuario'),
(19, 'eustase', 'kidq', 'eustas@hotsr', '$2y$10$EBlSlsSRExYw1etg4axlfOhKN1glm4c6R3.6tl0qRpo8nEhZsW.G.', 'usuario'),
(20, 'eustase', 'kidq', 'eustas@hotst', '$2y$10$VaFOjXCdb8XuUfToCbCqpuSW/ch6Zjo9derDs9xxC6zOZ1ejoLCHq', 'usuario'),
(21, 'ana', 'velasques', 'ana@hot', '$2y$10$UUOa96kTSRoxSZ3n87Kknu.ulN8hAH8T/Rbkr6SnLxs1zt9SEpp02', 'usuario'),
(22, 'pepito', 'perez', 'pepito@gmail', '$2y$12$Vz7wr7KEuKn4ds1gTl.09.lRtsGglG/4FxXSXMoV2tzv/sTUa3Tbq', 'usuario'),
(24, 'manuel', 'turizo', 'manuel@gmail.com', '$2y$12$89ZxpzlpQc/TCAcCfihsYuwTic/OGJnISQBS3z8jS19uUT8zelvT2', 'usuario'),
(28, 'louis', 'santiago', 'louissantiagomartinezriveros@gmail.com', '$2y$12$hS1Qm9zMW0DBKUwfYRYO8OCQv6hKcG1jc3OCv4.aokMPt/y76G62S', 'usuario'),
(29, 'erik', 'ten hag', 'erik@gmail', '$2y$12$rTRVHJ0mVswnKvwYRbLkwO523IABf95xbS8z.1U56GoQWw7UDcl4i', 'usuario'),
(32, 'manuel', 'edgar', 'manute@gmail.com', '$2y$10$KLCVYFEQkGq1br/HklBIz.bOCkAyo/tCEeWXURsTuh1/fGC3I6SDC', 'usuario'),
(37, 'lautaro', 'martinez', 'lauta@gmail.com', '$2y$12$DgLa5KBLj/IxD7m5WEcAp.7imjH3EvDEXdDrUWM/oxyymOBKeQ.JS', 'usuario'),
(38, 'manuel', 'turizo', 'manuelito@gmail', '$2y$12$Qg6a2Ms5pqSXg6iEmL/Gqe6iiKPDJ7tBGpUJBewtOwu2fe4KOIrda', 'usuario'),
(39, 'kilian', 'mbappe', 'kilian@gmail.com', '$2y$12$igC6YyNDlxt.1p0UJFn5WufQQnAsAqnXTw4XGH6k.dMhomnbwfbIC', 'usuario'),
(41, 'juan', 'manrique', 'juanitos@gmail.com', '$2y$12$5bTul9JyD1YNN30qDYt9COeBWXH6Hlss2TiJaHx9jfxWxVECTIulu', 'usuario'),
(42, 'angela', 'agilar', 'angelita@gmail.com', '$2y$12$WPsrBY.83Pq3.V41FKS4jOTfzsig3iIupM4zKvl7i7i/7ER0SD76q', 'usuario'),
(43, 'juanito', 'alimañas', 'juanitoo@gmail.com', '$2y$12$H7SnXU0UGKm.RnLw.2al.uM5B1BACI8EZqMLEkNYavtx5q5GDPNUK', 'usuario'),
(44, 'diangeo', 'alcapone', 'alcapo@gmail.com', '$2y$12$.7HfPU4vjKYG0luzshTfueRSLQWHoN5IO8Rq5I6ltPuOB8KyfdpQ6', 'usuario'),
(50, 'Usuario Eliminado', '', 'eliminado@valhalla.com', '', 'usuario'),
(52, 'son', 'goku', 'supersayayin@gmail.com', '$2y$10$BvoJRYtImboDFb4GfXIl0OgTSfsxyoYsXDIPNqm9y3CCKBIitzOzK', 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consola`
--

CREATE TABLE `consola` (
  `id` int(5) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `estado` enum('disponible','no_disponible','mantenimiento') DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consola`
--

INSERT INTO `consola` (`id`, `tipo`, `estado`) VALUES
(1, '360', 'disponible'),
(2, '360', 'disponible'),
(3, '360', 'disponible'),
(4, '360', 'disponible'),
(5, '360', 'disponible'),
(6, '360', 'disponible'),
(7, '360', 'disponible'),
(8, '360', 'disponible'),
(9, 'one', 'disponible'),
(10, 'one', 'disponible'),
(11, 'one', 'disponible'),
(12, 'one', 'disponible'),
(13, 'one', 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id` int(11) NOT NULL,
  `tipo` enum('correctivo','preventivo','limpieza','actualizacion') NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `id_consola` int(11) NOT NULL,
  `fecha_programada` date NOT NULL,
  `estado` enum('pendiente','en_proceso','completado','cancelado') NOT NULL DEFAULT 'pendiente',
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`id`, `tipo`, `descripcion`, `id_consola`, `fecha_programada`, `estado`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`) VALUES
(1, 'correctivo', 'Reemplazo de fuente de poder dañada', 1, '2024-07-18', 'completado', '2024-07-18 09:30:00', '2024-07-18 12:15:00', '2025-04-06 21:45:48', '2024-07-18 17:20:00'),
(2, 'preventivo', 'Limpieza interna y revisión de componentes', 3, '2024-08-18', 'completado', '2024-08-18 10:00:00', '2025-04-08 16:50:21', '2025-04-06 21:45:48', '2025-04-08 21:50:21'),
(3, 'correctivo', 'Reparación de puerto HDMI', 3, '2024-07-19', 'completado', '2024-07-19 14:00:00', '2024-07-19 16:30:00', '2025-04-06 21:45:48', '2024-07-19 21:35:00'),
(4, 'correctivo', 'Cambio de ventilador ruidoso', 4, '2024-08-05', 'completado', '2024-08-05 11:00:00', '2024-08-05 11:45:00', '2025-04-06 21:45:48', '2024-08-05 16:50:00'),
(5, 'correctivo', 'Reparación de botón de encendido', 5, '2024-08-31', 'cancelado', NULL, NULL, '2025-04-06 21:45:48', '2025-04-08 22:22:27'),
(6, 'correctivo', 'Solución a problemas de sobrecalentamiento', 2, '2024-08-18', 'cancelado', '2025-04-08 16:50:45', '2025-04-08 16:50:50', '2025-04-06 21:45:48', '2025-04-08 21:50:50'),
(7, 'preventivo', 'Mantenimiento trimestral programado', 7, '2025-04-09', 'completado', '2025-04-08 16:57:03', '2025-04-08 17:00:29', '2025-04-06 21:45:48', '2025-04-08 22:00:29'),
(8, 'preventivo', 'Revisión general y limpieza profunda', 8, '2024-08-28', 'cancelado', '2025-04-08 16:56:32', '2025-04-08 16:56:52', '2025-04-06 21:45:48', '2025-04-08 21:56:52'),
(9, 'preventivo', 'Actualización de firmware y optimización', 9, '2024-09-01', 'cancelado', '2025-04-08 16:56:41', '2025-04-08 16:57:12', '2025-04-06 21:45:48', '2025-04-08 21:57:12'),
(10, 'correctivo', 'Reparación de lector de discos', 10, '2024-09-18', 'completado', '2025-04-08 16:56:47', '2025-04-08 16:58:02', '2025-04-06 21:45:48', '2025-04-08 21:58:02'),
(13, 'preventivo', 'Revisión de conectores y puertos', 1, '2024-10-15', 'cancelado', '2025-04-08 16:57:08', '2025-04-08 16:58:13', '2025-04-06 21:48:44', '2025-04-08 21:58:13'),
(14, 'correctivo', 'Reparación de controlador inalámbrico', 2, '2024-10-20', 'cancelado', '2025-04-08 16:59:02', '2025-04-08 16:59:14', '2025-04-06 21:48:44', '2025-04-08 21:59:14'),
(15, 'preventivo', 'Calibración de mandos y controles', 3, '2024-11-01', 'completado', '2025-04-08 16:59:11', '2025-04-08 17:00:41', '2025-04-06 21:48:44', '2025-04-08 22:00:41'),
(16, 'limpieza', 'limpieza de consola', 2, '2025-04-08', 'cancelado', '2025-04-08 17:00:28', '2025-04-08 17:00:32', '2025-04-06 22:54:24', '2025-04-08 22:00:32'),
(17, 'limpieza', 'limpieza de consola', 2, '2025-04-08', 'completado', '2025-04-08 17:21:55', '2025-04-08 17:21:58', '2025-04-06 22:54:24', '2025-04-08 22:21:58'),
(18, 'limpieza', 'limpieza de consola', 2, '2025-04-08', 'cancelado', '2025-04-08 17:22:01', '2025-04-08 17:22:03', '2025-04-06 22:54:30', '2025-04-08 22:22:03'),
(19, 'limpieza', 'limpieza de consola', 2, '2025-04-08', 'cancelado', NULL, '2025-04-08 17:22:06', '2025-04-06 22:54:30', '2025-04-08 22:22:06'),
(20, 'correctivo', 'feaef', 1, '2025-04-10', 'cancelado', NULL, '2025-04-08 17:22:08', '2025-04-08 21:51:02', '2025-04-08 22:22:08'),
(21, 'correctivo', 'limpieza', 1, '2025-04-10', 'cancelado', NULL, '2025-04-08 17:22:12', '2025-04-08 22:01:05', '2025-04-08 22:22:12'),
(22, 'correctivo', 'l', 1, '2025-04-10', 'cancelado', NULL, '2025-04-08 17:22:13', '2025-04-08 22:17:19', '2025-04-08 22:22:13'),
(23, 'correctivo', 'l', 1, '2025-04-11', 'cancelado', NULL, '2025-04-08 17:22:14', '2025-04-08 22:21:19', '2025-04-08 22:22:14'),
(24, 'correctivo', 'u', 11, '2025-04-08', 'completado', '2025-04-08 17:22:52', '2025-04-08 17:22:54', '2025-04-08 22:22:46', '2025-04-08 22:22:54'),
(25, 'limpieza', 'limpieza de la consola y sus periféricos', 2, '2025-04-17', 'cancelado', NULL, '2025-04-09 17:10:11', '2025-04-09 22:06:13', '2025-04-12 02:11:07'),
(26, 'preventivo', 'lol', 1, '2025-04-19', 'completado', '2025-04-11 15:08:43', '2025-04-11 15:08:51', '2025-04-11 19:57:58', '2025-04-11 20:08:51'),
(27, 'correctivo', 'tri', 3, '2025-04-12', 'cancelado', NULL, '2025-04-11 15:08:45', '2025-04-11 20:08:28', '2025-04-11 20:08:45'),
(28, 'correctivo', 'troll', 1, '2025-04-19', 'cancelado', NULL, '2025-04-11 15:18:03', '2025-04-11 20:17:36', '2025-04-11 20:18:03'),
(29, 'correctivo', 'fill', 1, '2025-04-12', 'completado', '2025-04-11 15:29:36', '2025-04-11 15:29:40', '2025-04-11 20:29:28', '2025-04-11 20:29:40'),
(30, 'correctivo', 'ggg', 1, '2025-04-19', 'completado', '2025-04-11 15:31:13', '2025-04-11 21:10:04', '2025-04-11 20:30:53', '2025-04-12 02:10:04'),
(31, 'preventivo', 'ghghgg', 1, '2025-04-19', 'completado', '2025-04-11 21:10:26', '2025-04-11 21:10:30', '2025-04-11 20:33:19', '2025-04-12 02:10:30'),
(32, 'correctivo', 'qewqewq', 1, '2025-04-18', 'cancelado', NULL, '2025-04-11 21:10:50', '2025-04-11 20:39:34', '2025-04-12 02:10:50'),
(33, 'correctivo', '1', 1, '2025-04-20', 'cancelado', NULL, '2025-04-11 21:10:43', '2025-04-11 20:42:32', '2025-04-12 02:10:43'),
(34, 'correctivo', '2312321', 1, '2025-04-20', 'cancelado', NULL, '2025-04-11 21:10:45', '2025-04-11 20:57:42', '2025-04-12 02:10:45'),
(35, 'correctivo', 'eweqwe', 1, '2025-04-21', 'cancelado', NULL, '2025-04-11 21:10:42', '2025-04-11 20:57:55', '2025-04-12 02:10:42'),
(36, 'correctivo', 'wewqewqeqw', 1, '2025-04-22', 'cancelado', NULL, '2025-04-11 21:10:39', '2025-04-11 20:58:10', '2025-04-12 02:10:39'),
(37, 'correctivo', 'dsdsfsdfsd', 1, '2025-04-22', 'cancelado', NULL, '2025-04-11 21:10:40', '2025-04-11 20:59:16', '2025-04-12 02:10:40'),
(38, 'limpieza', 'limpieza de consola ', 6, '2025-04-18', 'completado', '2025-04-11 21:12:00', '2025-04-11 21:12:06', '2025-04-12 02:11:45', '2025-04-12 02:12:06');

--
-- Disparadores `mantenimiento`
--
DELIMITER $$
CREATE TRIGGER `after_mantenimiento_update` AFTER UPDATE ON `mantenimiento` FOR EACH ROW BEGIN
    IF NEW.estado != OLD.estado THEN
        IF NEW.estado = 'en_proceso' THEN
            UPDATE consola SET estado = 'mantenimiento' 
            WHERE id = NEW.id_consola;
        ELSEIF (OLD.estado = 'en_proceso' AND NEW.estado IN ('completado', 'cancelado')) THEN
            UPDATE consola SET estado = 'disponible' 
            WHERE id = NEW.id_consola;
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_mantenimiento_insert` BEFORE INSERT ON `mantenimiento` FOR EACH ROW BEGIN
    DECLARE mantenimiento_activo INT DEFAULT 0;
    
    IF NEW.estado = 'en_proceso' THEN
        SELECT COUNT(*) INTO mantenimiento_activo
        FROM mantenimiento
        WHERE id_consola = NEW.id_consola 
          AND estado = 'en_proceso';
        
        IF mantenimiento_activo > 0 THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'No se puede tener más de un mantenimiento en proceso por consola';
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_mantenimiento_update` BEFORE UPDATE ON `mantenimiento` FOR EACH ROW BEGIN
    DECLARE mantenimiento_activo INT DEFAULT 0;
    
    IF NEW.estado = 'en_proceso' AND OLD.estado != 'en_proceso' THEN
        SELECT COUNT(*) INTO mantenimiento_activo
        FROM mantenimiento
        WHERE id_consola = NEW.id_consola 
          AND estado = 'en_proceso'
          AND id != NEW.id;
        
        IF mantenimiento_activo > 0 THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'No se puede tener más de un mantenimiento en proceso por consola';
        END IF;
    END IF;
END
$$
DELIMITER ;

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
(1, 'App\\Models\\clienteModelo', 33, 'auth_token', 'd22131980074a38053bedcc67fee8234156f2b68e153aef11f246f06e3761505', '[\"*\"]', NULL, NULL, '2024-12-10 05:41:03', '2024-12-10 05:41:03'),
(2, 'App\\Models\\clienteModelo', 33, 'nombre-del-token', 'fcfb111b20601e4e1a044aa046579969ebd06e017e1283fa0ae800c2f9d6a55d', '[\"*\"]', NULL, NULL, '2024-12-10 05:42:11', '2024-12-10 05:42:11'),
(3, 'App\\Models\\clienteModelo', 33, 'nombre-del-token', '960ca013da76f74d0b05174cea0ec2cede5e784633d3fab8ecccafd09ae02da1', '[\"*\"]', NULL, NULL, '2024-12-10 23:35:37', '2024-12-10 23:35:37'),
(4, 'App\\Models\\clienteModelo', 34, 'auth_token', '7866d80c051f116d374003afbc7e288f3cc0c2bf859b4e784b84ce373f60fdcf', '[\"*\"]', NULL, NULL, '2024-12-11 00:30:53', '2024-12-11 00:30:53'),
(5, 'App\\Models\\clienteModelo', 35, 'auth_token', '2d5cb314a68de2a822c5b82d263614f5346f922e1795d34dc1666f5549530f2d', '[\"*\"]', NULL, NULL, '2024-12-11 00:30:55', '2024-12-11 00:30:55'),
(6, 'App\\Models\\clienteModelo', 36, 'auth_token', '070ba2fd0dbf3084398f026c6e200676cc1a940d7aef29c67b5d92772565c8a5', '[\"*\"]', NULL, NULL, '2024-12-11 00:30:57', '2024-12-11 00:30:57'),
(7, 'App\\Models\\clienteModelo', 37, 'auth_token', '05f3fbe5668bc26fa16b5bb6b5ef71622c9e48df836dd4bd9c36b32a94838f23', '[\"*\"]', NULL, NULL, '2024-12-11 00:32:17', '2024-12-11 00:32:17'),
(8, 'App\\Models\\clienteModelo', 38, 'auth_token', '379fafd0ae674d20da7554696b10683be2c2317bb111d4ff62c8b888950a2e12', '[\"*\"]', NULL, NULL, '2024-12-11 01:03:37', '2024-12-11 01:03:37'),
(9, 'App\\Models\\clienteModelo', 39, 'auth_token', 'b8d7e14583017681b87e7334f6b9c0575dd65561aec830649044fd6dff74e140', '[\"*\"]', NULL, NULL, '2024-12-11 01:07:01', '2024-12-11 01:07:01'),
(10, 'App\\Models\\clienteModelo', 39, 'nombre-del-token', '224de555bd5fbf16e2ee3af84870c8ced6b6eafd35a6d3fb8db2e30344b0810b', '[\"*\"]', NULL, NULL, '2024-12-11 01:07:31', '2024-12-11 01:07:31'),
(11, 'App\\Models\\clienteModelo', 39, 'nombre-del-token', 'eb4bf47161b16bf514aabfafc07073f64d85ae9480cb2e4a629d5582d6311f6f', '[\"*\"]', NULL, NULL, '2024-12-11 01:13:48', '2024-12-11 01:13:48'),
(12, 'App\\Models\\clienteModelo', 39, 'nombre-del-token', '3b38f36c5936a1d54c61a398f47f4030847042b2e899e0aa918b1122740df3b2', '[\"*\"]', NULL, NULL, '2024-12-11 01:22:05', '2024-12-11 01:22:05'),
(13, 'App\\Models\\clienteModelo', 40, 'auth_token', '9ace6c9f5033f193011e0bdbf6aa331af7768d3f28b6299582c519f4c8147c5d', '[\"*\"]', NULL, NULL, '2024-12-19 21:52:41', '2024-12-19 21:52:41'),
(14, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', '2cb88f155ed57ab91d5abeab7a409b2cc3a5aae251b0ec5b5c6342dedc4d0ab6', '[\"*\"]', NULL, NULL, '2024-12-19 21:53:44', '2024-12-19 21:53:44'),
(15, 'App\\Models\\clienteModelo', 41, 'auth_token', '38566f3c3f3baa8ec088594b5420a552f1bb82d4810693cd344864e65408b5c3', '[\"*\"]', NULL, NULL, '2024-12-25 02:00:13', '2024-12-25 02:00:13'),
(16, 'App\\Models\\clienteModelo', 24, 'nombre-del-token', 'e3b7f3da8ff60fd4577b679914c813d2b3e5876155d5177b712bec5b72871baf', '[\"*\"]', NULL, NULL, '2025-01-11 21:52:11', '2025-01-11 21:52:11'),
(17, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', '165e19b8f34b5c29c0a5c4f53d7979b3e432fd0a897a5b15d8def5b0c6406ce2', '[\"*\"]', NULL, NULL, '2025-01-11 22:13:04', '2025-01-11 22:13:04'),
(18, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', 'a93c8a8b6b189708c037c947288a8b3f7ebe665d8f8585805e277688ca25614f', '[\"*\"]', NULL, NULL, '2025-01-11 23:36:26', '2025-01-11 23:36:26'),
(19, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', '7164f2463b6073c71ef7f231f3296cc359a77f62edcb78aa0530420ab5b689f1', '[\"*\"]', NULL, NULL, '2025-02-24 21:30:30', '2025-02-24 21:30:30'),
(20, 'App\\Models\\clienteModelo', 42, 'auth_token', '75557602002e1b50bfd81edc66eefa9c6d5401a49f3632403a2ec2bc803d52ac', '[\"*\"]', NULL, NULL, '2025-02-24 21:44:10', '2025-02-24 21:44:10'),
(21, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'e2d3dbb16a1d24a48f95244bccf1d1962b37aca6d3c93ee316d32afdb15a264c', '[\"*\"]', NULL, NULL, '2025-02-24 22:54:46', '2025-02-24 22:54:46'),
(22, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '489865434ef5945f829c0eb986c1df24be4ef96ae8134d63a5018a554de6393a', '[\"*\"]', NULL, NULL, '2025-02-24 22:55:34', '2025-02-24 22:55:34'),
(23, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', '7fd039527fe89564301dd379b9d23698ed3b28f2446683f77e9a7bc6988224b4', '[\"*\"]', NULL, NULL, '2025-02-24 23:11:43', '2025-02-24 23:11:43'),
(24, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '002e0ddd87ea88ce2fb03b6a146015c60c0192cfb9ddd35dfd40e215085fff0e', '[\"*\"]', NULL, NULL, '2025-02-24 23:12:05', '2025-02-24 23:12:05'),
(25, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '6be9c0291d5e10fb946a3de334c821178e8729f61f46375fc3095cb70400920c', '[\"*\"]', NULL, NULL, '2025-02-24 23:12:18', '2025-02-24 23:12:18'),
(26, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '7970a0dfeaad180dd4ad5f9c5b5559114f8e3cc5956fe159a2112fb416a72302', '[\"*\"]', NULL, NULL, '2025-02-24 23:13:53', '2025-02-24 23:13:53'),
(27, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '92336d0d1a47c2934bbbdde202d142fd2fee60237cbc64a8900c47abcb8b7b18', '[\"*\"]', NULL, NULL, '2025-02-24 23:14:10', '2025-02-24 23:14:10'),
(28, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'ac50d991c0af1790cb369748f58984a80fc3505c1f40e5681eebd31a41674865', '[\"*\"]', NULL, NULL, '2025-02-24 23:18:18', '2025-02-24 23:18:18'),
(29, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '7fea284fc464647b6b7e9f7a255f241779e1cae331865c3ddf671728c5e21979', '[\"*\"]', NULL, NULL, '2025-02-24 23:24:55', '2025-02-24 23:24:55'),
(30, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'bb1e1cb7fdca4d60fdad0981313b53080c7adea2eff77a7f000cea6c9a7ee96b', '[\"*\"]', NULL, NULL, '2025-02-24 23:26:24', '2025-02-24 23:26:24'),
(31, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '01f5e48da029a6cc7f787615bfbda09629ae61d940d367db9d5542e03defcc46', '[\"*\"]', NULL, NULL, '2025-02-24 23:27:56', '2025-02-24 23:27:56'),
(32, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '29e821d02f90d47f8dfe4c28b63047e5a0dd40b447191d5ffcfa7e953020a52a', '[\"*\"]', NULL, NULL, '2025-02-24 23:27:56', '2025-02-24 23:27:56'),
(33, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'e8d679d4f2390a4a32357127ae0c5652d99d1628ee91c253fd45d59b45e32e23', '[\"*\"]', NULL, NULL, '2025-02-24 23:31:33', '2025-02-24 23:31:33'),
(34, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '69a2d123493a0f840ed63c9c32a8278caebf3c0a38e32541b42e01f0f03b81a4', '[\"*\"]', NULL, NULL, '2025-02-24 23:32:00', '2025-02-24 23:32:00'),
(35, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '14a62446f50b8b25060000fd3ed2a973cb80bc1e5efe43cae63b4179b706f993', '[\"*\"]', NULL, NULL, '2025-02-24 23:36:59', '2025-02-24 23:36:59'),
(36, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'e0b58ea498917c3bd1f5993c5fb458a180ecf28ce3fa733f099ab82cdfb4b79d', '[\"*\"]', NULL, NULL, '2025-02-24 23:40:06', '2025-02-24 23:40:06'),
(37, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '9d000334c53a1af392176e86701b0004479d81ea1e8a95b44a1df3a7de890100', '[\"*\"]', NULL, NULL, '2025-02-24 23:47:42', '2025-02-24 23:47:42'),
(38, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '0560bf4b3974330d8345c2eed17596bd57223109678d6fc263ec13196c57bb77', '[\"*\"]', NULL, NULL, '2025-02-25 00:32:14', '2025-02-25 00:32:14'),
(39, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'aca642cc7333a4ac9bfbfb14f4132392cd893ae68c649eeccde3f959ec5692cd', '[\"*\"]', '2025-02-25 01:17:42', NULL, '2025-02-25 00:41:52', '2025-02-25 01:17:42'),
(40, 'App\\Models\\clienteModelo', 43, 'auth_token', 'a4039a9287ea1ef5e18701eb2f2c2510aec5466a21c936fd2e76a36aeb1f436f', '[\"*\"]', NULL, NULL, '2025-02-25 01:00:20', '2025-02-25 01:00:20'),
(41, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'd6e577ae344303b55a4adcb1a459ca73d5de8635c422f56faa365647ac7517b7', '[\"*\"]', NULL, NULL, '2025-02-25 01:18:00', '2025-02-25 01:18:00'),
(42, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'fbc8553eb71d9bc31732d98100d398ff0e8ff8b879e014a33419be30c58d847d', '[\"*\"]', '2025-02-25 01:18:03', NULL, '2025-02-25 01:18:01', '2025-02-25 01:18:03'),
(43, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'ca22d987091d1be792afb87ac2a929f7ebfd67ec086bd8f010cbbddb69e9c35e', '[\"*\"]', '2025-02-25 04:10:22', NULL, '2025-02-25 03:39:29', '2025-02-25 04:10:22'),
(44, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'df57b40b10538fc20dc64fce6dffb7df4d17ef21b31821121740a5fb1d6d5491', '[\"*\"]', NULL, NULL, '2025-03-03 23:09:32', '2025-03-03 23:09:32'),
(45, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '5e26113103e3ceab7ac044c7a1d6298934fd2f1be647e1f4bb52c0d64606c593', '[\"*\"]', '2025-03-03 23:10:10', NULL, '2025-03-03 23:09:34', '2025-03-03 23:10:10'),
(46, 'App\\Models\\clienteModelo', 44, 'auth_token', '14964b5a14d5c942ed0dffee42d49cce5afe89ab3962fadf581372e9a15f323e', '[\"*\"]', NULL, NULL, '2025-03-03 23:15:29', '2025-03-03 23:15:29'),
(47, 'App\\Models\\clienteModelo', 44, 'nombre-del-token', '7151bc98577386cc83175f63dd53cb1c824d80af2e79e2c090108583c880ea04', '[\"*\"]', '2025-03-03 23:30:38', NULL, '2025-03-03 23:15:57', '2025-03-03 23:30:38'),
(48, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'aa99be5ff41e126270b35f9e8959338612aef4171710f5c30afad3695ad3569a', '[\"*\"]', '2025-03-03 23:31:18', NULL, '2025-03-03 23:30:58', '2025-03-03 23:31:18'),
(49, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '16180696e16e57fb9258405061b8408262fa8bacde69d97ff55a2fc5308c0bc6', '[\"*\"]', '2025-03-04 03:17:40', NULL, '2025-03-04 03:14:54', '2025-03-04 03:17:40'),
(50, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', 'f6f3c60bfb09ebbe79cb1c63348bd9d4cd6f76a0ffd72e8ac61125f81d7264d0', '[\"*\"]', '2025-03-04 03:30:59', NULL, '2025-03-04 03:24:08', '2025-03-04 03:30:59'),
(51, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', '2873c3b0aeadd3e5e37602d021ccaa01a860422be3db5230690b8a14fc591069', '[\"*\"]', '2025-03-04 03:45:27', NULL, '2025-03-04 03:31:18', '2025-03-04 03:45:27'),
(52, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '20b09967655a6ef8e52e08ffcda0ce48fe127af009569ea3e6cca9d3af660ae9', '[\"*\"]', '2025-03-04 04:08:00', NULL, '2025-03-04 03:50:32', '2025-03-04 04:08:00'),
(53, 'App\\Models\\clienteModelo', 40, 'auth_token', '59940f412df233597c3c8f2d01d16632e6ff0c4d44a004874885c193dcac5bb2', '[\"*\"]', NULL, NULL, '2025-03-04 03:55:52', '2025-03-04 03:55:52'),
(54, 'App\\Models\\clienteModelo', 40, 'auth_token', '93f5000439d6d984c704c054a76e30873e5381227f999fb9169ee5504f11dca2', '[\"*\"]', NULL, NULL, '2025-03-04 04:03:45', '2025-03-04 04:03:45'),
(55, 'App\\Models\\clienteModelo', 42, 'auth_token', 'f14a163f5777665c0407cdd99bc7a4bfc9b8350e3cc3ac878a4c47e0220addbd', '[\"*\"]', NULL, NULL, '2025-03-04 04:04:08', '2025-03-04 04:04:08'),
(56, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'e9cb40fc31518dcef07aada733daead5b188b00610d2a67b24d9e9fc71f29a4f', '[\"*\"]', '2025-03-04 04:06:24', NULL, '2025-03-04 04:06:22', '2025-03-04 04:06:24'),
(57, 'App\\Models\\clienteModelo', 40, 'nombre-del-token', '231ac6eee606703c44b8f818590ff814277a0516391df65d7d94249da37b20ae', '[\"*\"]', '2025-03-04 04:08:51', NULL, '2025-03-04 04:08:19', '2025-03-04 04:08:51'),
(58, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'a30982688077c7dad2b7d638d05d8f2ccd9cd68b16a840dada9eaba9a3b3cc33', '[\"*\"]', '2025-03-04 07:36:18', NULL, '2025-03-04 07:11:39', '2025-03-04 07:36:18'),
(59, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '4c9259d0ef77f95eae53e70be950bc12d87239772942776c1406845646fdb9d5', '[\"*\"]', '2025-03-04 07:46:52', NULL, '2025-03-04 07:46:26', '2025-03-04 07:46:52'),
(60, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'c44c95684c246b2f7cb6c3d7bd580c0250f05ea5dc36cf5aa39a5c1759761eee', '[\"*\"]', NULL, NULL, '2025-03-06 06:19:51', '2025-03-06 06:19:51'),
(61, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '1a12bf2618d82c77b70a866904e6073e429394f924bad07e0b8ce399e0ae291b', '[\"*\"]', NULL, NULL, '2025-03-06 06:19:53', '2025-03-06 06:19:53'),
(62, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'ed1995ff7130dc698a45df2bc6b1aaecfdc8610d6d580336b8a07aecb6e4e277', '[\"*\"]', NULL, NULL, '2025-03-06 06:19:54', '2025-03-06 06:19:54'),
(63, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'c91a2c0c4e1e767239ccec43e1f6582483b5dd614999cd873c2b4b6224835215', '[\"*\"]', '2025-03-06 06:27:02', NULL, '2025-03-06 06:19:55', '2025-03-06 06:27:02'),
(64, 'App\\Models\\clienteModelo', 7, 'nombre-del-token', 'aafd0ab5ea369cfb2c1023497c0c4dc14987c857475a064c461bfebbb0ceb84b', '[\"*\"]', '2025-03-06 06:45:45', NULL, '2025-03-06 06:34:13', '2025-03-06 06:45:45'),
(65, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'e7c26f1e21ff679fbee9b62daf0dcbd13600e2b59a9d20a0497d38f7641e75d9', '[\"*\"]', '2025-03-06 06:58:49', NULL, '2025-03-06 06:46:17', '2025-03-06 06:58:49'),
(66, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'aa5267f9b64d7219b74fd6a7bad2a83975f7466e7f06e4dc091b240544125892', '[\"*\"]', '2025-03-06 06:59:04', NULL, '2025-03-06 06:59:02', '2025-03-06 06:59:04'),
(67, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '6e05ccb11c4f9dfc59e3a66e86ed7090503a0201286cdbd323133bf81ba49061', '[\"*\"]', '2025-03-06 07:09:20', NULL, '2025-03-06 07:09:17', '2025-03-06 07:09:20'),
(68, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '6cd61534899457364f60ef9d837bc1d353118b020632925bf7c8e3273598cccf', '[\"*\"]', '2025-03-06 08:11:48', NULL, '2025-03-06 07:12:28', '2025-03-06 08:11:48'),
(69, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '846b93aae00e23fe7ed38c6c51dcb3493259cc687c3d51466c08f3a86cc40b28', '[\"*\"]', '2025-03-06 08:15:14', NULL, '2025-03-06 08:15:12', '2025-03-06 08:15:14'),
(70, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'f2c740c9d6b95b82ebe3223a3b77d5794d09c192b944bba69a53e65fc7a2b128', '[\"*\"]', NULL, NULL, '2025-03-06 08:17:36', '2025-03-06 08:17:36'),
(71, 'App\\Models\\clienteModelo', 45, 'auth_token', '3b160f1b6b26eaf8b238da591d81c11a7abd27260334c60a122ee5323b2c7d31', '[\"*\"]', NULL, NULL, '2025-03-06 08:18:07', '2025-03-06 08:18:07'),
(72, 'App\\Models\\clienteModelo', 45, 'nombre-del-token', '5373bf67d99f541ea9fa4ce07cc377ced95146957675321524d604be915c3eb6', '[\"*\"]', '2025-03-06 08:20:45', NULL, '2025-03-06 08:18:22', '2025-03-06 08:20:45'),
(73, 'App\\Models\\clienteModelo', 45, 'nombre-del-token', '170f2e0737872121b47f3a333628babee9aa568d0aee68a03ccd4721f9fb49c0', '[\"*\"]', '2025-03-06 08:23:50', NULL, '2025-03-06 08:21:56', '2025-03-06 08:23:50'),
(74, 'App\\Models\\clienteModelo', 45, 'nombre-del-token', '4548c77a90520f78b888ea690b15779215e88d6bf485ffaf0f02527adb95168d', '[\"*\"]', '2025-03-06 08:24:25', NULL, '2025-03-06 08:24:18', '2025-03-06 08:24:25'),
(75, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '91881f00d82386a67b2e669e24fdf61bd992247c3aa315f5b8f8decee3037e28', '[\"*\"]', '2025-03-09 07:29:44', NULL, '2025-03-09 06:53:08', '2025-03-09 07:29:44'),
(76, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '7286fe8c9eae6d9253d60f3f4b0b21b56e7454a9bb48bc60381b7cded04279d4', '[\"*\"]', '2025-03-09 08:02:16', NULL, '2025-03-09 07:32:18', '2025-03-09 08:02:16'),
(77, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '87f65f9e35f8dd0c31f15109b75f887384df7958509c326d07eab8379a020af1', '[\"*\"]', '2025-03-14 01:36:23', NULL, '2025-03-14 01:36:15', '2025-03-14 01:36:23'),
(78, 'App\\Models\\clienteModelo', 4, 'nombre-del-token', '33dc5175d219995bdb56012cb8701b5f5ef4850f626f132bacd5213c7fedbbc2', '[\"*\"]', '2025-03-15 02:02:20', NULL, '2025-03-15 02:02:14', '2025-03-15 02:02:20'),
(79, 'App\\Models\\clienteModelo', 1, 'nombre-del-token', '3169451623c6c1b877c388b7ab8113607b3757d1846152acae96ec66d15fca44', '[\"*\"]', NULL, NULL, '2025-03-15 02:42:33', '2025-03-15 02:42:33'),
(80, 'App\\Models\\clienteModelo', 46, 'auth_token', '1a864c0a659727359a4bb9588dd9b564fe4e6c4250593ffd281bb39165c2b4a2', '[\"*\"]', NULL, NULL, '2025-03-15 02:57:23', '2025-03-15 02:57:23'),
(81, 'App\\Models\\clienteModelo', 46, 'nombre-del-token', '0c29543632fd17cdf186be7b2a920521f9b31d5d4e64ee6b57c7b4f8f8db4cf4', '[\"*\"]', '2025-03-15 02:58:34', NULL, '2025-03-15 02:57:41', '2025-03-15 02:58:34'),
(82, 'App\\Models\\clienteModelo', 46, 'nombre-del-token', '55f6449f987bdb5177a6fe54f1b40c1061e8f9e6a3f5a9569f9240e0840bce59', '[\"*\"]', '2025-03-15 03:01:57', NULL, '2025-03-15 02:58:52', '2025-03-15 03:01:57'),
(83, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'ad0d983b68856311ea0084078c57a28f66c8f81a2f478686cafb08988718bc70', '[\"*\"]', '2025-03-15 03:02:58', NULL, '2025-03-15 03:02:55', '2025-03-15 03:02:58'),
(84, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '3d02cf615e4e08ab881649a74946ccee34151c9ba53c33dbeaa0efc7ae2e0c44', '[\"*\"]', '2025-03-17 20:02:38', NULL, '2025-03-17 19:57:30', '2025-03-17 20:02:38'),
(85, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'ef9703083f2887b9537d389e31e5d496c29177df06866e246207aca9e529d114', '[\"*\"]', '2025-03-17 20:26:07', NULL, '2025-03-17 20:25:47', '2025-03-17 20:26:07'),
(86, 'App\\Models\\clienteModelo', 44, 'nombre-del-token', 'd84e49849850f8e2303b36d4e9acd9945e86041c6e4a7f961faf1f7124309158', '[\"*\"]', '2025-03-17 20:38:25', NULL, '2025-03-17 20:31:03', '2025-03-17 20:38:25'),
(87, 'App\\Models\\clienteModelo', 44, 'nombre-del-token', '9cf4feecd2285a4e1148b761847fb9096beb8266256af92d3d0f5fd5bd521ff7', '[\"*\"]', '2025-03-17 21:14:06', NULL, '2025-03-17 20:39:06', '2025-03-17 21:14:06'),
(88, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '9b8da267e92590364fdd8e3ddfd5bd7984d4822e66f71869394331526cd781ef', '[\"*\"]', '2025-03-17 21:22:00', NULL, '2025-03-17 21:16:01', '2025-03-17 21:22:00'),
(89, 'App\\Models\\clienteModelo', 47, 'auth_token', 'afb58c5e053d3074e74b5728710c41eea7672d993989291ff6d5b77000ef3f1a', '[\"*\"]', NULL, NULL, '2025-03-17 21:40:33', '2025-03-17 21:40:33'),
(90, 'App\\Models\\clienteModelo', 47, 'nombre-del-token', 'd47b3b0e41fb8e49bcb7de7dfae547801fe2555e53c74376b534b20c75ea61c2', '[\"*\"]', '2025-03-17 21:41:26', NULL, '2025-03-17 21:40:44', '2025-03-17 21:41:26'),
(91, 'App\\Models\\clienteModelo', 44, 'nombre-del-token', 'ca384a7ae37bc2a1b91a1fc283835cf5d388b5b8752cc3ec06e95908c0589aa1', '[\"*\"]', '2025-03-25 04:59:07', NULL, '2025-03-25 04:45:38', '2025-03-25 04:59:07'),
(92, 'App\\Models\\clienteModelo', 48, 'auth_token', '4c37544737cfbc0b13db337a0a8226e690d7681c278b7d67b5ab6d0ffeea9f79', '[\"*\"]', NULL, NULL, '2025-04-06 08:23:08', '2025-04-06 08:23:08'),
(93, 'App\\Models\\clienteModelo', 48, 'nombre-del-token', '69be2240cd9dfe3390dc2d87fbccb1d2c6cf7f743e2c447e739e24b6d8ca1fd4', '[\"*\"]', '2025-04-06 08:24:25', NULL, '2025-04-06 08:24:06', '2025-04-06 08:24:25'),
(94, 'App\\Models\\clienteModelo', 48, 'nombre-del-token', '535246c4441be3b4ca5f3ab1628604ffcdff81bf7efa30fa21b1b1b59be98f49', '[\"*\"]', '2025-04-06 08:48:15', NULL, '2025-04-06 08:24:37', '2025-04-06 08:48:15'),
(95, 'App\\Models\\clienteModelo', 48, 'nombre-del-token', 'c8699e4782b7dbf476ed25da5c0294803c8e4fbcdc8beefb8834e8ab148cd48d', '[\"*\"]', '2025-04-06 08:52:44', NULL, '2025-04-06 08:52:34', '2025-04-06 08:52:44'),
(96, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'a007bea87cbd8c184bbe0818d8b2f9bc595f5e550919ddb737f88dfaa6d1e019', '[\"*\"]', '2025-04-06 09:01:30', NULL, '2025-04-06 08:53:22', '2025-04-06 09:01:30'),
(97, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'ecdb9d13a2e2b7afa189539fa22aad089ba4ea47f4c24ec31432b1ed37e03c67', '[\"*\"]', '2025-04-06 09:02:31', NULL, '2025-04-06 09:01:57', '2025-04-06 09:02:31'),
(98, 'App\\Models\\clienteModelo', 48, 'nombre-del-token', 'a76e9c75d512ba010b9cf0aac70e2cae388e881804dfe5e17ed872c16ac2e155', '[\"*\"]', '2025-04-06 09:18:05', NULL, '2025-04-06 09:03:33', '2025-04-06 09:18:05'),
(99, 'App\\Models\\clienteModelo', 47, 'nombre-del-token', 'f3ec249cc1768224943859fe0d3a75866d1751958b53160b5be40cc5ff4caf11', '[\"*\"]', '2025-04-06 09:56:48', NULL, '2025-04-06 09:19:24', '2025-04-06 09:56:48'),
(100, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'a7aa0ef5f235696b6d9a25ef79549468b6a6e96aba82a25d64073039a3616df7', '[\"*\"]', '2025-04-06 09:57:59', NULL, '2025-04-06 09:57:41', '2025-04-06 09:57:59'),
(101, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '2a0c81c33a5e2a817bebae68040dbb7fd74cd962240b9a692dbf64ffd0eaa4ea', '[\"*\"]', '2025-04-06 10:00:16', NULL, '2025-04-06 09:58:34', '2025-04-06 10:00:16'),
(102, 'App\\Models\\clienteModelo', 38, 'nombre-del-token', '72032542b3390f50e4fe042e66543bf638bc4b32ac326f03471448b46554aef5', '[\"*\"]', '2025-04-06 20:48:46', NULL, '2025-04-06 20:11:37', '2025-04-06 20:48:46'),
(103, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'c0af5c8d264d51522a516e704d71c70ec1fad8f7dd20ce6c18bbe95331d1b6bd', '[\"*\"]', '2025-04-09 00:36:24', NULL, '2025-04-09 00:36:12', '2025-04-09 00:36:24'),
(104, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '52a89fb5e700d0ea23107265231f61674c99ede45ec68a6ebb98478a146ae14f', '[\"*\"]', NULL, NULL, '2025-04-10 00:18:44', '2025-04-10 00:18:44'),
(105, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'e9416a0bb2b8a1a2b7488baedebaecd84646edae65a1a9259d37d1a3369ca618', '[\"*\"]', NULL, NULL, '2025-04-10 00:20:46', '2025-04-10 00:20:46'),
(106, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '648b40e5a0926facedd3f1c29a157acfc4668d05e9b796845508119e7434b405', '[\"*\"]', NULL, NULL, '2025-04-10 00:25:07', '2025-04-10 00:25:07'),
(107, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '91675e9d03c3ee3d9185d012dd06e564eaa46c58253ea19246d6e670144172c2', '[\"*\"]', NULL, NULL, '2025-04-10 00:26:35', '2025-04-10 00:26:35'),
(108, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'd95feba49015bd9b4cd0b727cdfa0336fa8644c8d12a25d80af254c2cfd1cf09', '[\"*\"]', NULL, NULL, '2025-04-10 00:27:09', '2025-04-10 00:27:09'),
(109, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '5060e4e613a7dff81bec430a9c7a97716919a5f582d6eb15b92d03fe75939e4e', '[\"*\"]', NULL, NULL, '2025-04-10 00:30:06', '2025-04-10 00:30:06'),
(110, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '13877ac86bcf7e4e6c0c35f182585077c02046a2af7c81f92c4d2694324502f4', '[\"*\"]', NULL, NULL, '2025-04-10 00:33:14', '2025-04-10 00:33:14'),
(111, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'fb7ddd8fd6f10639a4deb79f6cdcea11c5881fa115074d4bd43c11f0025dc10f', '[\"*\"]', NULL, NULL, '2025-04-10 00:39:58', '2025-04-10 00:39:58'),
(112, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '6362d752d0aa541786e105efea6289e8c4e4701ad135cad36c1f00d795401638', '[\"*\"]', NULL, NULL, '2025-04-10 00:41:15', '2025-04-10 00:41:15'),
(113, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '318d3b32cfb254c17924d1f32d33d94771fc7cce6017838bf58da1ea43044bfa', '[\"*\"]', NULL, NULL, '2025-04-10 00:48:09', '2025-04-10 00:48:09'),
(114, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '3fcba7c3678fcbc30bbb2e34c610898bcfeeb539be1f1b23363255c73ac15a9c', '[\"*\"]', NULL, NULL, '2025-04-10 00:50:17', '2025-04-10 00:50:17'),
(115, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '9061b1ef43a788b248699eff38ddbd99006a5ad0b30aaa15ca69c90e1e4e6cb0', '[\"*\"]', NULL, NULL, '2025-04-10 00:51:50', '2025-04-10 00:51:50'),
(116, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '8e198d730726429e80b18a59b9b7c8b8ac59c98158910df0829e22a838c56fb7', '[\"*\"]', NULL, NULL, '2025-04-10 00:56:50', '2025-04-10 00:56:50'),
(117, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', 'f1ed42cd84520f78ffd6deb2230a286b5e22f2751a6331d4ea2637a923f00b46', '[\"*\"]', NULL, NULL, '2025-04-10 00:57:43', '2025-04-10 00:57:43'),
(118, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '75597d28afc75a010303b56cdfba5840b83d26b74dc9e5e8a1507446bbeed176', '[\"*\"]', NULL, NULL, '2025-04-10 01:03:52', '2025-04-10 01:03:52'),
(119, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '4f1045d21861b026c50ada8eb5a2c67703767d171b4d402749ab951af0ff0327', '[\"*\"]', NULL, NULL, '2025-04-10 01:05:17', '2025-04-10 01:05:17'),
(120, 'App\\Models\\clienteModelo', 42, 'nombre-del-token', '277080db3a90157e8c8486edebb11fb374ac36f204a8b3bef322ee598cae85c0', '[\"*\"]', NULL, NULL, '2025-04-10 01:06:23', '2025-04-10 01:06:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `idPrestamo` int(5) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tiempodeuso` int(10) NOT NULL,
  `reserva` int(2) NOT NULL,
  `id_cliente` int(5) NOT NULL,
  `id_consola` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`idPrestamo`, `fecha`, `hora`, `tiempodeuso`, `reserva`, `id_cliente`, `id_consola`) VALUES
(1, '2024-08-18', '13:30:00', 120, 1, 3, 3),
(2, '2024-08-19', '14:10:00', 60, 1, 1, 3),
(3, '2024-07-19', '16:50:00', 90, 0, 2, 2),
(4, '2024-07-19', '12:00:00', 120, 0, 4, 5),
(5, '2024-07-19', '14:00:00', 120, 1, 5, 4),
(6, '2024-07-19', '16:00:00', 30, 1, 6, 7),
(7, '2024-07-19', '17:00:00', 90, 1, 7, 6),
(8, '2024-07-21', '18:00:00', 120, 0, 8, 9),
(9, '2024-07-31', '12:30:00', 30, 0, 9, 8),
(19, '2024-12-20', '12:30:00', 120, 1, 50, 6),
(20, '2024-12-19', '13:30:00', 120, 1, 50, 1),
(23, '2024-12-19', '13:30:00', 60, 1, 50, 8),
(24, '2024-12-24', '17:00:00', 180, 1, 41, 10),
(25, '2025-01-11', '12:00:00', 90, 1, 24, 1),
(26, '2025-02-26', '12:30:00', 180, 1, 50, 12),
(28, '2025-03-06', '16:30:00', 60, 1, 42, 7),
(29, '2025-02-24', '17:00:00', 60, 0, 42, 6),
(30, '2025-03-08', '12:30:00', 180, 1, 42, 7),
(31, '2025-02-26', '18:00:00', 120, 0, 42, 6),
(32, '2025-03-03', '12:00:00', 90, 1, 44, 10),
(33, '2025-03-06', '17:30:00', 180, 1, 43, 6),
(35, '2025-03-10', '12:00:00', 60, 0, 42, 13),
(37, '2025-03-10', '14:00:00', 60, 0, 42, 13),
(38, '2025-03-10', '15:00:00', 30, 0, 42, 13),
(45, '2025-03-19', '12:00:00', 120, 0, 42, 13),
(46, '2025-03-17', '12:00:00', 120, 0, 42, 13),
(47, '2025-03-18', '10:30:00', 120, 0, 42, 12),
(48, '2025-03-17', '14:30:00', 60, 0, 44, 13),
(53, '2025-03-17', '11:00:00', 90, 0, 44, 11),
(55, '2025-03-17', '10:00:00', 180, 0, 44, 2),
(56, '2025-03-18', '11:00:00', 120, 0, 44, 3),
(57, '2025-03-17', '11:00:00', 180, 0, 44, 1),
(59, '2025-03-19', '11:00:00', 60, 0, 42, 5),
(60, '2025-03-17', '14:00:00', 180, 0, 42, 12),
(61, '2025-03-19', '12:00:00', 180, 0, 42, 12),
(62, '2025-03-19', '14:00:00', 180, 0, 50, 1),
(63, '2025-03-24', '18:00:00', 60, 0, 44, 13),
(64, '2025-03-24', '20:27:00', 30, 1, 50, 9),
(66, '2025-04-06', '12:00:00', 90, 1, 42, 13),
(68, '2025-04-06', '11:00:00', 30, 1, 42, 13),
(69, '2025-04-06', '10:00:00', 30, 1, 38, 2),
(70, '2025-04-06', '10:00:00', 30, 1, 38, 3),
(71, '2025-04-06', '11:00:00', 90, 1, 38, 12),
(72, '2025-04-06', '14:00:00', 60, 1, 38, 8),
(73, '2025-04-08', '14:30:00', 30, 1, 42, 8),
(75, '2025-04-09', '18:00:00', 60, 0, 10, 12),
(76, '2025-04-11', '21:20:00', 30, 0, 10, 11);

--
-- Disparadores `prestamo`
--
DELIMITER $$
CREATE TRIGGER `after_insert_prestamo` AFTER INSERT ON `prestamo` FOR EACH ROW BEGIN
    DECLARE minutos INT;
    DECLARE precio INT;
    DECLARE tipoConsola VARCHAR(10);

    -- Obtener el tipo de consola
    SELECT tipo INTO tipoConsola FROM consola WHERE id = NEW.id_consola;

    -- Convertir tiempo de uso a número
    SET minutos = CAST(NEW.tiempodeuso AS UNSIGNED);

    -- Determinar el precio según el tipo de consola y tiempo de uso
    IF tipoConsola = '360' THEN
        CASE 
            WHEN minutos <= 30 THEN SET precio = 1500;
            WHEN minutos <= 60 THEN SET precio = 2500;
            WHEN minutos <= 90 THEN SET precio = 3000;
            WHEN minutos <= 120 THEN SET precio = 5000;
            WHEN minutos <= 180 THEN SET precio = 7500;
            ELSE 
                SET precio = (FLOOR(minutos / 180) * 7500) + 
                             CASE 
                                 WHEN minutos % 180 <= 30 THEN 1500
                                 WHEN minutos % 180 <= 60 THEN 2500
                                 WHEN minutos % 180 <= 90 THEN 3000
                                 WHEN minutos % 180 <= 120 THEN 5000
                                 ELSE 7500
                             END;
        END CASE;
    ELSEIF tipoConsola = 'one' THEN
        CASE 
            WHEN minutos <= 30 THEN SET precio = 1500;
            WHEN minutos <= 60 THEN SET precio = 3000;
            WHEN minutos <= 90 THEN SET precio = 3500;
            WHEN minutos <= 120 THEN SET precio = 5500;
            WHEN minutos <= 180 THEN SET precio = 8500;
            ELSE 
                SET precio = (FLOOR(minutos / 180) * 8500) + 
                             CASE 
                                 WHEN minutos % 180 <= 30 THEN 1500
                                 WHEN minutos % 180 <= 60 THEN 3000
                                 WHEN minutos % 180 <= 90 THEN 3500
                                 WHEN minutos % 180 <= 120 THEN 5500
                                 ELSE 8500
                             END;
        END CASE;
    ELSE
        SET precio = 0; -- Si el tipo de consola no coincide
    END IF;

    -- Insertar el registro en la tabla venta con la fecha del préstamo
    INSERT INTO venta (id_prestamo, fecha, monto)
    VALUES (NEW.idPrestamo, NEW.fecha, precio);
END
$$
DELIMITER ;

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
(2, '2024-08-19', 6000, 2),
(3, '2024-07-19', 2500, 3),
(4, '2024-07-19', 2500, 4),
(5, '2024-07-19', 6000, 5),
(6, '2024-07-19', 2500, 6),
(7, '2024-07-19', 3000, 7),
(8, '2024-07-21', 9000, 8),
(9, '2024-07-21', 2500, 9),
(19, '2025-03-17', 2500, 59),
(20, '2025-03-17', 8500, 60),
(21, '2025-03-17', 8500, 61),
(22, '2025-03-19', 7500, 62),
(23, '2025-03-24', 3000, 63),
(24, '2025-03-24', 1500, 64),
(26, '2025-04-06', 8500, 66),
(28, '2025-04-06', 1500, 68),
(29, '2025-04-06', 1500, 69),
(30, '2025-04-06', 1500, 70),
(31, '2025-04-06', 3500, 71),
(32, '2025-04-06', 2500, 72),
(33, '2025-04-08', 1500, 73),
(34, '2025-04-09', 3000, 75),
(35, '2025-04-11', 1500, 76);

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
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mantenimiento_consola` (`id_consola`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_fecha_programada` (`fecha_programada`);

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
  MODIFY `idCliente` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `consola`
--
ALTER TABLE `consola`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `idPrestamo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
  ADD CONSTRAINT `fk_prestamo_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE,
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
