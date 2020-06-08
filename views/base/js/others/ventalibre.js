//          --- COMPRA ESPESÍFICA ---

function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
}

var id_user = document.getElementById("id_user");
id_user.addEventListener("keypress", soloNumeros, false);

var montoVl = document.getElementById("montoVl");
montoVl.addEventListener("keypress", soloNumeros, false)
montoVl.maxLength = 4;

document.getElementById("fecha").valueAsDate = new Date();

// CONSEGUIR CLIENTE

$("#select").click(function () {
    var inputid = $("#id_user").val();
    var inputNombre = $("#nombre_usario").val();

    var search;

    if (inputid == '' && inputNombre == '') {
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Necesito un usario!',
            footer: '<a href="http://store.test/?c=usuario&a=index">Lista de usarios?</a>'
        })
    } else {

        if (inputid != '') {
            search = inputid
            inputNombre = '';
        } else if (inputNombre != '') {
            search = inputNombre
            inputid = '';
        }
        select(search)
    }
})

function select(search) {
    $.ajax({
        url: "http://store.test/?c=usuario&a=select",
        method: "POST",
        data: { search: search },
        dataType: "text",
        success: function (data) {
            var usuario = JSON.parse(data)
            if (usuario.datos[0] == false) {
                Swal.fire({
                    type:'error',
                    title:'Oooops ....',
                    text:'Usuario deshabilitado'
                })
                cliente_datos.value = '';
                id_datos.value = 0;
            }else{
                setUser(usuario)
            }
        }
    })
}

function setUser(usario) {
    var cliente_datos = document.getElementById("cliente_datos");
    var id_datos = document.getElementById("id_datos");

    if (usario.datos.length == 0) {
        
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Mmmm ... no me suena ese cliente ...'
          })

        cliente_datos.value = '';
        id_datos.value = 0;
    } else {
        if (usario.datos[0].estatus == 0) {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Cliente desabilitado ... ',
                footer: '<a href="http://store.test/?c=usuario&a=index"> puede habilitar de nuevo al cliente aqui...</a>'
              })
        } else {
            cliente_datos.value = usario.datos[0].nombre + " " + usario.datos[0].apellidos;
            id_datos.value = usario.datos[0].id;
            var details = document.getElementById("goToDetaills");
            details.innerHTML = `<a class="btn btn-info btn-sm btn-block" href="http://store.test/?c=usuario&a=ver&id=${usario.datos[0].id}">Detalles</a>`;
        }
        
    }
}

function clear(){
    // document.getElementById("id_user").value = '';
    // document.getElementById("nombre_usario").value = '';

    // document.getElementById("cliente_datos").value = '';
    // document.getElementById("id_datos").value = '';

    document.getElementById("montoVl").value = '';
    document.getElementById("descripcion").value = '';
}

$("#endSale").click(data=>{
    id_cliente = document.getElementById("id_datos").value;
    if (id_cliente != 0 && id_cliente != '') {

        cliente = document.getElementById("cliente_datos").value;
        monto = document.getElementById("montoVl").value;
        nota = document.getElementById("descripcion").value;
        
        if (monto != 0 && monto != '' && nota != '') {

            $.ajax({
                method:'POST',
                url:'http://store.test/?c=compra&a=doFreeSale',
                data:{
                    id_cliente:id_cliente, 
                    monto:monto,      
                    nota:nota,       
                    cliente:cliente},
                success:response=>{
                    const res = JSON.parse(response)
                    
                    var type = res.datos[0];
                    var txt = res.datos[1];
                    if (txt != '') {
                        Swal.fire({
                            type:type,
                            title:txt,
                            timer:1500
                        })
                    }
                    if (type == 'success') {
                        clear()
                    }
                    
                }
                })
            
        }else{
            Swal.fire({
                type:'warning',
                title:'Alto !!!',
                text:'Campos incompletos'
            })
        }

    }else{
        Swal.fire({
            type:'error',
            title:'Alto !',
            text:'Necesito un usario !!'
        })
    }
    
})

// FIN DE CONSEGUIR CLIENTE