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
    nombre VARCHAR(100) NOT NULL,
    cedula VARCHAR(20) NOT NULL,
    edad INT NULL,
    peso DECIMAL(5,2) NULL,
    tipo_sangre VARCHAR(3) NULL,
    altura DECIMAL(4,2) NULL,
    alergias TEXT NULL,
    fecha_nacimiento DATE NULL
);

CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,  
    doctor_id INT NOT NULL,    
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (doctor_id) REFERENCES usuario(id_u) 
);

CREATE TABLE historias_medicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    numero_identificacion VARCHAR(50),
    direccion VARCHAR(255),
    numero_telefono VARCHAR(20),
    antecedentes_familiares TEXT,
    medicamentos_actuales TEXT,
    alergias TEXT,
    historia_sintomas TEXT,
    fecha DATE NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE
);

CREATE TABLE utensilio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    costo DECIMAL(10, 2) NOT NULL,
    imagen LONGTEXT
);

CREATE TABLE inventario_utensilio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utensilio_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (utensilio_id) REFERENCES utensilio(id) ON DELETE CASCADE
);

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