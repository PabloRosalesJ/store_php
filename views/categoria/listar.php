<?php
require_once "views/base/cabezera.php";
?>

<!-- Category Modal -->

<div class="modal fade" id="CategoryModal" tabindex="-1" role="dialog" aria-labelledby="CategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="titulo text-center" id="CategoryModalLabel">Crear Categoria</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="CreateCategory">
        <div class="modal-body">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-block" id="saveCategory" data-dismiss="modal">Guardar Categoria</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- End Category Modal -->

<h1 class="titulo mt-3 ml-3">Todas las Categorias</h1>
<hr>
<nav class="navbar navbar-light bg-light justify-content-between">
    <!-- <a class="btn btn-primary box-primary mr-3" href="http://store.test/?c=categoria&a=crear">Crear nueva categoria</a> -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CategoryModal" >
      Crear Categoria
    </button>
    <a href="javascript:listar()" class="badge badge-pill badge-dark box">Reload list</a>
    <div class="form-inline">
      <input class="form-control mr-sm-2" type="search" id="search" placeholder="Buscar en categorias" aria-label="Search">
    </div>
</nav>
<br>
<div class="card">
<table class="table table-sm table-hover">
  <thead class="thead-light text-center">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody id="tabla"> </tbody>
</table>
</div>


<script type="text/javascript" src="views/base/js/others/category/listar_categoria.js"></script>

<?php
require_once "views/base/footer.php";
?>
