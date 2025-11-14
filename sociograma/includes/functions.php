<?php

/**
 * Escapa texto para imprimirlo en HTML sin riesgo (XSS).
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Cargar un archivo JSON y devolverlo como array asociativo.
 */
function load_json(string $path): array
{
    if (!file_exists($path)) {
        return []; // Si no existe, devolvemos array vacío
    }
    $raw = file_get_contents($path);
    if ($raw === false) {
        return []; // Error al leer
    }
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

/**
 * Guardar un array en un archivo JSON con formato legible.
 */
function save_json(string $path, array $data): bool
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false; // Error en la codificación
    }
    return file_put_contents($path, $json) !== false;
}

/**
 * Devuelve el valor anterior de un campo (rehidratación).
 * Soporta arrays (para checkboxes).
 */
function old(string $name, array $source = [], $default = ''): mixed
{
    return $source[$name] ?? $default;
}

/**
 * Devuelve el HTML de un mensaje de error si existe para ese campo.
 */
function field_error(string $name, array $errors = []): string
{
    if (isset($errors[$name])) {
        return '<span class="form-error">' . e($errors[$name]) . '</span>';
    }
    return ""; // Si no hay error, no mostramos nada
}

/**
 * Helper para marcar un <option> como 'selected'.
 */
function is_selected(string $name, string $value, array $source = []): string
{
    return (old($name, $source) === $value) ? 'selected' : '';
}

/**
 * Helper para marcar un 'radio' como 'checked'.
 */
function is_radio_checked(string $name, string $value, array $source = []): string
{
    return (old($name, $source) === $value) ? 'checked' : '';
}

/**
 * Helper para marcar un 'checkbox' múltiple como 'checked'.
 */
function is_checkbox_checked(string $name, string $value, array $source = []): string
{
    $old_values = old($name, $source, []); // El valor antiguo es un array
    return (is_array($old_values) && in_array($value, $old_values)) ? 'checked' : '';
}