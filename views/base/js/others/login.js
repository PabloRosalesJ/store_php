var alerta = document.getElementById("alert")

$("#").click(e=>{
    var username = $("#username").val()
    var password = $("#password").val()
    
    $.ajax({
        url:'http://store.test/?c=usuario&a=log_in',
        method:'POST',
        data:{
            username:username,    
            password:password
            },
        success: response=>{
            var r =JSON.parse(response)
                var html = `
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>`  
              alerta.innerHTML = html              
            
        }
    })
})

