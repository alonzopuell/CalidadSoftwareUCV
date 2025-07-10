<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Proveedor.php';
require_once __DIR__ . '/../config/conexion.php';

class ProductoController {
    private $producto;
    private $categoria;
    private $proveedor;

    public function __construct() {
        $conexion = new Conexion();
        $db = $conexion->obtenerConexion();
        $this->producto = new Producto($db);
        $this->categoria = new Categoria($db);
        $this->proveedor = new Proveedor($db);
    }

    public function index() {
        $resultado = $this->producto->leer();
        include __DIR__ . '/../views/productos/listar.php';
    }

    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->nombre = $_POST['nombre'];
            $this->producto->descripcion = $_POST['descripcion'];
            $this->producto->categoria_id = $_POST['categoria_id'];
            $this->producto->proveedor_id = $_POST['proveedor_id'];
            $this->producto->stock = $_POST['stock'];

            if ($this->producto->crear()) {
                $_SESSION['success'] = 'Producto creado correctamente';
                header("Location: index.php?controller=ProductoController&action=index");
                exit;
            } else {
                $_SESSION['error'] = 'Error al crear el producto';
            }
        }

        $categorias = $this->categoria->leer();
        $proveedores = $this->proveedor->leer();
        include __DIR__ . '/../views/productos/agregar.php';
    }

    public function editar() {
        $this->producto->id = $_GET['id'] ?? die('ID no especificado');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->nombre = $_POST['nombre'];
            $this->producto->descripcion = $_POST['descripcion'];
            $this->producto->categoria_id = $_POST['categoria_id'];
            $this->producto->proveedor_id = $_POST['proveedor_id'];
            $this->producto->stock = $_POST['stock'];

            if ($this->producto->actualizar()) {
                $_SESSION['success'] = 'Producto actualizado correctamente';
                header("Location: index.php?controller=ProductoController&action=index");
                exit;
            } else {
                $_SESSION['error'] = 'Error al actualizar el producto';
            }
        }

        $producto = $this->producto->leerUno();
        if (!$producto) die('Producto no encontrado');

        $this->producto->nombre = $producto['nombre'];
        $this->producto->descripcion = $producto['descripcion'];
        $this->producto->categoria_id = $producto['categoria_id'];
        $this->producto->proveedor_id = $producto['proveedor_id'];
        $this->producto->stock = $producto['stock'];

        $categorias = $this->categoria->leer();
        $proveedores = $this->proveedor->leer();
        
        include __DIR__ . '/../views/productos/editar.php';
    }

    public function eliminar() {
        $this->producto->id = $_GET['id'] ?? die('ID no especificado');
        
        if ($this->producto->eliminar()) {
            $_SESSION['success'] = 'Producto eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el producto';
        }
        
        header("Location: index.php?controller=ProductoController&action=index");
        exit;
    }
}
?>