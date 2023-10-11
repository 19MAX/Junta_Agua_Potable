<?php
include "flash_messages.php";
include "APIurls.php";
if ($_POST) {
    $cuota1 = (float)$_POST['cuota1'];
    $cuota2 = (float)$_POST['cuota2'];
    $cuota3 = (float)$_POST['cuota3'];
    $cuota4 = (float)$_POST['cuota4'];
    $cuota5 = (float)$_POST['cuota5'];
    $cuota6 = (float)$_POST['cuota6'];
    $id_pago = $_POST['id_pago'];
}
// Verifica si el archivo de cookies existe y no está vacío
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
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
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Establecer encabezados si es necesario (por ejemplo, para enviar JSON)
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ));

    // Realizar la solicitud cURL y obtener la respuesta
    $response = curl_exec($ch);

    // Verificar el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la sesión cURL
    curl_close($ch);

    if ($httpCode == 200) {
        create_flash_message(
            "Datos Actualizados  Exitosamente ",
            "success"
        );
        header('Location: /Sistema/financiamiento.php');
        exit();
    } elseif ($httpCode == 400) {
        create_flash_message(
            "Datos No  Actualizados  ",
            "error"
        );
        header('Location: /Sistema/financiamiento.php');
        exit();
    } else {
        // Otro código de respuesta HTTP
        echo 'Error en la solicitud: Código de respuesta HTTP ' . $httpCode;
    }

} else {
    header('Location: /Sistema/index.php?alert=error');
    exit();
}
?>
