<?php
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibe los datos del formulario
    $id = $_POST["cliente_id"];
    $cedula = $_POST["cedula"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $telefono = $_POST["telefono"];

    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
        // La cédula no está duplicada, puedes proceder con la actualización
        $url = BASE . "/clientes/update/" . $id;
        $data = array(
            'cedula' => $cedula,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono
        );
        $json_data = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data))
        );
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        $response = curl_exec($ch);
        curl_close($ch);

        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL: ' . curl_error($ch);
        } else {    
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                create_flash_message(
                    "Informacion del Cliente Actualizado Exitosamente",
                    "success"
                );

                header("Location: principal.php");
                exit;
            } elseif ($httpCode === 400) {
                create_flash_message(
                    "El Cliente no se actualizo por favor ingrese nuevamente la informacion",
                    "error"
                );

                header("Location: principal.php");
                exit;
            } else {
                echo "Error desconocido: Código de respuesta HTTP $httpCode.";
                
            }
        }
    } else {
        header('Location: /Sistema/index.php?alert=error');
        exit();
    }
} else {
    echo "Error: El formulario no se ha enviado correctamente.";
}

?>
