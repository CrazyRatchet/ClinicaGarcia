<?php
class Horarios {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener los horarios disponibles de un médico en una fecha específica
    public function obtenerHorariosDisponibles($doctor_id, $fecha) {
        $dia_semana = date('l', strtotime($fecha));
        
        $query = "SELECT hora_inicio, hora_fin
                  FROM horarios
                  WHERE doctor_id = :doctor_id AND dia_semana = :dia_semana";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':dia_semana', $dia_semana);
        $stmt->execute();
        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $queryCitas = "SELECT hora FROM citas WHERE doctor_id = :doctor_id AND fecha = :fecha";
        $stmtCitas = $this->conn->prepare($queryCitas);
        $stmtCitas->bindParam(':doctor_id', $doctor_id);
        $stmtCitas->bindParam(':fecha', $fecha);
        $stmtCitas->execute();
        $horasOcupadas = $stmtCitas->fetchAll(PDO::FETCH_COLUMN);
    
        $availableHours = [];
        foreach ($horarios as $horario) {
            $start = strtotime($horario['hora_inicio']);
            $end = strtotime($horario['hora_fin']);
            while ($start < $end) {
                $hora = date('H:i', $start);
                if (!in_array($hora, $horasOcupadas)) {
                    $availableHours[] = $hora;
                }
                $start = strtotime('+30 minutes', $start);
            }
        }
    
        return $availableHours;
    }
}
?>
