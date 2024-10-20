<?php

class Permisos
{
    private $conn;

    // Nombres de las tablas en la base de datos
    public $table_name = [
        "permiso",
        "servicio",
        "servicio_permiso"
    ];

    public function __construct($db)
    {
        $this->conn = $db; // Conexión a la base de datos
    }
    public function crearPermiso($data) {
        // Preparar consulta SQL para insertar el permiso
        $query = "INSERT INTO permiso (nombre_p, descripcion_p) VALUES (:nombre_p, :descripcion_p)";
        $stmt = $this->conn->prepare($query);
    
        // Bindear los parámetros
        $stmt->bindParam(':nombre_p', $data['nombre_p']);
        $stmt->bindParam(':descripcion_p', $data['descripcion_p']);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el ID del permiso creado
            $permisoId = $this->conn->lastInsertId();
    
            // Insertar relaciones en la tabla de servicio_permiso para todos los servicios seleccionados
            if (!empty($data['servicios'])) {
                $query = "INSERT INTO servicio_permiso (permiso_id, servicio_id) VALUES (:permiso_id, :servicio_id)";
                $stmt = $this->conn->prepare($query);
    
                // Iterar sobre los servicios seleccionados e insertarlos
                foreach ($data['servicios'] as $servicioId) {
                    $stmt->bindParam(':permiso_id', $permisoId);
                    $stmt->bindParam(':servicio_id', $servicioId);
                    $stmt->execute();
                }
            }
            return true; // Retornar true si la creación fue exitosa
        }
    
        return false; // Retornar false si hubo algún problema
    }
    
    
    // Método para obtener todos los permisos
    public function obtenerPermisos()
    {
        $query = "SELECT * FROM " . $this->table_name[0];
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modificarPermiso($id, $nombre_p, $descripcion_p) {
        // Actualizar el permiso en la base de datos
        $query = "UPDATE permiso SET nombre_p = :nombre_p, descripcion_p = :descripcion_p WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_p', $nombre_p);
        $stmt->bindParam(':descripcion_p', $descripcion_p);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute(); // Retorna el resultado de la ejecución
    }

    public function eliminarRegistro($permisoId) {
        // Eliminar las relaciones de servicio_permiso
        $this->eliminarServiciosPorPermiso($permisoId);

        // Ahora eliminar el permiso
        $query = "DELETE FROM " . $this->table_name[0] . " WHERE id = :permiso_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':permiso_id', $permisoId);
        return $stmt->execute();
    }

    public function eliminarServiciosPorPermiso($permisoId) {
        $query = "DELETE FROM servicio_permiso WHERE permiso_id = :permiso_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':permiso_id', $permisoId);
        return $stmt->execute();
    }

    // Método para buscar permisos y sus servicios relacionados
    public function buscarPermisosConServicios() {
        // Consulta SQL para obtener permisos y sus servicios relacionados
        $query = "
            SELECT p.id AS permiso_id, p.nombre_p, p.descripcion_p, 
                   GROUP_CONCAT(s.nombre_s SEPARATOR ', ') AS servicios
            FROM " . $this->table_name[0] . " p
            LEFT JOIN " . $this->table_name[2] . " ps ON p.id = ps.permiso_id
            LEFT JOIN " . $this->table_name[1] . " s ON ps.servicio_id = s.id
            GROUP BY p.id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
