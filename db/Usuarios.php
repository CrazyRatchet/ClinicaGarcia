<?php

class Usuarios
{
    private $conn;
    private $table_name = [
        "usuarios",
        "usuarios_login"
    ];

    public $datos = [
        "nombre",
        "apellido",
        "cedula",
        "direccion",
        "correo",
        "telefono",
        "rol",
        "especialidad",
    ];

    public $datos_login = [
        "nombre_usuario",
        "contrasenia"
    ];

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrarUsuarios()
    {
        $query = "Insert into " . $this->table_name[0] . "
        (nombre, apellido, cedula, direccion, correo, telefono, rol, especialidad)
        values
        (:nombre, :apellido, :cedula, :direccion, :correo, :telefono, :rol, :especialidad)";

        $stmt = $this->conn->prepare($query);


        foreach ($this->datos as $key => $value) {
            $this->datos[$key] = htmlspecialchars(strip_tags($value));
        }

        $stmt->bindParam(":nombre", $this->datos['nombre']);
        $stmt->bindParam(":apellido", $this->datos['apellido']);
        $stmt->bindParam(":cedula", $this->datos['cedula']);
        $stmt->bindParam(":direccion", $this->datos['direccion']);
        $stmt->bindParam(":correo", $this->datos['correo']);
        $stmt->bindParam(":telefono", $this->datos['telefono']);
        $stmt->bindParam(":rol", $this->datos['rol']);
        $stmt->bindParam(":especialidad", $this->datos['especialidad']);

        $query2 = "Insert into " . $this->table_name[1] . "
        (nombre_usuario, contrasenia)
        values 
        (:nombre_usuario, :contrasenia)";

        $stmt2 = $this->conn->prepare($query2);

        foreach ($this->datos_login as $key => $value) {
            $this->datos[$key] = htmlspecialchars(strip_tags($value));
        }


        $stmt2->bindParam(":nombre_usuario", $this->datos_login['nombre_usuario']);
        $stmt2->bindParam(":contrasenia", $this->datos_login['contrasenia']);

        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        }
        return false;
    }

    public function busquedaUsuarios($table, $atribute, $value){
        $query = "Select * From " . $table . " Where " . $atribute . " = :value";
        $stmt = $this->conn->prepare($query);

        $value = htmlspecialchars(strip_tags($value));
        $stmt->bindParam(":value", $value);

        if($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;

    }

    public function actualizarDatos($table, $atribute, $value){
        $query = "Update " . $atribute . " Set " . $value . " = :value";
        $stmt = $this->conn->prepare($query);

        $value = htmlspecialchars(strip_tags($value));
        $stmt->bindParam(":value", $value);

        if($stmt->execute()){
            return true;
        }
        return false;

    }
}
