<?php
require __DIR__ . '/config/conexion.php';
require __DIR__ . '/models/Notificacion.php';

$conexion = new Conexion();
$db = $conexion->obtenerConexion();

$notificacion = new Notificacion($db);
$notificacion->verificarStockBajo();

// Registrar en log
file_put_contents(__DIR__ . '/stock_check.log', 
    "Verificación de stock completada: " . date('Y-m-d H:i:s') . PHP_EOL, 
    FILE_APPEND);