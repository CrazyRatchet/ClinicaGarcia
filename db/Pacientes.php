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
public function agregarHistorialMedico($paciente_id, $nombre_completo, $fecha_nacimiento, $numero_identificacion, $direccion, $numero_telefono,
                                       $antecedentes_familiares, $medicamentos_actuales, $alergias, $historia_sintomas, $fecha) {
    $query = "INSERT INTO historias_medicas (paciente_id, nombre_completo, fecha_nacimiento, numero_identificacion, direccion, numero_telefono,
              antecedentes_familiares, medicamentos_actuales, alergias, historia_sintomas, fecha)
              VALUES (:paciente_id, :nombre_completo, :fecha_nacimiento, :numero_identificacion, :direccion, :numero_telefono,
              :antecedentes_familiares, :medicamentos_actuales, :alergias, :historia_sintomas, :fecha)";
    
    $stmt = $this->conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':paciente_id', $paciente_id);
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $stmt->bindParam(':numero_identificacion', $numero_identificacion);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':numero_telefono', $numero_telefono);
    $stmt->bindParam(':antecedentes_familiares', $antecedentes_familiares);
    $stmt->bindParam(':medicamentos_actuales', $medicamentos_actuales);
    $stmt->bindParam(':alergias', $alergias);
    $stmt->bindParam(':historia_sintomas', $historia_sintomas);
    $stmt->bindParam(':fecha', $fecha);

    return $stmt->execute(); // Devuelve verdadero si se insertó correctamente
}
public function obtenerPacientes() {
    $query = "SELECT id, nombre FROM pacientes"; // Ajusta según la estructura de tu tabla de pacientes
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Obtener historial médico por ID de paciente
public function obtenerHistorialPorPacienteId($pacienteId) {
    $query = "SELECT * FROM historias_medicas WHERE paciente_id = :paciente_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':paciente_id', $pacienteId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Modificar historial médico

public function tieneHistorialMedico($pacienteId) {
    $query = "SELECT COUNT(*) FROM historias_medicas WHERE paciente_id = :paciente_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':paciente_id', $pacienteId);
    $stmt->execute();
    return $stmt->fetchColumn() > 0; // Devuelve true si hay registros
}
public function obtenerPacientePorId($id) {
    $query = "SELECT * FROM pacientes WHERE id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function obtenerHistorialPorId($id) {
    $query = "SELECT * FROM historias_medicas WHERE id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Verifica si se encontró un historial
    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return null; // Retorna null si no se encontró el historial
}

public function modificarHistorialMedico($id, $paciente_id, $nombre_completo, $fecha_nacimiento, $numero_identificacion, $direccion, $numero_telefono,
                                         $antecedentes_familiares, $medicamentos_actuales, $alergias, $historia_sintomas, $fecha) {
    $query = "UPDATE historias_medicas SET 
              paciente_id = :paciente_id,
              nombre_completo = :nombre_completo,
              fecha_nacimiento = :fecha_nacimiento,
              numero_identificacion = :numero_identificacion,
              direccion = :direccion,
              numero_telefono = :numero_telefono,
              antecedentes_familiares = :antecedentes_familiares,
              medicamentos_actuales = :medicamentos_actuales,
              alergias = :alergias,
              historia_sintomas = :historia_sintomas,
              fecha = :fecha
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':paciente_id', $paciente_id);
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $stmt->bindParam(':numero_identificacion', $numero_identificacion);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':numero_telefono', $numero_telefono);
    $stmt->bindParam(':antecedentes_familiares', $antecedentes_familiares);
    $stmt->bindParam(':medicamentos_actuales', $medicamentos_actuales);
    $stmt->bindParam(':alergias', $alergias);
    $stmt->bindParam(':historia_sintomas', $historia_sintomas);
    $stmt->bindParam(':fecha', $fecha);

    return $stmt->execute(); // Devuelve verdadero si la actualización fue exitosa
}

}
