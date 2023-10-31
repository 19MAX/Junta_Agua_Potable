<?php
include "user_session.php";
include "APIurls.php";
include "flash_messages.php";

$message = '';
$type = '';
$flash_message = display_flash_message();
if (isset($flash_message)) {
    $message = $flash_message['message'];
    $type = $flash_message['type'];
}

$session_cookie = get_cookied_session();
if (isset($session_cookie)) {
    $id_servicio = $_GET['id_servicio'];

    // URL a la que deseas hacer la solicitud GET
    $url = BASE . '/notificaciones/get/'.$id_servicio;

    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devolver la respuesta como una cadena en lugar de imprimir directamente
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Usar el método GET
    curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

    // Realizar la solicitud cURL
    $response = json_decode(curl_exec($ch), true);

    // Verificar el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la sesión cURL
    curl_close($ch);

    if ($httpCode !== 200) {
        create_flash_message(
            $response['error'],
            'error'
        );
    }
} else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>

<?php
$title = "Notificaciones de servicio";
include "plantilla/header.php";
?>

<script src="js/flash_messages.js"></script>
<div class="container-fluid px-4">
    <h1 class="mt-4">Notificaciones por retraso de pago</h1>

    <!-- Table -->
    <div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between shadow-sm">
                        <h6 class="m-0 font-weight-bold text-primary">Mis Notificaciones</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="table-responsive shadow-sm">
                        <table id="tabla_notificaciones" class="crud-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>N conexion</th>
                                    <th>N medidor</th>
                                    <th>Cedula</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Telefono</th>
                                    <th>Fecha emision</th>
                                    <th>Hora emision</th>
                                    <th>Estado</th>
                                    <th>Total</th>
                                    <th class='exclude'>Actualizar pago</th>
                                    <th class='exclude'>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($response["success"] as $key => $registro) {
                                    $id = $registro['id'];
                                    $servicio = $registro["servicio"];
                                    $cliente = $registro["cliente"];
                                    $fecha_emision = $registro["fecha_emision"];
                                    $hora_emision = $registro["fecha_emision"];
                                    $total = $registro["total"];
                                    $pagado = $registro['pagado'];
                                    // Accede a los datos dentro de "servicio"
                                    $id_servicio = $servicio['id'];
                                    $n_conexion = $servicio["n_conexion"];
                                    $n_medidor = $servicio["n_medidor"];
                                    // Accede a los datos dentro de "cliente"
                                    $cedula = $cliente["cedula"];
                                    $nombres = $cliente["nombres"];
                                    $apellidos = $cliente["apellidos"];
                                    $telefono = $cliente["telefono"];

                                    if (!$pagado){
                                        echo '<tr class="bg-pago-alert">';
                                    } else {
                                        echo '<tr>';
                                    }
                                    echo'<td>' .($key + 1).'</td>';
                                    echo'<td>' .$n_conexion .'</td>';
                                    echo'<td>' .$n_medidor .'</td>';
                                    echo'<td>' .$cedula .'</td>';
                                    echo'<td>' .$nombres .'</td>';
                                    echo'<td>' .$apellidos .'</td>';
                                    echo'<td>' .$telefono .'</td>';
                                    echo'<td>' .$fecha_emision .'</td>';
                                    echo'<td>' .$hora_emision .'</td>';
                                    echo '<td class="fw-bold ';
                                    if ($pagado){
                                        echo 'text-success">Pagado</td>';
                                    } else {
                                        echo '">Pendiente</td>';
                                    }
                                    echo'<td>$ ' .$total .'</td>';
                                    echo '<td>';
                                    echo '<button title="Eliminar" type="button" class="btn btn-warning m-1" onclick="enviarFormulario(\'' . $formulario_id . '\')">';
                                    echo '<i class="fas fa-sync"></i>';
                                    echo '</button>';
                                    echo '</td>';

                                    echo '<td>';
                                    echo '<button title="Eliminar" type="button" class="btn btn-danger m-1 open-confirm-modal" data-toggle="modal" data-target="#confirmModal" data-id-notificacion="' . $id . '" data-id-servicio"' . $id_servicio . '">';
                                    echo '<i class="fas fa-trash"></i>';
                                    echo '</button>';
                                    echo '</td>';

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

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta notificacion?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminacion">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<?php
include "plantilla/footer.php"
?>