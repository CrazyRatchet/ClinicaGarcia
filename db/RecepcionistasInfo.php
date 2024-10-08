<?php
class RecepcionistasInfo {
    private $conn; // Conexión a la base de datos
    private $table_name = "recepcionistas_informacion"; // Nombre de la tabla

    // Propiedades de la clase
    public $id;
    public $cedula;
    public $nombre;
    public $apellido;
    public $telefono;
    public $correo;
    public $direccion;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo propietario natural
    public function registrar() {
        // Query para insertar un nuevo propietario natural
        $query = "INSERT INTO " . $this->table_name . " (cedula, nombre, apellido, telefono, correo, direccion) VALUES (:cedula, :nombre, :apellido, :telefono, :correo, :direccion)";

        // Preparar la declaración
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos para evitar inyección SQL
        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));

        // Enlazar los parámetros
        $stmt->bindParam(":cedula", $this->cedula);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":direccion", $this->direccion);
     
        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
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
