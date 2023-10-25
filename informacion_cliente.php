<?php
include "user_session.php";
include "APIurls.php";
include "flash_messsages.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $session_cookie = get_cookied_session();
    if (isset($session_cookie)) {
        // URL de la API que deseas consultar
        $url = BASE . "/clientes/get/" . $id;

        // Inicializa cURL
        $ch = curl_init($url);

        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
        curl_setopt($ch, CURLOPT_HTTPGET, true); // Configura la solicitud como tipo GET
        curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

        // Realiza la solicitud y guarda la respuesta en una variable
        $response = curl_exec($ch);

        // Cierra la conexión cURL
        curl_close($ch);

        // La variable $response contiene la respuesta de la API
        $clienteDatos = json_decode($response, true);

        // Verifica si la respuesta contiene datos válidos
        if ($clienteDatos && isset($clienteDatos['success'])) {
            $cliente = $clienteDatos['success'];

            // Ahora accedes a los datos del cliente
            $cedula = $cliente['cedula'];
            $nombres = $cliente['nombres'];
            $apellidos = $cliente['apellidos'];
            $telefono = $cliente['telefono'];
        } else {
            create_flash_message(
                'No se pudo obtener la información del cliente',
                'error'
            );
        }
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
} else {
    header("Location: $base_request/principal.php");
    exit();
}
?>

<?php
$title = 'Información cliente';
include("plantilla/header.php");
?>

<div class="col-12 text-center">

<!-- Project Card Example -->
<div class="card shadow m-3">
    <div class="card-header ">
        <h6 class="m-0 font-weight-bold text-primary">Informacion</h6>
    </div>
    <div class="card-body">

        <h4 class="small font-weight-bold">Cedula <span class="float-right"></span></h4>
        <div class="m-1">
        <?php echo $cedula ?>
        </div>

        <h4 class="small font-weight-bold">Nombres <span class="float-right"></span></h4>
        <div class="m-1">
        <?php echo $nombres ?>
        </div>

        <h4 class="small font-weight-bold">Apellidos <span class="float-right"></span></h4>
        <div >
        <?php echo $apellidos ?>
        </div>

        <h4 class="small font-weight-bold">Telefono <span class="float-right"></span></h4>
        <div >
        <?php echo $telefono ?>
        </div>


    </div>
</div>

<!-- Color System -->

</div>



<?php include("plantilla/footer.php");?>
