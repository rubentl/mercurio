-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-01-2018 a las 17:23:09
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor_avisosintranet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `grupo` varchar(127) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `grupo`) VALUES
(1, 'Mañana'),
(3, 'Noche'),
(2, 'Tarde');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `id_origen` int(11) DEFAULT NULL,
  `contenido` text CHARACTER SET latin1,
  `fecha` datetime DEFAULT NULL,
  `prioridad` varchar(127) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id_mensaje`, `id_origen`, `contenido`, `fecha`, `prioridad`) VALUES
(1, 1, 'pepe, intenta terminar el informe', '2018-01-19 15:03:10', 'Normal'),
(2, 2, 'Estoy terminándolo', '2018-01-19 15:05:11', 'Normal'),
(3, 3, 'Gracias por recomendarme', '2018-01-22 15:37:12', 'Baja'),
(5, 1, 'El viernes no hay reunión de desarrolo', '2018-01-22 15:45:51', 'Urgente'),
(6, 1, 'hola Julian, Bienvenido', '2018-01-23 17:23:37', 'Normal'),
(7, 1, 'La semana que viene las sesiones de tarde terminará media hora antes.', '2018-01-23 17:27:43', 'Urgente'),
(8, 2, 'Hola Julian', '2018-01-24 15:52:08', 'Baja'),
(9, 2, 'Hola soy pepe', '2018-01-24 17:07:25', 'Urgente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participan`
--

CREATE TABLE `participan` (
  `id_usuario` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `participan`
--

INSERT INTO `participan` (`id_usuario`, `id_grupo`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridades`
--

CREATE TABLE `prioridades` (
  `prioridad` varchar(127) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prioridades`
--

INSERT INTO `prioridades` (`prioridad`) VALUES
('Baja'),
('Normal'),
('Urgente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reciben`
--

CREATE TABLE `reciben` (
  `id_usuario` int(11) NOT NULL,
  `id_mensaje` int(11) NOT NULL,
  `fecha_recibido` datetime DEFAULT NULL,
  `fecha_leido` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reciben`
--

INSERT INTO `reciben` (`id_usuario`, `id_mensaje`, `fecha_recibido`, `fecha_leido`) VALUES
(1, 2, '2018-01-22 14:57:35', '2018-01-22 15:04:34'),
(1, 5, '2018-01-22 15:47:17', '2018-01-22 15:47:47'),
(1, 9, '2018-01-24 17:08:13', '2018-01-24 17:08:33'),
(2, 1, '2018-01-22 15:37:50', '2018-01-22 15:03:50'),
(2, 3, '2018-01-22 15:43:12', '2018-01-22 15:40:03'),
(2, 5, '2018-01-22 15:48:16', '2018-01-22 15:56:21'),
(2, 7, '2018-01-23 17:29:07', '2018-01-23 17:29:16'),
(3, 5, '2018-01-22 15:56:49', '2018-01-22 15:56:59'),
(3, 6, '2018-01-23 17:24:22', '2018-01-23 17:24:32'),
(3, 7, '2018-01-23 17:28:37', '2018-01-23 17:28:45'),
(3, 8, '2018-01-24 15:52:39', '2018-01-24 15:52:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rol` varchar(15) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol`) VALUES
('admin'),
('user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `login` varchar(127) CHARACTER SET latin1 DEFAULT NULL,
  `passwd` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(127) CHARACTER SET latin1 DEFAULT NULL,
  `nombre` varchar(127) CHARACTER SET latin1 DEFAULT NULL,
  `rol` varchar(15) CHARACTER SET latin1 DEFAULT 'user',
  `activo` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `login`, `passwd`, `email`, `nombre`, `rol`, `activo`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'pol@gmail.com', 'Rubén', 'admin', 1),
(2, 'pepe', '926e27eecdbc7a18858b3798ba99bddd', 'pepe@email.net', 'Pepón', 'user', 1),
(3, 'julian', '338c23e8eafc19ec9236404deac0bef4', 'pol@gmail.com', 'Julian', 'user', 1),
(4, NULL, NULL, 'andresdelcastillo@mail.cat', 'Andrés', 'user', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`),
  ADD UNIQUE KEY `grupo` (`grupo`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_origen` (`id_origen`),
  ADD KEY `prioridad` (`prioridad`);

--
-- Indices de la tabla `participan`
--
ALTER TABLE `participan`
  ADD PRIMARY KEY (`id_usuario`,`id_grupo`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `prioridades`
--
ALTER TABLE `prioridades`
  ADD PRIMARY KEY (`prioridad`);

--
-- Indices de la tabla `reciben`
--
ALTER TABLE `reciben`
  ADD PRIMARY KEY (`id_usuario`,`id_mensaje`),
  ADD KEY `id_mensaje` (`id_mensaje`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_origen`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`prioridad`) REFERENCES `prioridades` (`prioridad`);

--
-- Filtros para la tabla `participan`
--
ALTER TABLE `participan`
  ADD CONSTRAINT `participan_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `participan_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `reciben`
--
ALTER TABLE `reciben`
  ADD CONSTRAINT `reciben_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reciben_ibfk_2` FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id_mensaje`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`rol`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
