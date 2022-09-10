-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2022 a las 19:43:13
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_autos`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_insertarAlmacen` (IN `sp_desc` VARCHAR(50))  BEGIN
INSERT INTO tblalmacen VALUES
(' ',sp_desc);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_insertarCliente` (IN `sp_cedula` INT(11), IN `sp_nombres` VARCHAR(50), IN `sp_apellidos` VARCHAR(50))  BEGIN
INSERT INTO tblcliente VALUES
(sp_cedula,sp_nombres,sp_apellidos);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_insertarMarca` (IN `sp_desc` VARCHAR(50))  BEGIN
INSERT INTO tblmarca VALUES
('',sp_desc);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_insertarPlanta` (IN `sp_desc` VARCHAR(50))  BEGIN
INSERT INTO tblplanta VALUES
('',sp_desc);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_insertarreserva` (IN `sp_refe` VARCHAR(15), IN `sp_cedula` INT(11), IN `sp_fecreserva` DATETIME, IN `sp_fechafin` DATETIME)  BEGIN
INSERT INTO tblreserva VALUES 
('',sp_refe,sp_cedula,sp_fecreserva,sp_fechafin,1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_insertarVehiculo` (IN `sp_refer` VARCHAR(15), IN `sp_nom` VARCHAR(50), IN `sp_idplanta` INT(11), IN `sp_idmarca` INT(11), IN `sp_fensamble` DATE, IN `sp_modelo` INT(11), IN `sp_idalmacen` INT(11), IN `sp_fregistro` DATETIME)  BEGIN
insert into tblvehiculo VALUES
(sp_refer,sp_nom,sp_idplanta,sp_idmarca,sp_fensamble,sp_modelo,sp_idalmacen,sp_fregistro);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listarReserva` ()  BEGIN
SELECT r.idreserva, v.referencia, v.nombrevehiculo, c.cedula, concat(c.nombres,' ',c.apellidos) as nombres,
r.fechareserva,r.fechafin,r.reservado
FROM tblreserva AS r INNER JOIN tblvehiculo as v ON r.referencia=v.referencia
INNER JOIN tblcliente as c ON r.cedula = c.cedula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listartablaalmacen` ()  BEGIN
SELECT * FROM tblalmacen;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listartablamarca` ()  BEGIN
SELECT * FROM tblmarca;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listartablaPlanta` ()  BEGIN
SELECT * FROM tblplanta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listartblcliente` ()  BEGIN
SELECT * FROM tblcliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listarUnVehiculo` (IN `sp_referencia` VARCHAR(15))  BEGIN
SELECT v.referencia,v.nombrevehiculo,p.descplanta,m.descmarca,v.fechaensamble,v.modelo, a.descalmacen,v.fecharegistro
FROM tblvehiculo as v INNER JOIN tblplanta as p ON v.idplanta=p.idplanta 
INNER JOIN tblmarca as m ON v.idmarca = m.idmarca INNER JOIN tblalmacen as a 
ON v.idalmacen = a.idalmacen
WHERE V.referencia = sp_referencia;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listarVehiculos` ()  BEGIN
SELECT v.referencia,v.nombrevehiculo,p.descplanta,m.descmarca,v.fechaensamble,v.modelo, a.descalmacen,v.fecharegistro
FROM tblvehiculo as v INNER JOIN tblplanta as p ON v.idplanta=p.idplanta 
INNER JOIN tblmarca as m ON v.idmarca = m.idmarca INNER JOIN tblalmacen as a 
ON v.idalmacen = a.idalmacen;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_listarVehiculosNoReservados` ()  BEGIN
SELECT ve.referencia 
FROM tblreserva as re right JOIN tblvehiculo as ve ON re.referencia=ve.referencia 
WHERE re.reservado is null or re.reservado=0 GROUP BY ve.referencia;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_modificarVehiculo` (IN `sp_refe` VARCHAR(15), IN `sp_fechaensamble` DATE, IN `sp_modelo` INT(11))  BEGIN
UPDATE tblvehiculo as v SET v.fechaensamble= sp_fechaensamble, v.modelo=sp_modelo
WHERE v.referencia=sp_refe;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_reservasActivasCliente` (IN `sp_cedula` INT(11))  BEGIN
SELECT COUNT(re.cedula) as 'CantidadReservas'
FROM tblreserva as re 
WHERE re.Reservado = 1 and re.cedula = sp_cedula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_vehiculosReservadosPorDia` ()  BEGIN
SELECT re.idreserva as 'id', Count(ve.referencia) as 'title', LEFT(re.fechareserva,10) as 'start' 
FROM tblreserva as re right JOIN tblvehiculo as ve ON re.referencia=ve.referencia 
WHERE re.reservado = 0 or re.reservado = 1 GROUP by LEFT(re.fechareserva,10);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblalmacen`
--

CREATE TABLE `tblalmacen` (
  `idalmacen` int(11) NOT NULL,
  `descalmacen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblalmacen`
--

INSERT INTO `tblalmacen` (`idalmacen`, `descalmacen`) VALUES
(0, 'La Ceja Antioquia'),
(1, 'Rionegro Antioquia'),
(2, 'Marinilla Antioquia'),
(3, 'Bogota DC '),
(4, 'El Retiro Antioquia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcliente`
--

CREATE TABLE `tblcliente` (
  `cedula` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblcliente`
--

INSERT INTO `tblcliente` (`cedula`, `nombres`, `apellidos`) VALUES
(222, 'Juan', 'Perez'),
(234, 'Jose', 'R'),
(333, 'Juan', 'Perez'),
(456, 'Juan', 'Perez'),
(1456, 'Jose', 'Monsalve'),
(2134, 'jnose', 'Mih'),
(7899, 'Jojo', 'MKK'),
(23456, 'Leidy', 'Monsalve Catrillón');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblmarca`
--

CREATE TABLE `tblmarca` (
  `idmarca` int(11) NOT NULL,
  `descmarca` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblmarca`
--

INSERT INTO `tblmarca` (`idmarca`, `descmarca`) VALUES
(0, 'Toyota'),
(1, 'Chevrolet'),
(2, 'Ford'),
(3, 'Prueba'),
(4, 'dsadsadas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblplanta`
--

CREATE TABLE `tblplanta` (
  `idplanta` int(11) NOT NULL,
  `descplanta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblplanta`
--

INSERT INTO `tblplanta` (`idplanta`, `descplanta`) VALUES
(0, 'dasdsa'),
(1, 'Bogota DC'),
(2, 'Colombia, Medellin Lujos y Lujos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblreserva`
--

CREATE TABLE `tblreserva` (
  `idreserva` int(11) NOT NULL,
  `referencia` varchar(15) NOT NULL,
  `cedula` int(11) NOT NULL,
  `fechareserva` datetime NOT NULL DEFAULT current_timestamp(),
  `fechafin` datetime NOT NULL,
  `reservado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblreserva`
--

INSERT INTO `tblreserva` (`idreserva`, `referencia`, `cedula`, `fechareserva`, `fechafin`, `reservado`) VALUES
(7, 'ABC', 222, '2022-09-07 09:37:48', '2022-09-08 09:37:48', 0),
(8, 'abcd', 222, '2022-09-08 09:38:21', '2022-09-09 09:38:21', 0),
(9, 'ABC', 222, '2022-09-09 09:40:00', '2022-09-10 09:40:00', 0),
(10, 'ABC', 222, '2022-09-09 11:08:17', '2022-09-10 11:08:17', 1),
(11, 'ABC12', 456, '2022-09-09 11:37:59', '2022-09-10 11:37:59', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblvehiculo`
--

CREATE TABLE `tblvehiculo` (
  `referencia` varchar(15) NOT NULL,
  `nombrevehiculo` varchar(50) NOT NULL,
  `idplanta` int(11) NOT NULL,
  `idmarca` int(11) NOT NULL,
  `fechaensamble` date NOT NULL,
  `modelo` int(11) NOT NULL,
  `idalmacen` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblvehiculo`
--

INSERT INTO `tblvehiculo` (`referencia`, `nombrevehiculo`, `idplanta`, `idmarca`, `fechaensamble`, `modelo`, `idalmacen`, `fecharegistro`) VALUES
('ABC', 'Logan', 1, 1, '2005-05-06', 2006, 1, '0000-00-00 00:00:00'),
('ABC12', 'Clio', 2, 1, '2020-08-19', 2022, 2, '2022-09-09 11:35:14'),
('abcd', 'logan', 1, 1, '2022-09-08', 2018, 2, '0000-00-00 00:00:00'),
('ABCDE', 'Logan', 1, 1, '2022-09-08', 2022, 1, '2022-09-08 23:33:15'),
('HOLI', 'Logancito', 1, 3, '2022-09-01', 2015, 1, '0000-00-00 00:00:00'),
('HOLIAS', 'Logancito2', 1, 2, '2022-09-01', 2015, 3, '2022-09-08 11:47:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tblalmacen`
--
ALTER TABLE `tblalmacen`
  ADD PRIMARY KEY (`idalmacen`);

--
-- Indices de la tabla `tblcliente`
--
ALTER TABLE `tblcliente`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `tblmarca`
--
ALTER TABLE `tblmarca`
  ADD PRIMARY KEY (`idmarca`);

--
-- Indices de la tabla `tblplanta`
--
ALTER TABLE `tblplanta`
  ADD PRIMARY KEY (`idplanta`);

--
-- Indices de la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  ADD PRIMARY KEY (`idreserva`,`referencia`,`cedula`),
  ADD KEY `cedula` (`cedula`),
  ADD KEY `referencia` (`referencia`);

--
-- Indices de la tabla `tblvehiculo`
--
ALTER TABLE `tblvehiculo`
  ADD PRIMARY KEY (`referencia`),
  ADD KEY `idalmacen` (`idalmacen`),
  ADD KEY `idplanta` (`idplanta`),
  ADD KEY `idmarca` (`idmarca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tblalmacen`
--
ALTER TABLE `tblalmacen`
  MODIFY `idalmacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tblmarca`
--
ALTER TABLE `tblmarca`
  MODIFY `idmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tblplanta`
--
ALTER TABLE `tblplanta`
  MODIFY `idplanta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  MODIFY `idreserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  ADD CONSTRAINT `tblreserva_ibfk_2` FOREIGN KEY (`cedula`) REFERENCES `tblcliente` (`cedula`),
  ADD CONSTRAINT `tblreserva_ibfk_3` FOREIGN KEY (`referencia`) REFERENCES `tblvehiculo` (`referencia`);

--
-- Filtros para la tabla `tblvehiculo`
--
ALTER TABLE `tblvehiculo`
  ADD CONSTRAINT `tblvehiculo_ibfk_3` FOREIGN KEY (`idalmacen`) REFERENCES `tblalmacen` (`idalmacen`),
  ADD CONSTRAINT `tblvehiculo_ibfk_4` FOREIGN KEY (`idplanta`) REFERENCES `tblplanta` (`idplanta`),
  ADD CONSTRAINT `tblvehiculo_ibfk_5` FOREIGN KEY (`idmarca`) REFERENCES `tblmarca` (`idmarca`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
