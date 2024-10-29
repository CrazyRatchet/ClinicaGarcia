CREATE DATABASE clinica_garcia;
USE clinica_garcia;

CREATE TABLE rol (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_r VARCHAR(50) NOT NULL UNIQUE,
    descripcion_r TEXT
);

CREATE TABLE permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_p VARCHAR(100) NOT NULL UNIQUE,
    descripcion_p TEXT
);

CREATE TABLE rol_permiso (
    id_ int AUTO_INCREMENT primary Key,
    rol_id INT,
    permiso_id INT,
    FOREIGN KEY (rol_id) REFERENCES rol(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permiso(id) ON DELETE CASCADE,
    UNIQUE (rol_id, permiso_id)
);

CREATE TABLE especialidad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
);

CREATE TABLE usuario (
    id_u INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    direccion TEXT,
    correo VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(15) NOT NULL UNIQUE,
    rol_id INT,
    FOREIGN KEY (rol_id) REFERENCES rol(id)  ON DELETE SET NULL

);

CREATE TABLE usuario_login (
    id_ul INT,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasenia VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_ul) REFERENCES usuario(id_u)  ON DELETE CASCADE,
    PRIMARY KEY (id_ul)
);

CREATE TABLE servicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_s VARCHAR(100) NOT NULL UNIQUE,
    descripcion_s TEXT,
    equipamiento_s TEXT DEFAULT NULL,
    costo_s DECIMAL(10, 2) NOT NULL
);

CREATE TABLE servicio_permiso (
    id INT AUTO_INCREMENT Primary Key,
    servicio_id INT not null,
    permiso_id INT not null,
    FOREIGN KEY (servicio_id) REFERENCES servicio(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permiso(id) ON DELETE CASCADE,
    UNIQUE (servicio_id, permiso_id)
);


CREATE TABLE especialidad_usuario (
    id INT AUTO_INCREMENT Primary Key,
    id_usuario INT not null,
    id_especialidad INT not null,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_u) ON DELETE CASCADE,
    FOREIGN KEY (id_especialidad) REFERENCES especialidad(id) ON DELETE CASCADE,
    UNIQUE (id_usuario, id_especialidad)
);

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    peso DECIMAL(5,2),
    tipo_sangre VARCHAR(3),
    altura DECIMAL(4,2),
    alergias TEXT,
    fecha_nacimiento DATE
);

CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,  
    doctor_id INT NOT NULL,    
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (doctor_id) REFERENCES usuarios(id_u) 
);

