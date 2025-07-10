<?php
$error = $_SESSION['error'] ?? null;
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['error']);
unset($_SESSION['mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <div class="text-end mb-3">
                <a href="index.php?controller=AuthController&action=logout" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        
                        <?php if ($mensaje): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
                        <?php endif; ?>
                        
                        <form action="index.php?controller=AuthController&action=login" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                        
                        <div class="mt-3 text-center">
                            <a href="index.php?controller=AuthController&action=forgotPassword">¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="mt-2 text-center">
                            ¿No tienes cuenta? <a href="index.php?controller=AuthController&action=register">Regístrate aquí</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>