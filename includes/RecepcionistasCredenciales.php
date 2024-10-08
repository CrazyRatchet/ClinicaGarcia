<?php
class RecepcionistasCredenciales {
    private $conn;
    private $table_name = "recepcionistas_credenciales";

    // Propiedades de la clase
    public $cedula;
    public $usuario;
    public $contrasena;  // Mantener consistente el nombre como "contrasena"

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo administrador
    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " 
                 (cedula, usuario, contrasena) 
                 VALUES 
                 (:cedula, :usuario, :contrasena)";

        // Preparar la declaración
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $this->contrasena = htmlspecialchars(strip_tags($this->contrasena));

        // Encriptar la contraseña antes de guardarla
        $contrasena_hash = password_hash($this->contrasena, PASSWORD_DEFAULT);

        // Enlazar los parámetros
        $stmt->bindParam(":cedula", $this->cedula);
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":contrasena", $contrasena_hash);  // Usar la contraseña hasheada

        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para autenticar
    public function autenticar() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($query);

        // Limpiar el usuario
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        
        // Enlazar parámetro
        $stmt->bindParam(":usuario", $this->usuario);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Método para buscar por cédula
    public function buscar() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($query);

        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $stmt->bindParam(":cedula", $this->cedula);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
?>