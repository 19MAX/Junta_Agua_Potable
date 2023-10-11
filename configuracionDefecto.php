<?php
include "APIurls.php"; 

include "flash_messages.php";

$message = '';
$type = '';
$flash_message = display_flash_message();
if (isset($flash_message)) {
    $message = $flash_message['message'];
    $type = $flash_message['type'];

}
// URL a la que deseas hacer la solicitud GET
$url = BASE . '/configuracion/get/default';

// Verifica si el archivo de cookies existe y no está vacío
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    // Inicializar la sesión cURL
    $ch = curl_init($url);

    // Configurar las opciones de la solicitud cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devolver el resultado en lugar de imprimirlo en pantalla
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Establecer el método de solicitud como GET
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Realizar la solicitud cURL y obtener la respuesta
    $defecto = curl_exec($ch);

    // Verificar si hubo errores en la solicitud
    if (curl_errno($ch)) {
        echo 'Error cURL: ' . curl_error($ch);
    }

    // Cerrar la sesión cURL
    curl_close($ch);

    // Decodificar la respuesta JSON
    $defecto = json_decode($defecto, true);

    // Verificar si la respuesta contiene datos válidos
    if ($defecto && isset($defecto['success'])) {
        $configuracion = $defecto['success'];

        // Acceder a los datos del cliente
        $consumo_base = $configuracion['consumo_base'];
        $exedente = $configuracion['exedente'];
        $valor_consumo_base = $configuracion['valor_consumo_base'];
        $valor_exedente = $configuracion['valor_exedente'];
        $reconexion = $configuracion['reconexion'];
    } else {
        echo '<p>Error: No se pudo obtener la información del cliente.</p>';
    }
} else {
    
    header("Location: /Sistema/index.php?alert=error");
    exit();
}

?>
