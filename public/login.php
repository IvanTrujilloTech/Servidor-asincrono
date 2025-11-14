<?php
// Si ya está logueado, redirigir
require_once __DIR__ . '/../src/auth.php';
if (isAuthenticated()) {
    // Redirigir a su panel correspondiente
    header('Location: ' . (isAdmin() ? 'index_ajax.html' : 'sociograma.php'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRUD</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container login-container">
        <form id="login-form" class="card">
            <h2>Iniciar Sesión</h2>
            <div id="error-message" class="message error hidden"></div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="admin@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" value="admin123" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
    
    <script src="assets/js/main.js"></script>
</body>
</html>