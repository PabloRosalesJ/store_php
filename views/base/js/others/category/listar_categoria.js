$(document).ready(function (){
    listar();
});

function listar(){
    __ajax('http://store.test/?c=categoria&a=listar', '')
    .done((info)=>{
        var usario = JSON.parse( info )
        var table = document.getElementById("tabla");
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

            url:"http://store.test/?c=categoria&a=buscar",
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
            url:"http://store.test/?c=categoria&a=borrar",
            method:"POST",
            data:{id:id},
            dataType:"JSON",
            success:function (data) {
                // alert(data.mess);
                listar();
            }
        });
        // listar();
        }
      })
    // listar();      
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
        html = html + 
        '<tr class="box text-center">'+ 
            '<th> ' + usario.datos[i].id + '</th>'+ 
            '<td> ' + usario.datos[i].nombre + '</td>'+
            '<td> ' + 
                `<a class='btn btn-danger btn-sm box-danger mr-3' href=" javascript:borrar(${usario.datos[i].id}, '${usario.datos[i].nombre}') ">Borrar</a>
                <a class='btn btn-primary btn-sm box-primary mr-3' href="http://store.test/?c=categoria&a=listByCategory&id=${usario.datos[i].id}&name=${usario.datos[i].nombre}" >Productos relacionados</a>`+
            '</td> ' +
        '</tr class>';

    }
    table.innerHTML = html;
}


$("#saveCategory").click(function() {
    var nombre = $('#nombre').val()
    
        if (nombre != '' && nombre != NaN) {
            
            $.ajax({
            type:'POST',
            url:'http://store.test/?c=categoria&a=guardar',
            data: {
                nombre:nombre
            },
            success: function(){
                Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'He registrado la categoria '+ nombre +' con éxito !!!',
                        showConfirmButton: false,
                        timer: 1750,
                        
                    }),
            clear()
            listar();
        },
        error:function(){
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Hubo un error inesperado...',
                footer: 'intente de nuevo'
              })
        }
        })
    }// cierre de if
    else{
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'llena todos los campos...',
            footer: 'intente de nuevo'
          })
    }    
});

function clear(){
    document.getElementById('nombre').value = "";    
};