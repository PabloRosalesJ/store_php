//   CREAR CATEGORIA

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