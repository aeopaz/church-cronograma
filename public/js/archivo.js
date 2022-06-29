function subirArchivo(formulario) {
    let url = $('#' + formulario).attr('action');
    let formData = new FormData($("#" + formulario)[0]);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('.alert').alert('close')
            document.getElementById('btn_foto').hidden=true;
            document.getElementById('btn_cargando').hidden=false;
            // $('#modalCarga').modal('show');
           
        },
        complete: function (response) {
            document.getElementById('btn_foto').hidden=false;
            document.getElementById('btn_cargando').hidden=true;
            // $('#modalCarga').modal('hide');
            console.log(response);
            switch (response.status) {
                case 200:
                    mostrarAlerta(formulario, response.responseJSON, 'success');
                    break;
                case 422:
                    mostrarAlerta(formulario, response.responseJSON.errors.file, 'danger');
                    break;

                default:
                    mostrarAlerta(formulario, response.responseJSON, 'danger');
                    break;
            }
            

        }

    });

}

//Mostrar alerta Error
function mostrarAlerta(formulario, mensaje, tipo) {
    //crear div para la alerta
    let div = document.createElement("div");
    //Agregar elementos html al div
    div.innerHTML = `<div class="alert alert-${tipo} mb-2 alert-dismissible fade show" style="width: 40%"  data-dismiss="alert" role="alert"> <strong>${mensaje}</strong></div>`
    //Obtener el formulario
    let form = document.getElementById(formulario);
    //Agregar el div creado al formulario
    form.prepend(div);
    //Ocultar alerta automáticamente
    if (tipo == "success") {
        setTimeout(function () {
            $('.alert').alert('close')
            // alerta.fadeIn(0);
            // alerta.fadeOut(6000);
        }, 5000);
    }
}
