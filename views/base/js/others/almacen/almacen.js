$(document).ready(e => {
    var insertPlace = document.getElementById("insert");
    insertPlace.style.display = 'none';
    enDesabasto();
    historyAbastos();
})

var piezas = document.getElementById("piezas")

piezas.addEventListener("keypress", soloNumeros, false);

piezas.maxLength = 5;

function soloNumeros(e) {
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
}

function notifyError(e) {
    Swal.fire({
        type: 'warning',
        title: e
    })
    var insertPlace = document.getElementById("insert");
    insertPlace.style.display = 'none';
    var table = document.getElementById("tableSelect");
    table.innerHTML = '';

    var piezas = document.getElementById("piezas")
    piezas.value = '';
}

function showTable(object) {
    var table = document.getElementById("tableSelect");
    var html = ''
    for (let i = 0; i < object.datos.length; i++) {
        html = html + `<tr class="text-center box">
                    <th scope="row"> 
                        <input class="form-control" type="text" id="id_prod" style="width:75px" value="${object.datos[i].id}" readonly> 
                    </th>
                    <td>
                        <input class="form-control" type="text" id="nombre_prod" style="width:250px" value="${object.datos[i].nombre}" readonly> 
                        
                    </td>
                    <td class="titulo">${object.datos[i].stok}</td>
                    <td>${object.datos[i].min}</td>
                </tr>`
    }
    table.innerHTML = html;
    var insertPlace = document.getElementById("insert");
    insertPlace.style.display = 'block';
}

var inputId = document.querySelector('#id');
inputId.addEventListener('focus', e => {
    var n = document.getElementById("nombre");
    n.value = '';
})
var inputN = document.querySelector('#nombre');
inputN.addEventListener('focus', e => {
    var n = document.getElementById("id");
    n.value = '';
})

$("#select").click(e => {
    var id = document.getElementById("id").value;
    var nombre = document.getElementById("nombre").value;
    var search = null;

    if (id == '') {
        search = nombre;
    } else if (nombre == '') {
        search = id;
    }

    if (search != '') {
        $.ajax({
            url: 'http://store.test/?c=producto&a=selectOne',
            method: 'POST',
            data: { search: search },
            success: response => {
                var r = JSON.parse(response);
                if (r.datos.length == 0) {
                    var e = "Ningún dato coincide..."
                    notifyError(e);
                } else {
                    showTable(r)
                }
            }
        })
    } else {
        notifyError("Selecciona algo")
    }

})

$("#endInsert").click(e => {
    var id = document.getElementById("id_prod").value;
    var pz = document.getElementById("piezas").value;
    var nombre = document.getElementById("nombre_prod").value;
    
    if (pz != '' && pz != 0) {
        Swal.fire({
            title: 'Finalizar abestecimiento',
            text: "Estas seguro que las piezas son correctas ?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, adelante!',
            cancelButtonText: 'No, espera!'
        }).then((result) => {
            if (result.value) {
    
                $.ajax({
                    url: 'http://store.test/?c=producto&a=abastecer',
                    method: 'POST',
                    data: { id: id, pz:pz },
                    success: response => {
                        var r = JSON.parse(response);
                        Swal.fire({
                            type: r.datos[0],
                            title:r.datos[0],
                            text:r.datos[1],
                            timer:1750
                        })
                    }
                })
                
                $.ajax({
                    url:'http://store.test/?c=producto&a=abastos',
                    method: 'POST',
                    data:{id: id, pz:pz},
                    success:response=>{                  
                        historyAbastos();
                        enDesabasto();
                    }
                })
                clear();
            }
    
        })
    }else{
        Swal.fire(
            'Alto !',
            'Las piezas no pueden estar vacias',
            'warning'
        )
    }
})

function enDesabasto() {
    $.ajax({
        url: 'http://store.test/?c=producto&a=desabasto',
        method: 'POST',
        data: {},
        success: response => {
            var r = JSON.parse(response);
            var table = document.getElementById("enDesabasto");
            var html = ''
            if (r.datos.length != 0) {
                for (let i = 0; i < r.datos.length; i++) {
                    html = html + `<tr class="text-center box table-danger">
                        <th scope="row">${r.datos[i].id}</th>
                        <td>${r.datos[i].nombre}</td>
                        <td class="titulo">${r.datos[i].stok}</td>
                        <td>${r.datos[i].min}</td>
                    </tr>`
                }
            }else{
                html = `<td colspan="4" class="titulo text-center">Sin Datos</td>`;
            }
            table.innerHTML = html;
        }
    })
}

function clear() {
    var insertPlace = document.getElementById("insert");
    insertPlace.style.display = 'none';
    var table = document.getElementById("tableSelect");
    table.innerHTML = '';

    var piezas = document.getElementById("piezas")
    piezas.value = '';
    enDesabasto();
}

function historyAbastos() {
    $.ajax({
        url:'http://store.test/?c=producto&a=history',
        method:'POST',
        data:{},
        success:response=>{
            var r = JSON.parse(response)
            var table = document.getElementById("history");
            var html = ''
            if (r.datos.length != 0) {
                for (let i = 0; i < r.datos.length; i++) {
                    html = html + `<tr class="text-center box">
                        <th scope="row">${r.datos[i].id}</th>
                        <td>${r.datos[i].id_prod}</td>
                        <td>${r.datos[i].producto}</td>
                        <td>${r.datos[i].piezas}</td>
                        <td class="titulo">${r.datos[i].fecha}</td>
                    </tr>`
                }
            }else{
                html = `<td colspan="4" class="titulo text-center">Sin Datos</td>`;
            }
            table.innerHTML = html;
        }
    })
}

var toPDF = document.getElementById("toPDF");
toPDF.addEventListener('click', e=>{
     window.open("http://store.test/?c=producto&a=historyPDF", "Historial de Abastos", "width=720")
})

var toExcel = document.getElementById("toExcel");
toExcel.addEventListener('click', e=>{
     window.open("http://store.test/?c=producto&a=historyExcel","")
})