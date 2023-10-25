<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consumo_base = (float)$_POST['consumo_base'];
    $exedente = (float)$_POST['exedente'];
    $valor_consumo_base = (float)$_POST['valor_consumo_base'];
    $valor_exedente = (float)$_POST['valor_exedente'];
    $reconexion = (float)$_POST['reconexion'];

    $session_cookie = get_cookied_session();
    // Verifica si el archivo de cookies existe y no está vacío
    if (isset($session_cookie)) {
        // URL a la que deseas hacer la solicitud PUT
        $url = BASE . '/configuracion/update/default';

        // Datos que deseas enviar en la solicitud (pueden ser un arreglo o una cadena JSON)
        $data = array(
            'consumo_base' => $consumo_base,
            'exedente' => $exedente,
            'valor_consumo_base' => $valor_consumo_base,
            'valor_exedente' => $valor_exedente,
            'reconexion' => $reconexion
        );

        // Convertir los datos a formato JSON si es necesario
        $jsonData = json_encode($data);

        // Inicializar la sesión cURL
        $ch = curl_init($url);

        // Configurar las opciones de la solicitud cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devolver el resultado en lugar de imprimirlo en pantalla
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Establecer el método de solicitud como PUT
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Establecer los datos a enviar en la solicitud
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Establecer encabezados si es necesario (por ejemplo, para enviar JSON)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));

        // Realizar la solicitud cURL y obtener la respuesta
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        // Verificar el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Cerrar la sesión cURL
        curl_close($ch);

        if ($httpCode === 200) {
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
        header("Location: $base_request/configuracion.php");
        exit();
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>
