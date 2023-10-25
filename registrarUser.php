<?php
include "user_session.php";
include "APIurls.php";
include "flash_messages.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $cedula = $_POST["cedula"];
        $nombres = $_POST["nombres"];
        $apellidos = $_POST["apellidos"];
        $telefono = $_POST["telefono"];

        // Datos a enviar en el cuerpo de la solicitud en formato JSON
        $data = array(
            'cedula' => $cedula,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono
        );

        // URL de la API a la que deseas enviar los datos
        $url = BASE . '/clientes/new';

        // Convertir los datos a formato JSON
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
        $response = json_decode(curl_exec($ch),true);

        // Cerrar la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Manejar la respuesta de la API según el código de respuesta
        if ($httpCode === 201) {
            create_flash_message(
                $response['success'],
                "success"
            );
        } else{
            create_flash_message(
                $response['error'],
                "error"
            );
        }
        header("Location: $base_request/principal.php");
        exit();
    } else {
        // El archivo de cookies no existe o está vacío
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/principal.php");
    exit();
}
?>
