<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $cuota1 = (float)$_POST['cuota1'];
        $cuota2 = (float)$_POST['cuota2'];
        $cuota3 = (float)$_POST['cuota3'];
        $cuota4 = (float)$_POST['cuota4'];
        $cuota5 = (float)$_POST['cuota5'];
        $cuota6 = (float)$_POST['cuota6'];
        $id_pago = $_POST['id_pago'];

        // URL a la que deseas hacer la solicitud PUT
        $url = BASE . '/pagos/financiamiento/update/cuotas/' . $id_pago;

        // Datos que deseas enviar en la solicitud (pueden ser un arreglo o una cadena JSON)
        $data = array(
            'cuota1' => $cuota1,
            'cuota2' => $cuota2,
            'cuota3' => $cuota3,
            'cuota4' => $cuota4,
            'cuota5' => $cuota5,
            'cuota6' => $cuota6
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
            'Content-Length: ' . strlen($jsonData)
        ));

        // Realizar la solicitud cURL y obtener la respuesta
        $response = json_decode(curl_exec($ch), true);

        // Verificar el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Cerrar la sesión cURL
        curl_close($ch);

        if ($httpCode == 200) {
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
        header("Location: $base_request/financiamiento.php");
        exit();
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/financiamiento.php");
    exit();
}
?>
