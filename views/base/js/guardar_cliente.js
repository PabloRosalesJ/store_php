//   CREAR CLIENTE

$("#saveUser").click(function() {
    var nombre = $('#nombre').val(),
        apellidos = $('#apellidos').val(),
        direccion = $('#direccion').val(),
        telefono = $('#telefono').val()

        if (nombre != '' && apellidos != '' && direccion != '' && telefono != '') {
            
            $.ajax({
            type:'POST',
            url:'http://store.test/?c=usuario&a=guardar',
            data: {
                nombre:nombre,
                apellidos:apellidos,
                direccion:direccion,
                telefono:telefono
            },
            success: function(){
                Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'He registrado a '+ nombre +' con éxito !!!',
                        showConfirmButton: false,
                        timer: 1750,
                        
                    }),
            clear()
        },
        error:function(){
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Hubp un error inesperado...',
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
    document.getElementById('apellidos').value = "";
    document.getElementById('direccion').value = "";
    document.getElementById('telefono').value = "";
    
};

var inputTelefono = document.getElementById("telefono")

telefono.addEventListener("keypress", soloNumeros, false);

inputTelefono.maxLength = 10;

function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
}

//   FIN DE CREAR CLIENTE
 



