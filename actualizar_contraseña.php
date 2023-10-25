<?php
include "user_session.php";
include "APIurls.php";
include "flash_messages.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $id_user = (int)$_POST['id_user'];
        $new_password = $_POST['new_password'];
        // URL de la API o recurso al que deseas enviar la solicitud PUT
        $url = BASE . '/admin/reset/password';

        // Datos que deseas enviar en la solicitud PUT (en formato JSON)
        $data = json_encode(array(
            'id_user' => $id_user,
            'new_password' => $new_password,
        ));

        // Inicializa cURL
        $ch = curl_init($url);

        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Establece el método PUT
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);     // Establece los datos a enviar
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Devuelve el resultado en lugar de imprimirlo
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',             // Tipo de contenido JSON
        ));

        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Ejecuta la solicitud PUT y obtén la respuesta
        $response = json_decode(curl_exec($ch), true);

        // Cierra la sesión cURL
        curl_close($ch);

        // Verifica el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Comprueba si la solicitud fue exitosa (código de respuesta 200) o si hubo un error (código de respuesta 400)
        if ($httpCode === 200) {
            // La solicitud fue exitosa
            create_flash_message(
                $response['success'],
                "success"
            );
        } elseif ($httpCode !== 200) {
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