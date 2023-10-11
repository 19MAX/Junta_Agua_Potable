<?php
include "APIurls.php";
include "flash_messages.php";

$message = '';
$type = '';
$flash_message = display_flash_message();
if (isset($flash_message)) {
    $message = $flash_message['message'];
    $type = $flash_message['type'];

}


if (file_exists($cookieFile) && filesize($cookieFile) > 0) {

    $url = BASE. '/logs/get/all';

    $ch = curl_init($url);

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores
    // Ejecutar la solicitud cURL
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la conexión cURL
    curl_close($ch);

    // Verificar el código de respuesta HTTP
    if ($httpCode === 200) {
        

    } elseif ($httpCode === 400) {

        
    } else {
        // Otro código de respuesta HTTP
        echo "Se produjo un error inesperado. Código de respuesta HTTP: " . $httpCode;
    }
} else {
    header('Location: /Sistema/index.php?alert=error');
    exit();
}
?>


<?php include("plantilla/header.php") ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Logs</h1>
    <!-- script de alertas -->
    <script src="js/flash_messages.js"></script>
    <div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Logs</h6>
                        <div class="dropdown no-arrow">
                           
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="table-responsive shadow-sm">
                        <table id="tabla_logs" class="crud-table">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Categoria</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                        $response = json_decode($response, true);

                        foreach ($response['success'] as $dato) {
                            $detalle = 'Ninguno';
                            if (isset($dato['detalle'])) {
                                $dato['detalle'];
                            }
                            echo '<tr>';
                            echo'<td>' .$dato['usuario'] .'</td>';
                            echo'<td>' .$dato['categoria'] .'</td>';
                            echo'<td>' .$dato['fecha'] .'</td>';
                            echo'<td>' .$dato['hora'] .'</td>';
                            echo'<td>' .$detalle.'</td>';
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

<div id="eliminar_logs" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmar Eliminación</h4>
                <button type="button" onclick="modal_hide()" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="modal_hide()" data-dismiss="modal">Cancelar</button>
                <a href="eliminarLogs.php" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function () {
    showFlashMessages('<?php echo $message; ?>', '<?php echo $type; ?>');
    });
    
    function modal_hide() {
        $('#eliminar_logs').modal('hide');
        
    }
</script>

<?php include("plantilla/footer.php");?>