<?php
class Producto {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $nombre;
    public $descripcion;
    public $categoria_id;
    public $proveedor_id;
    public $stock;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leer() {
        $query = "SELECT p.*, c.nombre as categoria_nombre, pr.nombre as proveedor_nombre 
                 FROM productos p
                 LEFT JOIN categorias c ON p.categoria_id = c.id
                 LEFT JOIN proveedores pr ON p.proveedor_id = pr.id";
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
        $this->proveedor_id = $row['proveedor_id'];
        $this->stock = $row['stock'];
    }
    
    return $row;
}

    public function crear() {
        $query = "INSERT INTO productos SET 
                 nombre=:nombre, descripcion=:descripcion, 
                 categoria_id=:categoria_id, proveedor_id=:proveedor_id, stock=:stock";
        
        $stmt = $this->conn->prepare($query);
        $this->bindParams($stmt);
        
        if ($stmt->execute()) {
            $this->checkStockBajo();
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE productos SET 
                 nombre=:nombre, descripcion=:descripcion, 
                 categoria_id=:categoria_id, proveedor_id=:proveedor_id, stock=:stock
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
        $stmt->bindParam(":proveedor_id", $this->proveedor_id);
        $stmt->bindParam(":stock", $this->stock);
    }

    private function checkStockBajo() {
        if ($this->stock <= 5) {
            $this->crearNotificacion();
        }
    }

    private function crearNotificacion() {
        $query = "INSERT INTO notificaciones (tipo, item_id, mensaje)
                 VALUES ('producto', :item_id, :mensaje)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':item_id', $this->id);
        $mensaje = "Stock bajo para {$this->nombre} ({$this->stock} unidades)";
        $stmt->bindParam(':mensaje', $mensaje);
        $stmt->execute();
    }

    public function eliminar() {
        $query = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }
}
?>