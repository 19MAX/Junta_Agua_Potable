<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $id_servicio = (int)$_POST["id_servicio"];
        $lectura_actual = (int)$_POST["lectura_actual"];

        // Datos a enviar en la solicitud cURL
        $data = array(
            'lectura_actual' => $lectura_actual,
            'id_servicio' => $id_servicio
        );

        // URL de la API o servidor al que deseas enviar la solicitud cURL
        $url = BASE . '/planillas/new';

        $json_data = json_encode($data);

        // Inicializar cURL
        $ch = curl_init($url);

        // Establecer opciones de cURL
        curl_setopt($ch, CURLOPT_POST, 1); // Usar el método POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); // Enviar los datos en formato JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir la respuesta en lugar de imprimirla en pantalla
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data))
        );
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Ejecutar la solicitud cURL
        $response = json_decode(curl_exec($ch), true);

        // Cerrar la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesar la respuesta según el código de respuesta HTTP
        if ($httpCode === 201) {
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
        // El archivo de cookies no existe o está vacío
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/planillas.php?id=" . $id_servicio);
    exit();
}
?>
