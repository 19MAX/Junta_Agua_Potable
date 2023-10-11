<?php
include "flash_messages.php";
include "APIurls.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibe los datos del formulario
    $id_planilla = $_POST["id_planilla"];
    $id_servicio = $_POST["id_servicio"];
    $nueva_lectura = (int)$_POST["nueva_lectura"];

    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
        // Puedes proceder con la actualización de la lectura
        $url = BASE . "/planillas/update/lectura/" . $id_planilla;

        $data = array(
            'nueva_lectura' => $nueva_lectura,
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

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Procesa la respuesta según el código de respuesta HTTP
        if ($httpCode === 200) {
            create_flash_message(
                "La Planilla se Actualizo exitosamnete",
                "success"
            );
        } else {
            create_flash_message(
                "La Planilla no se puede Actualizar",
                "error"
            );
        }
        header("Location: $base_request/planillas.php?id=" . $id_servicio);
        exit();
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/planillas.php?id=" . $id_servicio);
    exit();
}
?>
