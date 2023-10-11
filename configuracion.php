<?php include("configuracionDefecto.php");?>



<?php include("plantilla/header.php");?>
<div class="container-fluid">
<script src="js/flash_messages.js"></script>
<button type="button" class="btn btn-info m-3" data-toggle="modal" data-target="#modalConf">
    Actualizar datos
</button>
</div>
    <div class="row m-4 text-center">
    <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-3 ">
            <div class="card shadow border-left-success py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col ">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Consumo Base</div>
                            <div class="h5 font-weight-bold text-gray-800"><?php echo $consumo_base;?>M³</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Exedente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $exedente;?>M³</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-3" >
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Valor Consumo Base</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo $valor_consumo_base; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Valor Exedente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" name="valorExe"> $<?php echo $valor_exedente; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body ">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Reconexion</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" name="valorExe"> $<?php echo $reconexion; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalConf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar datos de Configuracion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="Post" action="actualizarConf.php" id="formularioD">

                    <div class="form-floating mb-3">
                        <div >
                            <label >Consumo Base </label>
                            <input class="form-control" step="any" name="consumo_base" type="number" value="<?php echo $consumo_base;?>"/>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Exedente</label>
                        <input class="form-control" step="any" type="number" name="exedente" value="<?php echo $exedente;?>" />
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Valor Consumo base </label>
                        <input class="form-control" step="any" type="number" name="valor_consumo_base" value="<?php echo $valor_consumo_base;?>"/>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Valor Exedente</label>
                        <input class="form-control" step="any"  type="number" name="valor_exedente" value="<?php echo $consumo_base;?>" />
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <div>
                        <label >Valor Reconexion</label>
                        <input class="form-control" step="any"  type="number" name="reconexion" value="<?php echo $reconexion;?>" />
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- script de alertas -->
<script src="js/flash_messages.js"></script>
<script>
    $(document).ready(function () {
        showFlashMessages('<?php echo $message; ?>', '<?php echo $type; ?>');
    });
</script>

<script>
    $(document).ready(function() {
        showFlashMessages('<?php echo $message; ?>', '<?php echo $type; ?>');
    });
</script>

<?php include("plantilla/footer.php");?>
