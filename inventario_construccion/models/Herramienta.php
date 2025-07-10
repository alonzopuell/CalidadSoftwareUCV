<?php
class Herramienta {
    private $conn;
    private $table_name = "herramientas";

    public $id;
    public $nombre;
    public $descripcion;
    public $categoria_id;
    public $stock;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leer() {
        $query = "SELECT h.*, c.nombre as categoria_nombre 
                 FROM herramientas h
                 LEFT JOIN categorias c ON h.categoria_id = c.id";
        return $this->conn->query($query);
    }

    public function leerUno() {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        $this->nombre = $row['nombre'];
        $this->descripcion = $row['descripcion'];
        $this->categoria_id = $row['categoria_id'];
        $this->stock = $row['stock'];
        $this->estado = $row['estado'];
    }
    
    return $row;
}

    public function crear() {
        $query = "INSERT INTO herramientas 
                 SET nombre=:nombre, descripcion=:descripcion, 
                 categoria_id=:categoria_id, stock=:stock, estado=:estado";
        
        $stmt = $this->conn->prepare($query);
        $this->bindParams($stmt);
        
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            $this->checkStockBajo();
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE herramientas SET 
                 nombre=:nombre, descripcion=:descripcion, 
                 categoria_id=:categoria_id, stock=:stock, estado=:estado
                 WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        $this->bindParams($stmt);
        $stmt->bindParam(":id", $this->id);
        
        if ($stmt->execute()) {
            $this->checkStockBajo();
            return true;
        }
        return false;
    }

    private function bindParams($stmt) {
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":estado", $this->estado);
    }

    private function checkStockBajo() {
        if ($this->stock <= 5) {
            $this->crearNotificacion();
        }
    }

    private function crearNotificacion() {
        $query = "INSERT INTO notificaciones (tipo, item_id, mensaje, leida)
                 VALUES ('herramienta', :item_id, :mensaje, FALSE)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':item_id', $this->id);
        $mensaje = "Stock bajo para herramienta {$this->nombre} ({$this->stock} unidades)";
        $stmt->bindParam(':mensaje', $mensaje);
        $stmt->execute();
    }

    public function eliminar() {
        $query = "DELETE FROM herramientas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }
}
?>