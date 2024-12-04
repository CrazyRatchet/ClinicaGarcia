-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2024 a las 17:03:33
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
-- Base de datos: `clinica_garcia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE DATABASE clinica_garcia;
USE DATABASE clinica_garcia;

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `paciente_id`, `doctor_id`, `fecha`, `hora`) VALUES
(4, 1, 2, '2024-12-10', '15:00:00'),
(5, 1, 2, '2024-12-09', '08:00:00'),
(6, 1, 2, '2024-12-10', '08:30:00'),
(7, 3, 1, '2024-12-16', '08:30:00'),
(8, 1, 2, '2024-12-10', '09:00:00'),
(9, 1, 1, '2024-12-10', '10:00:00'),
(10, 1, 1, '2024-12-09', '11:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_medicas`
--

CREATE TABLE `consultas_medicas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `numero_identificacion` varchar(50) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `numero_telefono` varchar(20) DEFAULT NULL,
  `antecedentes_familiares` text DEFAULT NULL,
  `medicamentos_regulares` text DEFAULT NULL,
  `padecimientos` varchar(200) NOT NULL,
  `alergias` text DEFAULT NULL,
  `sintomas` varchar(100) NOT NULL,
  `diagnostico` text NOT NULL,
  `fecha_consulta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas_medicas`
--

INSERT INTO `consultas_medicas` (`id`, `paciente_id`, `nombre_completo`, `fecha_nacimiento`, `numero_identificacion`, `direccion`, `numero_telefono`, `antecedentes_familiares`, `medicamentos_regulares`, `padecimientos`, `alergias`, `sintomas`, `diagnostico`, `fecha_consulta`) VALUES
(1, 5, 'Noely', '2022-01-03', '8-969-2327', 'a', '111', 'a', 'a', 'a', 'a', 'a', 'a', '2024-12-03'),
(2, 5, 'Noely', '2022-01-03', '8-969-2327', 'a', 'a', 'a', 'a', 'a', 'a', 'z', 'a', '2024-12-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctores`
--

INSERT INTO `doctores` (`id`, `nombre`, `especialidad`, `telefono`) VALUES
(1, 'Dr. Pedro Martínez', 'Cardiología', '0412345678'),
(2, 'Dra. Laura Sánchez', 'Pediatría', '0423456789'),
(3, 'Dr. Javier López', 'Dermatología', '0418765432');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`id`, `nombre`, `descripcion`) VALUES
(2, 'Pediatría', 'Proveen cuidado primario a los niños incluyendo inmunizaciones, chequeos de la salud de bebés, exámenes físicos en escolares,\r\ny tratamiento de fiebres, tos, y malestar estomacal entre muchas otras cosas.'),
(3, 'Psiquiatría', 'Se especializan en la salud mental y tratan problemas emocionales y de comportamiento a través de una combinación de \r\nconsejería personal (psicoterapia), psicoanálisis, hospitalización y medicación.'),
(4, 'Cardiología', 'Se concentran en el tratamiento del corazón y los vasos sanguíneos, que puede incluir el manejo del fallo cardíaco, \r\nenfermedad cardiovascular y cuidado post operativo.'),
(5, 'Dermatología', 'Los dermatólogos son los que tratan los desordenes de la piel en  cabello, uñas y membranas mucosas adyacentes ya sea los adultos o niños.'),
(6, 'Gastroenterología', 'La gastroentetrología trata las funciones y enfermedades del sistema digestivo.\r\nTratan problemas relacionado a la vesícula biliar, estomago, intestinos, entre otros.'),
(7, 'Oftalmología', 'La Oftalmología es el área que trata las enfermedades o desordenes de los ojos como cataratas y glaucoma.\r\nEllos también realizan cirugía de ojo cuando es necesario.'),
(8, 'Radiología', 'El radiólogo es el médico que está entrenado para ver e interpretar las pruebas diagnosticas de imágenes como rayos X, Tomografía computarizadas, Resonancias Magnéticas, etc.'),
(9, 'Urología', 'La urología es la especialidad médica que cuida del tracto urinario de los hombres y las mujeres incluyendo los riñones, uréteres, vejiga y uretra.'),
(10, 'Endocrinología', 'La endocrinología trata el sistema endocrino y básicamente las glándulas que producen y secretan hormonas que controlan y regulan casi todas las funciones del cuerpo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `dia_semana` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `doctor_id`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES
(1, 1, 'Monday', '08:00:00', '12:00:00'),
(2, 1, 'Monday', '14:00:00', '18:00:00'),
(3, 1, 'Tuesday', '08:00:00', '12:00:00'),
(4, 1, 'Tuesday', '14:00:00', '18:00:00'),
(5, 2, 'Monday', '08:00:00', '12:00:00'),
(6, 2, 'Monday', '14:00:00', '18:00:00'),
(7, 2, 'Tuesday', '08:00:00', '12:00:00'),
(8, 2, 'Tuesday', '14:00:00', '18:00:00'),
(9, 3, 'Monday', '08:00:00', '12:00:00'),
(10, 3, 'Monday', '14:00:00', '18:00:00'),
(11, 3, 'Tuesday', '08:00:00', '12:00:00'),
(12, 3, 'Tuesday', '14:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_medicina`
--

CREATE TABLE `inventario_medicina` (
  `id` int(11) NOT NULL,
  `medicina_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_medicina`
--

INSERT INTO `inventario_medicina` (`id`, `medicina_id`, `cantidad`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_utensilio`
--

CREATE TABLE `inventario_utensilio` (
  `id` int(11) NOT NULL,
  `utensilio_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicina`
--

CREATE TABLE `medicina` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `imagen` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicina`
--

INSERT INTO `medicina` (`id`, `nombre`, `descripcion`, `costo`, `imagen`) VALUES
(1, 'Omeprazol', 'Dolor de cabeza', 1.00, 'https://iberofarmacos.net/wp-content/uploads/2022/03/OMEPRAZOL-20MG_Mesa-de-trabajo-1-scaled.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicina_sintoma`
--

CREATE TABLE `medicina_sintoma` (
  `id` int(11) NOT NULL,
  `medicina_id` int(11) NOT NULL,
  `sintoma_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `altura` decimal(4,2) DEFAULT NULL,
  `tipo_sangre` varchar(3) DEFAULT NULL,
  `correo` varchar(50) NOT NULL,
  `alergias` text DEFAULT NULL,
  `medicamentos_regulares` text DEFAULT NULL,
  `padecimientos` varchar(100) DEFAULT NULL,
  `fecha_datos` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `cedula`, `sexo`, `fecha_nacimiento`, `edad`, `peso`, `altura`, `tipo_sangre`, `correo`, `alergias`, `medicamentos_regulares`, `padecimientos`, `fecha_datos`) VALUES
(1, 'Fernando Garcia', '8-969-2326', 'Masculino', '2001-02-03', 23, 45.00, 1.00, 'A+', 'fernando24442@outlook.com', 'Penisilina', 'Omoprazol', 'Diabetes', '2024-12-03'),
(2, 'Noely', '8-2000-3376', 'Femenino', '2023-01-17', 1, 1.00, 1.00, 'A+', 'fernando24442@outlook.com', 'a', 'a', 'a', '2024-12-03'),
(3, 'Noely A', '8-1000-3333', 'Femenino', '2023-01-17', 1, 1.00, 1.00, 'A+', 'fernando24442@outlook.com', 'a', 'a', 'a', '2024-12-03'),
(4, 'A', '8-969-2320', 'Masculino', '2023-01-04', 1, 1.00, 1.00, 'A-', 'fernando24442@outlook.com', 'a', 'a', 'a', '2024-12-03'),
(5, 'Noely', '8-969-2327', 'Masculino', '2022-01-03', 2, 1.00, 1.00, 'A+', 'fernando24442@outlook.com', 'a', 'a', 'aaa', '2024-12-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `correo_paciente` varchar(255) NOT NULL,
  `medicamentos` text NOT NULL,
  `fecha_receta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id`, `paciente_id`, `cedula`, `correo_paciente`, `medicamentos`, `fecha_receta`) VALUES
(1, 1, '8-969-2326', 'fernando24442@outlook.com', 'Omeprazol', '2024-12-03 22:38:25'),
(2, 1, '8-969-2326', 'fernando24442@outlook.com', 'Ola', '2024-12-03 23:09:21'),
(3, 3, '8-1000-3333', 'fernando24442@outlook.com', 'aaaaaaaaaaaaa', '2024-12-03 23:20:08'),
(4, 1, '8-969-2326', 'fernando24442@outlook.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-12-04 03:34:13'),
(5, 1, '8-969-2326', 'fernando24442@outlook.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-12-04 03:34:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre_r` varchar(50) NOT NULL,
  `permiso_administrador` tinyint(1) DEFAULT 0,
  `permiso_medico` tinyint(1) DEFAULT 0,
  `permiso_administrativos` tinyint(1) DEFAULT 0,
  `permiso_citas` tinyint(1) DEFAULT 0,
  `permiso_inventario` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre_r`, `permiso_administrador`, `permiso_medico`, `permiso_administrativos`, `permiso_citas`, `permiso_inventario`) VALUES
(1, 'Administrador', 1, 1, 1, 1, 1),
(2, 'Medico', 0, 1, 0, 1, 0),
(3, 'Recepcionista', 0, 0, 1, 1, 0),
(4, 'Almacén', 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id` int(11) NOT NULL,
  `nombre_s` varchar(100) NOT NULL,
  `descripcion_s` text DEFAULT NULL,
  `equipamiento_s` text DEFAULT NULL,
  `costo_s` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintoma`
--

CREATE TABLE `sintoma` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_utensilio`
--

CREATE TABLE `uso_utensilio` (
  `id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `utensilio_id` int(11) NOT NULL,
  `cantidad_usada` int(11) NOT NULL,
  `costo_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `uso_utensilio`
--
DELIMITER $$
CREATE TRIGGER `calcular_costo_total` BEFORE INSERT ON `uso_utensilio` FOR EACH ROW BEGIN
    DECLARE costo DECIMAL(10, 2);
    SELECT costo INTO costo FROM utensilio WHERE id = NEW.utensilio_id;
    SET NEW.costo_total = NEW.cantidad_usada * costo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_u` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `direccion` text DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_u`, `nombre`, `apellido`, `cedula`, `direccion`, `correo`, `telefono`, `rol_id`) VALUES
(1, 'Fernando', 'Garcia', '8-9111-1111', 'Los Andes 2', 'fernando24442@outlook.com', '6115-4742', 1),
(30, 'Juan', 'Pérez', '1234567890', 'Calle Falsa 123', 'juan.perez@example.com', '1234567890', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_login`
--

CREATE TABLE `usuario_login` (
  `id_ul` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasenia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_login`
--

INSERT INTO `usuario_login` (`id_ul`, `nombre_usuario`, `contrasenia`) VALUES
(1, 'Fer', '$2y$10$S44C45HEfzet2N57SILFpuBef989hpBqWvNsx1lBwNty4C6/GpA92'),
(30, 'juanperez', 'password');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `utensilio`
--

CREATE TABLE `utensilio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `imagen` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indices de la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indices de la tabla `inventario_medicina`
--
ALTER TABLE `inventario_medicina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicina_id` (`medicina_id`);

--
-- Indices de la tabla `inventario_utensilio`
--
ALTER TABLE `inventario_utensilio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utensilio_id` (`utensilio_id`);

--
-- Indices de la tabla `medicina`
--
ALTER TABLE `medicina`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `medicina_sintoma`
--
ALTER TABLE `medicina_sintoma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicina_id` (`medicina_id`,`sintoma_id`),
  ADD KEY `sintoma_id` (`sintoma_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_r` (`nombre_r`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_s` (`nombre_s`);

--
-- Indices de la tabla `sintoma`
--
ALTER TABLE `sintoma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `uso_utensilio`
--
ALTER TABLE `uso_utensilio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cita_id` (`cita_id`),
  ADD KEY `utensilio_id` (`utensilio_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_u`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `usuario_login`
--
ALTER TABLE `usuario_login`
  ADD PRIMARY KEY (`id_ul`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `utensilio`
--
ALTER TABLE `utensilio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `inventario_medicina`
--
ALTER TABLE `inventario_medicina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inventario_utensilio`
--
ALTER TABLE `inventario_utensilio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicina`
--
ALTER TABLE `medicina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `medicina_sintoma`
--
ALTER TABLE `medicina_sintoma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sintoma`
--
ALTER TABLE `sintoma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `uso_utensilio`
--
ALTER TABLE `uso_utensilio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `utensilio`
--
ALTER TABLE `utensilio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctores` (`id`);

--
-- Filtros para la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  ADD CONSTRAINT `consultas_medicas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctores` (`id`);

--
-- Filtros para la tabla `inventario_medicina`
--
ALTER TABLE `inventario_medicina`
  ADD CONSTRAINT `inventario_medicina_ibfk_1` FOREIGN KEY (`medicina_id`) REFERENCES `medicina` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario_utensilio`
--
ALTER TABLE `inventario_utensilio`
  ADD CONSTRAINT `inventario_utensilio_ibfk_1` FOREIGN KEY (`utensilio_id`) REFERENCES `utensilio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medicina_sintoma`
--
ALTER TABLE `medicina_sintoma`
  ADD CONSTRAINT `medicina_sintoma_ibfk_1` FOREIGN KEY (`medicina_id`) REFERENCES `medicina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicina_sintoma_ibfk_2` FOREIGN KEY (`sintoma_id`) REFERENCES `sintoma` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`);

--
-- Filtros para la tabla `uso_utensilio`
--
ALTER TABLE `uso_utensilio`
  ADD CONSTRAINT `uso_utensilio_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uso_utensilio_ibfk_2` FOREIGN KEY (`utensilio_id`) REFERENCES `utensilio` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuario_login`
--
ALTER TABLE `usuario_login`
  ADD CONSTRAINT `usuario_login_ibfk_1` FOREIGN KEY (`id_ul`) REFERENCES `usuario` (`id_u`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
=======
CREATE TABLE uso_utensilio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cita_id INT NOT NULL,
    utensilio_id INT NOT NULL,
    cantidad_usada INT NOT NULL,
    costo_total DECIMAL(10, 2) AS (cantidad_usada * (SELECT costo FROM utensilio WHERE utensilio.id = uso_utensilio.utensilio_id)) STORED,
    FOREIGN KEY (cita_id) REFERENCES citas(id) ON DELETE CASCADE,
    FOREIGN KEY (utensilio_id) REFERENCES utensilio(id) ON DELETE CASCADE
);


-- Tabla de medicinas con campo de imagen 
CREATE TABLE medicina ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL UNIQUE, 
    descripcion TEXT, 
    costo DECIMAL(10, 2) NOT NULL, 
    imagen LONGTEXT  -- Campo para almacenar la imagen en Base64 o URL de la imagen 
); 

-- Tabla de inventario de medicinas 
CREATE TABLE inventario_medicina ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    medicina_id INT NOT NULL, 
    cantidad INT NOT NULL, 
    FOREIGN KEY (medicina_id) REFERENCES medicina(id) ON DELETE CASCADE 
); 

-- Tabla de síntomas 
CREATE TABLE sintoma ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL UNIQUE, 
    descripcion TEXT 
); 

-- Tabla intermedia para relacionar medicinas con síntomas 
CREATE TABLE medicina_sintoma ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    medicina_id INT NOT NULL, 
    sintoma_id INT NOT NULL, 
    FOREIGN KEY (medicina_id) REFERENCES medicina(id) ON DELETE CASCADE, 
    FOREIGN KEY (sintoma_id) REFERENCES sintoma(id) ON DELETE CASCADE, 
    UNIQUE (medicina_id, sintoma_id)  -- Evitar duplicados en la relación 
);  

-- Tabla para registrar el uso de medicinas en las citas 
CREATE TABLE uso_medicina ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    cita_id INT NOT NULL, 
    medicina_id INT NOT NULL, 
    cantidad_usada INT NOT NULL, 
    costo_total DECIMAL(10, 2) AS (cantidad_usada * (SELECT costo FROM medicina WHERE medicina.id = uso_medicina.medicina_id)) STORED, 
    FOREIGN KEY (cita_id) REFERENCES citas(id) ON DELETE CASCADE, 
    FOREIGN KEY (medicina_id) REFERENCES medicina(id) ON DELETE CASCADE 
); 
>>>>>>> f898329e6353263396e428c23f583706b8a24d41
