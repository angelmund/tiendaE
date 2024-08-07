// import { confirSave, eliminar } from "./alertas";
// import Swal from 'sweetalert2';
// Verifica si hay elementos que requieren form-proyecto en la página actual
if ($('#form-rol').length > 0) {
    document.addEventListener('DOMContentLoaded', function () {
        //se crea un objeto con los id de los input para mapear los valores
        const rol = {
            //tienen que coicidir con el mismo id de cada campo
            nombre: '',
        };
        let formularioValido = false;


        const nombre = document.querySelector('#nombre');
     

        const formulario = document.querySelector('#form-rol');
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
            rol.nombre = '';
            formulario.reset();
            limpiarAlerta(nombre.parentElement);
            comprobarFormulario();
        });

        
        btnEquis.addEventListener('click', (e) => {
            e.preventDefault();
            rol.nombre = '';
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
                rol[e.target.id] = '';
                comprobarFormulario();
                return;
            }

            limpiarAlerta(referencia);

            rol[e.target.id] = e.target.value.trim();
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

            if (Object.values(rol).includes('')) {
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
                    saverol();
                });
            }
        });



        async function saverol() {
            const url = $('#url').val();
            try {
                // Crea un objeto FormData y agrega los datos
                const formData = new FormData($('#form-rol')[0]);
                const response = await fetch(url + '/usuario/roles', {
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
                        title: "rol guardado con éxito",
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

        const btnEliminar = document.querySelectorAll('.eliminar-rol');

        btnEliminar.forEach(btn => {
            btn.addEventListener('click', funEliminar);
        });
        
        function funEliminar(event) {
            const id = event.currentTarget.dataset.id; // Obtener el ID del usuario del botón
            const ruta = $('#url').val();
            const url ='/usuario/asignarRol/' + id; // Actualizar la URL para eliminar un usuario
        
            eliminar("¿Seguro que desea eliminar el rol?", function (){
                eliminarRol(url); // Pasar la URL como parámetro
            });
        }
        
        async function eliminarRol(url) {
            try {
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                });
        
                const data = await response.json();
        
                if (data.idnotificacion == 1) {
                    Swal.fire({
                        title: "Eliminado con éxito",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ocurrió un error al eliminar"
                    });
                }
            } catch (error) {
                console.error('Error en try-catch:', error);
            }
        }
    });
}

