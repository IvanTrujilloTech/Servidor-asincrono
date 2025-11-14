<?php
// Incluimos las funciones helper
require __DIR__ . '/includes/functions.php';

// Título de la página
$page_title = 'Formulario Sociométrico DAW';

// Si venimos “de cero”, $old y $errors deben existir como arrays vacíos
// para que las funciones old() y field_error() no fallen.
// Si venimos de un error en process.php, estas variables ya estarán definidas.
$old = $old ?? [];
$errors = $errors ?? [];

// Incluimos la cabecera
include __DIR__ . '/includes/header.php';
?>

<h2>Completa el formulario</h2>
<p>
  Indica tus preferencias de colaboración. Esta información es confidencial y
  solo se usará para formar los grupos de trabajo del módulo.
</p>

<?php
// Incluimos el formulario.
// Le pasamos $old y $errors (que estarán vacíos la primera vez).
include __DIR__ . '/_form.php';

// Incluimos el pie de página
include __DIR__ . '/includes/footer.php';
?>