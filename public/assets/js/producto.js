
$('#guardarPro').click(function (event) {
    event.preventDefault();
    confirSave("¿Los datos capturados, son correctos?", function () {
        saveProducto();
    });
});


async function saveProducto() {
    const url = $('#url').val();
    try {
        const formElement = document.getElementById('Form-productos');
        const formData = new FormData(formElement);
        
        // Verificar si el archivo se adjuntó correctamente
        const fileInput = document.getElementById('foto');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            console.log(file); // Deberías ver los detalles del archivo aquí
            formData.append('foto', file); // Añadir manualmente el archivo al FormData
        } else {
            console.error("No se ha seleccionado ningún archivo.");
            return;
        }

        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]); // Verificar el contenido del FormData
        }

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

