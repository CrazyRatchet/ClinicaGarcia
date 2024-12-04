<?php
class Consultas {
    private $conn;
    private $table_name = "consultas_medicas";

    public $id;
    public $paciente_id;
    public $nombre_completo;
    public $fecha_nacimiento;
    public $numero_identificacion;
    public $direccion;
    public $numero_telefono;
    public $antecedentes_familiares;
    public $medicamentos_regulares;
    public $padecimientos;
    public $alergias;
    public $sintomas;
    public $diagnostico;
    public $fecha_consulta;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las consultas de un paciente
    public function obtenerConsultasPorPaciente($paciente_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE paciente_id = :paciente_id ORDER BY fecha_consulta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":paciente_id", $paciente_id);
        $stmt->execute();
        return $stmt;
    }
    

    public function obtenerConsultaPorId($consultaId, $pacienteId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :consulta_id AND paciente_id = :paciente_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":consulta_id", $consultaId);
        $stmt->bindParam(":paciente_id", $pacienteId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar una nueva consulta
    public function insertarConsulta() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (paciente_id, nombre_completo, fecha_nacimiento, numero_identificacion, direccion, 
                   numero_telefono, antecedentes_familiares, medicamentos_regulares, padecimientos, 
                   alergias, sintomas, diagnostico, fecha_consulta) 
                  VALUES (:paciente_id, :nombre_completo, :fecha_nacimiento, :numero_identificacion, 
                          :direccion, :numero_telefono, :antecedentes_familiares, :medicamentos_regulares, 
                          :padecimientos, :alergias, :sintomas, :diagnostico, :fecha_consulta)";
        
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(":paciente_id", $this->paciente_id);
        $stmt->bindParam(":nombre_completo", $this->nombre_completo);
        $stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
        $stmt->bindParam(":numero_identificacion", $this->numero_identificacion);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":numero_telefono", $this->numero_telefono);
        $stmt->bindParam(":antecedentes_familiares", $this->antecedentes_familiares);
        $stmt->bindParam(":medicamentos_regulares", $this->medicamentos_regulares);
        $stmt->bindParam(":padecimientos", $this->padecimientos);
        $stmt->bindParam(":alergias", $this->alergias);
        $stmt->bindParam(":sintomas", $this->sintomas);
        $stmt->bindParam(":diagnostico", $this->diagnostico);
        $stmt->bindParam(":fecha_consulta", $this->fecha_consulta);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
