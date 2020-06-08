$(document).ready(e=>{
    listSurtir();
    Credits();
})

function listSurtir() {
    $.ajax({
    url:'http://store.test/?c=producto&a=listSurtir',
    method:'POST',
    data:{},
    success:response=>{
        var r = JSON.parse(response);
        var table = document.getElementById("enDesabasto");
        var html = ''
        if (r.datos.length != 0) {
            for (let i = 0; i < r.datos.length; i++) {
                html = html + 
                `<tr class="text-center box">
                    <th scope="row">${r.datos[i].id}</th>
                    <td>${r.datos[i].nombre}</td>
                    <td class="titulo">${r.datos[i].faltantes}</td>
                </tr>`
            }
        } else{
            html = '<td colspan="4" class="titulo text-center box">El alamacén está al 100%</td>';
            var btnDesabasto = document.querySelector("#btnDesabasto");
            btnDesabasto.style.display = 'none'
        }
        table.innerHTML = html;
    }
})
}

function Credits() {
    $.ajax({
    url:'http://store.test/?c=usuario&a=userWhitCredit',
    method:'POST',
    data:{},
    success:response=>{
        var r = JSON.parse(response);
        var table = document.getElementById("Credits");
        var html = ''
        if (r.datos.length != 0) {
            for (let i = 0; i < r.datos.length; i++) {
                html = html + 
                `<tr class="text-center box">
                    <th scope="row">${r.datos[i].id}</th>
                    <td>${r.datos[i].Nombre}</td>
                    <td><a href="http://store.test/?c=usuario&a=ver&id=${r.datos[i].id}" >ver</a></td>
                </tr>`
            }
        } else{
            html = '<td colspan="3" class="titulo text-center box">Aún no has otorgado créditos</td>';
        }
        table.innerHTML = html;
    }
})
}

$("#btnDesabasto").click(e=>{
    window.open("http://store.test/?c=producto&a=SurtirPDF", "Lista para surtir", "width=720")
})