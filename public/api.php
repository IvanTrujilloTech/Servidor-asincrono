<?php
require_once __DIR__ . '/../src/auth.php'; // Para checkear sesión
require_once __DIR__ . '/../src/api.php';  // Para lógica CRUD

header('Content-Type: application/json');

// --- ¡SEGURIDAD! ---
// Solo los administradores pueden usar esta API
if (!isAdmin()) {
    http_response_code(403); // Forbidden
    echo json_encode(['ok' => false, 'error' => 'Acceso denegado. Se requiere rol de administrador.']);
    exit;
}

$action = $_GET['action'] ?? null;
$response = ['ok' => false, 'error' => 'Acción no válida'];
// Obtener el cuerpo de la petición (para POST, PUT, DELETE)
$input = json_decode(file_get_contents('php://input'), true);

try {
    switch ($action) {
        // --- LISTAR (GET) ---
        case 'list':
            $response = ['ok' => true, 'data' => listUsers()];
            break;

        // --- CREAR (POST) ---
        case 'create':
            $newUser = createUser($input);
            $response = ['ok' => true, 'data' => listUsers()]; // Devuelve la lista actualizada
            break;

        // --- ACTUALIZAR (POST/PUT) ---
        case 'update':
            $updatedList = updateUser($input);
            $response = ['ok' => true, 'data' => $updatedList];
            break;

        // --- ELIMINAR (POST/DELETE) ---
        case 'delete':
            // Asumimos que el ID viene en el JSON body: { "id": 5 }
            $updatedList = deleteUser($input['id'] ?? null);
            $response = ['ok' => true, 'data' => $updatedList];
            break;
    }
} catch (Exception $e) {
    http_response_code(400); // Bad Request
    $response['error'] = $e->getMessage();
}

echo json_encode($response);