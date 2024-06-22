
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
        
        // Verificar si el archivo se adjuntó correctamente
        const fileInput = document.getElementById('foto');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            console.log(file); // Deberías ver los detalles del archivo aquí
            if (file.size === 0) {
                console.error("El archivo no se ha seleccionado o está vacío.");
                return;
            }
        } else {
            console.error("No se ha seleccionado ningún archivo.");
            return;
        }

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

// $('#btnMostrar').click(function () {
//     $('.mostrar').show(); 
//     $('#btnMostrar').hide();
// });

// $('#btnCancelar').click(function () {
//     $('.mostrar').hide(); 
//     $('#btnMostrar').show();
// });

$('.actualizarPro').click(function (event) {
    event.preventDefault();
    const id = $(this).data('id');
    console.log(id);
    confirSave("¿Los datos capturados, son correctos?", function () {
        // Encuentra el formulario más cercano al botón que se presionó
        const formElement = $(this).closest('.modal').find('form')[0];
        updateProducto(id, formElement); // Pasar el ID y el formulario como argumentos a la función
    }.bind(this)); // Enlazar el botón que se presionó con la función de confirmación
});

async function updateProducto(id,formElement) {
    const url = $('#url').val();
    try {
        const formData = new FormData(formElement);
        
        // Verificar si el archivo se adjuntó correctamente
        const fileInput = document.getElementById('foto');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            console.log(file); // Deberías ver los detalles del archivo aquí
            if (file.size === 0) {
                console.error("El archivo no se ha seleccionado o está vacío.");
                return;
            }
        } else {
            console.error("No se ha seleccionado ningún archivo.");
            return;
        }

        console.log(formData);

        const response = await fetch(url + '/productos/update/' + id, {
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
                    document.getElementById('edit-productos').reset();
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