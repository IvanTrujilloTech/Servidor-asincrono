<?php
// Carga las funciones de autenticación
require_once __DIR__ . '/../src/auth.php';

// Cierra la sesión
logout();

// Redirige al login
header('Location: login.php');
exit;