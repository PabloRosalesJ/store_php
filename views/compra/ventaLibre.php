<?php
require_once "views/base/cabezera.php";

?>
<ul class="nav nav-pills mb-3 mt-3 shadow-sm p-3 bg-white rounded d-flex justify-content-around" id="pills-tab" role="tablist">

  <!-- CONTROLES -->
  <li class="nav-item box">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Venta Libre</a>
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
                  <input type="text" name="id_user" id="id_user" class="form-control" placeholder="id del usario" value="<?php echo isset($_GET["user_id"]) ?  $_GET["user_id"] : ""; ?>">
                  <label for="nombre_usario">Cliente</label>
                  <input type="text" name="nombre_usario" id="nombre_usario" class="form-control" placeholder="Nombre del Ciente">
                  <br>
                  <button class="btn btn-primary box-primary btn-block" id="select">Seleccionar</button>
                  <br>
                  <div id="goToDetaills"> </div>
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
                <div class="col form-group">
                    <label for="">Monto</label>
                  <input id="montoVl" type="text" class="form-control">
              
              
                <label for="descripcion">Descripcion</label>
                <textarea class="form-control" id="descripcion" rows="3"></textarea>
               </div>     
            </div>
            <!-- FIN DE COMPRA -->
            <hr>
            <!-- ARTICULOS -->
            
            <!-- FIN DE ARTICULOS -->

            <button class="btn btn-success box-success btn-block mt-3" id="endSale">Finalizar compra</button>

          </div>
        </div>
      </div>
      <!-- FIN DE VENTA ESPESIFICA -->
    </div>
  </div>
</div>

<script src="views/base/js/others/ventalibre.js"></script>

<?php
require_once "views/base/footer.php";
?>