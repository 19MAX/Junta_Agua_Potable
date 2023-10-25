<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

ini_set("display_errors","1");
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_servicio = $_GET['id_servicio'];
    $id_planilla = $_GET['id_planilla'];

    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        // URL de la API o recurso al que deseas enviar la solicitud DELETE
        $url = BASE . '/planillas/delete/' . $id_planilla;

        // Inicializa cURL
        $ch = curl_init();

        // Configura la URL y otras opciones
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // Establece el método HTTP como DELETE
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Realiza la solicitud DELETE
        $response = json_decode(curl_exec($ch), true);

        // Cierra la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesa la respuesta según el código de respuesta HTTP
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
        header("Location: $base_request/planillas.php?id=" . $id_servicio);
        exit();
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/planillas.php?id=" . $id_servicio);
    exit();
}
?>
