<?php
require_once __DIR__ . '/../config/conexion.php';

class Usuario {
    private $conn;
    
    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->obtenerConexion();
        
        if (!$this->conn) {
            die("Error de conexión a la base de datos");
        }
    }
    
    public function login($email, $password) {
        try {
            $query = "SELECT id, nombre, password FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (password_verify($password, $usuario['password'])) {
                    return $usuario;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }
    
    public function registrar($nombre, $email, $password) {
        try {
            if ($this->emailExiste($email)) {
                return false;
            }
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en registro: " . $e->getMessage());
            return false;
        }
    }
    
    public function solicitarResetPassword($email) {
        try {
            $usuario = $this->obtenerUsuarioPorEmail($email);
            if (!$usuario) return false;
            
            $token = bin2hex(random_bytes(32));
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));
            
            $query = "UPDATE usuarios SET token_reset = :token, token_expira = :expira WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expira', $expira);
            $stmt->bindParam(':email', $email);
            
            if ($stmt->execute()) {
                return $this->enviarEmailReset($email, $token);
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en solicitarResetPassword: " . $e->getMessage());
            return false;
        }
    }
    
    public function resetPassword($token, $newPassword) {
        try {
            $query = "SELECT id FROM usuarios WHERE token_reset = :token AND token_expira > NOW()";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                $query = "UPDATE usuarios SET password = :password, token_reset = NULL, token_expira = NULL WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':id', $usuario['id']);
                
                return $stmt->execute();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en resetPassword: " . $e->getMessage());
            return false;
        }
    }
    
    private function emailExiste($email) {
        $query = "SELECT id FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
    private function obtenerUsuarioPorEmail($email) {
        $query = "SELECT id, nombre FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() == 1 ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }
    
    private function enviarEmailReset($email, $token) {
        // En producción, reemplazar con envío real de email
        $enlace = "http://$_SERVER[HTTP_HOST]".BASE_PATH."/index.php?controller=AuthController&action=resetPassword&token=$token";
        error_log("Enlace de reset para $email: $enlace");
        return true;
    }
}