<?php
function requiereAutenticacion() {
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ?controller=AuthController&action=login");
        exit();
    }
}