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
        
        <link rel="icon" href="plantilla/imagen2.png">
        
        <link href="css2/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css2/stilos.css">


            <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

    </head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content" class=" bg-gradient-dark">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-5 rounded-4 mt-5">
                                    <div class="card-header border-5 rounded-4 shadow" class="carta" id="carta">
                                        <h3 class="text-center font-weight-light my-4">
                                        <img src="plantilla/imagen2.png">
                                        </h3>
                                    </div>
                                    <div class="card-body ">
                                        <form method="post" action="">
                                            <div class="form-floating mb-3">

                                                <div>
                                                    <label for="inputEmail">Usuario</label>
                                                    <div class="input-group">
                                                        <input class="form-control rounded-5 pt-4 pb-4" name="usuario" id="inputEmail" type="text" placeholder="Usuario" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text bg-white border-0">
                                                            <i class="fa-regular fa-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                            </div>

                                            <label for="inputPassword">Contraseña</label>
                                            <div class="form-floating mb-3">
                                                <div class="input-group">
                                                    <input class="form-control rounded-5 pt-4 pb-4" id="inputPassword" type="password" name="clave" placeholder="Contraseña" />
                                                    <div class="input-group-append">
                                                        <span id="togglePassword" class="input-group-text bg-white border-0">
                                                        <i class="fa-solid fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class=" mx-auto">
                                            <button type="submit" class="btn btn-dark btn-block rounded-5 bg-info mt-4 border-0" id="inicio">
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
        </div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        const passwordField = document.getElementById("inputPassword");
        const toggleIcon = document.getElementById("toggleIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("bi-eye");
            toggleIcon.classList.add("bi-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("bi-eye-slash");
            toggleIcon.classList.add("bi-eye");
        }
    });
</script>

<?php include("plantilla/footer.php");?>
