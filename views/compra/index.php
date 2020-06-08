<?php
require_once "views/base/cabezera.php";
?>
<ul class="nav nav-pills mb-3 mt-3 shadow-sm p-3 bg-white rounded d-flex justify-content-around" id="pills-tab" role="tablist">

  <!-- CONTROLES -->
  <li class="nav-item box">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Venta espesífica</a>
  </li>
  
  <!--FIN DE CONTROLES  -->

</ul>
  <!-- VENTAS -->
<div class="card">
  <div class="card-body">

    <div class="tab-content " id="pills-tabContent">

      <!-- VENTA ESPESIFICA -->

      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

        <div class="row">

          <div class="col-3">
            <div class="card bg-light">
              <div class="card-body">

                <!-- DATOS USARIO -->
                <div class="form-group">
                  <label for="fecha">Fecha</label>
                  <input type="date" name="fecha" id="fecha" class="form-control" readonly>
                  <hr>

                  <label for="id_user">id</label>
                  <input type="text" name="id_user" id="id_user" class="form-control" placeholder="id del usario">
                  <label for="nombre_usario">Cliente</label>
                  <input type="text" name="nombre_usario" id="nombre_usario" class="form-control" placeholder="Nombre del Ciente">
                  <br>
                  <button class="btn btn-primary box-primary btn-block" id="select">Seleccionar</button>
                  <br>
                  <p class="text-danger" id="notFound"></p>
                </div>
              </div>
            </div>
          </div>

          <!-- DATOS DE COMPRA -->
          <div class="col-9 mt-1">
            <!-- DATOS DEL COMPRANTE -->
            <div class="row align-items-center">
              <div class="col-3">
                <h3 class="titulo">Cliente:</h3>
              </div>
              <div class="col-4">
                <input id="cliente_datos" name="cliente_datos" class="form-control" readonly>
              </div>

              <div class="col-1">
                <h5 class="titulo">id:</h5>
              </div>
              <div class="col-2">
                <input id="id_datos" name="id_datos" class="form-control" readonly>
              </div>
            </div>
            <!-- FIN DE DATOS -->
            <hr>
            <!-- COMPRA -->
            <div class="row">

              <div class="col">
                <label for="producto">Producto:</label>
                <select id="producto" name="producto" class="custom-select">
                  <option value="01101">Selecciona uno</option>
                  <?php while ($p = $productos->fetch_object()) : ?>
                    <option class="<?= $p->nombre ?>" value="<?= $p->id ?>"><?= $p->nombre ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="col">
                <label for="precio">Precio:</label>
                <input id="precio" name="precio" type="precio" class="form-control" readonly>
              </div>
              <div class="col">
                <label for="stock">En almacen:</label>
                <input id="stock" name="stock" type="stock" class="form-control" readonly>
              </div>
              <div class="col">
                <label for="piezas">Piezas:</label>
                <input id="piezas" name="piezas" type="text" class="form-control" placeholder="No. piezas">
                <div class="invalid-tooltip">
                  Este campo no puede estar vacio.
                </div>
              </div>

              <div class="col-12">
                <label for="nota">Nota (Opcional)</label>
                <input type="text" id="nota" name="nota" class="form-control" placeholder="Nota corta">
              </div>

            </div>
            <div class="row mt-2 align-items-center">

              <div class="col-2">Total:</div>
              <div class="col-3">
                <input type="text" id="total" name="total" class="form-control" readonly>
              </div>
              <div class="col-7">
                <button id="order" class="btn btn btn-secondary btn-block box">Agregar</button>
              </div>

            </div>
            <!-- FIN DE COMPRA -->
            <hr>
            <!-- ARTICULOS -->
            <div class="card">
              <div class="card-body">

                <table class="table table-bordered table-hover table-sm m-0">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" style="width:10px">#</th>
                      <th scope="col" style="width:30%">Producto</th>
                      <th scope="col">pz</th>
                      <th scope="col">precio</th>
                      <th scope="col">notas</th>
                      <th scope="col">sub-total</th>
                      <th class="text-center" scope="col">&times;</th>
                    </tr>
                  </thead>
                  <tbody id="lista_Carrito">
                  </tbody>
                </table>

              </div>
            </div>
            <!-- FIN DE ARTICULOS -->

            <button class="btn btn-success box-success btn-block mt-3" id="endSale">Finalizar compra</button>

          </div>
        </div>
      </div>
      <!-- FIN DE VENTA ESPESIFICA -->
    </div>
  </div>
</div>

<script src="views/base/js/others/compra.js"></script>

<?php
require_once "views/base/footer.php";
?>