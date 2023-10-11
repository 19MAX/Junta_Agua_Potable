<?php
include "APIurls.php";

if ($_GET) {
    $id = $_GET['id'];
    if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
        // URL de la API que deseas consultar
        $url = BASE . "/clientes/get/" . $id;

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
            echo '<p>Error: No se pudo obtener la información del cliente.</p>';
        }
    } else {
        header("Location: $base_request/index.php?alert=error");
        exit();
    }
}
?>

<?php include("plantilla/header.php"); ?>

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
