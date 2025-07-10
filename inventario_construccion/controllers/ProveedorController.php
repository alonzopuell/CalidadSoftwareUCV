<?php
require_once __DIR__ . '/../models/Proveedor.php';
require_once __DIR__ . '/../config/conexion.php';

class ProveedorController {
    private $proveedor;

    public function __construct() {
        $conexion = new Conexion();
        $db = $conexion->obtenerConexion();
        $this->proveedor = new Proveedor($db);
    }

    public function index() {
        $resultado = $this->proveedor->leer();
        include __DIR__ . '/../views/proveedores/listar.php';
    }

    public function agregar() {
        if ($_POST) {
            $this->proveedor->nombre = $_POST['nombre'];
            $this->proveedor->contacto = $_POST['contacto'];
            $this->proveedor->telefono = $_POST['telefono'];
            $this->proveedor->direccion = $_POST['direccion'];
            
            if ($this->proveedor->crear()) {
                header("Location: index.php?controller=ProveedorController&action=index");
            } else {
                echo "Error al crear el proveedor.";
            }
        }
        include __DIR__ . '/../views/proveedores/agregar.php';
    }

    public function editar() {
        $this->proveedor->id = isset($_GET['id']) ? $_GET['id'] : die();
        
        if ($_POST) {
            $this->proveedor->nombre = $_POST['nombre'];
            $this->proveedor->contacto = $_POST['contacto'];
            $this->proveedor->telefono = $_POST['telefono'];
            $this->proveedor->direccion = $_POST['direccion'];
            
            if ($this->proveedor->actualizar()) {
                header("Location: index.php?controller=ProveedorController&action=index");
            } else {
                echo "Error al actualizar el proveedor.";
            }
        }
        
        $this->proveedor->leerUno();
        include __DIR__ . '/../views/proveedores/editar.php';
    }

    public function eliminar() {
        $this->proveedor->id = isset($_GET['id']) ? $_GET['id'] : die();
        
        if ($this->proveedor->eliminar()) {
            header("Location: index.php?controller=ProveedorController&action=index");
        } else {
            echo "Error al eliminar el proveedor.";
        }
    }
}
?>