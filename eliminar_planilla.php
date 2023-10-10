<?php
include "flash_messages.php";
include "APIurls.php";

if ($_GET) {
    $id_servicio = $_GET['id_servicio'];
    $id_planilla = $_GET['id_planilla'];
}

// Verifica si el archivo de cookies existe y no está vacío
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    // URL de la API o recurso al que deseas enviar la solicitud DELETE
    $url = BASE . '/planillas/delete/' . $id_planilla;

    // Inicializa cURL
    $ch = curl_init();

    // Configura la URL y otras opciones
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // Establece el método HTTP como DELETE
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

    // Realiza la solicitud DELETE
    $response = curl_exec($ch);

    // Cierra la sesión cURL
    curl_close($ch);

    // Obtener el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Procesa la respuesta según el código de respuesta HTTP
    if ($httpCode === 200) {
        create_flash_message(
            "La Planilla se elimino exitosamnete",
            "success"
        );
    } else {
        create_flash_message(
            "La Planilla no se puede eliminar",
            "error"
        );
    }
    header("Location: $base_request/planillas.php?id=" . $id_servicio);
    exit();
} else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>
