<?php
class Medicina
{
    private $conn;
    public $table_name = "medicina";

    // Campos de la tabla medicina
    public $datos = [
        "nombre" => null,
        "descripcion" => null,
        "costo" => null,
        "imagen" => null,
        "id" => null // Se incluye para la actualización
    ];

    public function __construct($db)
    {
        $this->conn = $db; // Conexión a la base de datos
    }

    // Método para crear una nueva medicina
    public function crearMedicina()
    {
        try {
            $this->conn->beginTransaction();
    
            // Inserta la medicina en la tabla `medicina`
            $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion, costo, imagen)
                      VALUES (:nombre, :descripcion, :costo, :imagen)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $this->datos['nombre']);
            $stmt->bindParam(':descripcion', $this->datos['descripcion']);
            $stmt->bindParam(':costo', $this->datos['costo']);
            $stmt->bindParam(':imagen', $this->datos['imagen']);
            $stmt->execute();
    
            $medicina_id = $this->conn->lastInsertId();
    
            // Inserta en inventario
            $queryInventario = "INSERT INTO inventario_medicina (medicina_id, cantidad)
                                VALUES (:medicina_id, :cantidad)";
            $stmtInventario = $this->conn->prepare($queryInventario);
            $stmtInventario->bindParam(':medicina_id', $medicina_id);
            $stmtInventario->bindParam(':cantidad', $this->datos['cantidad']);
            $stmtInventario->execute();
    
            // Inserta la relación en la tabla de relación para cada síntoma
            $queryRelacion = "INSERT INTO medicina_sintoma (medicina_id, sintoma_id) VALUES (:medicina_id, :sintoma_id)";
            $stmtRelacion = $this->conn->prepare($queryRelacion);
            foreach ($this->datos['sintomas'] as $sintoma_id) {
                $stmtRelacion->bindParam(':medicina_id', $medicina_id);
                $stmtRelacion->bindParam(':sintoma_id', $sintoma_id);
                $stmtRelacion->execute();
            }
    
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    // Método para actualizar una medicina
    public function actualizarMedicina()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, descripcion = :descripcion, costo = :costo, imagen = :imagen 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Asignar los valores a los parámetros
        $stmt->bindParam(':nombre', $this->datos['nombre']);
        $stmt->bindParam(':descripcion', $this->datos['descripcion']);
        $stmt->bindParam(':costo', $this->datos['costo']);
        $stmt->bindParam(':imagen', $this->datos['imagen']);
        $stmt->bindParam(':id', $this->datos['id']);

        return $stmt->execute(); // Ejecutar la actualización
    }

    // Método para eliminar una medicina
    public function eliminarMedicina($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Método para obtener todas las medicinas
    public function obtenerMedicinas()
{
    $query = "
        SELECT m.*, i.cantidad, GROUP_CONCAT(s.nombre SEPARATOR ', ') AS sintomas
        FROM " . $this->table_name . " m
        LEFT JOIN inventario_medicina i ON m.id = i.medicina_id
        LEFT JOIN medicina_sintoma ms ON m.id = ms.medicina_id
        LEFT JOIN sintoma s ON ms.sintoma_id = s.id
        GROUP BY m.id
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerSintomasPorMedicina($medicinaId) {
    $query = "SELECT s.id, s.nombre
              FROM sintoma s
              INNER JOIN medicina_sintoma ms ON s.id = ms.sintoma_id
              WHERE ms.medicina_id = :medicinaId";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':medicinaId', $medicinaId, PDO::PARAM_INT);
    $stmt->execute();
    
    $sintomas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sintomas;
}


}
