<?php
class Usuarios
{
    private $conn;
    public $datos = [];
    public $datos_login = [];

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear usuario
    public function crearUsuario()
    {
        // Inicia la transacción
        $this->conn->beginTransaction();
        try {
            // Inserción en la tabla usuario
            $query = "INSERT INTO usuario (nombre, apellido, cedula, direccion, correo, telefono, rol_id)
                      VALUES (:nombre, :apellido, :cedula, :direccion, :correo, :telefono, :rol_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $this->datos['nombre']);
            $stmt->bindParam(':apellido', $this->datos['apellido']);
            $stmt->bindParam(':cedula', $this->datos['cedula']);
            $stmt->bindParam(':direccion', $this->datos['direccion']);
            $stmt->bindParam(':correo', $this->datos['correo']);
            $stmt->bindParam(':telefono', $this->datos['telefono']);
            $stmt->bindParam(':rol_id', $this->datos['rol_id']);
            $stmt->execute();

            // Obtener el ID del usuario recién creado
            $usuario_id = $this->conn->lastInsertId();

            // Insertar en la tabla de usuario_login
            $query_login = "INSERT INTO usuario_login (id_ul, nombre_usuario, contrasenia)
                            VALUES (:usuario_id, :nombre_usuario, :contrasenia)";
            $stmt_login = $this->conn->prepare($query_login);
            $stmt_login->bindParam(':usuario_id', $usuario_id);
            $stmt_login->bindParam(':nombre_usuario', $this->datos_login['nombre_usuario']);
            $stmt_login->bindParam(':contrasenia', $this->datos_login['contrasenia']);
            $stmt_login->execute();

            // Commit de la transacción
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback en caso de error
            $this->conn->rollBack();
            return false;
        }
    }

    // Método para agregar especialidad a la tabla intermedia
    public function agregarEspecialidad($usuario_id, $especialidad_id)
    {
        $query = "INSERT INTO especialidad_usuario (id_usuario, id_especialidad) VALUES (:usuario_id, :especialidad_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':especialidad_id', $especialidad_id);
        $stmt->execute();
    }

    // Método para buscar usuarios por un campo específico
    public function busquedaUsuarios($campo, $valor)
    {
        $query = "SELECT u.*, ul.contrasenia, r.nombre_r AS rol
                  FROM usuario u
                  JOIN usuario_login ul ON u.id_u = ul.id_ul
                  LEFT JOIN rol r ON u.rol_id = r.id
                  WHERE ul.$campo = :valor";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function busquedaUsuariosSeleccionados() {
        // Consulta para obtener los datos de los usuarios junto con su rol y especialidad
        $query = "SELECT 
                      u.id_u, 
                      u.nombre, 
                      u.apellido, 
                      u.cedula, 
                      u.direccion, 
                      u.correo, 
                      u.telefono, 
                      r.nombre_r AS rol, 
                      GROUP_CONCAT(e.nombre SEPARATOR ', ') AS especialidades
                  FROM 
                      usuario u
                  LEFT JOIN 
                      rol r ON u.rol_id = r.id
                  LEFT JOIN 
                      especialidad_usuario eu ON u.id_u = eu.id_usuario
                  LEFT JOIN 
                      especialidad e ON eu.id_especialidad = e.id
                  GROUP BY 
                      u.id_u";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los resultados como un array asociativo
    }

    // Método para eliminar un usuario
    public function eliminarUsuario($id)
    {
        $query = "DELETE FROM usuario WHERE id_u = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); // Retorna verdadero si se elimina correctamente
    }
}
