<?php
require_once "views/base/cabezera.php";
?>

<div class="container shadow-sm p-3 mb-5 bg-white rounded mt-3">
    <h1 class="titulo text-center display-3">Reabastecer</h1>
    <hr>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <span class="titulo">Selecciona un producto para hacer un abastecimiento:</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="id">id</label>
                            <input type="text" name="id" id="id" class="form-control" placeholder="id">
                        </div>
                        <div class="col-9">
                            <label for="id">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="nombre">
                        </div>
                        <button id="select" class="btn btn-secondary btn-small btn-block box mt-2">Buscar</button>

                    </div>
                    <div id="insert">
                        <hr>
                        <div class="row align-items-end">
                            <div class="col-6">
                                <label for="piezas">Piezas a abastecer:</label>
                                <input type="text" id="piezas" class="form-control" placeholder="piezas" required>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary btn-block box-primary" id="endInsert">Abastecer</button>
                            </div>

                            <span class="ml-3 text-danger titulo">Proceda con cautela, esta accion no se puede revertir.</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 ">
            <div class="card ">
                <div class="card-header ">
                    <span class="titulo">Datos actuales del producto</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th scope="col">id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Stock min</th>
                                </tr>
                            </thead>
                            <tbody id="tableSelect">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shadow-sm p-1 bg-white rounded mt-3">
    <div class="row">
        <div class="col-5">
            <h2 class="titulo text-center">En desabasto</h2>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover table-sm ">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th scope="col">id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Stock min</th>
                        </tr>
                    </thead>
                    <tbody id="enDesabasto">

                    </tbody>
                </table>    
            </div>
        </div>
        <div class="col-7">
            <div class="row ">
                <div class="col-9 text-center"><h2 class="titulo">Abastos recientes</h2> </div>
                <div class="col-3">
                    <buton id="toPDF" class="btn btn-outline-danger btn-sm" >PDF</buton>
                    <buton id="toExcel" class="btn btn-outline-success btn-sm" >Excel</buton>
                </div>
            </div>
            
            <hr>
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th scope="col"># Abasto</th>
                        <th scope="col">id Prod</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Pz ingresadas</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody id="history">

                </tbody>
            </table> 
        </div>
    </div>
</div>

<script src="views/base/js/others/almacen/almacen.js"></script>

<?php
require_once "views/base/footer.php";
?>