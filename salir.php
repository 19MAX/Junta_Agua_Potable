<?php
include "user_session.php";
include "APIurls.php";

$session_cookie = get_cookied_session();
if (isset($session_cookie)) {
    try {
        // URL a la que deseas hacer la solicitud
        $url = BASE . '/auth/logout';

        // Inicializa una nueva sesión cURL
        $ch = curl_init($url);

        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena en lugar de imprimirla
        curl_setopt($ch, CURLOPT_POST, true); // Utiliza el método POST
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Ejecuta la solicitud cURL y obtén la respuesta
        $response = curl_exec($ch);

        // Verifica si hubo algún error
        if (curl_errno($ch)) {
            throw new Exception('Ocurrio un error al cerrar sesion');
        }

        // Cierra la sesión cURL
        curl_close($ch);

        // Redirige a la página de inicio de sesión
        delete_session();
        header("Location: $base_request/index.php");
        exit();
    } catch (Exception $e) {
        header("Location: $base_request/principal.php");
        exit();
    }
} else {
    delete_session();
    header("Location: $base_request/index.php");
    exit();
}
?>