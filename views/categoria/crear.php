<?php
require_once "views/base/cabezera.php";
?>
<div class="mt-3 ">
<div class="col align-self-center mt-3 ">
<div class="row justify-content-center ">
<div class="col-6">
<div class="card text-left box">
<div class="card-body ">

<!-- <form action="http://store.test/?c=categoria&a=guardar" method="post"> -->
    <h1 class="card-title titulo">Nueva Categoria</h1>
    <hr>
    <label for="nombre" class="titulo">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control">
    
    <br>

    <button class="btn btn-primary btn-block titulo box-primary" id="saveCategory">Guardar</button>
    
    <a href="http://store.test/?c=producto&a=crear" class="btn btn-secondary btn-block titulo box"> Ir Productos </a>

<!-- </form> -->

<script src="views/base/js/others/categoria.js"></script>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
require_once "views/base/footer.php";
?>