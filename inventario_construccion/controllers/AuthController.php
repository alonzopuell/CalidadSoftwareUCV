<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $usuarioModel;
    
    public function __construct() {
        $this->usuarioModel = new Usuario();
    }
    
    public function login() {
        // Si ya está logueado, redirigir al dashboard
        if ($this->estaLogueado()) {
            $this->redirigir('CategoriaController', 'index');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $usuario = $this->usuarioModel->login($email, $password);
            
            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $this->redirigir('CategoriaController', 'index');
                return;
            } else {
                $_SESSION['error'] = "Credenciales incorrectas";
                $this->redirigir('AuthController', 'login');
                return;
            }
        }
        
        $this->mostrarVista('auth/login');
    }

    
    public function register() {
        if ($this->estaLogueado()) {
            $this->redirigir('CategoriaController', 'index');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validaciones
            if (empty($nombre) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Todos los campos son obligatorios";
                $this->redirigir('AuthController', 'register');
            }
            
            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Las contraseñas no coinciden";
                $this->redirigir('AuthController', 'register');
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
                $this->redirigir('AuthController', 'register');
            }
            
            if ($this->usuarioModel->registrar($nombre, $email, $password)) {
                $_SESSION['mensaje'] = "Registro exitoso. Por favor inicia sesión.";
                $this->redirigir('AuthController', 'login');
            } else {
                $_SESSION['error'] = "Error al registrar. El email ya existe.";
                $this->redirigir('AuthController', 'register');
            }
        }
        
        $this->mostrarVista('auth/register');
    }
    
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            
            if ($this->usuarioModel->solicitarResetPassword($email)) {
                $_SESSION['mensaje'] = "Se ha enviado un enlace de recuperación a tu email.";
            } else {
                $_SESSION['error'] = "No se encontró una cuenta con ese email.";
            }
            $this->redirigir('AuthController', 'forgotPassword');
        }
        
        $this->mostrarVista('auth/forgot-password');
    }
    
    public function resetPassword() {
        $token = $_GET['token'] ?? '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
                $this->redirigir('AuthController', 'resetPassword', ['token' => $token]);
            }
            
            if ($this->usuarioModel->resetPassword($token, $password)) {
                $_SESSION['mensaje'] = "Contraseña actualizada correctamente. Por favor inicia sesión.";
                $this->redirigir('AuthController', 'login');
            } else {
                $_SESSION['error'] = "El enlace es inválido o ha expirado.";
                $this->redirigir('AuthController', 'forgotPassword');
            }
        }
        
        $this->mostrarVista('auth/reset-password', ['token' => $token]);
    }
    
    public function logout() {
    session_destroy();
    $_SESSION['mensaje'] = "Sesión cerrada correctamente";
    header("Location: index.php?controller=AuthController&action=login");
    exit();
}
    
    private function estaLogueado() {
        return isset($_SESSION['usuario_id']);
    }
    
    private function redirigir($controller, $action, $params = []) {
        $url = "index.php?controller=$controller&action=$action";
        foreach ($params as $key => $value) {
            $url .= "&$key=$value";
        }
        header("Location: $url");
        exit();
    }
    
    private function mostrarVista($vista, $datos = []) {
        extract($datos);
        $rutaVista = __DIR__ . '/../views/' . $vista . '.php';
        if (file_exists($rutaVista)) {
            require_once $rutaVista;
        } else {
            die("La vista $vista no existe en $rutaVista");
        }
    }
    
}