<?php

class Especialidades
{
    private $conn;

    // Nombre de la tabla en la base de datos
    public $table_name = "especialidad";

    // Campos de la tabla especialidad
    public $especialidad = [
        "nombre",
        "descripcion",
        "id" // Se añade para la actualización
    ];

    public function __construct($db)
    {
        $this->conn = $db; // Conexión a la base de datos
    }

    // Método para crear una nueva especialidad
    public function crearEspecialidad()
    {
        $query = "INSERT INTO " . $this->table_name . "
        (nombre, descripcion)
        VALUES
        (:nombre, :descripcion)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar los valores de la especialidad
        foreach ($this->especialidad as $key => $value) {
            $this->especialidad[$key] = htmlspecialchars(strip_tags($value));
        }

        // Asignar los parámetros
        $stmt->bindParam(":nombre", $this->especialidad['nombre']);
        $stmt->bindParam(":descripcion", $this->especialidad['descripcion']);

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

    // Método para actualizar una especialidad en la base de datos
    public function actualizarEspecialidad()
    {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        
        // Asignar los valores a los parámetros
        $stmt->bindParam(':nombre', $this->especialidad['nombre']);
        $stmt->bindParam(':descripcion', $this->especialidad['descripcion']);
        $stmt->bindParam(':id', $this->especialidad['id']);

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

    // Método para obtener todas las especialidades
    public function obtenerEspecialidades()
    {
        $query = "SELECT * FROM " .  $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
