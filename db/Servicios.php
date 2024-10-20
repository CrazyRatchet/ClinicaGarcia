<?php

class Servicios
{
    private $conn;

    // Nombre de la tabla en la base de datos
    public $table_name = "servicio";

    // Campos de la tabla servicio
    public $servicio = [
        "nombre_s",
        "descripcion_s",
        "equipamiento_s",
        "costo_s",
        "id" // Se añade para la actualización
    ];

    public function __construct($db)
    {
        $this->conn = $db; // Conexión a la base de datos
    }

    // Método para crear un nuevo servicio
    public function crearServicio()
    {
        $query = "INSERT INTO " . $this->table_name . "
        (nombre_s, descripcion_s, equipamiento_s, costo_s)
        VALUES
        (:nombre_s, :descripcion_s, :equipamiento_s, :costo_s)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar los valores del servicio
        foreach ($this->servicio as $key => $value) {
            $this->servicio[$key] = htmlspecialchars(strip_tags($value));
        }

        // Asignar los parámetros
        $stmt->bindParam(":nombre_s", $this->servicio['nombre_s']);
        $stmt->bindParam(":descripcion_s", $this->servicio['descripcion_s']);
        $stmt->bindParam(":equipamiento_s", $this->servicio['equipamiento_s']);
        $stmt->bindParam(":costo_s", $this->servicio['costo_s']);

        return $stmt->execute(); // Ejecutar la inserción
    }

    // Método para buscar registros en una tabla
    public function buscarRegistros($atributo, $value)
    {
        $query = "SELECT * FROM " .  $this->table_name . " WHERE " . $atributo . " = :value";
        $stmt = $this->conn->prepare($query);

        $value = htmlspecialchars(strip_tags($value));
        $stmt->bindParam(":value", $value);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function actualizarServicio() {
        // Método para actualizar un servicio en la base de datos
        $query = "UPDATE " . $this->table_name . " SET nombre_s = :nombre_s, descripcion_s = :descripcion_s, equipamiento_s = :equipamiento_s, costo_s = :costo_s WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
        
        // Asignar los valores a los parámetros
        $stmt->bindParam(':nombre_s', $this->servicio['nombre_s']);
        $stmt->bindParam(':descripcion_s', $this->servicio['descripcion_s']);
        $stmt->bindParam(':equipamiento_s', $this->servicio['equipamiento_s']);
        $stmt->bindParam(':costo_s', $this->servicio['costo_s']);
        $stmt->bindParam(':id', $this->servicio['id']);
    
        return $stmt->execute(); // Retorna el resultado de la ejecución
    }

    // Método para eliminar un registro
    public function eliminarRegistro($id)
    {
        $query = "DELETE FROM " .  $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Método para obtener todos los servicios
    public function obtenerServicios()
    {
        $query = "SELECT * FROM " .  $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
