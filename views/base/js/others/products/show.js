$(document).ready(function (){
    var category = null;

    $.ajax({
        url:'http://store.test/?c=categoria&a=listar',
        method:'GET',
        data:{},
        success: response => {
            var r = JSON.parse(response)
            category = r
            
            table = document.getElementById('id_categoria')
            html = ''

            for(let i = 0; i < category.datos.length; i++){
                if (category.datos[i].estatus != 0) {
                    html = html + `<option value="${category.datos[i].id}">${category.datos[i].nombre}</option>`;
                }
            }
            table.innerHTML = html;
        }
        
    })
    

    $.ajax({
        url :'http://store.test/?c=producto&a=listarVendidos',
        method : 'GET',
        data : {
            id : $("#id_product").html()
        },
        success : response=>{
            var data = JSON.parse(response)
            makeList(data);
        }
    })

    function makeList(data) {
        
        table = document.getElementById("tabla_vendidos");
        html = '';
        var counter = 0

        if (data.datos.length > 0) {
            for( i=0; i < data.datos.length; i++){
            counter = i + 1
            html +=
            `<th scope="row">${counter}</th>
            <td>${ data.datos[i].fecha }</td>
            <td>${ data.datos[i].cantidad }</td>
            <td>${ data.datos[i].total }</td>`
        }
        } else {
            html = `<h3 class="text-center">No hay registros</h3>`
        }

        
        table.innerHTML = html;
        
    }
    

});

$("#save").click(function (event) {

    //stop submit the form, we will post it manually.
    event.preventDefault();

    // Get form
    var form = $('#UpdateProduct')[0];
    var id = $("#id_product").html()

    // Create an FormData object
    var data = new FormData(form);
    data.append('id_prod', id);
    console.log(id);
    
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "http://store.test/?c=producto&a=actualizar",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 6000,
        success: response=> {   
            
            console.log(response);
            
            var r = JSON.parse(response)
            Swal.fire({
                title:r.datos[1],
                type:r.datos[0]
            })
            setTimeout(function(){ 
                location.reload();
            }, 2000);
            
        }
    });

});
