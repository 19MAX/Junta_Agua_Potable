<?php
if (isset($session_cookie)) {
    // URL a la que deseas hacer la solicitud GET
    $url = BASE . '/general/get/stats';

    // Inicializa una nueva sesión CURL
    $ch = curl_init($url);

    // Establece las opciones para la sesión CURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena en lugar de imprimirla
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Utiliza el método GET
    curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

    // Ejecuta la solicitud CURL y obtén la respuesta
    $infoAPP = curl_exec($ch);

    curl_close($ch);

    // Decodifica la respuesta JSON en un objeto PHP
    $infoApp = json_decode($infoAPP, true);

    // Verifica si la respuesta contiene datos válidos
    if ($infoApp && isset($infoApp['success'])) {
        $estadisticas = $infoApp['success'];

        // Ahora puedes acceder a los datos de estadísticas generales
        $clientesN = $estadisticas['clientes'];
        $serviciosN = $estadisticas['servicios'];
        $notificaciones = $estadisticas['notificaciones'];

        // Realiza las operaciones necesarias con los datos
    }
} else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}


?>

