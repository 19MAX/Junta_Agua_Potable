<?php 

include "APIurls.php";
include "flash_messages.php";
// URL a la que deseas hacer la solicitud GET
$url = BASE . '/pagos/reconexion/get/all';

if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devolver la respuesta como una cadena en lugar de imprimir directamente
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Usar el método GET
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Realizar la solicitud cURL
    $response = curl_exec($ch);

    // Verificar el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la sesión cURL
    curl_close($ch);

    if ($httpCode == 200) {
        // El servidor respondió correctamente (código 200)
        $response = json_decode($response, true);
    } else {
        create_flash_message(
            'No se pudo cargar los datos',
            'error'
        );
    }
} else {
    // Las cookies no están definidas o están vacías
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>
<?php include("plantilla/header.php") ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Pagos por Reconexion</h1>
    <div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between shadow-sm">
                        <h6 class="m-0 font-weight-bold text-primary">Pagos por Reconexion</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="table-responsive shadow-sm">
                        <table id="tabla_conexion" class="crud-table">
                            <thead>
                                <tr>
                                    <th>Id Servicio</th>
                                    <th>N conexion</th>
                                    <th>N medidor</th>
                                    <th>nombres</th>
                                    <th>apellidos</th>
                                    <th>fecha_emision</th>
                                    <th>hora_emision</th>
                                    <th>total</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($response["success"] as $registro) {
                                    $id = $registro["id"];
                                    $servicio = $registro["servicio"];
                                    $cliente = $registro["cliente"];
                                    $fecha_emision = $registro["fecha_emision"];
                                    $hora_emision = $registro["hora_emision"];
                                    $total = $registro["total"];
                                
                                    // Accede a los datos dentro de "servicio"
                                    $id_servicio = $servicio["id"];
                                    $n_conexion = $servicio["n_conexion"];
                                    $n_medidor = $servicio["n_medidor"];
                                    $direccion = $servicio["direccion"];
                                    $estado = $servicio["estado"];
                                    $lectura_anterior = $servicio["lectura_anterior"];
                                
                                    // Accede a los datos dentro de "cliente"
                                    $id_cliente = $cliente["id"];
                                    $cedula = $cliente["cedula"];
                                    $nombres = $cliente["nombres"];
                                    $apellidos = $cliente["apellidos"];
                                    $telefono = $cliente["telefono"];

                                    echo '<tr>';
                                    
                                    echo'<td>' .$id_servicio .'</td>';
                                    echo'<td>' .$n_conexion .'</td>';
                                    echo'<td>' .$n_medidor .'</td>';
                                    echo'<td>' .$nombres .'</td>';
                                    echo'<td>' .$apellidos .'</td>';
                                    echo'<td>' .$fecha_emision .'</td>';
                                    echo'<td>' .$hora_emision .'</td>';
                                    echo'<td>' .$total .'</td>';
                                    
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("plantilla/footer.php");?>