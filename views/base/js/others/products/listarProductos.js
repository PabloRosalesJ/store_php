$(document).ready(function (){
    //listar();
    list_products()
    $.ajax({
        url:'http://store.test/?c=categoria&a=listar',
        method:'GET',
        data:{},
        success: response => {
            var r = JSON.parse(response)
            var category = r
            table = document.getElementById('id_categoria')
            html = ''
            
            if (category.datos == 0) {
                $("#save").prop("disabled", true);
                html = `<option value="null">Sin categorias para realizar esta acción ...</option>`;
            }

            for(let i = 0; i < category.datos.length; i++){

                if (category.datos[i].estatus != 0) {

                    html = html + `<option value="${category.datos[i].id}">${category.datos[i].nombre}</option>`;

                }
            }

            table.innerHTML = html;
                
        }
        
    })
});

function list_products(){
    $.ajax({
        url:'http://store.test/?c=producto&a=listar',
        method:'GET',
        data:{},
        success:response=>{
            data = JSON.parse(response)
            
            makeList(data)
        }
    })
    
}

function makeList(product) {
    table = document.getElementById("listProducts");
    html = ''
    message = "Aun no hay datos para mostrar";
    if (product.datos.length == 0) {
        html = "<td  colspan='7' class='titulo h3 text-center'>"+message+"</td >";
    }
    for(let i = 0; i < product.datos.length; i++){
        if (parseInt(product.datos[i].stok) < parseInt(product.datos[i].min)) {
            var type = "table-danger"
        }else{
            var type = ""
        }
        html = html + 
        '<tr class="box text-center align-middle'+type+'">'+ 
            '<th> ' + product.datos[i].id + '</th>'+ 
            '<td><img src="http://store.test/img/' + product.datos[i].image + '" class="rounded-circle" width="50" height="50" alt=""></td>'+
            '<td> ' + product.datos[i].nombre + '</td>'+
            '<td> $ ' + product.datos[i].precio + '</td>'+
            '<td> $ ' + product.datos[i].precio_menudeo + '</td>'+
            '<td> $ ' + product.datos[i].precio_mayoreo + '</td>'+
            '<td> ' + product.datos[i].stok + '</td>'+
            '<td> ' + 
            `<a class='btn btn-danger btn-sm box-danger mr-3' href=" javascript:borrar(${product.datos[i].id}, '${product.datos[i].nombre}') ">Borrar</a>
            <a class='btn btn-secondary btn-sm box mr-3 text-white' href="http://store.test/?c=producto&a=ver&id=${product.datos[i].id}">Ver</a>`+
        '</tr class>';

    }
    
    table.innerHTML = html;
}

var search = document.querySelector("#search");
search.addEventListener('keyup', function(){
    var txt = $('#search').val();
    if (txt != '') {

        $.ajax({

            url:"http://store.test/?c=producto&a=buscar",
            method:"POST",
            data:{search:txt},
            dataType:"text",

            success:function (data) {

                var usario = JSON.parse( data )
                console.log(usario.nombre);

                var table = document.getElementById("tabla");
                var html = '';
                var message = 'No hay registros que coincidan con "'+txt+'"';
                makeList(usario, table, html, message)
            }
        })
    }
    if (txt == '') {
        list_products()
    }
});

function update(i, n, d, p){
    var Uid = document.getElementById("Uid");
    Uid.value = i;

    var Unombre = document.getElementById("Unombre");
    Unombre.value = n;

    var Udescripcion = document.getElementById("Udescripcion");
    Udescripcion.value = d;

    var Uprecio = document.getElementById("Uprecio");
    Uprecio.value = p;
}

$("#UpdateData").click(e=>{
    var id = document.getElementById("Uid").value;
    var nombre = document.getElementById("Unombre").value;
    var descripcion = document.getElementById("Udescripcion").value;
    var precio = document.getElementById("Uprecio").value;
    precio = parseInt(precio);

    $.ajax({
        url:'http://store.test/?c=producto&a=actualizar',
        method:'POST',
        data:{
            id:id,
            nombre:nombre,
            descripcion:descripcion,
            precio:precio
        },
        success:response=>{
            var r = JSON.parse(response)
            console.log(r);
            
            Swal.fire({
                title:`${r.datos[1]}`,
                type:`${r.datos[0]}`
            })                                
        }
    })
    list_products()
})

$("#save").click(function (event) {

    //stop submit the form, we will post it manually.
    event.preventDefault();

    // Get form
    var form = $('#CreateProduct')[0];

    // Create an FormData object
    var data = new FormData(form);

    

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "http://store.test/?c=producto&a=guardar",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 6000,
        success: response=> {
            // console.log(response)
            //$("#btnSubmit").prop("disabled", false);
            var r = JSON.parse(response)
            Swal.fire({
                title:r.datos[1],
                type:r.datos[0]
            })
            if (r.datos[0] == 'success') {
                list_products()     
                clearCreateProductForm() 
            }

        },
        // error: function (e) {

        //     $("#result").text(e.responseText);
        //     console.log("ERROR : ", e);
        //     $("#btnSubmit").prop("disabled", false);

        // }
    });

});

function clearCreateProductForm() {
    var nombre = document.getElementById("nombre").value = '';
    var id_categoria = document.getElementById("id_categoria").value = '';
    var descripcion = document.getElementById("descripcion").value = '';
    var precio = document.getElementById("precio").value = '';
    var mayoreo = document.getElementById("mayoreo").value = '';
    var menudeo = document.getElementById("menudeo").value = '';
    var imagen = document.getElementById("imagen").value = '';
    var stock = document.getElementById("stock").value = '';
    var stockMin = document.getElementById("stock_min").value = '';
}

function borrar(id, nombre) {

    Swal.fire({
        title: 'Eliminar a '+ nombre +' con id '+id+'?',
        text: "Esta accion no se podrá revertir!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar !'
      }).then((result) => {
        if (result.value) {
          Swal.fire(
            'Eliminado!',
            'He retirado a '+ nombre+' del sistema !!!',
            'success'
          ),
          $.ajax({
            url:"http://store.test/?c=producto&a=borrar",
            method:"POST",
            data:{id:id},
            dataType:"JSON",
            success:function (data) {
                list_products()
            },
        });
        
        }
      })
      
    }

$("#toExcel").click(e=>{
    window.open('http://store.test/?c=producto&a=store')
})
