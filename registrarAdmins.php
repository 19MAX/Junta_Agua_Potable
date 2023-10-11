<?php
include "flash_messages.php";
include "APIurls.php";

if (file_exists($cookieFile) && filesize($cookieFile) > 0) {

    if (isset($_POST)) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    }

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
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores


    // Ejecuta la solicitud cURL
    $response = curl_exec($ch);

    // Obtiene el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cierra la conexión cURL
    curl_close($ch);

    if ($httpCode === 201) {

        create_flash_message(
            "El administrador se registro exitosamente ",
            "success"
        );

        header("Location: $base_request/administradores.php");
        exit();

    } elseif ($httpCode !== 201) {
        create_flash_message(
            "El administrador no se pudo registrar ",
            "error"
        );

        header("Location: $base_request/administradores.php");
        exit();
    }
} else {
    // El archivo de cookies no existe o está vacío
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>
