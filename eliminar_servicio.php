<?php
include "flash_messages.php";
include "APIurls.php";


// Verificar si se ha proporcionado un ID válido
if ($_GET) {
    $nombre = $_GET['nombre'];
    $id_servicio = $_GET['id_servicio'];
    $id_de_cliente = $_GET['id_de_cliente'];
    // Verificar si el archivo de cookies existe y no está vacío
    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {

        // URL de la API para eliminar un cliente
        $url = BASE . "/servicios/delete/" . $id_servicio;

        // Inicializar cURL
        $ch = curl_init($url);

        // Establecer opciones de cURL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Usar el método DELETE
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir la respuesta en lugar de imprimirla en pantalla
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);

        // Cerrar la sesión cURL
        curl_close($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode === 200) {
            create_flash_message(
                "Servicio  Eliminado Exitosamente",
                "success"
            );
        } else {
            create_flash_message(
                "El servicio no se Elimino Correctamente",
                "error"
            );
        }
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
}
header("Location: $base_request/servicios.php?id=" . $id_de_cliente . '&nombre=' . $nombre);
exit();

?>
