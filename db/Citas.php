<?php
class Citas {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; // Guardamos la conexión a la base de datos
    }

    // Método para agendar una nueva cita
    public function agendarCita($paciente_id, $doctor_id, $fecha, $hora) {
        $query = "INSERT INTO citas (paciente_id, doctor_id, fecha, hora) VALUES (:paciente_id, :doctor_id, :fecha, :hora)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        return $stmt->execute(); // Retorna verdadero si se ejecuta correctamente
    }

    // Método para verificar si ya existe una cita para el mismo paciente y doctor en la misma fecha y hora
    public function verificarCitaExistente($paciente_id, $doctor_id, $fecha, $hora) {
        $query = "SELECT COUNT(*) FROM citas WHERE paciente_id = :paciente_id AND doctor_id = :doctor_id AND fecha = :fecha AND hora = :hora";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Devuelve verdadero si hay citas existentes
    }

    // Método para obtener todas las citas
    public function obtenerCitas() {
        $query = "SELECT citas.id, pacientes.nombre AS paciente, usuario.nombre AS medico, citas.fecha, citas.hora
                  FROM citas
                  JOIN pacientes ON citas.paciente_id = pacientes.id
                  JOIN usuario ON citas.doctor_id = usuario.id_u";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener una cita por su ID
    public function obtenerCitaPorId($id) {
        $query = "SELECT citas.id, citas.paciente_id, citas.doctor_id, citas.fecha, citas.hora,
                         pacientes.nombre AS paciente, usuarios.nombre AS medico
                  FROM citas
                  JOIN pacientes ON citas.paciente_id = pacientes.id
                  JOIN usuarios ON citas.doctor_id = usuarios.id_u
                  WHERE citas.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Método para obtener citas por paciente (opcional)
    public function obtenerCitasPorPaciente($paciente_id) {
        $query = "SELECT * FROM citas WHERE paciente_id = :paciente_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna citas del paciente
    }

    // Método para obtener citas por doctor (opcional)
    public function obtenerCitasPorDoctor($doctor_id) {
        $query = "SELECT * FROM citas WHERE doctor_id = :doctor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna citas del doctor
    }
}
