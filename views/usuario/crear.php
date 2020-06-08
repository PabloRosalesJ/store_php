<?php
require_once "views/base/cabezera.php";
?>
<div class="mt-3 ">
<div class="col align-self-center mt-3 ">
<div class="row justify-content-center ">
<div class="col-6">
<div class="card text-left box">
<div class="card-body ">

    <!-- <form action="http://store.test/?c=usuario&a=guardar" method="post"> -->

    <h1 class="card-title titulo">Alta Cliente</h1>
    <hr>
    <label for="nombre" class="titulo">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control">

    <label for="nombre" class="titulo">Apellidos</label>
    <input type="text" name="apellidos" id="apellidos" class="form-control">

    <label for="nombre" class="titulo">Direccion</label>
    <input type="text" name="direccion" id="direccion" class="form-control">

    <label for="nombre" class="titulo">Telefono</label>
    <input type="text" name="telefono" id="telefono" class="form-control">
    
    <br>

    <button class="btn btn-primary btn-block titulo box-primary" id="saveUser">Guardar</button>

    <a href="http://store.test/?c=usuario&a=index" class="btn btn-danger btn-block titulo box-danger"> <= Back </a>
    
    <!-- </form> -->

<script src="views/base/js/guardar_cliente.js"></script>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
require_once "views/base/footer.php";
?>