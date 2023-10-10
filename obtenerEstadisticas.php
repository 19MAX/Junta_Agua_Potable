<?php include "APIurls.php"; ?>


<?php

// Verificar si el archivo de cookies existe y no está vacío
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    // URL a la que deseas hacer la solicitud GET
    $url = BASE . '/general/get/stats';

    // Inicializa una nueva sesión CURL
    $ch = curl_init($url);

    // Establece las opciones para la sesión CURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena en lugar de imprimirla
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Utiliza el método GET
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Ejecuta la solicitud CURL y obtén la respuesta
    $infoAPP = curl_exec($ch);

    // Verifica si hubo algún error en la solicitud
    if (curl_errno($ch)) {
        echo 'Error en la solicitud CURL: ' . curl_error($ch);
    }

    curl_close($ch);

    // Decodifica la respuesta JSON en un objeto PHP
    $response = json_decode($infoAPP, true);

    // Verifica si la respuesta contiene datos válidos
    if ($response && isset($response['success'])) {
        $estadisticas = $response['success'];

        // Ahora puedes acceder a los datos de estadísticas generales
        $clientesN = $estadisticas['clientes'];
        $serviciosN = $estadisticas['servicios'];
        $notificaciones = $estadisticas['notificaciones'];

        // Realiza las operaciones necesarias con los datos
    } else {
        echo '<p>Error: No se pudo obtener la información de las estadísticas generales.</p>';
    }
} else {
    
    header('Location: /Sistema/index.php?alert=error');
    exit();
}


?>

