<?php
include "user_session.php";
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        // Recibe los datos del formulario
        $nombre = $_POST['nombre'];
        $id_de_cliente = $_POST["id_de_cliente"];
        $id = (int)$_POST["id_servicio"];
        $n_conexion = (int)$_POST["n_conexion"];
        $n_medidor = (int)$_POST["n_medidor"];
        $direccion = $_POST["direccion"];

        // URL de la API a la que deseas enviar los datos
        $url = BASE . "/servicios/update/" . $id;

        // Datos a enviar en el cuerpo de la solicitud en formato JSON
        $data = array(
            'n_conexion' => $n_conexion,
            'n_medidor' => $n_medidor,
            'direccion' => $direccion
        );

        // Convertir los datos a formato JSON
        $json_data = json_encode($data);

        // Inicializar cURL
        $ch = curl_init($url);

        // Establecer opciones de cURL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Usar el método PUT
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); // Enviar los datos en formato JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir la respuesta en lugar de imprimirla en pantalla
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data))
        );
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Ejecutar la solicitud cURL
        $response = json_decode(curl_exec($ch), true);

        // Cerrar la sesión cURL
        curl_close($ch);

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesar la respuesta según el código de respuesta HTTP
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
        header("Location: $base_request/servicios.php?id=" . $id_de_cliente . '&nombre=' . $nombre);
        exit();
    } else {
        // El archivo de cookies no existe o está vacío
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
}
header("Location: $base_request/servicios.php?id=" . $id_de_cliente . '&nombre=' . $nombre);
exit();
?>
