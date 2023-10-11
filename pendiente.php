<?php include("APIurls.php");?>

<?php 
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
// URL a la que deseas hacer la solicitud GET
$url = BASE. '/general/get/planillas/pendientes'  ;

// Inicializa una nueva sesión CURL
$ch = curl_init($url);

// Establece las opciones para la sesión CURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena en lugar de imprimirla
curl_setopt($ch, CURLOPT_HTTPGET, true); // Utiliza el método GET
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

// Ejecuta la solicitud CURL y obtén la respuesta
$response = curl_exec($ch);

// Verifica si hubo algún error
if (curl_errno($ch)) {
    echo 'Error en la solicitud CURL: ' . curl_error($ch);
}

curl_close($ch);

$response = json_decode($response, true);
} else {
    
    header('Location: /Sistema/index.php?alert=error');
    exit();
}


?>

<?php include("plantilla/header.php"); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Planillas Pendientes</h1>
    <ol class="breadcrumb mb-4 shadow-sm">
        <li class="breadcrumb-item "><a href="principal.php">Regresar</a></li>
    </ol>

    <div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between shadow-sm">
                        <h6 class="m-0 font-weight-bold text-primary">Planillas Pendientes</h6>
                        <div class="dropdown no-arrow">
                           
                            
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="table-responsive shadow-sm">
                        <table id="tabla_pendientes" class="crud-table">
                            <thead>
                                <tr>
                                    <th class="exclude">Ver Planila</th>
                                    <th>Cedula</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Fecha Emision</th>
                                    <th>Consumo Base</th>
                                    <th>Exedente</th>
                                    <th>Valor Consumo Base</th>
                                    <th>Valor Exedente</th>
                                    <th>Lectura Anterior</th>
                                    <th>Lectura Actual</th>
                                    <th>Consumo Total</th>
                                    <th>Valor Consumo Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                        

                            foreach ($response['success'] as $primerElemento) {
                                

                                // Accede a los valores dentro del primer elemento
                                $id = $primerElemento['id'];
                                
                                // Información del servicio dentro del primer elemento
                                $servicio = $primerElemento['servicio'];

                                $id_servicio = $servicio['id'];
                                $n_conexion = $servicio['n_conexion'];
                                $n_medidor = $servicio['n_medidor'];
                                $id_cliente_servicio = $servicio['id_cliente'];
                                $direccion = $servicio['direccion'];
                                $estado_servicio = $servicio['estado'];
                                $lectura_anterior = $servicio['lectura_anterior'];
                                // Información del cliente dentro del primer elemento
                                $cliente = $primerElemento['cliente'];

                                $id_de_cliente = $cliente['id'];
                                $cedula = $cliente['cedula'];
                                $nombres = $cliente['nombres'];
                                $apellidos = $cliente['apellidos'];
                                $telefono = $cliente['telefono'];
                                // Informacion dentro del primer elemento
                                $fecha_emision = $primerElemento['fecha_emision'];
                                $pagado = $primerElemento['pagado'];
                                $consumo_base = $primerElemento['consumo_base'];
                                $exedente = $primerElemento['exedente'];
                                $valor_consumo_base = $primerElemento['valor_consumo_base'];
                                $valor_exedente = $primerElemento['valor_exedente'];
                                $lectura_anterior = $primerElemento['lectura_anterior'];
                                $lectura_actual = $primerElemento['lectura_actual'];
                                $consumo_total = $primerElemento['consumo_total'];
                                $valor_consumo_total = $primerElemento['valor_consumo_total'];


                                echo '<tr>';


                                echo '<td>';
                                echo'<a href="planillas.php?id=' . $id_servicio . '">';
                                echo '<button title="Planilla Pendiente" type="button" class="btn btn-danger m-1">';
                                echo '<i class="fas fa-tasks"></i>';
                                echo '</button>';
                                echo '</a>';
                                echo '</td>';


                                echo '<td>' . $cedula . '</td>';
                                echo '<td>' . $nombres . '</td>';
                                echo '<td>' . $apellidos . '</td>';
                                echo '<td>' . $fecha_emision . '</td>';
                                echo '<td>' . $consumo_base . '</td>';
                                echo '<td>' . $exedente . '</td>';
                                echo '<td>' . $valor_consumo_base . '</td>';
                                echo '<td>' . $valor_exedente . '</td>';
                                echo '<td>' . $lectura_anterior . '</td>';
                                echo '<td>' . $lectura_actual . '</td>';
                                echo '<td>' . $consumo_total . '</td>';
                                echo '<td>' . $valor_consumo_total . '</td>';
                               

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