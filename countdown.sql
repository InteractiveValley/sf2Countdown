-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-02-2015 a las 23:58:57
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `countdown`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `created_at`, `slug`, `position`, `is_active`) VALUES
(6, 'Categoria 1', '2015-01-24 23:52:28', 'categoria-1', 1, 1),
(7, 'Categoria 2', '2015-01-24 23:52:28', 'categoria-2', 3, 1),
(8, 'Categoria 3', '2015-01-24 23:52:28', 'categoria-3', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE IF NOT EXISTS `configuraciones` (
`id` int(11) NOT NULL,
  `configuracion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_archivo` int(11) NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci,
  `is_active` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_venta`
--

CREATE TABLE IF NOT EXISTS `detalles_venta` (
`id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `iva` decimal(10,0) NOT NULL,
  `importe` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DetVenta`
--

CREATE TABLE IF NOT EXISTS `DetVenta` (
`id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `iva` decimal(10,0) NOT NULL,
  `importeIva` decimal(10,0) NOT NULL,
  `importe` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Direccion`
--

CREATE TABLE IF NOT EXISTS `Direccion` (
`id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `tipoDireccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `calle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numExterior` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numInterior` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cp` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `municipio` int(11) NOT NULL,
  `colonia` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `contacto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paqueteria` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE IF NOT EXISTS `direcciones` (
`id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo_direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `calle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_exterior` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_interior` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cp` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `municipio` int(11) NOT NULL,
  `colonia` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `contacto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paqueteria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Envio`
--

CREATE TABLE IF NOT EXISTS `Envio` (
`id` int(11) NOT NULL,
  `venta` int(11) NOT NULL,
  `direccion` int(11) NOT NULL,
  `numeroGuia` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE IF NOT EXISTS `envios` (
`id` int(11) NOT NULL,
  `venta` int(11) NOT NULL,
  `direccion` int(11) NOT NULL,
  `numero_guia` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galerias`
--

CREATE TABLE IF NOT EXISTS `galerias` (
`id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archivo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_archivo` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `galerias`
--

INSERT INTO `galerias` (`id`, `titulo`, `descripcion`, `thumbnail`, `archivo`, `tipo_archivo`, `position`, `is_active`) VALUES
(1, 'pago', NULL, '26e93ab5dcc06c0f162776caf8b5d5410d9b1968.jpg', '26e93ab5dcc06c0f162776caf8b5d5410d9b1968.jpg', 1, 1, 1),
(2, 'aguila', NULL, '83edb8854e2f400ed87cb2b4ce32dac78b47d1f8.jpg', '83edb8854e2f400ed87cb2b4ce32dac78b47d1f8.jpg', 1, 2, 1),
(3, '68747470733a2f2f7261772e6769746875622e636f6d2f6d656a6f72616e646f6c61636c6173652f6d656a6f72616e646f637572736f2f6d61737465722f74696d656c696e65637572736f732e6a7067', NULL, 'fc51878985f86132e387f44fab99110c9461024d.jpg', 'fc51878985f86132e387f44fab99110c9461024d.jpg', 1, 3, 1),
(4, 'pago', NULL, 'd3d69102e86888e543c723f09311f152ddf28a14.jpg', 'd3d69102e86888e543c723f09311f152ddf28a14.jpg', 1, 4, 1),
(6, 'aguila', NULL, 'e93a6af4e1597320fddf6de645692692c774b204.jpg', 'e93a6af4e1597320fddf6de645692692c774b204.jpg', 1, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
`id` int(11) NOT NULL,
  `pagina` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `imagen` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contenido` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagina_galeria`
--

CREATE TABLE IF NOT EXISTS `pagina_galeria` (
  `pagina_id` int(11) NOT NULL,
  `galeria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pago`
--

CREATE TABLE IF NOT EXISTS `Pago` (
`id` int(11) NOT NULL,
  `venta` int(11) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `iva` decimal(10,0) NOT NULL,
  `fechaPago` datetime NOT NULL,
  `formaPago` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
`id` int(11) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `iva` decimal(10,0) NOT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `forma_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
`id` int(11) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `marca` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unidad_medida` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `existencia` int(11) NOT NULL,
  `reservado` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `iva` decimal(10,0) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_producto_promocional` tinyint(1) NOT NULL,
  `es_nuevo` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `marca`, `unidad_medida`, `existencia`, `reservado`, `precio`, `iva`, `created_at`, `updated_at`, `slug`, `is_active`, `is_producto_promocional`, `es_nuevo`) VALUES
(1, 8, 'producto 1', 'Producto 1 utilizado en gran variedad de cosas como en pruebas para este desarrollo.', 'Laguna', 'PZ', 100, 0, '12', '1', '2015-01-24 17:41:51', '2015-02-11 13:33:51', 'producto-1', 1, 0, 1),
(2, 6, 'Producto 2', 'Este producto tiene la siguiente descripcion de ejemplo<span class="Apple-tab-span" style="white-space:pre">	</span>', 'Algo', 'LT', 102, 2, '100', '1', '2015-01-24 17:52:00', '2015-02-11 18:34:08', 'producto-2', 1, 0, 1),
(3, 8, 'Producto 4', 'Este es el producto numero cuatro de la categoria la verdad no se de donde.&nbsp;', 'Marca 1', 'PZ', 100, 0, '150', '1', '2015-02-11 12:32:00', '2015-02-11 13:34:01', 'producto-4', 1, 1, 1),
(4, 7, 'Producto 5', 'Otro producto para que puedan ser algo mas que unos cuantos', 'Richpolis', 'PZ', 100, 0, '100', '1', '2015-02-11 12:49:44', '2015-02-11 13:33:24', 'producto-5', 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_galeria`
--

CREATE TABLE IF NOT EXISTS `productos_galeria` (
  `producto_id` int(11) NOT NULL,
  `galeria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos_galeria`
--

INSERT INTO `productos_galeria` (`producto_id`, `galeria_id`) VALUES
(1, 3),
(2, 1),
(3, 2),
(4, 4),
(4, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE IF NOT EXISTS `Usuario` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `e_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `rfc` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rfc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grupo` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `password`, `salt`, `nombre`, `email`, `telefono`, `rfc`, `imagen`, `grupo`, `is_active`, `created_at`, `updated_at`, `facebook_id`, `facebook_access_token`, `twitter_id`, `twitter_access_token`) VALUES
(5, 'WGXT15JBB29503n4jBi4rMqJAKTWjFBrrSn4I7lGzKJh9CRxvePmqIx/SIPqLpkD9Bh/RAFZV19RcDO4ffUXIQ==', 'qxblpmzrybk0c4wogso4gc8gckssgw8', 'Richpolis Systems', 'richpolis@gmail.com', '55555555', NULL, NULL, 3, 1, '2015-01-24 23:52:28', '2015-01-24 23:52:28', NULL, NULL, NULL, NULL),
(6, 'pQ1se7xj8L7SnVEXSZzJptLKeVGvFK0osOzM4pMI2YyKmm+UA992K1L5zddizdhNrGnrCszHdBhawQXy5TDllw==', '45rsgygq58w0wscw8400c8c4gwcsg40', 'Administrador general', 'admin@countdown.com', '55555555', NULL, NULL, 2, 1, '2015-01-24 23:52:28', '2015-01-24 23:52:28', NULL, NULL, NULL, NULL),
(7, 'dNphUm5s2AfD/OrX1EftEuE2nrtdmwsSOyh4SLDdDMshNkLr0adRsBb2rOksbVfykqsnJ2Fto/ZDArDnf/N5bA==', '1lmaa4825xgk8sosg4oowc48kc08ook', 'Usuario 1', 'usuario1@countdown.com', '55555555', NULL, NULL, 1, 1, '2015-01-24 23:52:28', '2015-01-24 23:52:28', NULL, NULL, NULL, NULL),
(8, '1TlARbRt3aZmUGhk3G1F8jPv9XaLexD5/k1eIXej3BH8/8VAEX4zwKSr3H81X/TUIAiXocMpWg5u/tqmdGLYRQ==', '7eu1t8a0rg0s40wcgck48c4sg44okgw', 'Usuario 2', 'usuario2@countdown.com', '55555555', NULL, NULL, 1, 1, '2015-01-24 23:52:28', '2015-01-24 23:52:28', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Venta`
--

CREATE TABLE IF NOT EXISTS `Venta` (
`id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `iva` decimal(10,0) NOT NULL,
  `pago` int(11) NOT NULL,
  `fechaCompra` datetime NOT NULL,
  `envio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
`id` int(11) NOT NULL,
  `pago_id` int(11) DEFAULT NULL,
  `envio_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `importe` decimal(10,0) NOT NULL,
  `iva` decimal(10,0) NOT NULL,
  `fechaCompra` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_611AB286F2A5805D` (`venta_id`), ADD KEY `IDX_611AB2867645698E` (`producto_id`);

--
-- Indices de la tabla `DetVenta`
--
ALTER TABLE `DetVenta`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_9CC09A77645698E` (`producto_id`), ADD KEY `IDX_9CC09A7F2A5805D` (`venta_id`);

--
-- Indices de la tabla `Direccion`
--
ALTER TABLE `Direccion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_B0B0BECBDB38439E` (`usuario_id`);

--
-- Indices de la tabla `Envio`
--
ALTER TABLE `Envio`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `galerias`
--
ALTER TABLE `galerias`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paginas`
--
ALTER TABLE `paginas`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagina_galeria`
--
ALTER TABLE `pagina_galeria`
 ADD PRIMARY KEY (`pagina_id`,`galeria_id`), ADD KEY `IDX_93AEAADA57991ECF` (`pagina_id`), ADD KEY `IDX_93AEAADAD31019C` (`galeria_id`);

--
-- Indices de la tabla `Pago`
--
ALTER TABLE `Pago`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_767490E63397707A` (`categoria_id`);

--
-- Indices de la tabla `productos_galeria`
--
ALTER TABLE `productos_galeria`
 ADD PRIMARY KEY (`producto_id`,`galeria_id`), ADD KEY `IDX_A10E30967645698E` (`producto_id`), ADD KEY `IDX_A10E3096D31019C` (`galeria_id`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Venta`
--
ALTER TABLE `Venta`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_808D9E63FB8380` (`pago_id`), ADD KEY `IDX_808D9E95BC4699` (`envio_id`), ADD KEY `IDX_808D9EDB38439E` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `DetVenta`
--
ALTER TABLE `DetVenta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Direccion`
--
ALTER TABLE `Direccion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Envio`
--
ALTER TABLE `Envio`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `galerias`
--
ALTER TABLE `galerias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `paginas`
--
ALTER TABLE `paginas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Pago`
--
ALTER TABLE `Pago`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `Usuario`
--
ALTER TABLE `Usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `Venta`
--
ALTER TABLE `Venta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_venta`
--
ALTER TABLE `detalles_venta`
ADD CONSTRAINT `FK_611AB2867645698E` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
ADD CONSTRAINT `FK_611AB286F2A5805D` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `DetVenta`
--
ALTER TABLE `DetVenta`
ADD CONSTRAINT `FK_9CC09A77645698E` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
ADD CONSTRAINT `FK_9CC09A7F2A5805D` FOREIGN KEY (`venta_id`) REFERENCES `Venta` (`id`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
ADD CONSTRAINT `FK_B0B0BECBDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pagina_galeria`
--
ALTER TABLE `pagina_galeria`
ADD CONSTRAINT `FK_93AEAADA57991ECF` FOREIGN KEY (`pagina_id`) REFERENCES `paginas` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_93AEAADAD31019C` FOREIGN KEY (`galeria_id`) REFERENCES `galerias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
ADD CONSTRAINT `FK_767490E63397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `productos_galeria`
--
ALTER TABLE `productos_galeria`
ADD CONSTRAINT `FK_A10E30967645698E` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_A10E3096D31019C` FOREIGN KEY (`galeria_id`) REFERENCES `galerias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
ADD CONSTRAINT `FK_808D9E63FB8380` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`),
ADD CONSTRAINT `FK_808D9E95BC4699` FOREIGN KEY (`envio_id`) REFERENCES `direcciones` (`id`),
ADD CONSTRAINT `FK_808D9EDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
