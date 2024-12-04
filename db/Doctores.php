<?php
class Doctores {
    // Conexión a la base de datos
    private $conn;
    private $table_name = "Doctores";

    // Propiedades del doctor
    public $id;
    public $nombre;
    public $especialidad;
    public $telefono;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtener todos los doctores seleccionados
     */
    public function obtenerDoctoresSeleccionados() {
        $query = "SELECT id, nombre, especialidad FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear un nuevo doctor
     */
    public function crearDoctor() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, especialidad, telefono) 
                  VALUES (:nombre, :especialidad, :telefono)";
        $stmt = $this->conn->prepare($query);

        // Limpieza de datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->especialidad = htmlspecialchars(strip_tags($this->especialidad));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));

        // Asignar valores
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':especialidad', $this->especialidad);
        $stmt->bindParam(':telefono', $this->telefono);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Obtener un doctor por su ID
     */
    public function obtenerDoctorPorId() {
        $query = "SELECT id, nombre, especialidad, telefono FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);

        // Limpieza de datos
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        // Ejecutar la consulta
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar propiedades
        if ($row) {
            $this->nombre = $row['nombre'];
            $this->especialidad = $row['especialidad'];
            $this->telefono = $row['telefono'];
            return true;
        }
        return false;
    }

    /**
     * Actualizar los datos de un doctor
     */
    public function actualizarDoctor() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, especialidad = :especialidad, telefono = :telefono 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Limpieza de datos
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->especialidad = htmlspecialchars(strip_tags($this->especialidad));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));

        // Asignar valores
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':especialidad', $this->especialidad);
        $stmt->bindParam(':telefono', $this->telefono);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Eliminar un doctor por su ID
     */
    public function eliminarDoctor() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Limpieza de datos
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
