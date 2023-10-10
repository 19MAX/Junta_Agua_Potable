<?php
include "APIurls.php";

if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    if ($_POST) {
        $id_user = (int)$_POST['id_user'];
        $new_password = $_POST['new_password'];
    }
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
        'Content-Length: ' . strlen($data)           // Longitud del cuerpo de la solicitud
    ));

    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

    // Ejecuta la solicitud PUT y obtén la respuesta
    $response = curl_exec($ch);

    // Cierra la sesión cURL
    curl_close($ch);

    // Verifica el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Comprueba si la solicitud fue exitosa (código de respuesta 200) o si hubo un error (código de respuesta 400)
    if ($httpCode === 200) {
        // La solicitud fue exitosa

        echo "Solicitud exitosa. Respuesta: " . $response;
    } elseif ($httpCode === 400) {
        
        // Hubo un error en la solicitud
        echo "Error en la solicitud. Respuesta: " . $response;
    } else {
        // Otro código de respuesta HTTP
        echo "Se produjo un error inesperado. Código de respuesta HTTP: " . $httpCode;
    }
} else {
    header('Location: /Sistema/index.php?alert=error');
    exit();
}
?>