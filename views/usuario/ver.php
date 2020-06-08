<?php
require_once "views/base/cabezera.php";

$usario = $user->fetch_object();

if ($user->num_rows > 0) {
    if ($usario->estatus == 1) {
        $estatus = "<span class='badge badge-pill badge-success box-success-tag'> Up </span>";
        $e = "Up";
        // $btn = "Desactivar";
        // $btncolor = "danger";
        // $m = "";
    } elseif ($usario->estatus == 0) {
        $estatus = "<span class='badge badge-pill badge-danger box-danger-tag'>Down</span>";
        $e = "Down";
        // $btn = "Activar";
        // $btncolor = "success";
        // $m = "El cliente se encuentra inactivo y no puede realizar ninguna acción.";
    }
}


?>
<?php if ($user->num_rows > 0) : ?>
    <div class="modal fade" id="credito" tabindex="-1" role="dialog" aria-labelledby="credito" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <div class="row">
                        <h4 class="modal-title titulo ml-3">Crédito</h4>
                        <input type="text" id="pagos" class="form-control ml-3" readonly style="width:100px" >
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Nota</th>
                            </tr>
                        </thead>
                        <tbody id="creditTabel">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="UpdateUser" type="button" class="btn btn-outline-primary btn-block btn-lg titulo" data-dismiss="modal">Imprimir esre reporte</button>
                </div>
            </div>
        </div>
    </div>
    <!-- COLUMNA DE DETALLES Y ACCIONES -->
    <div class="row d-flex justify-content-between">

        <!-- DETALLES DEL CLIENTE -->
        <div class="card mt-3" style="width:45%;">
            <div class="card-header">
                <div class="row ">
                    <h3 class="titulo ml-3">Cliente: <?= $usario->nombre ?> <?= $usario->apellidos ?> </h3>
                    <small><?= $estatus ?></small>
                </div>
            </div>

            <div class="card-body ">

                <div class=" ml-3">Dirección: <?= $usario->direccion ?></div>
                <div class=" ml-3">Teléfono: +52 <?= $usario->telefono ?></div>

                <hr>

                <div class="row">
                    <div class="col">Total de deuda: $ </div>
                    <div class="col"><input type="text" id="TotalDeuda" class="form-control" readonly></input></div>
                </div>
                <div class="row">
                    <div class="col">Aún debe: $ </div>
                    <div class="col"><input type="text" id="pay" class="form-control" readonly></input></div>
                </div>

                <!-- <br /> -->
                <!-- <div class="row align-items-center">
                    <div class="col-10">
                        <div id="progresVar"></div>
                    </div>
                    <div class="col-2"> -->
                <!-- <p id="textP" class="text-success"></p> -->
                <!-- </div>
                </div> -->

                <!-- <br /> -->
                <hr>
                <div class="row justify-content-center text-center">
                    <!-- <div class="col-2">
                        <a href="" class="btn btn-outline-warning btn-sm" id="toPdf">Pdf</a>
                    </div>
                    <div class="col-2">
                        <a href="" class="btn btn-outline-success btn-sm" id="toPdf">Excel</a>
                    </div> -->
                    <div class="col-3">
                        <button class="btn btn-outline-info btn-sm box-primary" data-toggle="modal" data-target="#credito" onclick="showCredit(<?= $usario->id ?>)">Ver crédito</button>
                    </div>
                    <div class="col-5">
                        <a class="btn btn-outline-danger btn-sm" href="http://store.test/?c=compra&a=ventaLibre&user_id=<?= $usario->id ?>">Agregar compra</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-danger btn-sm box-danger-tag" href="javascript:delhistory(<?= $usario->id ?>)"
                            >Borrar historial
                        </a>
                    </div>
                </div>
                <!-- <div class="form-group"> -->
                    <!-- <div class="row"> -->
                        <!-- <div class="col">
                        <a href="http://store.test/?c=usuario&a=crear" class="btn btn-info box-primary btn-block form-group">Actualizar información</a>
                    </div> -->
                        <!-- <div class="col">
                            <a href="http://store.test/?c=usuario&a=changeEstado&id=<?= $usario->id ?>" class="btn btn-block btn-<?= $btncolor ?> box-<?= $btncolor ?>" type="submit"><?= $btn ?></a>
                        </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
        <!-- FIN DE DETALLES DEL CLIENTE -->

        <!-- AGREGAR -->
        <div class="card mt-3 " style="width:50%;">
            <div class="card-header">
                <h4 class="titulo text-center">Agregar Pago</h4>
            </div>
            <div class="card-body">

                <!-- <form action="http://store.test/?c=pago&a=pago" method="post"> -->

                <?php if ($usario->estatus == 1) : ?>

                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="id_cliente">id</label>
                            <input type="text" name="id_cliente" id="id_cliente" class="form-control" value="<?= $usario->id ?>" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="monto">Monto</label>
                            <input type="text" name="monto" id="monto" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="nombre">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <textarea class="form-control" id="descripcion" rows="3"></textarea>
                    </div>
                    <button class="btn btn-success btn-block box-success" id="pagar">Agregar Pago</button>




                <?php else : ?>
                    <h3 class="text-danger titulo"><?= $m ?></h3>
                <?php endif; ?>

                <!-- <button type="submit">post</button>

        </form> -->

            </div>
        </div>
        <!-- FIN AGREGAR -->

    </div>
    <!-- FIN DE COLUMNA DE DETALLES Y ACCIONES -->

    <div class="card mt-3" style="width:100%;">
        <div class="panel-heading">
            <nav class="navbar navbar-light bg-light justify-content-between">

                <a href="javascript:listar()" class="badge badge-pill badge-dark box">Reload list</a>
                <h4 class="titulo">Historial</h4>
                <div class="form-inline">
                    <input class="form-control mr-sm-2" type="search" id="search" placeholder="Buscar " aria-label="Search">
                </div>
            </nav>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover ">
                <thead class="thead-light text-center ">
                    <tr>
                        <th scope="col"># pago </th>
                        <th scope="col">monto</th>
                        <th scope="col">fecha</th>
                        <th scope="col">descripcion</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla">
                </tbody>
            </table>
        </div>
    </div>
<?php else : ?>

    <div class="container">
        <br>
        <div class="card text-center">
            <div class="card-header">
                404
            </div>
            <div class="card-body">
                <h2 class="card-title">404 Cient not found</h2>
                <h3 class="card-text">El cliente que buscas se fué de viaje o simplemente no existe ...</h3>
                <h5>Puedes hacer lo siguiente:</h5>
                <img src="views/base/img/nyan-cat.gif" high="50px" alt="Card image">
                <a href="http://store.test/?c=usuario&a=index" class="btn btn-primary">Lista de clientes</a>
            </div>
            <div class="card-footer text-muted">
                O quedarte a ver este gatito ...
            </div>
        </div>
    </div>
<?php endif; ?>



<script src="views/base/js/others/ver.js"></script>

<?php
require_once "views/base/footer.php";
?>