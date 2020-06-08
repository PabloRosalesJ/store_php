<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Store</title>
    <script type="text/javascript" src="views/base/css/bootstrap.css"></script>
    <script type="text/javascript" src="views/base/css/dataTables.bootstrap4.min.css"></script>

    <link rel="stylesheet" href="views/base/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/base/css/main.css">
    <link rel="stylesheet" href="views/base/css/sweetalert2.min.css">
    <link rel="stylesheet" href="views/base/css/animate.css">    

    <script type="text/javascript" src="views/base/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="views/base/js/popper.min.js"></script>
    <script type="text/javascript" src="views/base/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="views/base/js/sweetalert2.all.min.js"></script>
    
</head>
<body>
  
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
  <div class="navbar-brand" >Store</div>
  
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item active">
        <a class="nav-link" href="http://store.test/?c=dashboard&a=index">Home  </a>
      </li>
      
      <li class="nav-item dropdown ml-3">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Punto de Ventas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="http://store.test/?c=compra&a=index">Venta Espesifica</a>
          <a class="dropdown-item" href="http://store.test/?c=compra&a=ventaLibre">Venta libre</a>
          <div class="dropdown-divider"></div>
          
          <a class="dropdown-item" href="http://store.test/?c=compra&a=listar">Listar Ventas</a>
          
        </div>
      </li>

      <li class="nav-item dropdown ml-3">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Clientes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="http://store.test/?c=usuario&a=index">Listar</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="http://store.test/?c=usuario&a=crear">Crear</a>
        </div>
      </li>

      <li class="nav-item dropdown ml-3">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Productos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!-- <a class="dropdown-item" href="http://store.test/?c=categoria&a=crear">Crear categoria</a> -->
          <a class="dropdown-item" href="http://store.test/?c=categoria&a=index">Categorias</a>
          <div class="dropdown-divider"></div>
          <!-- <a class="dropdown-item" href="http://store.test/?c=producto&a=crear">Crear producto</a> -->
          <a class="dropdown-item" href="http://store.test/?c=producto&a=index">Productos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="http://store.test/?c=producto&a=almacen">Almacén</a>
        </div>
      </li>
      
    </ul>
    <?php if(isset($_SESSION["identity"])): ?>
    <span class="navbar-text">
      Hola de nuevo 
      <a href="http://store.test/?c=usuario&a=admin">
        <strong><?=$_SESSION["identity"]->username?></strong>  
      </a> !    
      <a href="http://store.test/?c=usuario&a=logout" class="btn btn-outline-danger btn-sm">salir</a>
      <?php if(isset($_SESSION['notify'])):?>
      <div class="shadow-sm bg-white rounded">
        <button class="btn btn-outline-pimary btn-sm">x</button>
      </div>
      <?php endif;?>
    </span>
  <?php endif; ?>
  </div>
</nav>

<div class="container">
    


