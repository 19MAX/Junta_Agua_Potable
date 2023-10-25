<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Datos que deseas enviar en la solicitud POST (en este ejemplo, datos de formulario)
        $data = array(
            'username' => $username,
            'password' => $password
        );

        // URL del punto final al que deseas enviar la solicitud POST
        $url = BASE . '/admin/new';

        $json_data = json_encode($data);

        // Inicializa cURL
        $ch = curl_init($url);

        // Configura la solicitud POST
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        // Habilita el retorno de la respuesta como una cadena en lugar de imprimirlo directamente
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json', // Establece el tipo de contenido como JSON
        ));
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");


        // Ejecuta la solicitud cURL
        $response = json_decode(curl_exec($ch), true);

        // Obtiene el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Cierra la conexión cURL
        curl_close($ch);

        if ($httpCode === 201) {

            create_flash_message(
                $response['success'],
                "success"
            );
        } else {
            create_flash_message(
                $response['error'],
                "error"
            );
        }
        header("Location: $base_request/administradores.php");
        exit();
    } else {
        // El archivo de cookies no existe o está vacío
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/administradores.php");
    exit();
}
?>
