<?php

require __DIR__ . '/includes/functions.php';

// Indicamos al navegador que la respuesta es JSON y UTF-8
header('Content-Type: application/json; charset=utf-8');

$file = __DIR__ . '/data/sociograma.json';
$data = load_json($file);

// Imprimimos el JSON formateado
echo json_encode([
    'count' => count($data),
    'items' => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);