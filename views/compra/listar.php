<?php
require_once "views/base/cabezera.php";
?>
<ul class="nav nav-pills mb-3 mt-3 shadow-sm p-3 bg-white rounded d-flex justify-content-around" id="pills-tab" role="tablist">

    <!-- CONTROLES -->
    <li class="nav-item box">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Venta espesífica</a>
    </li>
    <li class="nav-item box">
        <a class="nav-link" id="free_sale_controll" data-toggle="pill" href="#free_sale_content" role="tab" aria-controls="free_sale_controll" aria-selected="false">Venta libre</a>
    </li>
    <!--FIN DE CONTROLES  -->

    <!-- VENTAS -->
</ul>
<div class="card">
    <div class="card-body">

        <div class="tab-content " id="pills-tabContent">

            <!-- VENTA ESPESIFICA -->

            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="shadow-sm bg-white p-3 rounded d-flex bg-light">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label for="buscar">
                                    <h5>Filtro</h5>
                                </label>
                                <input class="form-control mt-0" type="search" name="buscar" id="buscar" placeholder="id / nombre Cliente">
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <h5>Exportar</h5>
                                </div>
                                <div class="row">

                                    <a id="toPDF" class="btn btn-outline-warning mr-2 btn-sm box-warning" >PDF</a>
                                    
                                    <a id="toExcel" href="http://store.test/?c=compra&a=excel" class="btn btn-outline-success mr-2 btn-sm box-success">Excel</a>
                                    <button id="loadVe" class="btn btn-dark ml-2 btn-sm box">Reload</button>
                                    
                                    <p id="alertFilter" class="ml-4 alert alert-danger p-0 mb-0" role="alert"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="nav nav-pills mb-3 mt-3 shadow-sm bg-white rounded d-flex ">

                    <table class="table table-sm table-hover table-bordered" >
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width:1%">#</th>
                                <th scope="col">fecha</th>
                                <th scope="col">id_user</th>
                                <th scope="col">nombre</th>
                                <th scope="col">producto</th>
                                <th scope="col">pz</th>
                                <th scope="col">total</th>
                                <th scope="col">nota</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="vntEsp"> 
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- FIN DE VENTA ESPESIFICA -->

            <!-- VENTA LIBRE -->
            <div class="tab-pane fade" id="free_sale_content" role="tabpanel" aria-labelledby="free_sale_controll">
                
            <div class="shadow-sm bg-white p-3 rounded d-flex bg-light">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label for="buscar">
                                    <h5>Filtrar por cliente</h5>
                                </label>
                                <input class="form-control mt-0" type="search" name="buscar" id="buscarVL" placeholder="filtro">
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <h5>Exportar</h5>
                                </div>
                                <div class="row">
                                    <button class="btn btn-warning mr-2 btn-sm box-warning">PDF</button>
                                    <button class="btn btn-success mr-2 btn-sm box-success">Excel</button>
                                    <button class="btn btn-dark ml-2 btn-sm box">Reload</button>
                                    <p id="alertFilterVL" class="ml-4 alert alert-danger p-0 mb-0" role="alert"></p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="nav nav-pills mb-3 mt-3 shadow-sm bg-white rounded d-flex ">

                    <table class="table table-sm table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width:1%">#</th>
                                <th scope="col">fecha</th>
                                <th scope="col">#Cliente</th>
                                <th scope="col">Nombre del Cliente</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Nota</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="table-free">

                            
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- FIN DE VENTA LIBRE -->

        </div>

    </div>
</div>
<!-- FIN DE VENTAS -->

<script src="views/base/js/others/listar_compras.js"></script>

<?php
require_once "views/base/footer.php";
?>