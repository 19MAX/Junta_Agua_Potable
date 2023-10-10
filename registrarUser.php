<?php
include "flash_messages.php";

include "APIurls.php";

if ($_POST) {
    // Verificar si el archivo de cookies existe y no está vacío
    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
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
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);

        // Cerrar la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Manejar la respuesta de la API según el código de respuesta
        if ($httpCode !== 201) {
            $response = json_decode($response);

            create_flash_message(
                "No se pudo registrar el usuario",
                "error"
            );
        } else{
            create_flash_message(
                "Cliente Registrado exitosamente",
                "success"
            );
        }
        header("Location: $base_request/principal.php");
        exit();
    } else {
        // El archivo de cookies no existe o está vacío
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
}
?>
