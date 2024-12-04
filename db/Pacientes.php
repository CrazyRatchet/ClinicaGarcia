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
            // Verificar si el paciente ya existe
            if ($this->verificarPacienteExistente($this->datos_paciente['cedula'])) {
                throw new Exception("El paciente ya está registrado.");
            }
    
            // Inserta solo nombre y cédula, dejando los demás campos vacíos o nulos
            $query = "INSERT INTO pacientes (nombre, cedula, sexo, fecha_nacimiento, edad, peso, altura, tipo_sangre, correo, alergias, medicamentos_regulares, padecimientos, fecha_datos)
            VALUES (:nombre, :cedula, NULL, NULL, NULL, NULL, NULL, NULL, :correo, NULL, NULL, NULL, NULL)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $this->datos_paciente['nombre']);
            $stmt->bindParam(':cedula', $this->datos_paciente['cedula']);
            $stmt->bindParam(':correo', $this->datos_paciente['correo']);
  
    
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
    
    public function verificarPacienteExistente($cedula)
{
    try {
        // Consulta para verificar si existe un paciente con la misma cédula
        $query = "SELECT COUNT(*) FROM pacientes WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();

        // Devuelve true si encuentra al menos un registro
        return $stmt->fetchColumn() > 0;
    } catch (Exception $e) {
        error_log("Error en verificarPacienteExistente: " . $e->getMessage());
        return false;
    }
}
 // función para buscar pacientes por cédula
 public function buscarPacientePorCedula($cedula) {
    $query = "SELECT * FROM pacientes WHERE cedula LIKE :cedula";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Método para que el médico complete los datos del paciente
    public function completarDatosPaciente($id)
{
    try {
        $query = "UPDATE pacientes
                  SET sexo = :sexo, fecha_nacimiento = :fecha_nacimiento,
                      edad = :edad, peso = :peso, altura = :altura, tipo_sangre = :tipo_sangre,
                      alergias = :alergias, medicamentos_regulares = :medicamentos_regulares,
                      padecimientos = :padecimientos, fecha_datos = :fecha_datos
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Asignar los valores a los parámetros
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':sexo', $this->datos_paciente['sexo']);
        $stmt->bindParam(':fecha_nacimiento', $this->datos_paciente['fecha_nacimiento']);
        $stmt->bindParam(':edad', $this->datos_paciente['edad']);
        $stmt->bindParam(':peso', $this->datos_paciente['peso']);
        $stmt->bindParam(':altura', $this->datos_paciente['altura']);
        $stmt->bindParam(':tipo_sangre', $this->datos_paciente['tipo_sangre']);;
        $stmt->bindParam(':alergias', $this->datos_paciente['alergias']);
        $stmt->bindParam(':medicamentos_regulares', $this->datos_paciente['medicamentos_regulares']);
        $stmt->bindParam(':padecimientos', $this->datos_paciente['padecimientos']);
        $stmt->bindParam(':fecha_datos', $this->datos_paciente['fecha_datos']);

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
        $query = "SELECT id, nombre, cedula, edad, peso, tipo_sangre, correo, altura, alergias, fecha_nacimiento FROM pacientes";
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
public function modificarPaciente($id, $nombre, $cedula, $correo)
{
    try {
        $query = "UPDATE pacientes 
                SET nombre = :nombre, cedula = :cedula, correo = :correo 
                WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':correo', $correo);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Error en modificarPaciente: " . $e->getMessage());
        return false;
    }
}
public function obtenerDatosMedicos($id)
{
    $query = "SELECT 
                sexo, 
                edad, 
                peso, 
                altura, 
                tipo_sangre, 
                correo, 
                alergias, 
                medicamentos_regulares, 
                padecimientos, 
                fecha_datos, 
                fecha_nacimiento 
              FROM pacientes 
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener historial médico por ID de paciente


// Modificar historial médico

public function obtenerPacientePorId($id) {
    $query = "SELECT * FROM pacientes WHERE id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function obtenerTodosLosPacientes()
{
    try {
        $query = "SELECT * FROM pacientes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error en obtenerTodosLosPacientes: " . $e->getMessage());
        return [];
    }
}

}
