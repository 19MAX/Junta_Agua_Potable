<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo de DataTables en Español</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- Agrega la traducción en español desde un CDN -->
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"></script>
</head>

<?php include("plantilla/header.php"); ?>

<body>
    <table id="miTabla" class="table" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Juan</td>
                <td>juan@example.com</td>
            </tr>
            <tr>
                <td>2</td>
                <td>María</td>
                <td>maria@example.com</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Pedro</td>
                <td>pedro@example.com</td>
            </tr>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });
    </script>
</body>

<?php include("plantilla/footer.php");?>
</html>
