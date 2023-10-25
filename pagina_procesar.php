<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $id_servicio = $_GET['id_servicio'];
        $id_planilla = $_GET['id_planilla'];
        $pagado = ($_GET["pagado"] == "1") ? true : false;

        // URL de la API o recurso al que deseas enviar datos
        $url = BASE . '/planillas/update/pago/' . $id_planilla;

        // Datos que deseas enviar en la solicitud PUT (en este ejemplo, un array asociativo)
        $data = array(
            'id_planilla' => $id_planilla, // Reemplaza con el ID de la planilla que deseas actualizar
            'pagado' => $pagado, // El nuevo valor para el campo "pagado"
        );

        // Convierte los datos a formato JSON
        $jsonData = json_encode($data);

        // Inicializa cURL
        $ch = curl_init($url);

        // Configura la URL y otras opciones
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Configura la solicitud como PUT
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Agrega los datos JSON a enviar
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json', // Establece el encabezado Content-Type
            'Content-Length: ' . strlen($jsonData) // Establece la longitud del contenido JSON
        ));

        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Realiza la solicitud PUT y obtiene la respuesta
        $response = json_decode(curl_exec($ch), true);

        // Cierra la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesa la respuesta según el código de respuesta HTTP
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
        header("Location: $base_request/planillas.php?id=" . $id_servicio);
        exit();
    }
}
else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>
