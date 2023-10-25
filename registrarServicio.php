<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        $nombre = $_POST["nombre"];
        $id_cliente = (int)$_POST["id_cliente"];
        $n_conexion = (int)$_POST["n_conexion"];
        $n_medidor = (int)$_POST["n_medidor"];
        $direccion = $_POST["direccion"];
        $estado = ($_POST["estado"] == "1") ? true : false;
        $lectura_anterior = (int)$_POST["lectura_anterior"];
        $contado_conexion = isset($_POST["contado_conexion_bool"]) && $_POST["contado_conexion_bool"] == "true";
        $financiamiento_conexion = isset($_POST["financiamiento_conexion_bool"]) && $_POST["financiamiento_conexion_bool"] == "true";


        // Datos a enviar en la solicitud cURL
        $data = array(
            'id_cliente' => $id_cliente,
            'n_conexion' => $n_conexion,
            'n_medidor' => $n_medidor,
            'direccion' => $direccion,
            'estado' => $estado,
            'lectura_anterior' => $lectura_anterior,
            'contado_conexion'=> $contado_conexion,
            'financiamiento_conexion'=> $financiamiento_conexion
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
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Ejecutar la solicitud cURL
        $response = json_decode(curl_exec($ch),true);

        // Cerrar la sesión cURL
        curl_close($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesar la respuesta según el código de respuesta HTTP
        if ($httpCode === 201) {

            create_flash_message(
                $response['success'],
                "success"
            );
        } else{
            create_flash_message(
                $response['error'],
                "error"
            );
        }
        header("Location: $base_request/servicios.php?id=" . $id_cliente . '&nombre=' . $nombre);
        exit();
    } else {
        // El archivo de cookies no existe o está vacío
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/servicios.php?id=" . $id_cliente . '&nombre=' . $nombre);
    exit();
}
?>
