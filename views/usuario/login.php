<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Store | login</title>
    <link rel="stylesheet" href="views/base/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/base/css/main.css">
    <link rel="stylesheet" href="views/base/css/sweetalert2.min.css">
    <link rel="stylesheet" href="views/base/css/animate.css">
    <style>
    </style>
</head>

<body>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-4 "></div>
            <div class="col-4 align-self-center mt-3">
                <div style="margin-top: 20px;""></div>
                <h1 class=" text-center display-3 mt-3">Login</h1>
                    <hr>
                    <div class="card box">
                        <div class="card-body mb-3">
                            <form action="http://store.test/?c=usuario&a=log_in" method="post">
                                <div class="from-control">
                                    <label for="">Userame</label>
                                    <input type="text" name="username" id="username" class="form-control" 
                                    <?php if(isset($_SESSION["Auth_Error"])):?>
                                        value="<?=$_SESSION["Auth_Error"]["username"]?>"
                                    <?php endif;?>
                                    required>
                                    <label for="">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" 
                                    
                                    required>
                                </div>
                                <hr>
                                <button id="login" class="btn btn-primary btn-block box-primary">Go</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mt-3">
                        <?php if (isset($_SESSION["Auth_Error"])) : ?>
                            <div class="alert mt-3">
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    <strong>Error de Autenticación!</strong>
                                    <p>Usuario o contraseña incorrectos.</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <!-- <?=var_dump($_SESSION)?> -->
                        <?php
                        endif;
                        unset($_SESSION["Auth_Error"]);
                        ?>
                    </div>
                </div>
            </div>

            <footer>
            <div class="mt-3">
                        <h1 class=" h1 titulo text-center">Store</h1>
                        <hr>
                        <p class="text-center mb-0">v2.0.1</p>
                        <p class="text-center mb-0">by iMagineDreams</p>
                    </div>
            </footer>

        </div>

        <script type="text/javascript" src="views/base/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="views/base/js/popper.min.js"></script>
        <script type="text/javascript" src="views/base/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="views/base/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="views/base/js/others/login.js"></script>
</body>

</html>