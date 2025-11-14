<?php
require_once __DIR__ . '/../src/auth.php';

// --- ¡SEGURIDAD! ---
// Si no está autenticado, fuera.
if (!isAuthenticated()) {
    header('Location: login.php');
    exit;
}
?>
<?php
// Incluimos las funciones helper
require __DIR__ . '/../sociograma/includes/functions.php';

// Título de la página
$page_title = 'Formulario Sociométrico DAW';

// Si venimos “de cero”, $old y $errors deben existir como arrays vacíos
// para que las funciones old() y field_error() no fallen.
// Si venimos de un error en process.php, estas variables ya estarán definidas.
$old = $old ?? [];
$errors = $errors ?? [];

// Incluimos la cabecera
include __DIR__ . '/../sociograma/includes/header.php';
?>

<h2>Completa el formulario</h2>
<p>
  Indica tus preferencias de colaboración. Esta información es confidencial y
  solo se usará para formar los grupos de trabajo del módulo.
</p>

<?php
// Incluimos el formulario.
// Le pasamos $old y $errors (que estarán vacíos la primera vez).
include __DIR__ . '/../sociograma/_form.php';

// Incluimos el pie de página
include __DIR__ . '/../sociograma/includes/footer.php';
?>

</form>