<?php
include("obtenerEstadisticas.php");

include "flash_messages.php";

$message = '';
$type = '';
$flash_message = display_flash_message();
if (isset($flash_message)) {
    $message = $flash_message['message'];
    $type = $flash_message['type'];
}

// Verifica si el archivo de cookies existe y no está vacío
if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    $url = BASE . "/clientes/get/all";

    // Inicializa cURL
    $ch = curl_init($url);

    // Configura las opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Configura la solicitud como tipo GET
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Realiza la solicitud y guarda la respuesta en una variable
    $response = curl_exec($ch);

    // Cierra la conexión cURL
    curl_close($ch);


    // Obtén el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Procesa la respuesta según el código de respuesta
    if ($httpCode !== 200) {
        // Respuesta con error
        $responseData = json_decode($response);
        if (isset($responseData->error)) {
            $message = $responseData->error;
        } else {
            $message = "Error al cargar los datos";
        }
        $type = 'error';
    }

} else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>

<?php include("plantilla/header.php"); ?>
<div class="container-fluid px-4">
<script src="js/flash_messages.js"></script>
    <h3 class="mt-4">Junta Administradora de Agua Potable</h3>
    <ol class="breadcrumb mb-4 shadow-sm">
        <li class="breadcrumb-item active">Estadisticas</li>
    </ol>
    <div class="row">
                            <!-- Earnings (Monthly) Card Example -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card shadow-sm  border-left-primary py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters  align-items-center">
                                                <div class="col ">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Clientes</div>
                                                    <div class="h5 font-weight-bold text-gray-800"> <?php echo $clientesN;
                                                     ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Earnings (Monthly) Card Example -->
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-success shadow-sm  h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Servicios</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $serviciosN; ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pending Requests Card Example -->
                                <div class="col-xl-4 col-md-12 mb-4" >
                                    <div class="card border-left-warning shadow-sm  h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Planillas Pendientes</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $notificaciones; ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-bell fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
    <div class="row">
        <!-- Contenedor de tablas -->
        <div class="col-12">
            <div class="card shadow">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between shadow-sm">
                    <h6 class="m-0 font-weight-bold text-primary">Clientes </h6>

                </div>
                
                <div class="table-responsive crud-table shadow-sm">
                    <table id="tabla_clientes">
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Teléfono</th>
                                <th class="exclude">Eliminar</th>
                                <th class="exclude">Informacion</th>
                                <th class="exclude">Actualizar</th>
                                <th class="exclude">Servicios</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $info_clientes = json_decode($response, true);

                        foreach ($info_clientes['success'] as $dato) {
                            echo '<tr>';
                            echo'<td>' .$dato['cedula'] .'</td>';
                            echo'<td>' .$dato['nombres'] .'</td>';
                            echo'<td>' .$dato['apellidos'] .'</td>';
                            echo'<td>' .$dato['telefono'] .'</td>';

                            echo '<td>';
                            echo '<button title="Eliminar Cliente" type="button" class="btn btn-danger m-1 open-confirm-modal" data-toggle="modal" data-target="#confirmModal" data-id="' . $dato['id'] . '">';
                            echo '<i class="fas fa-trash"></i>';
                            echo '</button>';
                            echo '</td>';



                            echo '<td>';
                            echo '<a href="informacion_cliente.php?id=' . $dato['id'] . '">';
                            echo '<button title="Informacion del cliente" type="button" class="btn btn-primary m-1">';
                            echo '<i class="fas fa-info-circle"></i>';
                            echo '</button>';
                            echo '</a>';
                            echo '</td>';

                            echo '<td>';
                            echo '<button title="Actualizar cliente" type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#actualizar" data-id="' . $dato['id'] . '" data-cedula="' . $dato['cedula'] . '" data-nombres="' . $dato['nombres'] . '" data-apellidos="' . $dato['apellidos'] . '" data-telefono="' . $dato['telefono'] . '" onclick="datos(this)">';
                            echo '<i class="fas fa-sync"></i>';
                            echo '</button>';
                            echo '</td>';
 
                            echo '<td>';
                            echo '<a href="servicios.php?id=' . $dato['id'] . '&nombre=' . $dato['nombres'] . '">';
                            echo '<button title="Servicios del cliente" type="button" class="btn btn-danger m-1">';
                            echo '<i class="fas fa-clipboard-list"></i>';
                            echo '</button>';
                            echo '</a>';
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



<div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Nuevo Cliente</h5>
                <button type="button" onclick="modal_hide()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="registrarUser.php">

                    <div class="form-floating mb-3">
                        <div >
                            <label >Cédula</label>
                            <input class="form-control" name="cedula" type="text"/>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Nombres</label>
                        <input class="form-control"  type="text" name="nombres" />
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <div>
                        <label >Apellidos</label>
                        <input class="form-control"  type="text" name="apellidos" />
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Teléfono</label>
                        <input class="form-control"  type="text" name="telefono" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="modal_hide()" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar informacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="actualizardatos.php" id="FormularioA">
                    
                    <input type="hidden" name="cliente_id" value="">
                    <div class="form-floating mb-3">
                        <div >
                            <label >Cédula</label>
                            <input class="form-control"  name="cedula"  type="text"/>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Nombres</label>
                        <input class="form-control"  name="nombres" type="text" />
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Apellidos</label>
                        <input class="form-control"  type="text" name="apellidos" />
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Telefono</label>
                        <input class="form-control"  type="text" name="telefono" />
                        </div>
                    </div>
                        
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" >Actualizar</button>
                    </div>

                </form>

                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este cliente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <a href="eliminar_cliente.php" id="confirmDelete" class="btn btn-primary">Sí</a>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        showFlashMessages('<?php echo $message; ?>', '<?php echo $type; ?>');
        
        $(".open-confirm-modal").click(function() {
            var id = $(this).data("id");
            $("#confirmDelete").attr("href", "eliminar_cliente.php?id=" + id);
        });
    });
    
    function modal_hide() {
        $('#registrar').modal('hide');
        console.log();
    }

    function datos(button) {
        // Obtener una referencia al formulario
        var formulario = document.getElementById('FormularioA');

        // Obtener los datos del cliente desde los atributos personalizados del botón
        var id = button.getAttribute('data-id');
        var cedula = button.getAttribute('data-cedula');
        var nombres = button.getAttribute('data-nombres');
        var apellidos = button.getAttribute('data-apellidos');
        var telefono = button.getAttribute('data-telefono');

        // Llena los campos del formulario modal con los datos del cliente
        formulario.cliente_id.value = id;
        formulario.cedula.value = cedula;
        formulario.nombres.value = nombres;
        formulario.apellidos.value = apellidos;
        formulario.telefono.value = telefono;
    }

</script>



<?php include("plantilla/footer.php");?>
