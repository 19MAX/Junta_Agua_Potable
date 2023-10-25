<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nombre = $_GET['nombre'];
    $id_principal = $_GET['id_principal'];
    $id_servicio = $_GET['id_servicio'];
    $id_cliente = (int)$_GET['id_cliente'];

    // URL de la API donde deseas enviar la solicitud PUT
    $api_url = BASE . '/servicios/update/cliente/' . $id_servicio;

    // Datos que deseas enviar en la solicitud PUT (en formato JSON)
    $data = json_encode(array(
        'id_cliente' => $id_cliente,
    ));

    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        // Inicializa cURL
        $ch = curl_init($api_url);

        // Configura las opciones de cURL para una solicitud PUT
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Establece el método PUT
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);     // Establece los datos a enviar
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Devuelve el resultado en lugar de imprimirlo
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',             // Tipo de contenido JSON
            'Content-Length: ' . strlen($data)           // Longitud del cuerpo de la solicitud
        ));
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Realiza la solicitud PUT a la API
        $response = curl_exec($ch);
        $response = json_decode(curl_exec($ch), true);
        // Cierra la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesar la respuesta según el código de respuesta HTTP
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
        header("Location: $base_request/servicios.php?id=" . $id_principal . '&nombre=' . $nombre);
        exit();
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/servicios.php?id=" . $id_principal . '&nombre=' . $nombre);
    exit();
}
?>
