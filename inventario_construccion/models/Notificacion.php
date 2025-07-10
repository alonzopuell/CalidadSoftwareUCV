<?php
class Notificacion {
    private $conn;
    private $table_name = "notificaciones";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leer() {
        $query = "SELECT * FROM notificaciones ORDER BY fecha DESC";
        return $this->conn->query($query);
    }

    public function eliminar($id) {
    $query = "DELETE FROM notificaciones WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

    public function marcarLeida($id) {
        $query = "UPDATE notificaciones SET leida = TRUE WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function verificarStockBajo() {
        // Verificar productos
        $query = "SELECT p.* FROM productos p
                 LEFT JOIN notificaciones n ON n.item_id = p.id AND n.tipo = 'producto' AND DATE(n.fecha) = CURDATE()
                 WHERE p.stock <= 5 AND n.id IS NULL";
        $productos = $this->conn->query($query);
        $this->crearNotificaciones($productos, 'producto');

        // Verificar herramientas
        $query = "SELECT h.* FROM herramientas h
                 LEFT JOIN notificaciones n ON n.item_id = h.id AND n.tipo = 'herramienta' AND DATE(n.fecha) = CURDATE()
                 WHERE h.stock <= 5 AND n.id IS NULL";
        $herramientas = $this->conn->query($query);
        $this->crearNotificaciones($herramientas, 'herramienta');
    }

    private function crearNotificaciones($items, $tipo) {
        while ($item = $items->fetch(PDO::FETCH_ASSOC)) {
            $query = "INSERT INTO notificaciones (tipo, item_id, mensaje)
                     VALUES (:tipo, :item_id, :mensaje)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':item_id', $item['id']);
            $mensaje = "Stock bajo para {$item['nombre']} ({$item['stock']} unidades)";
            $stmt->bindParam(':mensaje', $mensaje);
            $stmt->execute();
        }
    }
}
?>