<?php 

include "APIurls.php"; 
// URL a la que deseas hacer la solicitud GET
$url = BASE . '/pagos/financiamiento/get/all';

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
        
    } elseif ($httpCode == 400) {
        // Error 400: Solicitud incorrecta
        echo 'Error 400: Solicitud incorrecta';
    } else {
        // Otro código de respuesta HTTP
        echo 'Error en la solicitud: Código de respuesta HTTP ' . $httpCode;
    }

} else {
    // Las cookies no están definidas o están vacías
    header('Location: /Sistema/index.php?alert=error');
    exit();
}
?>
<?php include("plantilla/header.php") ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Financiamiento</h1>
    
<script src="js/flash_messages.js"></script>
    <div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Financiamiento</h6>
                        <?php var_dump ($response); ?>
                    </div>
                    <!-- Card Body -->
                    <div class="table-responsive ">
                        <table id="tabla_conexion" class="crud-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Financiamiento</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("plantilla/footer.php");?>