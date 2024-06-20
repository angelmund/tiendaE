import { alertaInfo, confirSave, eliminar } from "./alertas";
import Swal from 'sweetalert2';
// Declaración de la variable btnSubmit*

// const btnSubmit = document.querySelector('#btn_save');*

// let formularioValido;*

document.addEventListener('DOMContentLoaded', function () {
    if ($('#form-usuario').length > 0) {

        const formulario = document.querySelector('#form-usuario');

        const limpiar = document.querySelector('#limpiar');

        limpiar.addEventListener('click', (e) => {
            e.preventDefault();
            formulario.reset();
        });

        formulario.addEventListener('submit', async function (event) {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente

            
                confirSave("¿Los datos capturados son correctos?", function () {
                    saveUsuario();
                });
            
        });

        async function saveUsuario() {
            const url = $('#url').val();
            const formData = new FormData($('#form-usuario')[0]);

            try {
                const response = await fetch(url + '/usuarios/nuevo', {
                    method: 'POST',
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
                        setTimeout(function () {
                            formulario.reset();
                            const vistaUrl = url + "/usuarios";
                            window.location.href = vistaUrl;
                        }, 1000);
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
                            text: "Error desconocido"
                        });
                }
            } catch (error) {
                console.error("Error al procesar la solicitud:", error);
            }
        }



    }

    const btnEliminar = document.querySelectorAll('.eliminar-user');

    btnEliminar.forEach(btn => {
        btn.addEventListener('click', eliminarUsuario);
    });

    function eliminarUsuario(event) {
        const id = event.currentTarget.dataset.id; // Obtener el ID del usuario del botón
        const ruta = $('#url').val();
        const url = '/usuarios/delete/' + id; // Actualizar la URL para eliminar un usuario

        eliminar("¿Seguro que desea eliminar el usuario?", function () {
            eliminarUsuarioFetch(url); // Pasar la URL como parámetro
        });
    }

    async function eliminarUsuarioFetch(url) {
        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
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
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
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
                        text: "Error desconocido"
                    });
            }
        } catch (error) {
            console.error('Error en try-catch:', error);
        }
    }

});





