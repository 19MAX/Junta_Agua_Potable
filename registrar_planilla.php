<?php
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si el archivo de cookies existe y no está vacío
    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
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
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        
        // Cerrar la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Comprobar si hubo errores en la solicitud cURL
        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL: ' . curl_error($ch);
        } else {
            // Procesar la respuesta según el código de respuesta HTTP
            if ($httpCode === 201) {
                create_flash_message(
                    "La planilla se Registro Exitosamente ",
                    "success"
                );

                header('Location: /Sistema/planillas.php?id=' . $id_servicio);
                exit();
            } elseif ($httpCode === 400) {
                create_flash_message(
                    "La planilla no se Registro ",
                    "error"
                );

                header('Location: /Sistema/planillas.php?id=' . $id_servicio);
                exit();
            } else {
                // Otros códigos de respuesta: Puedes manejarlos según tus necesidades
                echo 'Error desconocido: Código de respuesta HTTP ' . $httpCode;
            }
        }
    } else {
        // El archivo de cookies no existe o está vacío
        header('Location: /Sistema/index.php?alert=error');
        exit();
    }
}
?>
