<?php
require_once "views/base/cabezera.php";
?>
<div class="mt-3 ">
<div class="col align-self-center">
<div class="row justify-content-center ">
<div class="col-6">
<div class="card text-left box">
<div class="card-body ">

    <!-- <form action="http://store.test/?c=usuario&a=guardar" method="post"> -->

    <h1 class="card-title titulo text-center">Crear Producto</h1>
    <hr>
    
    <label class="titulo" for="categoria">Selecciona una categoria</label>
    <select class="form-control" id="categoria">
        <?php while ($c = $categorias->fetch_object()):?>
            <option value="<?=$c->id?>"><?=$c->nombre?></option>
    <?php endwhile; ?>
    </select>

    <label for="nombre" class="titulo">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control">

    <label for="desc" class="titulo">Descripción corta</label>
    <input type="text" name="desc" id="desc" class="form-control">

    <div class="row">
        <div class="col-4">
            <label for="precio" class="titulo">Precio</label>
            <input type="text" name="precio" id="precio" class="form-control">
        </div>
        <div class="col-4">
            <label for="stock" class="titulo">Stock</label>
            <input type="text" name="stock" id="stock" class="form-control">
        </div>
        <div class="col-4">
            <label for="stockMin" class="titulo">Stock Mímimo</label>
            <input type="text" name="stockMin" id="stockMin" class="form-control">
        </div>
    </div>
    <br>

    <button class="btn btn-primary btn-block titulo box-primary" id="saveProduct">Guardar</button>

    <a href="http://store.test/?c=usuario&a=index" class="btn btn-danger btn-block titulo box-danger"> <= Back </a>
    
    <!-- </form> -->

<script src="views/base/js/others/producto.js "></script>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
require_once "views/base/footer.php";
?>