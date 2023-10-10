<?php include "APIurls.php";?>

<?php 

// Verifica si el archivo de cookies existe y no está vacío
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    // URL a la que deseas hacer la solicitud
    $url = BASE . '/auth/logout';

    // Inicializa una nueva sesión cURL
    $ch = curl_init($url);

    // Configura las opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena en lugar de imprimirla
    curl_setopt($ch, CURLOPT_POST, true); // Utiliza el método POST
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Ejecuta la solicitud cURL y obtén la respuesta
    $response = curl_exec($ch);

    // Verifica si hubo algún error
    if (curl_errno($ch)) {
        echo 'Error en la solicitud cURL: ' . curl_error($ch);
    }

    // Cierra la sesión cURL
    curl_close($ch);
    
    try {
        // Borra el contenido del archivo de cookies
        file_put_contents($cookieFile, '');

        // Redirige a la página de inicio de sesión
        header('Location: /Sistema/index.php');
        exit();
    } catch (Exception $e) {
        header('Location: /Sistema/principal.php');
    }
} else {
    // El archivo de cookies no existe o está vacío, realiza la acción que desees en este caso
    // Por ejemplo, puedes redirigir a la página de inicio de sesión o mostrar un mensaje de error.
    header('Location: /Sistema/index.php');
    exit();
}
?>