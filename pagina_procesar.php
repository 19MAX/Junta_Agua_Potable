<?php
include "flash_messages.php";
include "APIurls.php";

// Verificar si el archivo de cookies existe y no está vacío
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    if ($_GET) {
        $id_servicio = $_GET['id_servicio'];
        $id_planilla = $_GET['id_planilla'];
        $pagado = ($_GET["pagado"] == "1") ? true : false;
    }

    // URL de la API o recurso al que deseas enviar datos
    $url = BASE . '/planillas/update/pago/' . $id_planilla;

    // Datos que deseas enviar en la solicitud PUT (en este ejemplo, un array asociativo)
    $data = array(
        'id_planilla' => $id_planilla, // Reemplaza con el ID de la planilla que deseas actualizar
        'pagado' => $pagado, // El nuevo valor para el campo "pagado"
    );

    // Convierte los datos a formato JSON
    $jsonData = json_encode($data);

    // Inicializa cURL
    $ch = curl_init();

    // Configura la URL y otras opciones
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Configura la solicitud como PUT
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Agrega los datos JSON a enviar
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json', // Establece el encabezado Content-Type
        'Content-Length: ' . strlen($jsonData) // Establece la longitud del contenido JSON
    ));

    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Realiza la solicitud PUT y obtiene la respuesta
    $response = curl_exec($ch);

    // Cierra la sesión cURL
    curl_close($ch);

    // Obtener el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Comprobar si hubo errores en la solicitud cURL
    if (curl_errno($ch)) {
        echo "Error en la solicitud cURL: " . curl_error($ch);
    } else {
        // Procesa la respuesta según el código de respuesta HTTP
        if ($httpCode === 200) {
            create_flash_message(
                "Se Cambio el estado de pago Correctamente ",
                "success"
            );

            header('Location: /Sistema/planillas.php?id=' . $id_servicio);
            exit();
        } elseif ($httpCode === 400) {
            create_flash_message(
                "El estado de pago no se pudo Cambiar ",
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
    header('Location: /Sistema/index.php?alert=error');
    exit();
}
?>
