<?php
include "user_session.php";
include "APIurls.php";
?>


<?php

if ($_GET) {
    $id_planilla=$_GET['id'];
}

$session_cookie = get_cookied_session();
if (isset($session_cookie)) {
// URL a la que deseas hacer la solicitud GET
$url = BASE. '/planillas/get/' . $id_planilla ;

// Inicializa una nueva sesión CURL
$ch = curl_init($url);

// Establece las opciones para la sesión CURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena en lugar de imprimirla
curl_setopt($ch, CURLOPT_HTTPGET, true); // Utiliza el método GET
curl_setopt($ch, CURLOPT_COOKIE, "session=$session_cookie");

// Ejecuta la solicitud CURL y obtén la respuesta
$response = curl_exec($ch);

curl_close($ch);

// Decodifica la respuesta JSON en un objeto PHP
$response = json_decode($response, true);

if ($response && isset($response['success'])) {
    $servicio = $response['success'];
}

 // Ahora puedes acceder a los datos de estadisticas
 $id_planilla = $servicio['id'];

 if ($servicio && isset($servicio['servicio'])) {
     $datos_servicio= $servicio['servicio'];

     // Ahora puedes acceder a los datos de estadisticas
     $id_servicio = $datos_servicio['id'];
     $n_conexion = $datos_servicio['n_conexion'];
     $n_medidor = $datos_servicio['n_medidor'];
     $id_cliente = $datos_servicio['id_cliente'];
     $direccion = $datos_servicio['direccion'];
     $lectura_anterior = $datos_servicio['lectura_anterior'];
 }


 if (isset($servicio['cliente'])) {
     $datos_cliente = $servicio['cliente'];

     // Accede a las propiedades del cliente solo si existen
     $cedula = $datos_cliente['cedula'];
     $nombres = $datos_cliente['nombres'] ;
     $apellidos = $datos_cliente['apellidos'] ;
     $telefono = $datos_cliente['telefono'] ;
     // Continúa de esta manera para otras propiedades del cliente
 }
 if (isset($servicio['fecha_emision'])) {

     $fechaEmision = $servicio['fecha_emision'];
     $consumo_base = $servicio['consumo_base'];
     $exedente = $servicio['exedente'];
     $valor_consumo_base = $servicio['valor_consumo_base'];
     $valor_exedente = $servicio['valor_exedente'];
     $lectura_anterior = $servicio['lectura_anterior'];
     $lectura_actual = $servicio['lectura_actual'];
     $consumo_total = $servicio['consumo_total'];
     $valor_consumo_total = $servicio['valor_consumo_total'];
 }


$fecha_array = explode("/", $fechaEmision);

if (count($fecha_array) === 3) {
    $mes_numero = $fecha_array[1];
    $nombres_meses = [
        1 => " Enero",
        2 => " Febrero",
        3 => " Marzo",
        4 => " Abril",
        5 => " Mayo",
        6 => " Junio",
        7 => " Julio",
        8 => " Agosto",
        9 => " Septiembre",
        10 => " Octubre",
        11 => " Noviembre",
        12 => " Diciembre"
    ];
    $nombre_mes = $nombres_meses[intval($mes_numero)];
}

}else {
    header("Location: $base_request/index.php?alert=error");
    exit();
}
?>



<?php
$title = "Resumen Planilla";
include("plantilla/header.php");
?>

<div class="row pl-5 pt-4">
    <button type="button" class=" col-1 btn btn-danger" onclick="imprimirPlanilla()">PDF</button>
</div>

<div class="col-12" id="planilla_imprimir" >
    <!-- Project Card Example -->
    <div class="card shadow m-3" >
        <div class="card-header row m-0 ">
            <div class="text-left col-6">
            <h6 class="m-0 font-weight-bold text-info">Ministerio del Ambiente</h6>
            <h6 class="m-0 font-weight-bold text-info">Agua y Tansicion Ecologica</h6>
            </div>
            <div class="text-center col-6">
            <h6 class="m-0 font-weight-bold text-info">Junta Administrativa de Agua Potable "La Chongona"</h6>
            <h6 class="m-0 font-weight-bold text-info">FACTURA DE COBRO POR SERVICIOS</h6>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h4 class="small font-weight-bold m-3">Nombre del Usuario : <?php echo $nombres; ?> </h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold m-3">Consumo del Mes de : <?php echo $nombre_mes; ?> </h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold m-3">Fecha de Emision :  <?php echo $fechaEmision; ?> </h4>
                <div class="m-1"></div>
            </div>
            <div class="col-6">
                <h4 class="small font-weight-bold m-3">Conexion Nª : <?php echo $n_conexion; ?></h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold m-3">Numero de Medidor : <?php echo $n_medidor; ?></h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold m-3">Direccion :  <?php echo $direccion; ?></h4>
                <div class="m-1"></div>
            </div>
        </div>

        <div class="row pt-3">
            <div class="text-left col-4 ">
                <h4 class="small font-weight-bold m-3">Lectura actual: <?php echo $lectura_actual; ?></h4>
            </div>
            <div class="text-center col-4 ">
                <h4 class="small font-weight-bold m-3">Lectura_anterior: <?php echo $lectura_anterior; ?></h4>
            </div>
            <div class="text-rigth col-4 ">
                <h4 class="small font-weight-bold text-right m-3">Consumo M³: <?php echo $consumo_total; ?> </h4>
            </div>
        </div>

    </div>
        <div class="card shadow m-3 border-info">
            <div class="card-header row m-0 pb-1 border-bottom-info">
        <div class="row col-10">
            <div class="text-left col-6">
                <h6 class="m-0 font-weight-bold text-info pl-0 text-center">CONCEPTOS</h6>
            </div>
            <div class="text-right col-6">
                <h6 class="mr-0 font-weight-bold text-info pr-0">VALORES</h6>
            </div>
        </div>
    </div>

    <div class="card-body pt-1">
        <div class="row">
            <div class="col-6">
                <h4 class="small font-weight-bold">Por tarifas : <span class="float-right"></span></h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold">Por Exedentes :  <span class="float-right"></span></h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold">TOTAL :  <span class="float-right"></span></h4>
                <div class="m-1"></div>
            </div>
            <div class="col-6 border-left-info">
                <h4 class="small font-weight-bold"><?php echo $valor_consumo_base; ?></h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold"><?php echo $valor_exedente; ?></h4>
                <div class="m-1"></div>
                <h4 class="small font-weight-bold"><?php echo $valor_consumo_total; ?></h4>
                <div class="m-1"></div>
            </div>
        </div>
    </div>
</div>

<div class="print-content">
    <div class="d-flex">
        <p><b>Impreso el: </b></p>
        <p id="fecha-emision-planilla"></p>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <div>
            <div class="signer-space"></div>
            <div class="text-center">
                <p><b>Firma. Presidente de Junta de Agua</b></p>
            </div>
        </div>
    </div>
</div>

<script>
    function imprimirPlanilla() {
        var d = new Date();
        var strDate = (d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate() +
            " a las " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2));
        $('#fecha-emision-planilla').text(strDate);
        printJS({
            printable:"planilla_imprimir",
            type:"html",
            css:["css/sb-admin-2.css","css2/stilos.css"],
        })
    }
</script>


<?php include("plantilla/footer.php");?>