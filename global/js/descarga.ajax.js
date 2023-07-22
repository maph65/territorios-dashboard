function getDescarga(url){
    try{
    $.get(url,null, function(data) {
        if (data.status === 'ok') {
            var descarga = data.descarga;
            console.log(descarga);
            if(typeof $('#descarga-form #id_descarga').val() === 'undefined'){
                var hidden = document.createElement("input");
                hidden.setAttribute("type", "hidden");
                hidden.setAttribute("name", "id_descarga");
                hidden.setAttribute("id", "id_descarga");
                hidden.setAttribute("value", descarga.id_descarga);
                $('#descarga-form').prepend(hidden);
            }else{
                $('#descarga-form #id_descarga').val(descarga.id_descarga);
            }
            $('#descarga-form #titulo').val(descarga.titulo);
            $('#descarga-form #descripcion').val(descarga.descripcion);
            /*$('#imagen-crop').croppie({
                url: descarga.imagen,
            });*/
        } else {
            setTimeout(function() {
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "progressBar": true,
                    "showEasing": "swing",
                    "timeOut": "6000"
                };
                toastr.error('<strong>Ocurrio un error</strong><br/><small>'+ data.msg +'</small>');
            }, 2500);
        }
    });
    }catch(e){
        setTimeout(function() {
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "progressBar": true,
                    "showEasing": "swing",
                    "timeOut": "6000"
                };
                toastr.error('<strong>Ocurrio un error</strong><br/><small>No se encontró el contenido solicitado.</small>');
            }, 2500);
    }
}

