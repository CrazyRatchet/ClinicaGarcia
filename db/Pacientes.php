<?php
class Pacientes
{
    private $conn;
    public $datos_paciente = []; // Arreglo para manejar los datos básicos del paciente

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear un paciente (solo nombre y cédula)
    public function crearPacienteBasico()
    {
        try {
            // Inserta solo nombre y cédula, dejando los demás campos vacíos o nulos
            $query = "INSERT INTO pacientes (nombre, cedula, edad, peso, tipo_sangre, altura, alergias, fecha_nacimiento)
                    VALUES (:nombre, :cedula, NULL, NULL, NULL, NULL, NULL, NULL)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $this->datos_paciente['nombre']);
            $stmt->bindParam(':cedula', $this->datos_paciente['cedula']);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Error al ejecutar la consulta de creación.");
            }
        } catch (Exception $e) {
            error_log("Error en crearPacienteBasico: " . $e->getMessage());
            return false;
        }
    }

    // Método para que el médico complete los datos del paciente
    public function completarDatosPaciente($id)
    {
        try {
            $query = "UPDATE pacientes
                    SET edad = :edad, peso = :peso, tipo_sangre = :tipo_sangre, altura = :altura, 
                        alergias = :alergias, fecha_nacimiento = :fecha_nacimiento
                    WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':edad', $this->datos_paciente['edad']);
            $stmt->bindParam(':peso', $this->datos_paciente['peso']);
            $stmt->bindParam(':tipo_sangre', $this->datos_paciente['tipo_sangre']);
            $stmt->bindParam(':altura', $this->datos_paciente['altura']);
            $stmt->bindParam(':alergias', $this->datos_paciente['alergias']);
            $stmt->bindParam(':fecha_nacimiento', $this->datos_paciente['fecha_nacimiento']);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Error al ejecutar la consulta de actualización.");
            }
        } catch (Exception $e) {
            error_log("Error en completarDatosPaciente: " . $e->getMessage());
            return false;
        }
    }
    public function busquedaPacientesSeleccionados()
{
    try {
        $query = "SELECT id, nombre, cedula, edad, peso, tipo_sangre, altura, alergias, fecha_nacimiento FROM pacientes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error en busquedaPacientesSeleccionados: " . $e->getMessage());
        return false;
    }
}
public function eliminarPaciente($id)
{
    try {
        $query = "DELETE FROM pacientes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error en eliminarPaciente: " . $e->getMessage());
        return false;
    }
}
public function modificarPaciente($id, $nombre, $cedula)
{
    try {
        $query = "UPDATE pacientes SET nombre = :nombre, cedula = :cedula WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cedula', $cedula);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error en modificarPaciente: " . $e->getMessage());
        return false;
    }
}
public function obtenerDatosMedicos($id)
{
    $query = "SELECT edad, peso, tipo_sangre, altura, alergias, fecha_nacimiento FROM pacientes WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
