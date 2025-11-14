<?php
// Incluimos las funciones de auth.php porque también usa getUsers/saveUsers
require_once __DIR__ . '/auth.php';

/**
 * Devuelve la lista de todos los usuarios (sin el password)
 */
function listUsers() {
    $users = getUsers();
    // Quitar la contraseña de la respuesta por seguridad
    foreach ($users as &$user) {
        unset($user['password']);
    }
    return $users;
}

/**
 * Crea un nuevo usuario
 */
function createUser($data) {
    if (empty($data['nombre']) || empty($data['email']) || empty($data['password']) || empty($data['rol'])) {
        throw new Exception("Todos los campos (nombre, email, password, rol) son obligatorios.");
    }

    $users = getUsers();
    
    // Comprobar email duplicado
    foreach ($users as $user) {
        if ($user['email'] === $data['email']) {
            throw new Exception("El email ya está en uso.");
        }
    }

    // Generar un nuevo ID (el máximo actual + 1)
    $newId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;

    $newUser = [
        'id' => $newId,
        'nombre' => htmlspecialchars($data['nombre']),
        'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
        'password' => password_hash($data['password'], PASSWORD_BCRYPT), // Hashear contraseña
        'rol' => $data['rol'] === 'admin' ? 'admin' : 'user'
    ];

    $users[] = $newUser;
    saveUsers($users);
    
    unset($newUser['password']); // No devolver el hash en la respuesta
    return $newUser;
}

/**
 * Actualiza un usuario existente
 */
function updateUser($data) {
    if (empty($data['id']) || empty($data['nombre']) || empty($data['email']) || empty($data['rol'])) {
        throw new Exception("Los campos id, nombre, email y rol son obligatorios.");
    }

    $users = getUsers();
    $found = false;

    foreach ($users as &$user) {
        if ($user['id'] == $data['id']) {
            $user['nombre'] = htmlspecialchars($data['nombre']);
            $user['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $user['rol'] = $data['rol'] === 'admin' ? 'admin' : 'user';

            // Actualizar contraseña SOLO si se proporciona una nueva
            if (!empty($data['password'])) {
                $user['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }
            
            $found = true;
            break; // Dejar de buscar
        }
    }

    if (!$found) {
        throw new Exception("Usuario no encontrado.");
    }

    saveUsers($users);
    return listUsers(); // Devuelve la lista actualizada
}

/**
 * Elimina un usuario por su ID
 */
function deleteUser($id) {
    if (empty($id)) {
        throw new Exception("Se requiere un ID.");
    }

    $users = getUsers();
    
    // Filtrar el array, excluyendo el ID a eliminar
    $usersFiltered = array_filter($users, function($user) use ($id) {
        return $user['id'] != $id;
    });

    if (count($users) === count($usersFiltered)) {
        throw new Exception("Usuario no encontrado.");
    }
    
    // Guardar el array filtrado y re-indexado
    saveUsers(array_values($usersFiltered));
    return listUsers(); // Devuelve la lista actualizada
}