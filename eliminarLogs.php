<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

$session_cookie = get_cookied_session();
if (isset($session_cookie)) {
    // URL de la API o recurso al que deseas enviar la solicitud DELETE
    $url = BASE . '/logs/delete/old';

    // Inicializa cURL
    $ch = curl_init();

    // Configura la URL y otras opciones
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // Establece el método HTTP como DELETE
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

    // Realiza la solicitud DELETE y obtiene la respuesta
    $response = json_decode(curl_exec($ch), true);

    // Cierra la sesión cURL
    curl_close($ch);

    // Verifica si la solicitud fue exitosa
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode === 200) {

        create_flash_message(
            $response['success'],
            "success"
        );
    } else {
        create_flash_message(
            $response['error'],
            "error"
        );
    }
    header("Location: $base_request/logs.php");
    exit();

} else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>
