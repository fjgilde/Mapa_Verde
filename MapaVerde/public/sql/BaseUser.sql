-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.27-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.2.0.6576
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para userspag
CREATE DATABASE IF NOT EXISTS `userspag` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `userspag`;

-- Volcando estructura para tabla userspag.estadisticas_medioambientales
CREATE TABLE IF NOT EXISTS `estadisticas_medioambientales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indicador` varchar(255) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla userspag.estadisticas_medioambientales: ~5 rows (aproximadamente)
INSERT INTO `estadisticas_medioambientales` (`id`, `indicador`, `valor`, `fecha`, `ubicacion`) VALUES
	(1, 'CO2', 412.56, '2025-04-09', 'Andalucía'),
	(2, 'Temperatura', 26.8, '2025-04-09', 'Andalucía'),
	(3, 'Humedad', 72, '2025-04-09', 'Andalucía'),
	(4, 'Lluvia', 15.3, '2025-04-09', 'Andalucía'),
	(5, 'Calidad del aire', 45, '2025-04-09', 'Andalucía');

-- Volcando estructura para tabla userspag.list_user_pag
CREATE TABLE IF NOT EXISTS `list_user_pag` (
  `Usuarios` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `Email` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla userspag.list_user_pag: ~3 rows (aproximadamente)
INSERT INTO `list_user_pag` (`Usuarios`, `password`, `Email`) VALUES
	('1', '123', '1@gmail.com'),
	('2', '1234', '2@gmail.com'),
	('admin', 'admin', 'admin@gmail.com');

-- Volcando estructura para tabla userspag.noticias
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` blob DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla userspag.noticias: ~1 rows (aproximadamente)
INSERT INTO `noticias` (`id`, `titulo`, `contenido`, `imagen`, `fecha`) VALUES
	(4, 'Inmersión libre', 'Esta capacidad situaría a las focas en una clase superior a la de cualquier mamífero terrestre que se haya probado. Dado que los niveles de oxígeno en tierra son bastante constantes, los humanos y otros animales terrestres no parecen haber evolucionado para notar niveles bajos de oxígeno en la sangre, a veces ni siquiera cuando están a punto de desmayarse.\r\n\r\nEn los seres humanos que practican la apnea sin botellas de oxígeno, los accidentes son bastante frecuentes. Según McKnight, la culpa puede ser nuestra dependencia de los niveles de CO2 en sangre en lugar de los de oxígeno. “Se trata de una estrategia perfectamente sensata en tierra, donde la acumulación de CO2 tiende a indicar problemas respiratorios”, explica.\r\nPero al aguantar la respiración durante el buceo, confiar en los niveles de CO2 es arriesgado, sobre todo en inmersiones repetidas. \r\n\r\n(Relacionado: Una moda que te dejará sin respiración: por qué hay que probar el buceo en apnea en Taiwán)\r\n\r\n“Cada vez que salimos a la superficie e inhalamos, restablecemos nuestra sensibilidad al CO2, aunque los niveles ya sean altos”, explica McKnight. Esto aumenta la posibilidad de que una persona se desmaye sin darse cuenta antes de llegar a la superficie, incluso en apneístas expertos, que se entrenan para ignorar los niveles altos de CO2 durante inmersiones largas.\r\n\r\nPeter Lindholm, fisiólogo del buceo de la Universidad de California, se pregunta qué revelaría un experimento similar en humanos. “Al ver este estudio, pienso que debería volver a hacerse con buceadores libres para ver si encontramos individuos que perciban los niveles de oxígeno o sean más tolerantes a los niveles de CO2”, dice: “No necesitarían comer el pescado, claro, sólo aguantar la respiración”.', NULL, '2025-04-09 08:47:34');

-- Volcando estructura para tabla userspag.review_table
CREATE TABLE IF NOT EXISTS `review_table` (
  `review_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_rating` int(1) NOT NULL,
  `user_review` text NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla userspag.review_table: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
