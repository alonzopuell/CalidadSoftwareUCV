<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', __DIR__);

// Autoloader
spl_autoload_register(function ($class) {
    $file = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require_once 'config/conexion.php';

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario_id']) && !isset($_GET['controller'])) {
    header("Location: index.php?controller=AuthController&action=login");
    exit();
}

// Mostrar encabezado con botón de cerrar sesión si está logueado
if (isset($_SESSION['usuario_id'])) {
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
        <style>
            .logout-header {
                background-color: #f8f9fa;
                padding: 10px 20px;
                border-bottom: 1px solid #dee2e6;
            }
        </style>
    </head>
    <body>
        <header class="logout-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-end">
                    <div class="d-flex align-items-center">
                        <span class="me-3">'.htmlspecialchars($_SESSION['usuario_nombre']).'</span>
                        <a href="index.php?controller=AuthController&action=logout" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </header>
    ';
}

// Determinar controlador y acción
$controller = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'CategoriaController';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Incluir el controlador
$controllerFile = 'controllers/' . $controller . '.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    $controllerInstance = new $controller();
    
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        die("La acción $action no existe");
    }
} else {
    die("El controlador $controller no existe");
}

// Cerrar el HTML si se mostró el encabezado
if (isset($_SESSION['usuario_id'])) {
    echo '</body></html>';
}
?>