<?php

class Sintomas
{
    private $conn;

    // Nombre de la tabla en la base de datos
    public $table_name = "sintoma";

    // Campos de la tabla sintoma
    public $sintoma = [
        "nombre",
        "descripcion",
        "id" // Incluido para identificar registros en actualizaciones y eliminaciones
    ];

    public function __construct($db)
    {
        $this->conn = $db; // Conexión a la base de datos
    }

    // Método para crear un nuevo síntoma
    public function crearSintoma()
    {
        $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion)
        VALUES (:nombre, :descripcion)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar los valores del síntoma
        foreach ($this->sintoma as $key => $value) {
            $this->sintoma[$key] = htmlspecialchars(strip_tags($value));
        }

        // Asignar los parámetros
        $stmt->bindParam(":nombre", $this->sintoma['nombre']);
        $stmt->bindParam(":descripcion", $this->sintoma['descripcion']);

        return $stmt->execute(); // Ejecutar la inserción
    }

    // Método para buscar registros en la tabla
    public function buscarRegistros($atributo, $value)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE " . $atributo . " = :value";
        $stmt = $this->conn->prepare($query);

        $value = htmlspecialchars(strip_tags($value));
        $stmt->bindParam(":value", $value);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Método para actualizar un síntoma en la base de datos
    public function actualizarSintoma()
    {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
        
        // Asignar los valores a los parámetros
        $stmt->bindParam(':nombre', $this->sintoma['nombre']);
        $stmt->bindParam(':descripcion', $this->sintoma['descripcion']);
        $stmt->bindParam(':id', $this->sintoma['id']);
    
        return $stmt->execute(); // Retorna el resultado de la ejecución
    }

    // Método para eliminar un registro
    public function eliminarRegistro($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Método para obtener todos los síntomas
    public function obtenerSintomas()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
