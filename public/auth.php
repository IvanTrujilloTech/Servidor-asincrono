<?php
require_once __DIR__ . '/../src/auth.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? null;
$response = ['ok' => false, 'error' => 'Acción no válida'];

try {
    switch ($action) {
        // --- LOGIN ---
        case 'login':
            $input = json_decode(file_get_contents('php://input'), true);
            $user = login($input['email'] ?? '', $input['password'] ?? '');
            if ($user) {
                unset($user['password']); // No enviar el hash al cliente
                $response = ['ok' => true, 'user' => $user];
            } else {
                $response['error'] = 'Credenciales incorrectas.';
            }
            break;

        // --- LOGOUT ---
        case 'logout':
            logout();
            $response = ['ok' => true];
            break;

        // --- VERIFICAR SESIÓN (ME) ---
        case 'me':
            $user = getCurrentUser();
            if ($user) {
                $response = ['ok' => true, 'user' => $user];
            } else {
                $response = ['ok' => false, 'error' => 'No autenticado'];
            }
            break;
    }
} catch (Exception $e) {
    http_response_code(400); // Bad Request
    $response['error'] = $e->getMessage();
}

echo json_encode($response);