<?php
require_once "views/base/cabezera.php";
?>
<div class="modal fade" id="Update" tabindex="-1" role="dialog" aria-labelledby="Update" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-danger text-danger">
      <div class="modal-header card-header">
        <h4 class="modal-title titulo" >Editar a id :</h4>
        <input type="text" name="Uid" id="Uid" class="form-control ml-3" readonly style="width:100px">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="form-group">
        <div class="row">
          <div class="col form-group">
            <label class="" for="Unombre">Nombre</label>
            <input type="text" name="Unombre" id="Unombre" class="form-control" placeholder="Nombre">
          </div>
          <div class="col">
            <label for="Uapellidos">Apellidos</label>
            <input type="text" name="Uapellidos" id="Uapellidos" class="form-control" placeholder="Apellidos">
          </div>
        </div>
        <div class="row">
          <div class="col form-group">
            <label for="Udireccion">Direccion</label>
            <input type="text" name="Udireccion" id="Udireccion" class="form-control" placeholder="Direccion">
            <label for="Utelefono">Telefono</label>
            <input type="text" name="Utelefono" id="Utelefono" class="form-control" placeholder="Telefono">
          </div>
        </div>
      </div>
    </div>
      <div class="modal-footer">
        <button id="UpdateUser" type="button" class="btn btn-outline-primary btn-block btn-lg titulo" data-dismiss="modal">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

<h1 class="titulo mt-3 ml-3">Todos los Clientes</h1>
<hr>
<nav class="navbar navbar-light bg-light justify-content-between">
    <a class="btn btn-primary box-primary mr-3" href="http://store.test/?c=usuario&a=crear">Crear nuevo cliente</a>
    <a href="javascript:listar()" class="badge badge-pill badge-dark box">Reload list</a>
    <div class="form-inline">
      <input class="form-control mr-sm-2" type="search" id="search" placeholder="Buscar en clientes" aria-label="Search">
    </div>
</nav>
<br>
<div class="card">
<table class="table table-sm table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Domicilio</th>
      <th scope="col">Telefono</th>
      <th scope="col">Status</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody id="listar"> </tbody>
</table>
</div>

<br>

<div class="row justify-content-center">
  <nav aria-label="Page navigation example">
    <ul class="pagination" id="pagination">
      
    </ul>
  </nav>
</div>


<script type="text/javascript" src="views/base/js/others/listar.js"></script>

<?php
require_once "views/base/footer.php";
?>
