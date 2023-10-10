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

    $url = BASE. '/admin/get/all';

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
    if ($httpCode !== 200) {
        $message = 'Error al cargar los datos';
        $type = 'error';
    }
} else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>


<?php include("plantilla/header.php") ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Administradores</h1>

<script src="js/flash_messages.js"></script>
    <div>
        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Administradores</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="table-responsive ">
                        <table id="tabla_administradores" class="crud-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Contraseña de un admistrador</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                        $response = json_decode($response, true);

                        foreach ($response['success'] as $dato) {
                            echo '<tr>';
                            echo'<td>' .$dato['id'] .'</td>';
                            echo'<td>' .$dato['username'] .'</td>';
                            echo '<td>';
                            echo '<button title="Nueva contraseña para un administrador" type="button" class="btn btn-warning m-1 open-modal" data-toggle="modal" data-target="#actualizar_contraseña" data-id="' . $dato['id'] . '"onclick="password(this)">';
                            echo '<i class="fas fa-sync"></i>';
                            echo '</button>';
                            echo '</td>';

                            echo '<td>';
                            echo '<button title="Eliminar Cliente" type="button" class="btn btn-danger m-1 open-confirm-modal" data-toggle="modal" data-target="#confirmModal_eliminar" data-id="' . $dato['id'] . '">';
                            echo '<i class="fas fa-trash"></i>';
                            echo '</button>';
                            echo '</td>';

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


<div class="modal fade" id="actualizar_contraseña" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar informacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="actualizar_contraseña.php" id="FormularioE">
                   
                <input type="hidden" name="id_user" value="">

                   <div class="form-floating mb-3">
                        <div >
                            <label >Ingrese la nueva Contraseña</label>
                            <input class="form-control"  name="new_password"  type="text"/>
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


<!-- Registrar Admins -->

<div class="modal fade" id="registrar_administradores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Nuevo Administrador</h5>
                <button type="button" onclick="modal_hide()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="registrarAdmins.php">

                    <div class="form-floating mb-3">
                        <div >
                            <label >Ingrese el nombre del Administrador</label>
                            <input class="form-control" name="username" type="text"/>
                        </div>                                  
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Ingrese la contraseña del administrador</label>
                        <input class="form-control"  type="text" name="password" />
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

<!-- Eliminar Administrador -->
<div class="modal fade" id="confirmModal_eliminar" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
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
                <a href="eliminarAdmins.php" id="confirmDelete" class="btn btn-primary">Sí</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        showFlashMessages('<?php echo $message; ?>', '<?php echo $type; ?>');

            $(".open-confirm-modal").click(function() {
                var id = $(this).data("id");
                $("#confirmDelete").attr("href", "eliminarAdmins.php?id=" + id);
            });
        });


    function modal_hide() {
        $('#registrar_administradores').modal('hide');
        console.log();
    }

    function password(button) {
        // Obtener una referencia al formulario
        var formulario = document.getElementById('FormularioE');

        // Obtener los datos del cliente desde los atributos personalizados del botón
        var id_user = button.getAttribute('data-id');

        // Llena los campos del formulario modal con los datos del cliente
        formulario.id_user.value = id_user;
    }
</script>


<?php include("plantilla/footer.php");?>