CREATE DATABASE gestion_clinica;

USE gestion_clinica;

CREATE TABLE administrador (
    cedula VARCHAR (20) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    correo VARCHAR(40) NOT NULL,  
    direccion VARCHAR(100) NOT NULL,
    usuario VARCHAR (20) NOT NULL UNIQUE,
    contrasena VARCHAR (255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE medicos_credenciales (
    cedula VARCHAR(20) PRIMARY KEY,  
    usuario VARCHAR(20) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE medicos_informacion (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    cedula VARCHAR(20) NOT NULL, 
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    especialidad VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    FOREIGN KEY (cedula) REFERENCES medicos_credenciales(cedula) 
) ;

ALTER TABLE medicos_informacion
ADD CONSTRAINT unique_cedula UNIQUE (cedula);


CREATE TABLE especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);


INSERT INTO especialidades (nombre) VALUES
('Cardiología'),
('Cirugía General'),
('Dermatología'),
('Ginecología y Obstetricia'),
('Medicina Interna'),
('Neurología'),
('Oftalmología'),
('Oncología'),
('Odontología'),
('Pediatría'),
('Psiquiatría');

CREATE TABLE recepcionistas_credenciales (
    cedula VARCHAR(20) PRIMARY KEY,  
    usuario VARCHAR(20) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE recepcionistas_informacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(20) NOT NULL UNIQUE, 
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    FOREIGN KEY (cedula) REFERENCES recepcionistas_credenciales(cedula)
) ;


