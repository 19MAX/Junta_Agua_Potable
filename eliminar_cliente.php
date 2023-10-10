<?php
include "flash_messages.php";

include "APIurls.php";

// Verificar si se ha proporcionado un ID válido
if (isset($_GET['id'])) {
    // Verifica si el archivo de cookies existe y no está vacío
    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
        $id = $_GET['id'];

        // URL de la API para eliminar un cliente
        $url = BASE . "/clientes/delete/" . $id;

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

        // Manejar la respuesta de la API aquí
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            create_flash_message(
                "Cliente eliminado exitosamente",
                "success"
            );
        } else {
            create_flash_message(
                "No se pudo eliminar al usuario",
                "error"
            );
        }
        header("Location: $base_request/principal.php");
        exit;
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/principal.php");
    exit;
}

?>
