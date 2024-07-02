$('.actualizar').click(function (event) {
    event.preventDefault();
    const id = $(this).data('id');
    //  console.log(id);
    confirSave("¿Los datos capturados, son correctos?", function () {
        // Encuentra el formulario más cercano al botón que se presionó
        const formElement = $(this).closest('.modal').find('form')[0];
        updateEstado(id, formElement); // Pasar el ID y el formulario como argumentos a la función
    }.bind(this)); // Enlazar el botón que se presionó con la función de confirmación
});

async function updateEstado(id, formElement) {
    const url = $('#url').val();
    // console.log(id);
    const formData = new FormData(formElement);
    //  console.log(formData);

    try {
        const response = await fetch(url + '/pedidos/update/' + id, {
            method: 'POST',
            mode: 'cors',
            redirect: 'manual',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
        });

        const data = await response.json();
        switch (data.idnotificacion) {
            case 1:
                Swal.fire({
                    title: data.mensaje,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                });
                // Esperar un breve período de tiempo antes de recargar la página
                setTimeout(function () {
                    window.location.reload();
                }, 1000); // Espera 1 segundo

                break;

            case 2:
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: data.mensaje
                });
                break;
            case 3:
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: data.mensaje
                });
                break;
            case 3:
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: data.mensaje
                });
                break;
            default:
                Swal.fire({
                    icon: "info",
                    title: "Info...",
                    text: data.mensaje
                });
        }

    } catch (error) {
        console.error("Error al procesar la solicitud:", error);
    }
}