<?php
require_once "views/base/cabezera.php";
?>
<div class="container">

<!-- IMAGE MODAL -->
<div class="modal fade bd-example-modal-lg" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo ucfirst($producto->nombre)  ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
      <img src="http://store.test/img/<?php echo $producto->image ?>" alt="producto" width="750">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- END IMAGE MODAL -->

<!-- UPDATE PRODUCT MODAL -->
<div class="modal fade bd-example-modal-lg"  id="Update" tabindex="-1" role="dialog" aria-labelledby="Update" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header card-header text-center">
        <h2 class="text-center titulo" id="Update">Crear producto</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" id="UpdateProduct">
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <!-- <input type="hidden" name="id_prod" id="id_prod" value="<?php echo $producto->id ?>"> -->
            <div class="col-6">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="<?php echo ucfirst($producto->nombre)?>">
            </div>

            <div class="col-6">
              <div class="input-group-prepend">
                <label class="input-group-text" for="id_categoria">Selecciona una categoria</label>
              </div>
              <select class="custom-select" name="id_categoria" id="id_categoria">
              </select>
            </div>

          </div>

          <label for="descripcion">Descripcion</label>
          <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Decripcion" value="<?php echo ucfirst($producto->descripcion)  ?>">
          <br>
          
          <h5 class="text-center">Precios</h5>
          <hr>

          <div class="row">
            <div class="col-4">
              <label for="precio">Precio</label>
              <input type="text" name="precio" id="precio" class="form-control" placeholder="Precio" value="<?php echo $producto->precio ?>">
            </div>
            <div class="col-4">
              <label for="menudeo">Menudeo</label>
              <input type="text" name="menudeo" id="menudeo" class="form-control" placeholder="Menudeo" value="<?php echo $producto->precio_menudeo ?>">
            </div>
            <div class="col-4">
              <label for="mayoreo">Mayoreo</label>
              <input type="text" name="mayoreo" id="mayoreo" class="form-control" placeholder="Mayoreo" value="<?php echo $producto->precio_mayoreo ?>">
            </div>
          </div> <br>

          <h5 class="text-center">Almacén</h5>
          <hr>

          <div class="row">
            <div class="col-4">
              <label for="imagen">Imagen</label>
              <input type="file" name="imagen" id="imagen" class="form-control" placeholder="imagen" >              
            </div>
            <div class="col-4">
              <label for="stock">Stock</label>
              <input type="text" name="stock" id="stock" class="form-control" placeholder="Stock" value="<?php echo $producto->stok ?>">              
            </div>
            <div class="col-4">
              <label for="stock_min">Stock Min</label>
              <input type="text" name="stock_min" id="stock_min" class="form-control" placeholder="Stock Min" value="<?php echo $producto->min ?>">              
            </div>
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary box-primary btn-block btn-lg titulo" data-dismiss="modal" id="save">Guardar</button>
        </div>
    </form>
    </div>
  </div>
</div>
<!-- END UPDATE PRODUCT MODAL -->


<h1 class="titulo text-center display-4 mt-3">Detalle</h1>
<hr>

<div class="row shadow">
  <!-- Info -->
  <div class="col-4 mt-3 mb-3">
    <a data-toggle="modal" data-target="#imageModal">
      <img src="http://store.test/img/<?php echo $producto->image ?>" alt="" class="rounded-circle mx-auto d-block"  width="200" height="200">
    </a>
    <div class="display-4 text-center"> <?php echo ucfirst($producto->nombre)  ?></div>
    <p class="ml-3 text-center mb-0" >id: <span id="id_product"><?php echo $producto->id ?></span> </p>
    <p class="ml-3">Descripción: <?php echo ucfirst($producto->descripcion)  ?></p>
    <hr>
    <div class="ml-3">
      <div class="row">
        <div class="col-6">
          Precio:  <br>
          Precio unitario:  <br>
          Precio mayoreo: <br>
          Stock: <br>
          Stock minimo:  <br>
          Categoria: 
        </div>
        <div class="col-6">
          $ <?php echo $producto->precio ?> <br>
          $ <?php echo $producto->precio_menudeo ?> <br>
          $ <?php echo $producto->precio_mayoreo ?> <br>
          <?php echo $producto->stok ?> <br>
          <?php echo $producto->min ?> <br>
          <?php echo ucfirst($producto->caregory) ?> <br>
        </div>
      </div>
      <br>
      <button class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#Update">Actualizar información</button>
    </div>
  </div>
<!-- end info -->

<!-- history -->
  <div class="col-8 mt-3 mb-3">
    <h4 class="text-center">Historial de ventas</h4>
    <hr>
    <table class="table table-sm table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Fecha</th>
        <th scope="col">Pz</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody>
      <tr id="tabla_vendidos" class="box"></tr>
    </tbody>
    </table>
  </div>
<!-- end history -->

</div>

</div>

<script type="text/javascript" src="views/base/js/others/products/show.js"></script>

<?php
require_once "views/base/footer.php";

