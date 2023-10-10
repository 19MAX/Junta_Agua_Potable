<?php
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si el archivo de cookies existe y no está vacío
    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
        $nombre = $_POST["nombre"];
        $id_cliente = (int)$_POST["id_cliente"];
        $n_conexion = (int)$_POST["n_conexion"];
        $n_medidor = (int)$_POST["n_medidor"];
        $direccion = $_POST["direccion"];
        $estado = ($_POST["estado"] == "1") ? true : false;
        $lectura_anterior = (int)$_POST["lectura_anterior"];

        // Datos a enviar en la solicitud cURL
        $data = array(
            'id_cliente' => $id_cliente,
            'n_conexion' => $n_conexion,
            'n_medidor' => $n_medidor,
            'direccion' => $direccion,
            'estado' => $estado,
            'lectura_anterior' => $lectura_anterior
        );

        // URL de la API o servidor al que deseas enviar la solicitud cURL
        $url = BASE . '/servicios/new';

        $json_data = json_encode($data);
        // Inicializar cURL
        $ch = curl_init($url);

        // Establecer opciones de cURL
        curl_setopt($ch, CURLOPT_POST, 1); // Usar el método POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); // Enviar los datos en formato JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir la respuesta en lugar de imprimirla en pantalla
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data))
        );
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);

        // Cerrar la sesión cURL
        curl_close($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesar la respuesta según el código de respuesta HTTP
        if ($httpCode === 201) {

            create_flash_message(
                "Servicio Registrado Exitosamente",
                "success"
            );
        } else{
            create_flash_message(
                "Servicio No Registrado ",
                "error"
            );
        header("Location: $base_request/servicios.php?id=" . $id_cliente . '&nombre=' . $nombre);
        exit();
        }
    } else {
        // El archivo de cookies no existe o está vacío
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
}
?>
