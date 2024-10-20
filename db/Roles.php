<?php

class Roles
{
    private $conn;

    // Nombres de las tablas en la base de datos
    public $table_name = [
        "rol",
        "permiso",
        "rol_permiso"
    ];

    public function __construct($db)
    {
        $this->conn = $db; // Conexión a la base de datos
    }

    // Método para crear un rol
    public function crearRol($data) {
        // Preparar consulta SQL para insertar el rol
        $query = "INSERT INTO rol (nombre_r, descripcion_r) VALUES (:nombre_r, :descripcion_r)";
        $stmt = $this->conn->prepare($query);

        // Bindear los parámetros
        $stmt->bindParam(':nombre_r', $data['nombre_r']);
        $stmt->bindParam(':descripcion_r', $data['descripcion_r']);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el ID del rol creado
            $rolId = $this->conn->lastInsertId();

            // Insertar relaciones en la tabla de rol_permiso para todos los permisos seleccionados
            if (!empty($data['permisos'])) {
                $query = "INSERT INTO rol_permiso (rol_id, permiso_id) VALUES (:rol_id, :permiso_id)";
                $stmt = $this->conn->prepare($query);

                // Iterar sobre los permisos seleccionados e insertarlos
                foreach ($data['permisos'] as $permisoId) {
                    $stmt->bindParam(':rol_id', $rolId);
                    $stmt->bindParam(':permiso_id', $permisoId);
                    $stmt->execute();
                }
            }
            return true; // Retornar true si la creación fue exitosa
        }

        return false; // Retornar false si hubo algún problema
    }

    // Método para obtener todos los roles
    public function obtenerRoles()
    {
        $query = "SELECT * FROM " . $this->table_name[0];
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para modificar un rol
    public function modificarRol($id, $nombre_r, $descripcion_r) {
        // Actualizar el rol en la base de datos
        $query = "UPDATE rol SET nombre_r = :nombre_r, descripcion_r = :descripcion_r WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_r', $nombre_r);
        $stmt->bindParam(':descripcion_r', $descripcion_r);
        $stmt->bindParam(':id', $id);

        return $stmt->execute(); // Retorna el resultado de la ejecución
    }

    // Método para eliminar un rol y sus relaciones
    public function eliminarRegistro($rolId) {
        // Eliminar las relaciones de rol_permiso
        $this->eliminarPermisosPorRol($rolId);

        // Ahora eliminar el rol
        $query = "DELETE FROM " . $this->table_name[0] . " WHERE id = :rol_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':rol_id', $rolId);
        return $stmt->execute();
    }

    // Método para eliminar las relaciones de un rol con los permisos
    public function eliminarPermisosPorRol($rolId) {
        $query = "DELETE FROM rol_permiso WHERE rol_id = :rol_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':rol_id', $rolId);
        return $stmt->execute();
    }

    // Método para buscar roles y sus permisos relacionados
    public function buscarRolesConPermisos() {
        // Consulta SQL para obtener roles y sus permisos relacionados
        $query = "
            SELECT r.id AS rol_id, r.nombre_r, r.descripcion_r, 
                   GROUP_CONCAT(p.nombre_p SEPARATOR ', ') AS permisos
            FROM " . $this->table_name[0] . " r
            LEFT JOIN " . $this->table_name[2] . " rp ON r.id = rp.rol_id
            LEFT JOIN " . $this->table_name[1] . " p ON rp.permiso_id = p.id
            GROUP BY r.id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
