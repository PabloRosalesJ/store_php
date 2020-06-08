<?php
require_once "views/base/cabezera.php";
?>

<h1 class="titulo text-center display-4 mt-3">This place is only for Admins</h1>
<hr>

<div class="container shadow-sm p-3 mb-5 bg-white rounded">
    <div class="row">

        <div class="col">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3>Crear nuevo</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="username">User Name</label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="col">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control">
                        </div>
                        <div class="col">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="col">
                            <label for="password">Confirm password</label>
                            <input type="password" name="password" id="passwordConfirm" class="form-control">
                        </div>
                    </div>
                    <button id="save" class="btn btn-primary btn-block btn-lg mt-3 box-primary">Guardar</button>
                </div>
            </div>
        <hr>
        <div class="card box">
            <div class="card-header">
                <h3>BackUp</h3>
            </div>
            <div class="card-body">
            <p class="text-center">Esta sección genera un respaldo de la base de datos.</p>
                <button class="btn btn-danger btn-block box-danger" id="backup">Generar</button>
            </div>
        </div>

        </div>

        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3>Lista de administradores</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th scope="col">id</th>
                                <th scope="col">User</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">&times;</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="views/base/js/others/admin.js"></script>
<?php
require_once "views/base/footer.php";
?>