
$('#guardarPro').click(function () {
    preventDefault();
    confirSave("¿Los datos capturados, son correctos?", function () {
        saveProducto();
    });
});

async function saveProducto() {
    const url = $('#url').val();
    try {
        const formElement = document.getElementById('Form-productos');
        const formData = new FormData(formElement);



        console.log(formData);

        const response = await fetch(url + '/productos/store', {
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
                    document.getElementById('Form-productos').reset();
                    window.location.reload();
                }, 1000); // Espera 1 segundo

                break;

            case 2:
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
                    text: "Error desconocido"
                });
        }

    } catch (error) {
        console.error("Error al procesar la solicitud:", error);
    }
}

