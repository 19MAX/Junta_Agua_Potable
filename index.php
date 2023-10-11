<?php include("APIurls.php");

if (file_exists($cookieFile) && filesize($cookieFile) > 0) {
    header("Location: $base_request/principal.php");
}
// Recupera el valor del parámetro "alert" de la URL
$alertType = isset($_GET['alert']) ? $_GET['alert'] : '';

// Define un array asociativo que mapea tipos de alerta a clases de Bootstrap
$alertClasses = array(
    'success' => 'alert-success',
    'error' => 'alert-danger',
    'warning' => 'alert-warning',
);

// Verifica si el tipo de alerta existe en el array
if (array_key_exists($alertType, $alertClasses)) {
    // Muestra la alerta si el tipo de alerta es válido
    echo '<div class="alert ' . $alertClasses[$alertType] . ' alert-dismissible fade show" role="alert">';
    echo 'Usted Cerro Sesion ';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
}


// URL de la API METODO POST
$url = BASE . "/auth/sign_in";

//Almaceno por metodo POST
if ($_POST) {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Datos en formato JSON que voy a enviar a la solicitud
    $data = array(
    "username" => $usuario,
    "password" => $clave
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    // Configuración para seguir redirecciones
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Agregar encabezados si es necesario (por ejemplo, encabezado JSON)
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

    $response = curl_exec($ch);
    // Cerrar la sesión cURL
    curl_close($ch);

    // Obtener el código de respuesta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // Verificar si la solicitud fue exitosa (por ejemplo, si el código de respuesta es 200)
    if ($httpCode === 200) {
        $cookieInfo = curl_getinfo($ch, CURLINFO_COOKIELIST);
        file_put_contents($cookieFile, $cookieInfo[0], FILE_APPEND);

        header("Location: $base_request/principal.php");
        exit();
    }
}

?>


<?php include("plantilla/header2.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistema 1</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css2/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css2/stilos.css">


            <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">



        <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.11.10/i18n/Spanish.json">

        <!-- CDN DE PRINTJS.CRABBLY.COM -->
        <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
        <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
        <script></script>

    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header " class="carta" id="carta">
                                        <h3 class="text-center font-weight-light my-4">LOGIN</h3>
                                    </div>
                                    <div class="card-body ">
                                        <form method="post" action="">
                                            <div class="form-floating mb-3">

                                                <div >
                                                <label for="inputEmail">Usuario</label>
                                                <input class="form-control" name="usuario" id="inputEmail" type="text" placeholder="name@example.com" />
                                                </div>
                                    
                                            </div>
                                            <div class="form-floating mb-3">

                                                <div>
                                                <label for="inputPassword">Clave</label>
                                                <input class="form-control" id="inputPassword" type="password" name="clave" placeholder="Password" />
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center" >
                                            <button type="submit" class="btn btn-primary btn-user btn-block" id="inicio">
                                            Iniciar Sesion
                                            </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

<?php include("plantilla/footer.php");?>
