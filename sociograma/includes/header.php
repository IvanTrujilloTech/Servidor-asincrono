<?php
require_once __DIR__ . '/../../src/auth.php';
$user = getCurrentUser();
$username = $user ? $user['nombre'] : 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../sociograma/assets/css/styles.css">
  <title><?= $page_title ?? 'Sociograma DAW' ?></title>
</head>

<body>
  <div class="container">
      <header>
            <div class="user-info">
                <h3>Bienvenido, <strong><?= htmlspecialchars($username) ?></strong><h3>
                <a href="logout.php" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
    <main>