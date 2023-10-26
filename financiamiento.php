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
    // URL a la que deseas hacer la solicitud GET
    $url = BASE . '/pagos/financiamiento/get/all';

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
$title = "Conexiones por Financiamiento";
include("plantilla/header.php")
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Conexion con Financiamiento</h1>
    <script src="js/flash_messages.js"></script>
    <div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between shadow-sm">
                        <h6 class="m-0 font-weight-bold text-primary">Conexion con Financiamiento</h6>
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
                                    <th>Entrada </th>
                                    <th>Cuota 1</th>
                                    <th>Cuota 2</th>
                                    <th>Cuota 3</th>
                                    <th>Cuota 4</th>
                                    <th>Cuota 5</th>
                                    <th>Cuota 6</th>
                                    <th>Total a Pagar</th>
                                    <th>Total Pagado</th>
                                    <th>Restante a Pagar</th>
                                    <th>Actualizar</th>
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
                                    $entrada = $registro["entrada"];
                                    $cuota1 = $registro["cuota1"];
                                    $cuota2 = $registro["cuota2"];
                                    $cuota3 = $registro["cuota3"];
                                    $cuota4 = $registro["cuota4"];
                                    $cuota5 = $registro["cuota5"];
                                    $cuota6 = $registro["cuota6"];
                                    $total_pagar = $registro["total_pagar"];
                                    $total_pagado = $registro["total_pagado"];
                                    $restante_pagar = $registro["restante_pagar"];
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
                                    echo'<td>$ ' .$entrada .'</td>';

                                    $formulario_id = 'formulario_' . $id; // Puedes usar el ID del registro como parte del identificador

                                    echo '<form id="' . $formulario_id . '" action="actualizar_cuotas.php" method="post" >';
                                    echo '<td><input class="w-100" type="number" id="cuota1" name="cuota1" value="' . $cuota1 . '"></td>';
                                    echo '<td><input class="w-100" type="number" id="cuota2" name="cuota2" value="' . $cuota2 . '"></td>';
                                    echo '<td><input class="w-100" type="number" id="cuota3" name="cuota3" value="' . $cuota3 . '"></td>';
                                    echo '<td><input class="w-100" type="number" id="cuota4" name="cuota4" value="' . $cuota4 . '"></td>';
                                    echo '<td><input class="w-100" type="number" id="cuota5" name="cuota5" value="' . $cuota5 . '"></td>';
                                    echo '<td><input class="w-100" type="number" id="cuota6" name="cuota6" value="' . $cuota6 . '"></td>';
                                    echo '<input type="hidden" name="id_pago" id="id_pago" value="'. $id .'"><br>';
                                    echo'</form>';
                                    echo'<td>$ ' .$total_pagar .'</td>';
                                    echo'<td>$ ' .$total_pagado .'</td>';
                                    echo'<td>$ ' .$restante_pagar .'</td>';
                                    echo '<td>';
                                    echo '<button title="Actualizar Todas las cuotas" type="button" class="btn btn-warning m-1" onclick="enviarFormulario(\'' . $formulario_id . '\')">';
                                    echo '<i class="fas fa-sync"></i>';
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

<script>
    function enviarFormulario(formulario_id) {
        // Encuentra el formulario por su ID y envíalo
        document.querySelector('#' + formulario_id).submit();
    }

    $(document).ready(function() {
        showFlashMessages('<?php echo $message; ?>', '<?php echo $type; ?>');
    });

    function set_cuotas_in_table(){
        // Fields
        cuotas_fields = [
            'cuota1'
        ];
        // Values
        cuotas_values = [
            $('input[name="cuota1"]'), $('input[name="cuota2"]'), $('input[name="cuota3"]'),
            $('input[name="cuota4"]'), $('input[name="cuota5"]'), $('input[name="cuota6"]')
        ]
        return cuotas_values;
    }

</script>



<?php include("plantilla/footer.php");?>