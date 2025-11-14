<?php
// Iniciar la sesión solo si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('JSON_FILE', __DIR__ . '/storage/data.json');

/**
 * Lee todos los usuarios del JSON
 */
function getUsers() {
    if (!file_exists(JSON_FILE)) {
        return [];
    }
    $json = file_get_contents(JSON_FILE);
    return json_decode($json, true);
}

/**
 * Guarda el array de usuarios en el JSON
 */
function saveUsers($users) {
    // Usar JSON_PRETTY_PRINT para que el archivo sea legible
    $json = json_encode($users, JSON_PRETTY_PRINT);
    file_put_contents(JSON_FILE, $json);
}

/**
 * Intenta loguear a un usuario
 */
function login($email, $password) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            // Credenciales correctas. Guardar en sesión.
            $_SESSION["id"] = $user['id'];
            $_SESSION["nombre"] = $user['nombre'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["rol"] = $user['rol'];
            return $user;
        }
    }
    // Si no encuentra al usuario o la contraseña es incorrecta
    return false;
}

/**
 * Cierra la sesión
 */
function logout() {
    session_unset();
    session_destroy();
}

/**
 * Comprueba si el usuario está autenticado
 */
function isAuthenticated() {
    return isset($_SESSION['id']);
}

/**
 * Comprueba si el usuario es Administrador
 */
function isAdmin() {
    return isAuthenticated() && $_SESSION['rol'] === 'admin';
}

/**
 * Devuelve los datos de la sesión actual
 */
function getCurrentUser() {
    if (!isAuthenticated()) {
        return null;
    }
    return [
        'id' => $_SESSION['id'],
        'nombre' => $_SESSION['nombre'],
        'email' => $_SESSION['email'],
        'rol' => $_SESSION['rol']
    ];
}