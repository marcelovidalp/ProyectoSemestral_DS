-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 12-11-2024 a las 02:49:13
-- Versión del servidor: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `A2023_marcelo_vidal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dw2_agentes`
--

CREATE TABLE `dw2_agentes` (
  `id_agentes` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dw2_agentes`
--

INSERT INTO `dw2_agentes` (`id_agentes`, `nombre`, `rol`) VALUES
(1, 'Brimstone', 'Controlador'),
(2, 'Brimstone', 'Controlador'),
(3, 'Phoenix', 'Duelista'),
(4, 'Sage', 'Centinela'),
(5, 'Sova', 'Iniciador'),
(6, 'Viper', 'Controlador'),
(7, 'Cypher', 'Centinela'),
(8, 'Reyna', 'Duelista'),
(9, 'Killjoy', 'Centinela'),
(10, 'Breach', 'Iniciador'),
(11, 'Omen', 'Controlador'),
(12, 'Jett', 'Duelista'),
(13, 'Raze', 'Duelista'),
(14, 'Skye', 'Iniciador'),
(15, 'Yoru', 'Duelista'),
(16, 'Astra', 'Controlador'),
(17, 'Kay/o', 'Iniciador'),
(18, 'Chamber', 'Centinela'),
(19, 'Neon', 'Duelista'),
(20, 'Fade', 'Iniciador'),
(21, 'Harbor', 'Controlador'),
(22, 'Gekko', 'Iniciador'),
(23, 'Deadlock', 'Centinela'),
(24, 'Iso', 'Duelista'),
(25, 'Clove', 'Controlador'),
(26, 'Vyse', 'Centinela');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dw2_juegos`
--

CREATE TABLE `dw2_juegos` (
  `id_juegos` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dw2_juegos`
--

INSERT INTO `dw2_juegos` (`id_juegos`, `nombre`) VALUES
(1, 'Valorant'),
(2, 'Counter-Strike 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dw2_mapas`
--

CREATE TABLE `dw2_mapas` (
  `id_mapas` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `id_juego` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dw2_mapas`
--

INSERT INTO `dw2_mapas` (`id_mapas`, `nombre`, `id_juego`) VALUES
(1, 'Bind', 1),
(2, 'Icebox', 1),
(3, 'Ascent', 1),
(4, 'Lotus', 1),
(5, 'Abyss', 1),
(6, 'Sunset', 1),
(7, 'Pearl', 1),
(8, 'Fracture', 1),
(9, 'Haven', 1),
(10, 'Split', 1),
(11, 'Breeze', 1),
(12, 'Ancient', 2),
(13, 'Anubis', 2),
(14, 'Inferno', 2),
(15, 'Mirage', 2),
(16, 'Nuke', 2),
(17, 'Overpass', 2),
(18, 'Vertigo', 2),
(19, 'Dust 2', 2),
(20, 'Italy', 2),
(21, 'Office', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dw2_partidas`
--

CREATE TABLE `dw2_partidas` (
  `id_partidas` int(11) NOT NULL,
  `resultado` tinyint(1) NOT NULL,
  `asesinatos` int(11) NOT NULL,
  `muertes` int(11) NOT NULL,
  `asistencias` int(11) NOT NULL,
  `id_mapa` int(11) DEFAULT NULL,
  `id_agente` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_juego` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dw2_partidas`
--

INSERT INTO `dw2_partidas` (`id_partidas`, `resultado`, `asesinatos`, `muertes`, `asistencias`, `id_mapa`, `id_agente`, `id_user`, `id_juego`) VALUES
(1, 1, 14, 7, 2, 7, 13, 1, 1),
(2, 0, 18, 9, 3, 6, 15, 1, 1),
(3, 1, 12, 32, 5, 10, 5, 2, 1),
(4, 1, 12, 32, 5, 10, 5, 2, 1),
(5, 1, 21, 34, 4, 12, NULL, 2, 2),
(6, 0, 2, 1, 2, 5, 9, 3, 1),
(7, 1, 2, 2, 3, 2, 3, 3, 1),
(8, 0, 3, 3, 3, 15, NULL, 3, 2),
(9, 1, 12, 2, 3, 6, 16, 1, 1),
(10, 1, 14, 3, 2, 16, NULL, 1, 2),
(11, 1, 12, 3, 2, 20, NULL, 1, 2),
(12, 1, 123, 15, 15, 13, NULL, 7, 2),
(13, 1, 123, 15, 15, 13, NULL, 7, 2),
(14, 1, 123, 15, 15, 13, NULL, 7, 2),
(15, 1, 123, 15, 15, 13, NULL, 7, 2),
(16, 1, 123, 15, 15, 13, NULL, 7, 2),
(17, 1, 13, 2, 3, 1, 1, 8, 1),
(18, 1, 18, 5, 3, 5, 5, 8, 1),
(19, 1, 432, 234, 12, 1, 1, 8, 1),
(20, 1, 123, 21, 1, 19, NULL, 8, 2),
(21, 1, 534, 53, 534, 9, 18, 11, 1),
(22, 1, 14, 12, 14, 14, NULL, 19, 2),
(23, 1, 14, 12, 14, 14, NULL, 19, 2),
(24, 0, 13, 2, 3, 15, NULL, 19, 2),
(25, 1, 12, 32, 12, 19, NULL, 19, 2),
(26, 0, 12, 23, 4, 15, NULL, 19, 2),
(27, 1, 12, 12, 12, 18, NULL, 19, 2),
(28, 1, 12, 12, 12, 18, NULL, 19, 2),
(29, 1, 12, 2, 3, 13, NULL, 19, 2),
(30, 1, 16, 4, 2, 20, NULL, 19, 2),
(31, 0, 15, 5, 3, 19, NULL, 19, 2),
(32, 1, 15, 13, 3, 16, NULL, 19, 2),
(33, 1, 123, 123, 123, 13, NULL, 19, 2),
(34, 1, 14, 12, 1, 20, NULL, 19, 2),
(35, 1, 13, 12, 1, 17, NULL, 19, 2),
(36, 1, 13, 12, 1, 17, NULL, 19, 2),
(37, 0, 21, 2, 1, 17, NULL, 19, 2),
(38, 0, 12, 12, 1, 18, NULL, 19, 2),
(39, 1, 12, 12, 2, 15, NULL, 19, 2),
(40, 0, 13, 12, 2, 19, NULL, 19, 2),
(41, 1, 14, 12, 2, 21, NULL, 19, 2),
(42, 1, 1, 1, 1, 19, NULL, 19, 2),
(43, 0, 14, 12, 3, 18, NULL, 19, 2),
(44, 0, 12, 12, 12, 19, NULL, 19, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dw2_users`
--

CREATE TABLE `dw2_users` (
  `id_users` int(4) NOT NULL,
  `username` varchar(20) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dw2_users`
--

INSERT INTO `dw2_users` (`id_users`, `username`, `passwd`, `correo`) VALUES
(1, 'yo', '$2y$10$95i1vre9s77qocF1g9U9ROa9k13Cg5Jd/ueQOuTuSXKEBUFDJBeki', 'yo@yo.cl'),
(2, 'marcelovidalp', '$2y$10$oJrTlO/D7XkNa9tvjW3NfOr2hq/pk7ViQ.jqK8vjIWV7vzUU0HxWi', 'marcelo.vidal2023@alu.uct.cl'),
(3, 'mvalveal', '$2y$10$K8RJ2LxdpXTYtRaTPl7deeElZo7AYfG2v/T2WYYtv7fycnxgvuyg.', 'mvalveal@correofalso.cl'),
(4, 'Fabo01', '$2y$10$13HEIC0S18gCEdtuu8o6kO87cCjLE/fJ.AFqi8lEs3d5hO7BsASra', 'fabon.gv@gmail.com'),
(5, 'yo', '$2y$10$A6V1nGgXTKHNhgppFkxfQezLSLlozn4UV6pMeBbWvIIG7QH6YrMYu', 'yo@yo.cl'),
(6, 'yo', '$2y$10$docjfESfBasJAFcuoEGARe7ecln9WM4tWcjUV/CTDJwbcqbwQxfIO', 'yo@yo.cl'),
(7, 'lilG', '$2y$10$oUTItox6bPCZUmhSmXfAaucToWXZVtcMTyZAHNALzthHJKndlBYlu', 'lilG@gmail.com'),
(8, 'el', '$2y$10$9hNjJFEyHThmEjvOIAppuelFUWma2Cg5dP7O9wTsNKu1KTOHnhVOO', 'el@el.cl'),
(9, 'lol', '$2y$10$zxyW..pWwJ37QZpzIUpEmOSypRIOI24kNA1KEvttiBCzmgU32b0V2', 'lol@lol.com'),
(10, 'lol', '$2y$10$de3wli1MV9JR9pmwKkZ3oeM.yb7sYcxklzXxa57TVpvK7Wy.UsNRG', 'lol@lol.com'),
(11, 'peo', '$2y$10$mJJnmAv0ZcaArUa6meDlZeqBUVDho8ZVx7k2MTPE5ueEzZNvZaE/S', 'peo@peo.cl'),
(12, 'marciano', '$2y$10$mv1oilS9bVGaUgpYvcDlNeC0ErlcBb4YqNSNxvrqJzdyPoR8YPini', 'marciano@123.cl'),
(13, 'marciano', '$2y$10$jWkqisp6AjRGN1Ofw./G2uzeI/4JKLZ4kbAoe5XXggUqMZlPEvT.C', 'mar@ciano.cl'),
(14, 'marciano', '$2y$10$PuqQoKUxtIaHPlixNFTduOxcf0Mj9l8Jb/AgaN3cE3sgkvV9aaMIi', 'mar@ciano.cl'),
(15, 'marciano', '$2y$10$fwsqfBB2M/YECBOLA2KCm.hhimGgaI1qIYMtgAf49txU2fZtVP2om', 'mar@cia.no'),
(16, 'marciano', '$2y$10$VV2rHA9cGNUJMsqTjPEDVuTkp1okB78b4XKLzOPbAz9ugvqzB06i6', 'mar@ci.ano'),
(17, 'marciano', '$2y$10$8QfzwGsx.pF8HKdyN1sGsupPbvL4TWpCTTh7xtWOhe4RGmfNZt8AO', 'mar@ciano.cl'),
(18, 'maciano', '$2y$10$7JBWcJv2BQCZEfOpdQIGL.iYpwTux5nv4./frW3m.aXqs7Jbxwe7G', 'mar@ciano.cl'),
(19, 'manzanita', '$2y$10$pAa/o1RI5N05rkUCafQPzODVEzssFI3fUmMNcTvBNEvKcq.sZs6Q.', 'manzana@1.cl');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dw2_agentes`
--
ALTER TABLE `dw2_agentes`
  ADD PRIMARY KEY (`id_agentes`);

--
-- Indices de la tabla `dw2_juegos`
--
ALTER TABLE `dw2_juegos`
  ADD PRIMARY KEY (`id_juegos`);

--
-- Indices de la tabla `dw2_mapas`
--
ALTER TABLE `dw2_mapas`
  ADD PRIMARY KEY (`id_mapas`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indices de la tabla `dw2_partidas`
--
ALTER TABLE `dw2_partidas`
  ADD PRIMARY KEY (`id_partidas`),
  ADD KEY `id_mapa` (`id_mapa`),
  ADD KEY `id_agente` (`id_agente`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indices de la tabla `dw2_users`
--
ALTER TABLE `dw2_users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dw2_agentes`
--
ALTER TABLE `dw2_agentes`
  MODIFY `id_agentes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `dw2_juegos`
--
ALTER TABLE `dw2_juegos`
  MODIFY `id_juegos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dw2_mapas`
--
ALTER TABLE `dw2_mapas`
  MODIFY `id_mapas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `dw2_partidas`
--
ALTER TABLE `dw2_partidas`
  MODIFY `id_partidas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `dw2_users`
--
ALTER TABLE `dw2_users`
  MODIFY `id_users` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dw2_mapas`
--
ALTER TABLE `dw2_mapas`
  ADD CONSTRAINT `dw2_mapas_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `dw2_juegos` (`id_juegos`);

--
-- Filtros para la tabla `dw2_partidas`
--
ALTER TABLE `dw2_partidas`
  ADD CONSTRAINT `dw2_partidas_ibfk_1` FOREIGN KEY (`id_mapa`) REFERENCES `dw2_mapas` (`id_mapas`),
  ADD CONSTRAINT `dw2_partidas_ibfk_2` FOREIGN KEY (`id_agente`) REFERENCES `dw2_agentes` (`id_agentes`),
  ADD CONSTRAINT `dw2_partidas_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `dw2_users` (`id_users`),
  ADD CONSTRAINT `dw2_partidas_ibfk_4` FOREIGN KEY (`id_juego`) REFERENCES `dw2_juegos` (`id_juegos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
