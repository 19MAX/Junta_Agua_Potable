<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $id_notificacion = (int)$_POST['actualizar_not_id'];

        // URL a la que deseas hacer la solicitud PUT
        $url = BASE . '/notificaciones/update/pago/' . $id_notificacion;

        // Inicializar la sesión cURL
        $ch = curl_init($url);

        // Configurar las opciones de la solicitud cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devolver el resultado en lugar de imprimirlo en pantalla
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Establecer el método de solicitud como PUT
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Establecer encabezados si es necesario (por ejemplo, para enviar JSON)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));

        // Realizar la solicitud cURL y obtener la respuesta
        $response = json_decode(curl_exec($ch), true);

        // Verificar el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Cerrar la sesión cURL
        curl_close($ch);

        if ($httpCode == 200) {
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
        header("Location: $base_request/notificaciones.php");
        exit();
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/notificaciones.php");
    exit();
}
