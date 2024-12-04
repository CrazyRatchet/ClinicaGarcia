<?php

class Roles
{
    private $conn;

    // Nombre de la tabla de roles en la base de datos
    public $table_name = "rol";

    public function __construct($db)
    {
        $this->conn = $db; // Conexión a la base de datos
    }

    // Método para crear un rol
    public function crearRol($data)
    {
        try {
            // Validar datos
            if (empty($data['nombre_r'])) {
                throw new Exception("El nombre del rol es obligatorio.");
            }

            // Preparar consulta SQL para insertar el rol
            $query = "
                INSERT INTO " . $this->table_name . " 
                (nombre_r, permiso_administrador, permiso_medico, permiso_administrativos, permiso_citas, permiso_inventario) 
                VALUES (:nombre_r, :permiso_administrador, :permiso_medico, :permiso_administrativos, :permiso_citas, :permiso_inventario)
            ";
            $stmt = $this->conn->prepare($query);

            // Bindear los parámetros
            $stmt->bindParam(':nombre_r', $data['nombre_r']);
            $stmt->bindParam(':permiso_administrador', $data['permiso_administrador'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_medico', $data['permiso_medico'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_administrativos', $data['permiso_administrativos'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_citas', $data['permiso_citas'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_inventario', $data['permiso_inventario'], PDO::PARAM_BOOL);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return "Rol creado exitosamente.";
            }

            throw new Exception("Error al crear el rol.");
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Método para obtener todos los roles
    public function obtenerRoles()
    {
        try {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los roles como un array asociativo
        } catch (Exception $e) {
            return "Error al obtener roles: " . $e->getMessage();
        }
    }

    // Método para modificar un rol
    public function modificarRol($id, $data)
    {
        try {
            // Validar datos
            if (empty($data['nombre_r'])) {
                throw new Exception("El nombre del rol es obligatorio.");
            }

            // Actualizar el rol en la base de datos
            $query = "
                UPDATE " . $this->table_name . " 
                SET 
                    nombre_r = :nombre_r, 
                    permiso_administrador = :permiso_administrador, 
                    permiso_medico = :permiso_medico, 
                    permiso_administrativos = :permiso_administrativos, 
                    permiso_citas = :permiso_citas, 
                    permiso_inventario = :permiso_inventario 
                WHERE id = :id
            ";
            $stmt = $this->conn->prepare($query);

            // Bindear los parámetros
            $stmt->bindParam(':nombre_r', $data['nombre_r']);
            $stmt->bindParam(':permiso_administrador', $data['permiso_administrador'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_medico', $data['permiso_medico'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_administrativos', $data['permiso_administrativos'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_citas', $data['permiso_citas'], PDO::PARAM_BOOL);
            $stmt->bindParam(':permiso_inventario', $data['permiso_inventario'], PDO::PARAM_BOOL);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return "Rol actualizado exitosamente.";
            }

            throw new Exception("Error al actualizar el rol.");
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Método para eliminar un rol
    public function eliminarRol($id)
    {
        try {
            // Validar ID
            if (empty($id)) {
                throw new Exception("ID del rol es obligatorio.");
            }

            // Consulta SQL para eliminar el rol
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return "Rol eliminado exitosamente.";
            }

            throw new Exception("Error al eliminar el rol.");
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
