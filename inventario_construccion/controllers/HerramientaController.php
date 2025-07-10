<?php
require_once __DIR__ . '/../models/Herramienta.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../config/conexion.php';

class HerramientaController {
    private $herramienta;
    private $categoria;

    public function __construct() {
        $conexion = new Conexion();
        $db = $conexion->obtenerConexion();
        $this->herramienta = new Herramienta($db);
        $this->categoria = new Categoria($db);
    }

    public function index() {
        $resultado = $this->herramienta->leer();
        include __DIR__ . '/../views/herramientas/listar.php';
    }

    public function agregar() {
        if ($_POST) {
            $this->herramienta->nombre = $_POST['nombre'];
            $this->herramienta->descripcion = $_POST['descripcion'];
            $this->herramienta->categoria_id = $_POST['categoria_id'];
            $this->herramienta->stock = $_POST['stock'];
            $this->herramienta->estado = $_POST['estado'];
            
            if ($this->herramienta->crear()) {
                header("Location: index.php?controller=HerramientaController&action=index");
            } else {
                echo "Error al crear la herramienta.";
            }
        }
        
        $categorias = $this->categoria->leer();
        include __DIR__ . '/../views/herramientas/agregar.php';
    }

    

    

    public function editar() {
        $this->herramienta->id = $_GET['id'] ?? die('ID de herramienta no especificado');
        
        // Obtener datos actuales de la herramienta
        $datosHerramienta = $this->herramienta->leerUno();
        if (!$datosHerramienta) {
            die('Herramienta no encontrada');
        }

        // Asignar valores al objeto herramienta
        $this->herramienta->nombre = $datosHerramienta['nombre'];
        $this->herramienta->descripcion = $datosHerramienta['descripcion'];
        $this->herramienta->categoria_id = $datosHerramienta['categoria_id'];
        $this->herramienta->stock = $datosHerramienta['stock'];
        $this->herramienta->estado = $datosHerramienta['estado'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->herramienta->nombre = $_POST['nombre'];
            $this->herramienta->descripcion = $_POST['descripcion'];
            $this->herramienta->categoria_id = $_POST['categoria_id'];
            $this->herramienta->stock = $_POST['stock'];
            $this->herramienta->estado = $_POST['estado'];

            if ($this->herramienta->actualizar()) {
                header("Location: index.php?controller=HerramientaController&action=index");
                exit;
            } else {
                die("Error al actualizar la herramienta");
            }
        }

        // Obtener listas para los selects
        $categorias = $this->categoria->leer();

        include __DIR__ . '/../views/herramientas/editar.php';
    }


    

    public function eliminar() {
        $this->herramienta->id = isset($_GET['id']) ? $_GET['id'] : die();
        
        if ($this->herramienta->eliminar()) {
            header("Location: index.php?controller=HerramientaController&action=index");
        } else {
            echo "Error al eliminar la herramienta.";
        }
    }
}
?>