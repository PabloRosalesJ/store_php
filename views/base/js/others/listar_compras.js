$(document).ready(()=>{
    listar();
})

function listar() {
    var tableName = document.getElementById("vntEsp");
    $.ajax({
        url:'http://store.test/?c=compra&a=todosVE',
        method:'POST',
        data:{},
        success: response => {
            var datos = JSON.parse(response)
            makeListVE(datos, tableName)
        }
    })
}

function makeListVE(object, tableName) {
    var html = '';
    if (object.datos.length == 0) {
        html = '<td colspan="9"><h1 class="titulo"> No hay datos que mostrar </h1></td>';
    }else{
        for (let i = 0; i < object.datos.length; i++) {
            html = html + `<tr class="box">
            <th scope="row">${object.datos[i].id}</th>
                <td>${object.datos[i].fecha}</td>
                <td>${object.datos[i].id_user}</td>
                <td>${object.datos[i].nombre}</td>
                <td>${object.datos[i].producto}</td>
                <td>${object.datos[i].cantidad}</td>
                <td>$${object.datos[i].total}.00</td>
                <td>${object.datos[i].nota}</td>
                <td> 
                    <a class="btn btn-secondary box btn-sm text-white">tiket</a>
                    <a href="http://store.test/?c=usuario&a=ver&id=${object.datos[i].id_user}" class="btn btn-info box-primary btn-sm">cliente</a> </td>
            </tr>`
        }
    }

    tableName.innerHTML = html;
}


var search = document.querySelector("#buscar");
search.addEventListener('keyup', function(){
    var txt = $('#buscar').val();

    var alertFilter = document.getElementById("alertFilter");

    if (txt != '') {
        alertFilter.innerHTML = "Filtro activo";
        $.ajax({

            url:"http://store.test/?c=compra&a=SchTodosVE",
            method:"GET",
            data:{search:txt},
            dataType:"text",

            success:function (data) {

                var usario = JSON.parse( data )
                var tableName = document.getElementById("vntEsp");
                makeListVE(usario, tableName)
            }
        })
    } else if(txt == ''){
        alertFilter.innerHTML = "";
        listar();
    }
});


$("#toPDF").click(()=>{
    window.open("http://store.test/?c=compra&a=PDF", "Reporte para imprimir", "width=900")
})

// <-------->   ALL TO FREE SALES   <--------->

function listarVL(data, table) {
    var html = '';
            
            if (data.datos.length == 0) {
                html = '<td colspan="9"><h1 class="titulo"> No hay datos registrados </h1></td>';
            }
            else{
                for (let i = 0; i < data.datos.length; i++) {
                    html = html + `<tr class="box">
                    <th scope="row">${data.datos[i].id}</th>
                    <td>${data.datos[i].fecha}</td>
                    <td>${data.datos[i].id_cliente}</td>
                    <td>${data.datos[i].nombre_cliente}</td>
                    <td>$${data.datos[i].monto}.00</td>
                    <td>${data.datos[i].nota}</td>
                    <td class="text-center"><button class="btn btn-info btn-sm box-primary">Tiket</button>
                    <a href="http://store.test/?c=usuario&a=ver&id=${data.datos[i].id}" class="btn btn-secondary box btn-sm">Ver cliente</a> </td>
                    </tr>`
                }
            }
            table.innerHTML = html;
}

$("#free_sale_controll").click(a=>{
    $.ajax({
        method:'POST',
        url:'http://store.test/?c=compra&a=allFreeSAles',
        data:{},
        success:response=>{
            const data = JSON.parse(response);
            var table = document.getElementById("table-free");
            listarVL(data, table)
        }
    })
})

var searchVL = document.getElementById("buscarVL");
searchVL.addEventListener('keyup', function(){
    var txt = $("#buscarVL").val();

    var alertFilter = document.getElementById("alertFilterVL");

    if (txt != '') {
        alertFilter.innerHTML = "Filtro activo";
        $.ajax({
            url:"http://store.test/?c=compra&a=buscarVL",
            method:"POST",
            data:{search:txt},
            dataType:"text",
            success:response=>{
                const data = JSON.parse(response);
                var table = document.getElementById("table-free");
                listarVL(data, table)
            }
        })
    } else if(txt == ''){
        alertFilter.innerHTML = "";
        listar();
    }
});

