<?php

if (isset($session_cookie)) {
    // URL a la que deseas hacer la solicitud GET
    $url = BASE . '/general/get/stats/cobros/conexion';

    // Inicializa una nueva sesión CURL
    $ch = curl_init($url);

    // Establece las opciones para la sesión CURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena en lugar de imprimirla
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Utiliza el método GET
    curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

    // Ejecuta la solicitud CURL y obtén la respuesta
    $response = json_decode(curl_exec($ch), true);

    curl_close($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $stats_cobros = null;

    if ($http_code !== 200) {
        create_flash_message("No fue posible obtener los graficos",'error');
    }
    $stats_conexion_contado = $response['success']['resumen_conexion_contado'];
    $stats_conexion_financiamiento = $response['success']['resumen_conexion_financiamiento'];
    $stats_reconexion = $response['success']['resumen_reconexion'];
} else {
    header("Location: $base_request/index.php?alert=error");
}
