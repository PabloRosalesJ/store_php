//   CREAR PREODUCTO    

$("#saveProduct").click(function() {
    var categoria = $('#categoria').val()
    var nombre = $('#nombre').val()
    var desc = $('#desc').val()
    var precio = $('#precio').val()
    var stock = $('#stock').val()
    var stockMin = $('#stockMin').val()
    
        if (categoria != '' && nombre != '' && desc != '' && precio != '' && stock != '') {
            
            $.ajax({
            type:'POST',
            url:'http://store.test/?c=producto&a=guardar',
            data: {
                categoria:categoria,
                nombre:nombre,
                desc:desc,
                precio:precio,
                stock:stock,
                stockMin:stockMin
            },
            success: response=>{
                var r = JSON.parse(response)
                Swal.fire({
                    type: r.datos[0],
                    title: r.datos[0],
                    text: r.datos[1],
                    timer:1500
                })

                if (r.datos[0] == 'success') {
                    return clear();
                }
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
    document.getElementById('desc').value = "";    
    document.getElementById('precio').value = "";    
    document.getElementById('stock').value = "";
};