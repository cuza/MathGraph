-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2013 a las 19:35:55
-- Versión del servidor: 5.5.20
-- Versión de PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mathgraph`
--
CREATE DATABASE `mathgraph` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mathgraph`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idprofesor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `iduser`, `idprofesor`) VALUES
(4, 12, 11),
(5, 13, 7),
(6, 14, 7),
(7, 16, 7),
(10, 21, 19),
(11, 22, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `error`
--

CREATE TABLE IF NOT EXISTS `error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idalumno` int(11) NOT NULL,
  `paso` int(2) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

--
-- Volcado de datos para la tabla `error`
--

INSERT INTO `error` (`id`, `idalumno`, `paso`, `fecha`) VALUES
(1, 13, 3, '2013-05-13'),
(2, 13, 2, '2013-05-13'),
(3, 13, 2, '2013-05-13'),
(4, 13, 4, '2013-05-13'),
(5, 13, 6, '2013-05-13'),
(6, 13, 2, '2013-05-14'),
(7, 13, 2, '2013-05-14'),
(8, 14, 2, '2013-05-14'),
(9, 14, 2, '2013-05-14'),
(10, 14, 2, '2013-05-14'),
(11, 14, 2, '2013-05-14'),
(12, 14, 2, '2013-05-14'),
(14, 14, 1, '2013-05-14'),
(15, 14, 1, '2013-05-14'),
(16, 14, 1, '2013-05-18'),
(17, 14, 4, '2013-05-18'),
(18, 14, 6, '2013-05-18'),
(19, 14, 6, '2013-05-18'),
(20, 14, 6, '2013-05-18'),
(21, 14, 6, '2013-05-18'),
(22, 14, 6, '2013-05-18'),
(23, 14, 2, '2013-05-22'),
(24, 14, 2, '2013-05-22'),
(25, 14, 2, '2013-05-22'),
(26, 14, 1, '2013-05-22'),
(27, 14, 3, '2013-05-23'),
(28, 14, 3, '2013-05-23'),
(29, 14, 3, '2013-05-24'),
(30, 14, 3, '2013-05-24'),
(31, 14, 3, '2013-05-24'),
(32, 14, 3, '2013-05-24'),
(33, 14, 3, '2013-05-24'),
(34, 14, 3, '2013-05-24'),
(35, 14, 3, '2013-05-24'),
(36, 14, 3, '2013-05-24'),
(37, 14, 3, '2013-05-24'),
(38, 14, 3, '2013-05-24'),
(39, 14, 3, '2013-05-24'),
(40, 14, 3, '2013-05-24'),
(41, 14, 3, '2013-05-24'),
(42, 14, 3, '2013-05-24'),
(43, 14, 3, '2013-05-24'),
(44, 14, 8, '2013-05-24'),
(45, 13, 1, '2013-05-27'),
(46, 13, 2, '2013-05-27'),
(47, 13, 2, '2013-05-27'),
(48, 14, 3, '2013-05-27'),
(49, 14, 3, '2013-05-27'),
(50, 14, 2, '2013-05-27'),
(51, 14, 2, '2013-05-27'),
(52, 14, 2, '2013-05-27'),
(53, 14, 3, '2013-05-27'),
(54, 14, 2, '2013-05-27'),
(55, 14, 2, '2013-05-27'),
(56, 13, 2, '2013-05-27'),
(57, 13, 2, '2013-05-27'),
(58, 13, 2, '2013-05-27'),
(59, 13, 2, '2013-05-27'),
(60, 14, 2, '2013-05-28'),
(61, 14, 2, '2013-05-28'),
(62, 14, 2, '2013-05-28'),
(63, 14, 2, '2013-05-28'),
(64, 14, 2, '2013-05-28'),
(65, 14, 2, '2013-05-28'),
(66, 14, 2, '2013-05-28'),
(67, 14, 2, '2013-05-28'),
(68, 14, 2, '2013-05-28'),
(69, 14, 2, '2013-05-28'),
(70, 14, 2, '2013-05-28'),
(71, 14, 2, '2013-05-28'),
(72, 14, 2, '2013-05-28'),
(73, 14, 2, '2013-05-28'),
(74, 14, 2, '2013-05-28'),
(75, 14, 2, '2013-05-28'),
(76, 14, 2, '2013-05-28'),
(77, 14, 2, '2013-05-28'),
(78, 14, 2, '2013-05-28'),
(79, 14, 2, '2013-05-28'),
(80, 14, 2, '2013-05-28'),
(81, 14, 2, '2013-05-28'),
(82, 14, 2, '2013-05-28'),
(83, 14, 2, '2013-05-28'),
(84, 14, 2, '2013-05-28'),
(85, 14, 2, '2013-05-28'),
(86, 14, 3, '2013-05-28'),
(87, 14, 4, '2013-05-28'),
(88, 14, 9, '2013-05-28'),
(89, 16, 1, '2013-06-05'),
(90, 16, 2, '2013-06-05'),
(91, 16, 2, '2013-06-05'),
(92, 16, 4, '2013-06-05'),
(93, 16, 4, '2013-06-05'),
(94, 16, 4, '2013-06-05'),
(95, 16, 4, '2013-06-05'),
(96, 16, 5, '2013-06-05'),
(97, 16, 5, '2013-06-05'),
(98, 16, 6, '2013-06-05'),
(99, 16, 6, '2013-06-05'),
(100, 16, 7, '2013-06-05'),
(101, 16, 8, '2013-06-05'),
(102, 16, 9, '2013-06-05'),
(103, 14, 2, '2013-06-06'),
(104, 14, 2, '2013-06-06'),
(105, 14, 3, '2013-06-06'),
(106, 14, 3, '2013-06-06'),
(107, 14, 3, '2013-06-09'),
(108, 14, 3, '2013-06-09'),
(109, 14, 5, '2013-06-09'),
(110, 14, 5, '2013-06-09'),
(111, 21, 2, '2013-06-10'),
(112, 21, 2, '2013-06-10'),
(113, 21, 2, '2013-06-10'),
(114, 21, 2, '2013-06-10'),
(115, 21, 2, '2013-06-10'),
(116, 21, 9, '2013-06-10'),
(117, 22, 1, '2013-06-10'),
(118, 22, 1, '2013-06-10'),
(119, 22, 1, '2013-06-10'),
(120, 22, 1, '2013-06-10'),
(121, 22, 1, '2013-06-10'),
(122, 22, 1, '2013-06-10'),
(123, 21, 2, '2013-06-10'),
(124, 21, 2, '2013-06-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `func`
--

CREATE TABLE IF NOT EXISTS `func` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `func` text NOT NULL,
  `desc` text NOT NULL,
  `idprofesor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `func`
--

INSERT INTO `func` (`id`, `func`, `desc`, `idprofesor`) VALUES
(1, '(x)^(2)', 'funcion cuadrÃ¡tica', 7),
(2, 'x', 'funcion lineal', 7),
(3, '(1)/(x+1)', 'funcion con asintotas', 7),
(4, 'sen(x)', 'seno', 7),
(5, '(x)/((x-2)*(x-3))', 'racional', 7),
(6, 'log(x)', 'logaritmo', 7),
(7, 'tan(x)', 'tangente', 7),
(9, '(sen(x))/(cos(x))', '(sen(x))/(cos(x))', 7),
(10, '(sen(x))/(cos(x))', 'tangente = sen/cos', 7),
(11, '((x)^(2)+(4)*(x)+3)/((x)^(2)+(5)*(x)+6)', 'prueba 1', 7),
(12, '(x)/(1+(x)^(2))', 'prueba 2', 7),
(13, '(1)/(x+2)', 'funcion de liana', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` text NOT NULL,
  `pass` text NOT NULL,
  `name` text NOT NULL,
  `role` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nick`, `pass`, `name`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'A'),
(7, 'yaudi', '42398dfc519be569e98af3257e464032', 'Yaudi', 'P'),
(11, 'h', '2510c39011c5be704182423e3a695e91', 'h', 'P'),
(12, 'pan', '96ac0342a3ccf9553e3d4c9da9b821b0', 'Pedro', 'E'),
(13, 'dan', '9180b4da3f0c7e80975fad685f7f134e', 'Daniel Piad', 'E'),
(14, 'wendi', '57a3a0c5796dd85a32fd9476b6f3362a', 'Wendy Sanchez', 'E'),
(16, 'julian', '338c23e8eafc19ec9236404deac0bef4', 'julian 4to', 'E'),
(19, 'liana', 'fc5b22eacd42daffeb5f58784fcd98c1', 'liana', 'P'),
(21, 'aa', '4124bc0a9335c27f086f24ba207a4912', 'aa', 'E'),
(22, 'asd', '7815696ecbf1c96e6894b779456d330e', 'asd', 'E');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
