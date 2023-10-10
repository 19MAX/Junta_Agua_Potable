<?php
include "flash_messages.php";
include "APIurls.php";
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    // URL de la API o recurso al que deseas enviar la solicitud DELETE
    $url = BASE . '/logs/delete/old';

    // Inicializa cURL
    $ch = curl_init();

    // Configura la URL y otras opciones
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // Establece el método HTTP como DELETE
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

    // Realiza la solicitud DELETE y obtiene la respuesta
    $response = curl_exec($ch);

    // Cierra la sesión cURL
    curl_close($ch);
    
    // Verifica si la solicitud fue exitosa
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode === 200) {

        create_flash_message(
            "Logs  Eliminados Exitosamente ",
            "success"
        );
        header('Location: /Sistema/logs.php');
        exit();

    } elseif ($httpCode === 400) {
        create_flash_message(
            "Logs  No Eliminados ",
            "error"
        );
        header('Location: /Sistema/logs.php');
        exit();
    } else {
        // Otros códigos de respuesta: Puedes manejarlos según tus necesidades
        echo 'Error desconocido: Código de respuesta HTTP ' . $httpCode;
    }

} else {
    header('Location: /Sistema/index.php?alert=error');
    exit();
}
?>
