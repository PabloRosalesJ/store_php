$(document).ready(function (){
  listar();
  TotalDeuda();
});
var id_cliente = $('#id_cliente').val()

// fecha
var inmputMonto = document.getElementById("monto")
inmputMonto.addEventListener("keypress", soloNumeros, false);
inmputMonto.maxLength = 5;
function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
}
document.getElementById("fecha").valueAsDate = new Date();
// FIN DE FECHA

//   CREAR PAGO 
$("#pagar").click(function() {
    var id_cliente = $('#id_cliente').val()
    var monto = $('#monto').val()
    var fecha = $('#fecha').val()
    var descripcion = $('#descripcion').val()
      if (monto != '' && fecha != '') {
          
          $.ajax({
          type:'POST',
          url:'http://store.test/?c=pago&a=pago',
          data: {
              id_cliente:id_cliente,
              monto:monto,
              fecha:fecha,
              descripcion:descripcion,
          },
          success: function(){
              Swal.fire({
                      position: 'center',
                      type: 'success',
                      title: 'He añadido un pago por $'+ monto +' !!!',
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
  listar();
});

function clear(){ 
  document.getElementById('monto').value = "";    
  // document.getElementById('fecha').value = "";    
  document.getElementById('descripcion').value = "";
  listar();
};
// FIN DE PAGO

// LISTAR 

function listar(){
  
  var id = $('#id_cliente').val()
  __ajax('http://store.test/?c=pago&a=pagos', id)
  .done((info)=>{
      var usario = JSON.parse( info )
      var table = document.getElementById("tabla");
      var html = '';
      message = "Aun no hay pagos que mostrar ...";
      makeList(usario, table, html, message)
  })
} 

var search = document.querySelector("#search");
search.addEventListener('keyup', function(){
  var txt = $('#search').val();
  var id_cliente = $('#id_cliente').val()

  if (txt != '') {

      $.ajax({

          url:"http://store.test/?c=pago&a=buscar",
          method:"POST",
          data:{search:txt, id_cliente:id_cliente},
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

// BORRAR
function borrar(id, nombre) {

  Swal.fire({
      title: 'Eliminar un pago por $'+ nombre +'?',
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
          'He retirado el pago del historial !!!',
          'success'
        ),
        $.ajax({
          url:"http://store.test/?c=pago&a=borrar",
          method:"POST",
          data:{id:id},
          dataType:"JSON",
          success:function (data) {
              // alert(data.mess);
              listar();
          }
      });
      listar();
      }
    })
  listar();      
}

function __ajax(url, id_cliente) {
  var ajax = $.ajax({
      type:'POST',
      url : url,
      data:{id_cliente:id_cliente}
  })
  return ajax;
}

function makeList(usario, table, html, message) {
  if (usario.datos.length == 0) {
      html = "<td  colspan='7' class='titulo h3 text-center'>"+message+"</td >";
  }

  // var id_cliente = $('#id_cliente').val();
  var total = 0;
  for(let i = 0; i < usario.datos.length; i++){
    // if (usario.datos[i].id_cliente == parseInt(id_cliente)) {
      var desc;
      if (usario.datos[i].descripcion.length > 25) {
        desc = usario.datos[i].descripcion.substr(0,20) +'...';
      } else if(usario.datos[i].descripcion.length < 25){
        desc = usario.datos[i].descripcion;
      }

      html = html + 
      '<tr class="box text-center">'+ 
          '<th> ' + usario.datos[i].id + '</th>'+ 
          '<td> ' + '$'+ usario.datos[i].monto + '.00'+'</td>'+
          '<td> ' + usario.datos[i].fecha + '</td>'+
          '<td> ' + desc + '</td>'+
          '<td> ' + 
          `<a class='btn btn-danger btn-sm box-danger mr-3' href=" javascript:borrar(${usario.datos[i].id}, '${usario.datos[i].monto}') ">Borrar</a>`+
      '</tr class>';
       total += parseInt(usario.datos[i].monto);
    // } 
  }
  table.innerHTML = html;
  var pagos = document.getElementById("pagos")
  pagos.value = total;
}

function TotalDeuda() {
  const id = document.getElementById("id_cliente").value;
  var div = document.getElementById("TotalDeuda");
  var pagos = document.getElementById("pagos")
  var pay = document.getElementById("pay")

  $.ajax({
    type:'GET',
    url:'http://store.test/?c=pago&a=totalPagos&id',
    data:{id:id},
    success:response=>{
      var total = JSON.parse(response)
      div.value = total.datos[0].Total;   
      pay.value = (total.datos[0].Total) - (pagos.value)
    }
  })
}



function showCredit(id){
  $.ajax({
    url:'http://store.test/?c=compra&a=freeSalesbyUser',
    method:'POST',
    data:{id:id},
    success: response => {
      var r = JSON.parse(response)
      var table = document.getElementById("creditTabel")
      var html = ``
      var pagos = 0

      if (r.datos.length == 0) {
        html = '<td colspan="4"><h4 class="text-center">Sin créditos registrados</h4></td>'
      } else{
        for (let i = 0; i < r.datos.length; i++) {
          html += `
          <tr>
            <th scope="row">${r.datos[i].id}</th>
            <td>${r.datos[i].fecha}</td>
            <td>${r.datos[i].monto}</td>
            <td>${r.datos[i].nota}</td>
          </tr>` 
          pagos + (r.datos[i].monto)       
        }
      }
      table.innerHTML = html
      var flag = document.getElementById("pagos")
      flag.value = pagos
    }
  })
}

function delhistory(id) {
  Swal.fire({
    type:'warning',
    title:'eliminar a '+id
  })
}