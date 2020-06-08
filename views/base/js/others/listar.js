//   LISTA DE CLIENTES
$(document).ready(function (){
    listar();
});

var server = 'http://store.test/?c=usuario&a=listar&p='
let indexp = 1


function listar(){
    __ajax( server+indexp, '')
    .done((info)=>{
        var usario = JSON.parse( info )
        var table = document.getElementById("listar");
        var html = '';
        message = "Aun no hay datos para mostrar";
        makeList(usario, table, html, message)
    });
} 

var search = document.querySelector("#search");
search.addEventListener('keyup', function(){
    var txt = $('#search').val();
    if (txt != '') {

        $.ajax({

            url:"http://store.test/?c=usuario&a=buscar",
            method:"POST",
            data:{search:txt},
            dataType:"text",

            success:function (data) {

                var usario = JSON.parse( data )
                var table = document.getElementById("listar");
                var html = '';
                var message = 'No hay registros que coincidan con "'+txt+'"';
                makeListSearch(usario, table, html, message)
            }
        })
    }
    if (txt == '') {
        listar()
    }
});

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
            url:"http://store.test/?c=usuario&a=eliminar",
            method:"POST",
            data:{id:id},
            dataType:"JSON",
    
            success:function (data) {
                // alert(data.mess);
                listar();
            }
        });
        listar();
        }
      })
    listar();      
}

function __ajax(url, data) {
    var ajax = $.ajax({
        'method' : 'POST',
        'url' : url,
        'data' : data
    })
    return ajax;
}

function makeList(usario, table, html, message) {
    if (usario.datos.length == 0) {
        html = "<td  colspan='7' class='titulo h3 text-center'>"+message+"</td >";
    }
    for(let i = 0; i < usario.datos.length; i++){

        if (usario.datos[i].estatus == 1) {
            estatus = "<span class='badge badge-pill badge-success box-success'>Activo</span>";
        }else{
            estatus = "<span class='badge badge-pill badge-danger box-danger'>Inactivo</span>";
        }
        var id = usario.datos[i].id 
        var nombre = usario.datos[i].nombre
        var apellidos = usario.datos[i].apellidos
        var direccion = usario.datos[i].direccion
        var telefono = usario.datos[i].telefono
        
        html = html + 
        '<tr class="box">'+ 
            '<th> ' + id + '</th>'+ 
            '<td> ' + nombre + '</td>'+ 
            '<td> ' + apellidos + '</td>'+ 
            '<td> ' + direccion + '</td>'+ 
            '<td> ' + telefono + '</td>'+ 
            '<td> ' + estatus+ '</td>'+ 
            '<td> ' + 
            `<a class='btn btn-danger btn-sm box-danger' href=" javascript:borrar(${usario.datos[i].id}, '${usario.datos[i].nombre}') ">Borrar</a>
            <a class='btn btn-info btn-sm box-primary' href="http://store.test/?c=usuario&a=ver&id=${usario.datos[i].id}">Ver</a>
            <a class='btn btn-secondary btn-sm box text-white' onclick="update(${id},'${nombre}','${apellidos}','${direccion}', '${telefono}')" data-toggle="modal" data-target="#Update" >Actualizar</a>`+
            '</td>'+ 
        '</tr class>';
    }
    var p = usario.total[0]
    var paginate = document.getElementById("pagination");
    var link = ''

    for (let i = 0; i < p; i++) {
        l = i+1;
        link += `
            <li class="page-item nav-item box-primary">
                <a class="page-link nav-link active" href="javascript:ChSrvr(${l})">${l}</a>
            </li>
        `   
    }
    paginate.innerHTML = link
    table.innerHTML = html;
}

//   FIN DE LISTA DE CLIENTES
function update(i,n,a,d,t){
    var Uid = document.getElementById("Uid");
    Uid.value = i;

    var Unombre = document.getElementById("Unombre");
    Unombre.value = n;

    var Uapellidos = document.getElementById("Uapellidos");
    Uapellidos.value = a;

    var Udireccion = document.getElementById("Udireccion");
    Udireccion.value = d;

    var Utelefono = document.getElementById("Utelefono");
    Utelefono.value = t; 
}

$("#UpdateUser").click(e=>{
    var id = document.getElementById("Uid").value;
    var nombre = document.getElementById("Unombre").value;
    var apellidos = document.getElementById("Uapellidos").value;
    var direccion = document.getElementById("Udireccion").value;
    var telefono = document.getElementById("Utelefono").value;

    $.ajax({
        url:'http://store.test/?c=usuario&a=Update',
        type:'POST',
        data:{
            id:id,
            nombre:nombre,
            apellidos:apellidos,
            direccion:direccion,
            telefono:telefono,
        },
        success: response =>{
            var r = JSON.parse(response)
            if(r.datos[0] == 'succes'){
                Swal.fire({
                    type: 'success',
                    title: 'Cambios Guardados',
                    timer: 1500
                })
                listar()
            }else if(r.datos[0] == 'error'){
                Swal.fire({
                    type: 'error',
                    title: 'Error al procesar datos',
                    text: 'intenta de nuevo',
                    timer: 1500
                })
            }
        }        
    })
})

function ChSrvr(p){
    url = server + p;
    p = '';
    $.ajax({
        url: url,
        method:'GET',
        data:{},
        success: response => {
            var usario = JSON.parse( response )
            var table = document.getElementById("listar");
            var html = '';
            message = "Aun no hay datos para mostrar";
            makeList(usario, table, html, message)
        }
    })
}

function makeListSearch(usario, table, html, message) {
    if (usario.datos.length == 0) {
        html = "<td  colspan='7' class='titulo h3 text-center'>"+message+"</td >";
    }
    for(let i = 0; i < usario.datos.length; i++){

        if (usario.datos[i].estatus == 1) {
            estatus = "<span class='badge badge-pill badge-success box-success'>Activo</span>";
        }else{
            estatus = "<span class='badge badge-pill badge-danger box-danger'>Inactivo</span>";
        }
        var id = usario.datos[i].id 
        var nombre = usario.datos[i].nombre
        var apellidos = usario.datos[i].apellidos
        var direccion = usario.datos[i].direccion
        var telefono = usario.datos[i].telefono
        
        html = html + 
        '<tr class="box">'+ 
            '<th> ' + id + '</th>'+ 
            '<td> ' + nombre + '</td>'+ 
            '<td> ' + apellidos + '</td>'+ 
            '<td> ' + direccion + '</td>'+ 
            '<td> ' + telefono + '</td>'+ 
            '<td> ' + estatus+ '</td>'+ 
            '<td> ' + 
            `<a class='btn btn-danger btn-sm box-danger' href=" javascript:borrar(${usario.datos[i].id}, '${usario.datos[i].nombre}') ">Borrar</a>
            <a class='btn btn-info btn-sm box-primary' href="http://store.test/?c=usuario&a=ver&id=${usario.datos[i].id}">Ver</a>
            <a class='btn btn-secondary btn-sm box text-white' onclick="update(${id},'${nombre}','${apellidos}','${direccion}', '${telefono}')" data-toggle="modal" data-target="#Update" >Actualizar</a>`+
            '</td>'+ 
        '</tr class>';
    }
    
    table.innerHTML = html;
}