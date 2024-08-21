document.addEventListener('DOMContentLoaded',function(){
    var formContenido = document.querySelector('#formContenido');
    formContenido.onsubmit = function(e){
        e.preventDefault();

        var idcontenido = document.querySelector('#idcontenido').value;
        var titulo = document.querySelector('#titulo').value;
        var descripcion = document.querySelector('#descripcion').value;
        var file = document.querySelector('#file').value;
        
        if(titulo == '' || descripcion == ''){
            swal('Atencion','Todos los campos son obligatorios', 'error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/contenido/ajax-contenido.php';
        var form = new FormData(formContenido);
        request.open('POST',url,true);
        request.send(form);
        console.log(request);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var data = JSON.parse(request.responseText);
                swal({
                    title: "Crear/Actualizar Contenido",
                    type: "success",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: true
                },function(confirm){
                    if(confirm){
                        if(data.status){
                            $('#modalContenido').modal('hide');
                            localtion.reload();
                            formContenido.reset();
                        }else{
                            swal('Atencion',data.msg,'error');
                        }
                    }
                })

            }
        }
    }
})

function openModalContenido(){
    document.querySelector('#idcontenido').value = "";
    document.querySelector('#tituloModal').innerHTML = "Nuevo Contenido";
    document.querySelector('#tituloModal').innerHTML = "Nuevo Contenido";
    document.querySelector('#formContenido').reset();
    $('#modalContenido').modal('show');
}

function editarContenido(id){
    var idcontenido = id;

    document.querySelector('#tituloModal').innerHTML = 'Actualizar Contenido';
    document.querySelector('#action').innerHTML = 'Actualizar';

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTPP');
    var url = './models/contenido/edit-contenido.php?idcontenido='+idcontenido;
    request.open('GET',url,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
        if(data.status){
            document.querySelector('#idcontinedo').value = data.data.contenido_id;
            document.querySelector('#titulo').value = data.data.titulo;
            document.querySelector('#descripcion').value = data.data.descripcion;
            //document.querySelector('#file').value = data.data.material;

            $('modalContenido').modal('show');
        } else {
            swal('Atencion',data.msg,'error');
                }
            }
        }
}

function eliminarContenido(id){
    var idcontenido = id;

    swal({
        title: "Eliminar Contenido",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    },function(confirm){
        if(confirm){
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/contenido/delet-contenido.php';
        request.open('POST',url,true);
        var strData = "idcontenido="+idcontenido;
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.send(strData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var data = JSON.parse(request.responseText);
                if(data.status){
                    location.reload();
                } else{
                    swal('Atencion',data.msg,'error');
                }
            }
        }
    }
})
}     