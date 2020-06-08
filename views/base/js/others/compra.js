//          --- COMPRA ESPESÍFICA ---
$(document).ready(function (){
    listarCarrito();
});


function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
}

var id_user = document.getElementById("id_user");
id_user.addEventListener("keypress", soloNumeros, false);

var precioProducto = $("#precio").val();
var total = document.getElementById("total");
total.value = 0;

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
            cliente_datos.value = usario.datos[0].nombre + " " + usario.datos[0].apellidos;
            id_datos.value = usario.datos[0].id;
    }


}

// FIN DE CONSEGUIR CLIENTE

// CONSEGUIR PRECIO UNITARIO

$("#producto").change(function () {

    var id = $('#producto').val();
    var inputprecio = document.getElementById("precio");
    var inputstock = document.getElementById("stock");

    $.ajax({
        url: "http://store.test/?c=producto&a=precio",
        method: "POST",
        data: { id: id },
        dataType: "text",

        success: function (data) {

            var precio = JSON.parse(data)
            inputprecio.value = precio.datos[0].precio
            inputstock.value = precio.datos[0].stok
            precioProducto = precio.datos[0].precio
        }
    })
});

// FIN DE CONSEGUIR PRECIO UNITARIO

// FIN SELECCIONAR USARIO

var inmputpiezas = document.getElementById("piezas")
inmputpiezas.addEventListener("keypress", soloNumeros, false);
inmputpiezas.maxLength = 2;

// HACER CARRITO

//      DETALLES CARRITO
var productonombre;
$("#producto").change(function () {
    productonombre = $("#producto option:selected").text();
});

var productos = [];

function clear(){
    document.getElementById('precio').value = "";    
    document.getElementById('stock').value = "";    
    document.getElementById('piezas').value = "";    
    document.getElementById('nota').value = "";    
    document.getElementById('producto').value = "";
    document.getElementById('total').value = 0;    
    productonombre = undefined;    
};

$("#order").click(e=>{
    var id_user = document.getElementById("id_datos").value; 
    var id_prod = $('#producto').val();
    var nombre = document.getElementById("cliente_datos").value;
    var producto = productonombre
    var cantidad = document.getElementById("piezas").value; 
    var precio = document.getElementById("precio").value; 
    var total = parseInt(cantidad) * parseInt(precio);
    var stock = document.getElementById("stock").value; 
    var nota = document.getElementById("nota").value; 
    var fecha = document.getElementById("fecha").value; 
    var inputPz = document.getElementById("piezas");

    if (id_user =='') {
        noUser()
    }else{
        if (cantidad != '') {
            if ( parseInt(cantidad) > parseInt(stock)) {
            Swal.fire({
                type:'error',
                title:'Piezas insufucuentes !',
                timer:1000
            })
            }else{
                $.ajax({
                    url:'http://store.test/?c=carrito&a=agregar',
                    method:'POST',
                    data:{
                        id_user:id_user,
                        id_prod:id_prod,
                        nombre:nombre,
                        producto:producto,
                        cantidad:cantidad,
                        total:total,
                        nota:nota,
                        fecha:fecha,
                        precio:precio
                    },
                    success:response=>{
                        var r = JSON.parse(response);
                        // console.log(response)
                        if (r.datos[0] == 'error') {
                            Swal.fire({
                                type:`${r.datos[0]}`,
                                title:`${r.datos[1]}`
                            })                             
                        }else{
                            listarCarrito();
                            clear();
                        }
                    }
                })
                inputPz.className = "form-control";
            }

        }else{
            inputPz.className = "form-control is-invalid";
        }
    }
})

function noUser() {
    Swal.fire({
        type:'error',
        title:'Necesito un cliente...',
        timer:1000
    })
}

function listarCarrito() {
    $.ajax({
        url:'http://store.test/?c=carrito&a=listarCarrito',
        method: 'POST',
        success:response=>{
            var res = JSON.parse(response);
            var html = '';
            var table = document.getElementById("lista_Carrito");
            if (res.datos.length != 0) {
                $('#id_user').attr('readonly', true);
                $('#nombre_usario').attr('readonly', true);

                var n =  document.getElementById("cliente_datos");
                n.value = res.datos[0].nombre;
                // alert(n)
                var id = document.getElementById("id_datos");
                id.value = res.datos[0].id_user;
                // alert(id)
                var totalInput = document.getElementById("total");
                var total = 0;

                for (let i = 0; i < res.datos.length; i++) {
                    var index = i + 1;
                    html = html + 
                    '<tr class="box">'+ 
                        '<th> ' +  index + '</th>'+ 
                        '<td> ' + res.datos[i].producto + '</td>'+
                        '<td> ' + res.datos[i].cantidad + '</td>'+
                        '<td> $' + res.datos[i].precio + '.00</td>'+
                        '<td> ' + res.datos[i].nota + '</td>'+
                        '<td> $' + res.datos[i].total + '.00</td>'+
                        '<td class="text-center" > ' + '<a href="javascript:deleteby('+res.datos[i].id_prod+', '+res.datos[i].cantidad+')" class ="btn btn-danger btn-sm box-danger > <span aria-hidden="true">&times;</span> </a>' + 
                    '</tr>';
                    total += parseInt(res.datos[i].total);
                }
                totalInput.value = total;
            } else{
                html = "<td colspan='7' class='text-center titulo'><h3>El Carrito está vacio</h3></td>"
                $('#id_user').attr('readonly', false);
                $('#nombre_usario').attr('readonly', false);
                clear();
            }
            table.innerHTML = html;
        }
    })
}

function deleteby(id,pz) {
    $.ajax({
        url:'http://store.test/?c=carrito&a=deleteBy',
        method:'POST',
        data:{id:id},
        success:a=>{
            listarCarrito();
        }
    })
    $.ajax({
        url: 'http://store.test/?c=producto&a=abastecer',
        method: 'POST',
        data: { id: id, pz:pz },
        success: response => {
        }
    })


}

$("#endSale").click(e=>{
    var table = document.getElementById("lista_Carrito");
    
        var tot = document.getElementById('total');    
        Swal.fire({
            title: 'Finalizar compra?',
            text: "Ralizar compra por: $"+tot.value,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Finalizar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url:'http://store.test/?c=carrito&a=endSales',
                    method:'POST',
                    data:{},
                    success:response=>{
                        var r = JSON.parse(response)
                        console.log(r)
                        if (r.datos.length == 0) {
                            Swal.fire({
                                type:`error`,
                                title:`Carrito vacio`,
                                timer:1500
                            })
                        }else{
                        Swal.fire({
                            type:`${r.datos[0]}`,
                            title:`${r.datos[0]}`,
                            timer:1500
                        })    
                        listarCarrito();
                        console.log(r);}
                    }
                })
            }
        })
})
// var table = document.getElementById("lista_Carrito");
// alert(table.innerHTML)
// $("#order").click(function () {
//     var totalCompra = document.getElementById("total").value;
//     var id_user = document.getElementById("id_datos").value;
//     var cliente_datos = document.getElementById("cliente_datos").value;

//     if (id_user != '' && id_user != 0) {
//         var producto = {
//             id_user:0,
//             id_prod: 0,
//             piezas: 0,
//             nota: "",
//             nombre_prod: "",
//             nombre_cliente:"",
//             precio: 0,
//             subtotal: 0
//         }
//         var productoid = $('#producto').val();
//         var piezas = $("#piezas").val();
//         var nota = $("#nota").val();
//         var inputPz = document.getElementById("piezas");
//         var inStock = document.getElementById("stock").value;
//         inStock = parseInt(inStock);

       
//         if (piezas != 0 && piezas != '') {
//             producto.id_user = id_datos.value
//             producto.id_prod = productoid
//             producto.piezas = piezas
//             producto.nota = nota
//             producto.nombre_prod = productonombre
//             producto.nombre_cliente = cliente_datos
//             producto.precio = precioProducto
//             producto.subtotal = precioProducto * piezas

//             if ( producto.nombre_prod == undefined) {
//                 Swal.fire({
//                     type: 'warning',
//                     title: 'Aún no me has dicho que vas a vender',
//                     footer: 'Selecciona algo de la lista de productos'
//                   })
//             } else {
//                 if (piezas <= inStock) {
                    
//                     productos.push(producto)
//                     if (piezas != 0 && piezas != '') {
                        
//                         listaCarrito(productos)
//                         inputPz.className = "form-control";
//                         clear()
//                     }
//                     else{
//                         Swal.fire({
//                             type: 'error',
//                             title: 'Date un tiro ...',
//                             text: 'Esta madre ha colapsado ...',
//                             timer: 1500
//                         })
//                     }

//                } else {
//                   Swal.fire({
//                       type: 'error',
//                       title: 'Piezas insuficientes',
//                       timer: 1500
//                   })
//                }
//             }
//         } else {
//             inputPz.className = "form-control is-invalid";
//         }
//     } else {
//         Swal.fire({
//             type:'error',
//             title:'Ooops ...',
//             text: 'Necesito un usario para realizar una venta ...'
//         })
        
//     }
// })



// function listaCarrito(lista) {
//     var html = "";
//     var table = document.getElementById("lista_Carrito");
    
//     for(let i = 0; i < lista.length; i++){
//         index = i+1;
//         html = html + 
//         '<tr class="box">'+ 
//             '<th> ' + index + '</th>'+ 
//             '<td> ' + lista[i].nombre_prod + '</td>'+
//             '<td> ' + lista[i].piezas + '</td>'+
//             '<td> $' + lista[i].precio + '.00</td>'+
//             '<td> ' + lista[i].nota + '</td>'+
//             '<td> $' + lista[i].subtotal + '.00</td>'+
//             '<td class="text-center" > ' + '<a href="javascript:unset('+i+')" class ="btn btn-danger btn-sm box-danger > <span aria-hidden="true">&times;</span> </a>' + 
//         '</tr>';

//     }
//     table.innerHTML = html;

//     var totalList = 0;
//     for (let i = 0; i < productos.length; i++) {
//         totalList += productos[i].subtotal;
//     }
//     total.value = totalList;
// }

    //      FIN DETALLES CARRITO

// ACCIONES DEL CARRITO

// function unset(index) {
    
//     productos.splice(index);
//     listaCarrito(productos);
    
// }

// $("#endSale").click(()=>{
//     if (productos.length == 0) {
//         Swal.fire({
//             type:'warning',
//             title:'El carrito está vacio ...',
//             timer:1500
//         });
//     } else {
//         Swal.fire({
//             type: 'warning',
//             title: 'Terminar compra?',
//             text:'Generar compra por $' + total.value,
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Finalizar'
//           }).then((result) => {
//             if (result.value) {
//               Swal.fire(
//                 'Genial !!!',
//                 'Compra finalizada',
//                 'success'
//               ) 
//               console.log(productos)
//               for (let i = 0; i < productos.length; i++) {
//                 let id_user = productos[i].id_user,
//                 id_prod = productos[i].id_prod,
//                 cantidad = productos[i].piezas,
//                 total = productos[i].subtotal,
//                 nota = productos[i].nota,
//                 nombre = productos[i].nombre_cliente,
//                 producto = productos[i].nombre_prod 
                
//                 $.ajax({
//                     method:'POST',
//                     url:'http://store.test/?c=compra&a=compra',
//                     data:{
//                         id_user : id_user,
//                         id_prod : id_prod,
//                         cantidad : cantidad,
//                         total : total,
//                         nota : nota,
//                         nombre : nombre,
//                         producto : producto
//                     },
//                     dataType:'text',
//                     success: data =>{
                        
//                     },
//                     error: e=>{
//                         Swal.fire({
//                             type:error,
//                             title:'hubo un error',
//                             tetx: e
//                         })
//                     }
//                 })
//             }
//             clear()
//             productos = []
//             listaCarrito(productos)
//             }
//           })
//         }
// })


