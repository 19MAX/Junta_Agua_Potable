<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

ini_set("display_errors",1);
error_reporting(E_ALL);

// Verificar si se ha proporcionado un ID válido
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $session_cookie = get_cookied_session();
    // Verificar si el archivo de cookies existe y no está vacío
    if (isset($session_cookie)) {
        // URL de la API para eliminar un cliente
        $url = BASE . "/admin/delete/" . $id;

        // Inicializar cURL
        $ch = curl_init($url);

        // Establecer opciones de cURL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Usar el método DELETE
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir la respuesta en lugar de imprimirla en pantalla
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Ejecutar la solicitud cURL
        $response = json_decode(curl_exec($ch),true);

        // Cerrar la sesión cURL
        curl_close($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode === 200) {
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
        header("Location: $base_request/administradores.php");
        exit();
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/administradores.php");
    exit();
}

?>
