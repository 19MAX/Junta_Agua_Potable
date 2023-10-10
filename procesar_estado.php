<?php 
include "flash_messages.php";
include("APIurls.php");

if (isset($_GET['id']) && isset($_GET['id_cliente'])) {
    $id_cliente = $_GET['id_cliente'];
    $id_servicio = $_GET['id'];
    $estado = ($_GET["estado"] == "1") ? true : false;
    $nombre =$_GET['nombre'];


    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
        // Las cookies están definidas y no están vacías

        // URL de la API
        $url = BASE . "/servicios/update/estado/" . $id_servicio; // Reemplaza con la URL de tu API

        // Datos a enviar en formato JSON
        $data = [
            'id' => $id_servicio,
            'estado' => $estado,
        ];

        // Convertir datos a JSON
        $jsonData = json_encode($data);

        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar las opciones de cURL para una solicitud PUT
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

        // Realizar la solicitud a la API
        $response = curl_exec($ch);

        // Procesar la respuesta de la API
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Cerrar la conexión cURL
        curl_close($ch);

        if ($httpCode === 200) {
            create_flash_message(
                "El Estado se Actualizo Correctamente ",
                "success"
            );
        } else {
            create_flash_message(
                "El Estado No se Actualizo ",
                "error"
            );
        }
        header("Location: $base_request/servicios.php?id=" . $id_cliente . '&nombre=' . $nombre);
        exit();
    } else {
        // Las cookies no están definidas o están vacías
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
}
header("Location: $base_request/servicios.php?id=" . $id_cliente . '&nombre=' . $nombre);
exit();
?>