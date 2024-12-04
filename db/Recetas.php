<?php
class Recetas {
    private $conn;
    private $table_name = "recetas";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nueva receta
    public function crearReceta($paciente_id, $cedula, $correo_paciente, $medicamentos) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (paciente_id, cedula, correo_paciente, medicamentos) 
                  VALUES (:paciente_id, :cedula, :correo_paciente, :medicamentos)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':correo_paciente', $correo_paciente);
        $stmt->bindParam(':medicamentos', $medicamentos);

        return $stmt->execute();
    }

    // Obtener todas las recetas
    public function obtenerTodas() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY fecha_receta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar receta por cédula
    public function buscarPorCedula($cedula) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE cedula = :cedula ORDER BY fecha_receta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
