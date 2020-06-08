<?php
require_once "views/base/cabezera.php";
?>
<div class="modal fade bd-example-modal-lg"  id="Create" tabindex="-1" role="dialog" aria-labelledby="Create" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header card-header text-center">
        <h2 class="text-center titulo" id="Create">Crear producto</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" id="CreateProduct">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">

              <div class="col-6">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" >
              </div>

              <div class="col-6">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="id_categoria">Categoria</label>
                </div>
                <select class="custom-select" name="id_categoria" id="id_categoria">
                </select>
              </div>

            </div>

            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Decripcion" >
            <br>
            
            <h5 class="text-center">Precios</h5>
            <hr>

            <div class="row">
              <div class="col-4">
                <label for="precio">Precio</label>
                <input type="text" name="precio" id="precio" class="form-control" placeholder="Precio" >
              </div>
              <div class="col-4">
                <label for="menudeo">Menudeo</label>
                <input type="text" name="menudeo" id="menudeo" class="form-control" placeholder="Menudeo" >
              </div>
              <div class="col-4">
                <label for="mayoreo">Mayoreo</label>
                <input type="text" name="mayoreo" id="mayoreo" class="form-control" placeholder="Mayoreo" >
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
                <input type="text" name="stock" id="stock" class="form-control" placeholder="Stock" >              
              </div>
              <div class="col-4">
                <label for="stock_min">Stock Min</label>
                <input type="text" name="stock_min" id="stock_min" class="form-control" placeholder="Stock Min" >              
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

<div class="modal fade" id="Update" tabindex="-1" role="dialog" aria-labelledby="Update" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header card-header">
        <h5 class="modal-title" id="Update">Actualizar al id</h5>
        <input type="text" name="Uid" id="Uid" class="form-control ml-3" style="width:50px" readonly>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-danger">
        <div class="form-group">
          <label for="Unombre">Nombre</label>
          <input type="text" name="Unombre" id="Unombre" class="form-control" placeholder="Nombre" >
          <label for="Udescripcion">Descripcion</label>
          <input type="text" name="Udescripcion" id="Udescripcion" class="form-control" placeholder="Decripcion" >
          <label for="Uprecio">Precio</label>
          <input type="text" name="Uprecio" id="Uprecio" class="form-control" placeholder="Precio" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary box-primary btn-block btn-lg titulo" data-dismiss="modal" id="UpdateData">Actualizar informacion</button>
      </div>
    </div>
  </div>
</div>

<h1 class="titulo mt-3 ml-3">Todos los Productos</h1>
<hr>
<nav class="navbar navbar-light bg-light justify-content-between">
    <a class='btn btn-primary box-primary mr-3 text-white' data-toggle="modal" data-target="#Create">Crear nuevo producto</a>
    <a href="javascript:listar()" class="badge badge-pill badge-dark box">Reload list</a>
    <a href="" class="badge badge-pill badge-success box-success" id="toExcel">Excel</a>
    <div class="form-inline">
      <input class="form-control mr-sm-2" type="search" id="search" placeholder="Buscar en productos" aria-label="Search">
    </div>
</nav>
<br>
<div class="card">
<table class="table table-striped table-bordered mb-0 " style="width:100%">
  <thead class="thead-light">
    <tr class="text-center" >
      <th scope="col">#</th>
      <th scope="col">Img</th>
      <th scope="col">Nombre</th>
      <th scope="col">Precio</th>
      <th scope="col">P. unitario</th>
      <th scope="col">P. mayoreo</th>
      <th scope="col">Stock</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <div class="row align-items-center">
    <tbody id="listProducts" > </tbody>
  </div>
</table>
</div>

<script type="text/javascript" src="views/base/js/others/products/listarProductos.js"></script>

<?php
require_once "views/base/footer.php";
?>
