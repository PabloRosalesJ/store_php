$(document).ready(e=>{
    listar();
})

$("#save").click(e=>{
    var username = $("#username").val();
    var nombre = $("#nombre").val();
    var apellidos = $("#apellidos").val();
    var telefono = $("#telefono").val();
    var password = $("#password").val();
    var passwordConfirm = $("#passwordConfirm").val();

    $.ajax({
        url:'http://store.test/?c=usuario&a=createAdmin',
        method:'POST',
        data:{
            username:username,
            nombre:nombre,
            apellidos:apellidos,
            telefono:telefono,
            password:password,
            passwordConfirm:passwordConfirm
        },
        success:response=>{
            var r = JSON.parse(response);
            if (r.datos[0] != 'error') {
                Swal.fire({
                    type:r.datos[0],
                    title:r.datos[1],
                })
                clear();
                listar();
            }
            else{
                Swal.fire({
                    type:r.datos[0],
                    title:r.datos[1]
                }) 
            }
        }
    })
})

function clear() {
    var username = document.getElementById("username").value = '';
    var nombre = document.getElementById("nombre").value = '';
    var apellidos = document.getElementById("apellidos").value = '';
    var telefono = document.getElementById("telefono").value = '';
    var password = document.getElementById("password").value = '';
    var passwordConfirm = document.getElementById("passwordConfirm").value = '';
}

function listar() {
    $.ajax({
        url:'http://store.test/?c=usuario&a=listAdmin',
        method: 'POST',
        data:{},
        success: response=>{
            var r = JSON.parse(response);
            var table = document.getElementById("table");
            var html = '';
            for (let i = 0; i < r.datos.length; i++) {
                html += `
                <tr class="box ">
                    <td class="titulo">${r.datos[i].id}</td>
                    <td >${r.datos[i].username}</td>
                    <td>${r.datos[i].nombre}</td>
                    <td>${r.datos[i].telefono}</td>
                    <td> 
                        <a href="javascript:borrar('${r.datos[i].id}','${r.datos[i].nombre}')" class="btn btn-outline-danger btn-sm">&times;</a>
                    </td>
                </tr>`                
            }
            table.innerHTML = html;
        }
    })
}

function borrar(id,n) {
    Swal.fire({
        title: "Precaución!",
        text: 'Remover al administrador '+ n +', id '+id+'?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar !',
        cancelButtonText: 'No, espera ...!'
      }).then((result) => {
        if (result.value) {
          
          $.ajax({
            url:"http://store.test/?c=usuario&a=borrarAdmin",
            method:"POST",
            data:{id:id},
            dataType:"JSON",
            success: r => {
                Swal.fire({
                    type:r.datos[0],
                    title:r.datos[0],
                    text:r.datos[1]
                })
                listar();
            }
        })
        }
      })
}

$('#backup').click(e=>{
    setTimeout(() => {
        Swal.fire({
            type: 'success',
            title :'BackUP generado con éxito',
            text : 'El archivo se encuentra en la carpeta de descargas, copelo a su USB !!!'
        })
    }, 3000);

    window.open("http://store.test/?c=producto&a=BackUP","")
})