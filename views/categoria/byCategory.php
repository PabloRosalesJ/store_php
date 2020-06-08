<?php
require_once "views/base/cabezera.php";
?>

<div class="container">
    <div class="div shadow-sm p-3 mb-5 bg-white rounded mt-3">
        <div class="card">
            <div class="card-header">
                <h2 class="titulo">Categoria: <span><?= $name ?></span></h2>
                <span>Número de Productos: <span><?= $numrow ?></span></span>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover">
                    <thead class="thead-light text-center">
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Stock mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = $productos->fetch_object()): ?>
                        <?php if ($p->min > $p->stok) {
                            $type = "table-danger";
                        }else {
                            $type = "";
                        }
                        ?>
                            <tr class="box text-center <?=$type?>">
                                <th scope="row" >
                                    <!-- <a class="btn btn-secondary btn-sm" href="http://http://store.test/?c=producto&a=ver&id=<?=$p->id?>"> -->
                                       <?=$p->id?>
                                    <!-- </a> -->
                                </th>
                                <td><?=$p->nombre?></td>
                                <td><?=$p->descripcion?></td>
                                <td><?=$p->precio?></td>
                                <td><?=$p->stok?></td>
                                <td><?=$p->min?></td>
                            </tr>
                        
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
require_once "views/base/footer.php";
?>