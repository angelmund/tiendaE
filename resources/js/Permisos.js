import { confirSave } from "./alertas";
import Swal from 'sweetalert2';
// Verifica si hay elementos que requieren form-proyecto en la página actual
if ($('#form-permiso').length > 0) {
    document.addEventListener('DOMContentLoaded', function () {
        //se crea un objeto con los id de los input para mapear los valores
        const permiso = {
            //tienen que coicidir con el mismo id de cada campo
            nombre: '',
        };
        let formularioValido = false;


        const nombre = document.querySelector('#nombre');
     

        const formulario = document.querySelector('#form-permiso');
        const btnSubmit = document.querySelector('#btn_save');
        const btnCancelar = document.querySelector('#limpiar');
        const btnEquis = document.querySelector('.btn-close');

        // Deshabilitar el botón de submit al inicio
        // btnSubmit.disabled = true;
        btnSubmit.disabled = true;

        // agrega validarformulario
      
        nombre.addEventListener('input', validarFormulario);

        btnCancelar.addEventListener('click', (e) => {
            e.preventDefault();
            permiso.nombre = '';
            formulario.reset();
            limpiarAlerta(nombre.parentElement);
            comprobarFormulario();
        });

        
        btnEquis.addEventListener('click', (e) => {
            e.preventDefault();
            permiso.nombre = '';
            formulario.reset();
            limpiarAlerta(nombre.parentElement);
            comprobarFormulario();
        });



        // valida el formulario
        function validarFormulario(e) {
            const referencia = e.target.parentElement;

            // console.log(`Campo ${e.target.id}: ${e.target.value.trim()}`);
            // console.log('Estado actual del proyecto:', proyecto);

            if (e.target.value.trim() === '') {
                mostrarAlerta(`El campo es obligatorio`, referencia);
                permiso[e.target.id] = '';
                comprobarFormulario();
                return;
            }

            limpiarAlerta(referencia);

            permiso[e.target.id] = e.target.value.trim();
            comprobarFormulario();
        }

        // muestra alerta 
        function mostrarAlerta(mensaje, referencia) {
            limpiarAlerta(referencia);

            const error = document.createElement('SPAN');

            error.textContent = mensaje;
            error.classList.add('bg-danger', 'text-white', 'p-2', 'text-center');
            referencia.appendChild(error);
        }

        // limpia la alerta 
        function limpiarAlerta(referencia) {
            const alerta = referencia.querySelector('.bg-danger');
            if (alerta) {
                alerta.remove();
            }
        }


        function comprobarFormulario() {
            // console.log("Comprobando formulario...");
            // ... (resto del código)

            if (Object.values(permiso).includes('')) {
                // console.log("Formulario no válido");
                btnSubmit.disabled = true;
                formularioValido = false; // El formulario no es válido
            } else {
                // console.log("Formulario válido");
                btnSubmit.disabled = false;
                formularioValido = true; // El formulario es válido
            }
        }


        btnSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            if (formularioValido) { // Verifica si el formulario es válido
                confirSave("¿Los datos capturados, son correctos?", function () {
                    savePermiso();
                });
            }
        });



        async function savePermiso() {
            const url = $('#url').val();
            try {
                // Crea un objeto FormData y agrega los datos
                const formData = new FormData($('#form-permiso')[0]);
                const response = await fetch(url + '/usuario/permisos', {
                    method: 'POST',
                    mode: 'cors',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: formData
                });
                const data = await response.json();
                // console.log(data); // Muestra los datos recibidos en la consola

                if (data.idnotificacion == 3) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.mensaje // Muestra el mensaje de error recibido del servidor
                    });
                } else if (data.idnotificacion == 1) {
                    Swal.fire({
                        title: "Permiso guardado con éxito",
                        icon: "success",
                        showConfirmButton: false,  // No mostrar el botón "Ok"
                        timer: 1500,  // Cerrar automáticamente después de 1500 milisegundos (1.5 segundos)
                        timerProgressBar: true  // Mostrar una barra de progreso durante el temporizador
                    });
                    // Espera 1500 milisegundos (1.5 segundos) antes de limpiar el formulario
                    setTimeout(function () {
                        formulario.reset();  // Limpia el formulario
                        window.location.reload();
                        // comprobarFormulario();  // Asegúrate de que el botón esté deshabilitado después de limpiar
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ocurrió un error al guardar!"
                    });
                }
            } catch (error) {
                // console.log(error);
            }
        }
    });
}

