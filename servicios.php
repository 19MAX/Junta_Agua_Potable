<?php
include("APIurls.php");
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

    if ($_GET) {
        $id_de_cliente = $_GET['id'];
        $nombre =$_GET['nombre'];
        // $info_clientes = json_decode($_GET['info_clientes'], true);
    }

    // URL de la API que deseas consultar
    $url = BASE . "/servicios/get/all/" . $id_de_cliente;

    // Inicializa cURL
    $ch = curl_init($url);

    // Configura las opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Configura la solicitud como tipo GET
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Realiza la solicitud y guarda la respuesta en una variable
    $response = curl_exec($ch);
    $response = json_decode($response, true);

    // Verifica si hubo algún error en la solicitud
    if (curl_errno($ch)) {
        echo 'Error en la solicitud cURL: ' . curl_error($ch);
    }

    // Cierra la conexión cURL
    curl_close($ch);

    // La variable $response contiene la respuesta de la API
    $url_clientes = BASE . "/clientes/get/all";

    // Inicializa cURL
    $ch = curl_init($url_clientes);

    // Configura las opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Configura la solicitud como tipo GET
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Lee las cookies desde el archivo en solicitudes posteriores

    // Realiza la solicitud y guarda la respuesta en una variable
    $info_clientes = curl_exec($ch);
    $info_clientes = json_decode($info_clientes, true);

    // Verifica si hubo algún error en la solicitud
    if (curl_errno($ch)) {
        echo 'Error en la solicitud cURL: ' . curl_error($ch);
    }

    // Cierra la conexión cURL
    curl_close($ch);
    // Puedes procesar la respuesta aquí
} else {
    // El archivo de cookies no existe o está vacío, realiza la acción que desees en este caso
    // Por ejemplo, puedes redirigir a la página de inicio de sesión o mostrar un mensaje de error.
    
    header('Location: /Sistema/index.php?alert=error');
    exit();
}
?>

<?php include("plantilla/header.php");?>
<!-- Begin Page Content -->
<div class="container-fluid mt-4">
    <!-- script de alertas -->
    <script src="js/flash_messages.js"></script>
    <!-- Content Row -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between shadow-sm">
                    <h6 class="m-0 font-weight-bold text-primary ">
                    Servicios del Cliente : <p class=" text-dark" ><?php echo $nombre; ?></p> 
                    
                    </h6>
                    
                </div>
                <!-- Card Body -->
                <div class="table-responsive shadow-sm">
                    
                    <table id="tabla_servicios" class="crud-table" >
                        <thead>
                            <tr>
                                <th>Id_Servicio</th>
                                <th>N_conexion</th>
                                <th>N_medidor</th>
                                <th>ID_Cliente</th>
                                <th>Direccion</th>
                                <th>Lectura Anterior Medidor</th>
                                <th>Conexion con Financiamiento</th>
                                <th class="exclude">Estado de Servicio</th>
                                <th class="exclude">Editar Servicio</th>
                                <th class="exclude">Eliminar Servicio</th>
                                <th class="exclude">Cambiar al cliente que le pertenece el servico</th>
                                <th class="exclude">Planillas</th>
                                
                                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        
                        foreach ($response['success'] as $dato) {
                            echo '<tr>';
                            echo'<td>' .$dato['id'] .'</td>';
                            echo'<td>' .$dato['n_conexion'] .'</td>';
                            echo'<td>' .$dato['n_medidor'] .'</td>';
                            echo'<td>' .$dato['id_cliente'] .'</td>';
                            echo'<td>' .$dato['direccion'] .'</td>';

                            echo'<td>' .$dato['lectura_anterior'] .'</td>';
                            
                            
                            echo '<td>' . ($dato['financiamiento_conexion'] ? "Sí" : "No") . '</td>';

                            echo '<td>';
                            echo '<a href="procesar_estado.php?id_cliente=' . $dato['id_cliente'] . '&id=' . $dato['id'] . '&estado=' . ($dato['estado'] ? '0' : '1') . '&nombre=' . $nombre . '" class="btn btn-' . ($dato['estado'] ? 'success' : 'danger') . ' m-1" title="' . ($dato['estado'] ? 'Activado' : 'Desactivado') . '">';
                            echo '<i class="fa ' . ($dato['estado'] ? 'fa-check-circle' : 'fa-times-circle') . '"></i>'; 
                            echo '</a>';
                            echo '</td>';






                            echo '<td>';
                            echo '<button title="Editar Servicio" type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#editar" data-id_servicio="' . $dato['id'] . '"  data-id_cliente="' . $id_de_cliente . '"  data-n_conexion="' . $dato['n_conexion'] . '" data-n_medidor="' . $dato['n_medidor'] . '" data-direccion="' . $dato['direccion'] . '" onclick="datos(this)">';
                            echo '<i class="fas fa-edit"></i>';
                            echo '</button>';
                            echo '</td>';


                            echo '<td>';
                            echo '<button title="Eliminar Servicio" type="button" class="btn btn-danger m-1 open-confirm-modal" data-toggle="modal" data-target="#confirmModal" data-id-servicio="' . $dato['id'] . '" data-id-cliente="' . $id_de_cliente . '" data-nombre-cliente="' . $nombre . '">';
                            echo '<i class="fas fa-trash"></i>';
                            echo '</button>';
                            echo '</td>';




                            // <!-- Botón para abrir el modal de Cambiar a que cliente le pertenece el servicio -->
                            echo '<td>';
                            echo '<button title="Cambiar el Servicio a un cliente nuevo" type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#cambiarClienteModal" onclick="cambiarUser(this)" data-id_servicio="' . $dato['id'] . '">';
                            echo '<i class="fas fa-exchange-alt"></i>';
                            echo '</button>';
                            echo '</td>';




                            echo '<td>';
                            echo '<a href="planillas.php?id=' . $dato['id'] . '">';
                            echo '<button title="Planillas del cliente " type="button" class="btn btn-danger m-1">';
                            echo '<i class="fas fa-table"></i>';
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



<div class="modal fade" id="registrar_servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Nuevo Servicio</h5>
                <button type="button" class="close" onclick="modal_hide()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="registrarServicio.php">
                    <input type="hidden" name="id_cliente" value="<?php echo $id_de_cliente; ?>">
                    <input type="hidden" name="nombre" value="<?php echo $nombre; ?>">
                    <div class="form-floating mb-3">
                        <div>
                            <label>N_conexion</label>
                            <input class="form-control" name="n_conexion" type="number" />
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <div>
                            <label>N_medidor</label>
                            <input class="form-control" type="number" name="n_medidor" />
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <div>
                            <label>Direccion</label>
                            <input class="form-control" type="text" name="direccion" />
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <div>
                            <label>Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="1">Activado</option>
                                <option value="0">Desactivado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <div>
                            <label>Lectura_anterior</label>
                            <input class="form-control" type="number" name="lectura_anterior" />
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="contado_conexion" name="contado_conexion_bool" value="true" onclick="disableFinanciamiento()">
                        <label class="form-check-label" for="contado_conexion">Conexion al contado ($250)</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="financiamiento_conexion" name="financiamiento_conexion_bool" value="true" onclick="disableContado()">
                        <label class="form-check-label" for="financiamiento_conexion">Conexion con Financiamiento ($150)</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="modal_hide()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar Servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="editar_servicios.php" id="FormularioB">

                

                <input type="hidden" name="nombre" value="<?php echo $nombre; ?>">
                    
                <input type="hidden" name="id_de_cliente" value="<?php echo $id_de_cliente; ?>">

                <input type="hidden" name="id_servicio" value="">


                    <div class="form-floating mb-3">
                        <div >
                            <label >N_Conexion</label>
                            <input class="form-control"  name="n_conexion"  type="number"/>
                        </div>                                  
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >N_Medidor</label>
                        <input class="form-control"  name="n_medidor" type="number" />
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Direccion</label>
                        <input class="form-control"  type="text" name="direccion" />
                        </div>
                    </div>

                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" >Guardar Cambios</button>
                    </div>

                </form>

                
            </div>
        </div>
    </div>
</div>




<!-- Modal  de Cambiar a que cliente le pertenece el servicio -->

<div class="modal fade" id="cambiarClienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cambiar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="GET" action="cambiar_cliente.php" id="cambiar_cliente" >
                
                        <input type="hidden" name="nombre" value="<?php echo $nombre; ?>" >

                        <input type="hidden" name="id_principal" value="<?php echo $id_de_cliente; ?>" >

                        <input type="hidden" name="id_servicio" value="">

                        <div class="form-group mb-3">
                            <label >Ingrese al Cliente para el Cambio de Servicio</label>
                            <select class="form-control" id="id_cliente_select" name="id_cliente" style="width:100%;">
                                <?php
                                foreach ($info_clientes['success'] as $cliente) {
                                    
                                        echo '<option value="' . $cliente['id'] . '">' . $cliente['nombres'] ." : " . $cliente['cedula'] .'</option>';
                                }
                                    
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Cambiar de cliente</button>
                        </div>
                        
                    </form>
                </div>
        </div>
    </div>
</div>



<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar el servicio <span id="servicioId"></span> para el cliente <span id="clienteNombre"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminacion">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function disableFinanciamiento() {
        document.getElementById("financiamiento_conexion").disabled = document.getElementById("contado_conexion").checked;
    }

    function disableContado() {
        document.getElementById("contado_conexion").disabled = document.getElementById("financiamiento_conexion").checked;
    }

    function modal_hide() {
        // Agrega aquí la lógica para ocultar el modal si es necesario.
    }



    $(document).ready(function () {

    showFlashMessages('<?php echo $message; ?>', '<?php echo $type; ?>');

    $('.open-confirm-modal').click(function () {
        var idServicio = $(this).data('id-servicio');
        var idCliente = $(this).data('id-cliente');
        var nombreCliente = $(this).data('nombre-cliente');

        // Actualizar el contenido del modal de confirmación con los datos relevantes
        $('#servicioId').text(idServicio);
        $('#clienteNombre').text(nombreCliente);

        // Asignar una función al botón "Confirmar" del modal
        $('#confirmarEliminacion').off('click').on('click', function () {
            // Construir la URL de redirección con los parámetros necesarios
            var redirectUrl = 'eliminar_servicio.php?id_servicio=' + idServicio +
                '&id_de_cliente=' + idCliente +
                '&nombre=' + nombreCliente;

            // Redirigir al usuario a la página deseada
            window.location.href = redirectUrl;
            });
        });
    });


    function cambiarUser(button) {
        // Obtener una referencia al formulario
        var formulario = document.getElementById('cambiar_cliente');

        // Obtener el ID del servicio desde el atributo personalizado del botón
        var idServicio = button.getAttribute('data-id_servicio');

        // Llena un campo del formulario con el ID del servicio
        formulario.id_servicio.value = idServicio;

    }

    $(document).ready(function () {
        $('#id_cliente_select').select2({
            dropdownParent: $('#cambiarClienteModal')
        });
        
    });

    function modal_hide() {
        $('#registrar_servicio').modal('hide');
        
    }

    function datos(button) {
    // Obtener una referencia al formulario
    var formulario = document.getElementById('FormularioB');

    // Obtener los datos del cliente desde los atributos personalizados del botón
    
    var id_servicio = button.getAttribute('data-id_servicio');
    var id_de_cliente = button.getAttribute('data-id_cliente');
    var n_conexion = button.getAttribute('data-n_conexion');
    var n_medidor = button.getAttribute('data-n_medidor');
    var direccion = button.getAttribute('data-direccion');
    // Llena los campos del formulario con los datos del cliente
    formulario.id_servicio.value = id_servicio;
    formulario.id_de_cliente.value = id_de_cliente;
    formulario.n_conexion.value = n_conexion;
    formulario.n_medidor.value = n_medidor;
    formulario.direccion.value = direccion;
    }

</script>

<?php include("plantilla/footer.php");?>