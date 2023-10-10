<?php
include "flash_messages.php";
include "APIurls.php";

if (isset($_GET)) {
    $nombre = $_GET['nombre'];
    $id_principal = $_GET['id_principal'];
    $id_servicio = $_GET['id_servicio'];
    $id_cliente = (int)$_GET['id_cliente'];
}

// URL de la API donde deseas enviar la solicitud PUT
$api_url = BASE . '/servicios/update/cliente/' . $id_servicio;

// Datos que deseas enviar en la solicitud PUT (en formato JSON)
$data = json_encode(array(
    'id_cliente' => $id_cliente,
));

if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
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
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Realiza la solicitud PUT a la API
    $response = curl_exec($ch);
    
    // Cierra la sesión cURL
    curl_close($ch);

    // Obtener el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Comprobar si hubo errores en la solicitud cURL
    if (curl_errno($ch)) {
        echo "Error en la solicitud cURL: " . curl_error($ch);
    } else {
        // Procesar la respuesta según el código de respuesta HTTP
        if ($httpCode === 200) {
            create_flash_message(
                "El Servicio se cambio Exitosamente de cliente",
                "success"
            );

            header('Location: /Sistema/servicios.php?id=' . $id_principal . '&nombre=' . $nombre);
            exit();
        } elseif ($httpCode === 400) {
            create_flash_message(
                "El servicio no se cambio de cliente",
                "error"
            );

            header('Location: /Sistema/servicios.php?id=' . $id_principal . '&nombre=' . $nombre);
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
?>
