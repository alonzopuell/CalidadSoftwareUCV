<?php
require_once __DIR__ . '/../models/Notificacion.php';
require_once __DIR__ . '/../config/conexion.php';

class NotificacionController {
    private $notificacion;

    public function __construct() {
        $conexion = new Conexion();
        $db = $conexion->obtenerConexion();
        $this->notificacion = new Notificacion($db);
    }

    public function index() {
        $notificaciones = $this->notificacion->leer();
        include __DIR__ . '/../views/notificaciones/stock_bajo.php';
    }

    public function eliminar() {
    $id = $_GET['id'] ?? null;
    if ($id && $this->notificacion->eliminar($id)) {
        $_SESSION['mensaje'] = "Notificación eliminada correctamente";
    } else {
        $_SESSION['error'] = "Error al eliminar la notificación";
    }
    header("Location: index.php?controller=NotificacionController&action=index");
}

    public function verificarStockBajo() {
        $this->notificacion->verificarStockBajo();
        header("Location: index.php?controller=NotificacionController&action=index");
    }

    public function marcarLeida() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->notificacion->marcarLeida($id);
        }
        header("Location: index.php?controller=NotificacionController&action=index");
    }
}
?>