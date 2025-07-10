<?php
require_once BASE_PATH . '/models/Categoria.php';
require_once BASE_PATH . '/config/conexion.php';


class CategoriaController {
    private $categoria;

    public function __construct() {
        $conexion = new Conexion();
        $db = $conexion->obtenerConexion();
        $this->categoria = new Categoria($db);
    }

    public function index() {
        $resultado = $this->categoria->leer();
        include __DIR__ . '/../views/categorias/listar.php';
    }

    public function agregar() {
        if ($_POST) {
            $this->categoria->nombre = $_POST['nombre'];
            $this->categoria->descripcion = $_POST['descripcion'];
            
            if ($this->categoria->crear()) {
                header("Location: index.php?controller=CategoriaController&action=index");
            } else {
                echo "Error al crear la categoría.";
            }
        }
        include __DIR__ . '/../views/categorias/agregar.php';
    }

    public function editar() {
        $this->categoria->id = isset($_GET['id']) ? $_GET['id'] : die();
        
        if ($_POST) {
            $this->categoria->nombre = $_POST['nombre'];
            $this->categoria->descripcion = $_POST['descripcion'];
            
            if ($this->categoria->actualizar()) {
                header("Location: index.php?controller=CategoriaController&action=index");
            } else {
                echo "Error al actualizar la categoría.";
            }
        }
        
        $this->categoria->leerUno();
        include __DIR__ . '/../views/categorias/editar.php';
    }

    public function eliminar() {
        $this->categoria->id = isset($_GET['id']) ? $_GET['id'] : die();
        
        if ($this->categoria->eliminar()) {
            header("Location: index.php?controller=CategoriaController&action=index");
        } else {
            echo "Error al eliminar la categoría.";
        }
    }
}
?>