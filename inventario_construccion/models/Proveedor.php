<?php
class Proveedor {
    private $conn;
    private $table_name = "proveedores";

    public $id;
    public $nombre;
    public $contacto;
    public $telefono;
    public $direccion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leer() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function leerUno() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nombre = $row['nombre'];
        $this->contacto = $row['contacto'];
        $this->telefono = $row['telefono'];
        $this->direccion = $row['direccion'];
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre=:nombre, contacto=:contacto, telefono=:telefono, direccion=:direccion";
        $stmt = $this->conn->prepare($query);
        
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->contacto = htmlspecialchars(strip_tags($this->contacto));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":contacto", $this->contacto);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":direccion", $this->direccion);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre=:nombre, contacto=:contacto, telefono=:telefono, direccion=:direccion 
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->contacto = htmlspecialchars(strip_tags($this->contacto));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":contacto", $this->contacto);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":id", $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>