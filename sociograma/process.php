<?php
require __DIR__ . '/includes/functions.php';

// Comprobar que venimos por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo 'Método no permitido. Este script solo acepta peticiones POST.';
    exit;
}

// Recoger y sanear (básico) los datos de entrada
// Recogemos todos los campos del formulario. Usamos trim() para limpiar espacios.
// IVAN RECUERDA QUE: 'herramientas' es un array, no se puede "trimear".
$input = [];
foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        // Para los checkboxes (ej. herramientas)
        $input[$key] = $value;
    } else {
        // Para el resto de campos
        $input[$key] = trim($value);
    }
}

// Validar los datos
$errors = [];

// --- Validación de campos obligatorios ---
if (empty($input['nombre'])) {
    $errors['nombre'] = 'El nombre es obligatorio.';
} elseif (strlen($input['nombre']) < 3) {
    $errors['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
}

if (empty($input['grupo'])) {
    $errors['grupo'] = 'Debes seleccionar un grupo.';
}

if (empty($input['preferido_1'])) {
    $errors['preferido_1'] = 'Debes indicar al menos una persona con la que te gusta trabajar.';
}

if (empty($input['evitar_1'])) {
    $errors['evitar_1'] = 'Debes indicar al menos una persona con la que prefieres no trabajar.';
}

if (empty($input['rol_habitual'])) {
    $errors['rol_habitual'] = 'Por favor, indica tu rol habitual.';
}

if (empty($input['lenguaje_fuerte'])) {
    $errors['lenguaje_fuerte'] = 'Por favor, indica tu lenguaje principal.';
}

if (empty($input['comunicacion_pref'])) {
    $errors['comunicacion_pref'] = 'Indica tu preferencia de comunicación.';
}

if (empty($input['manejo_estres'])) {
    $errors['manejo_estres'] = 'El campo de manejo de estrés es obligatorio.';
}

if (empty($input['so_preferido'])) {
    $errors['so_preferido'] = 'Indica tu S.O. preferido.';
}

if (empty($input['fecha_respuesta'])) {
    $errors['fecha_respuesta'] = 'La fecha de respuesta es obligatoria.';
}

// --- Validación de formatos ---
if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'El formato del email no es válido.';
}

if (!empty($input['edad']) && !filter_var($input['edad'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 16, 'max_range' => 99]])) {
    $errors['edad'] = 'La edad debe ser un número entre 16 y 99.';
}

// Decidir qué hacer según si hay errores o no

if (!empty($errors)) {
    // --- HAY ERRORES: Rehidratar el formulario ---

    // Guardamos los datos recibidos (saneados) en $old
    $old = $input;
    
    // Título para la página de error
    $page_title = 'Error - Corrige tu formulario';

    // Incluimos la cabecera
    include __DIR__ . '/includes/header.php';

    // Mostramos un resumen de error
    echo '<div class="error-summary">';
    echo '<h2>Corrige los errores</h2>';
    echo '<p>Hemos encontrado ' . count($errors) . ' error(es) en tu envío. Por favor, revisa los campos marcados en rojo.</p>';
    echo '</div>';

    // Volvemos a incluir el formulario.
    // _form.php usará las variables $old y $errors que hemos definido aquí.
    include __DIR__ . '/_form.php';

    // Incluimos el pie de página
    include __DIR__ . '/includes/footer.php';
    
    // Detenemos la ejecución
    exit;

} else {
    // --- TODO CORRECTO: Guardar en JSON y mostrar confirmación ---

    $file_path = __DIR__ . '/data/sociograma.json';

    // 1. Cargar los datos existentes
    $data = load_json($file_path);

    // 2. Añadir la nueva respuesta (añadimos timestamp)
    $input['timestamp_guardado'] = date('Y-m-d H:i:s');
    $data[] = $input; // Añade el nuevo array $input al final del array $data

    // 3. Guardar el array actualizado en el archivo
    if (save_json($file_path, $data)) {
        
        // Éxito al guardar
        $page_title = '¡Respuesta Guardada!';
        include __DIR__ . '/includes/header.php';
        
        echo '<div class="success-message">';
        echo '<h2>¡Gracias, ' . e($input['nombre']) . '!</h2>';
        echo '<p>Tu respuesta sociométrica ha sido guardada correctamente.</p>';
        echo '<p>Total de respuestas recogidas: ' . count($data) . '</p>';
        echo '</div>';
        
        echo '<div class="nav-links">';
        echo '<a href="index.php">Enviar otra respuesta</a>';
        echo '<a href="api.php">Ver respuestas (JSON)</a>';
        echo '</div>';

        include __DIR__ . '/includes/footer.php';
        
        exit;

    } else {
        // Error al guardar (permisos, etc.)
        http_response_code(500); // Internal Server Error
        $page_title = 'Error del Servidor';
        include __DIR__ . '/includes/header.php';

        echo '<div class="error-summary">';
        echo '<h2>Error Interno del Servidor</h2>';
        echo '<p>No se pudo guardar tu respuesta en el archivo <code>data/sociograma.json</code>.</p>';
        echo '<p>Por favor, comprueba que la carpeta <code>data/</code> existe y tiene permisos de escritura para el servidor web (Apache/Nginx).</p>';
        echo '</div>';

        include __DIR__ . '/includes/footer.php';

        exit;
    }
}
?>