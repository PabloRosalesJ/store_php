<?php
require_once "views/base/cabezera.php";
?>
<h1 class="display-4 titulo text-center mt-3">Dashboard</h1>
<hr>
<div class="containser shadow-sm p-3 mb-5 bg-white rounded mt-3">
    <div class="row">
        <div class="col-6">
        <div class="table-responsive">
                <h4 class="titulo text-center">Reporte para surtit:</h4>
                <table class="table table-hover table-sm ">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th scope="col">id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Pz faltates</th>
                        </tr>
                    </thead>
                    <tbody id="enDesabasto">

                    </tbody>
                </table>  
            </div>
            <button id="btnDesabasto" class="btn btn-outline-primary btn-sm btn-block box-primary">Imprimir Reporte</button>  
        </div>

        <div class="col-6">
        <div class="table-responsive">
                <h4 class="titulo text-center">Usarios con crédito:</h4>
                <table class="table table-hover table-sm ">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th scope="col">id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="Credits">

                    </tbody>
                </table>  
                <!-- <button id="btnDesabasto" class="btn btn-outline-primary btn-sm btn-block">Descargar Reporte</button>   -->
            </div>
        </div>
    </div>
</div>
<script src="views/base/js/others/dashboard.js"></script>

<?php
require_once "views/base/footer.php";
?>