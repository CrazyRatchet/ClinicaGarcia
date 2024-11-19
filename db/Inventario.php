<?php
class Inventario {
    private $db;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection(); // Obtén la conexión desde el método getConnection()
        } catch (Exception $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }

    // Método para listar utensilios
    public function listarUtensilios(): array {
        try {
            $query = "SELECT * FROM utensilio";
            $stmt = $this->db->prepare($query); // Usamos prepare() en lugar de query()
            $stmt->execute();
            return $stmt->fetchAll(); // Obtenemos todos los resultados como un array asociativo
        } catch (Exception $e) {
            echo "Error al obtener utensilios: " . $e->getMessage();
            return [];
        }
    }

    public function registrarUtensilio($imagen, $nombre, $descripcion, $costo) {
        $query = "INSERT INTO utensilio (imagen, nombre, descripcion, costo) VALUES (:imagen, :nombre, :descripcion, :costo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':imagen',$imagen);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo, PDO::PARAM_STR);

        return $stmt->execute();
    }

    
    public function obtenerUtensilioPorId($id) {
        $query = "SELECT * FROM utensilio WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function actualizarUtensilio($id, $nombre, $descripcion, $costo, $imagen) {
        $query = "UPDATE utensilio SET nombre = :nombre, descripcion = :descripcion, costo = :costo, imagen = :imagen WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function eliminarUtensilio($id) {
        $query = "DELETE FROM utensilio WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }    

}
?>