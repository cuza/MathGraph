-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2013 a las 19:35:55
-- Versión del servidor: 5.5.20
-- Versión de PHP: 5.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mathgraph`
--
CREATE DATABASE `mathgraph`
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_general_ci;
USE `mathgraph`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `iduser`     INT(11) NOT NULL,
  `idprofesor` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `error`
--

CREATE TABLE IF NOT EXISTS `error` (
  `id`       INT(11) NOT NULL AUTO_INCREMENT,
  `idalumno` INT(11) NOT NULL,
  `paso`     INT(2)  NOT NULL,
  `fecha`    DATE    NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `func`
--

CREATE TABLE IF NOT EXISTS `func` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `func`       TEXT    NOT NULL,
  `desc`       TEXT    NOT NULL,
  `idprofesor` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id`   INT(11) NOT NULL AUTO_INCREMENT,
  `nick` TEXT    NOT NULL,
  `pass` TEXT    NOT NULL,
  `name` TEXT    NOT NULL,
  `role` CHAR(1) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =2;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nick`, `pass`, `name`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'A');

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
