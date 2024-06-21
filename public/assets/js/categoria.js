
$('#guardarCategoria').click(function (event) {
    event.preventDefault();
    confirSave("¿Los datos capturados, son correctos?", function () {
        saveCategoria();
    });
});


async function saveCategoria() {
    const url = $('#url').val();
    try {
        const formElement = document.getElementById('Form-categorias');
        const formData = new FormData(formElement);

        const response = await fetch(url + '/categorias/store', {
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
                    document.getElementById('Form-categorias').reset();
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


$('#actualizarCategoria').click(function (event) {
    console.log("Actualiza");
    event.preventDefault();
    confirSave("¿Los datos capturados, son correctos?", function () {
        updateCategoria();
    });
});

async function updateCategoria() {
    const url = $('#url').val();
    const id = $('#id').val();
    try {
        const formElement = document.getElementById('form-actualizarCa');
        const formData = new FormData(formElement);

        const response = await fetch(url + '/categorias/update/' + id, {
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