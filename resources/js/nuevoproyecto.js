import { confirSave } from "./alertas";
import Swal from 'sweetalert2';
// Verifica si hay elementos que requieren form-proyecto en la página actual
if ($('#form-proyecto').length > 0) {
    document.addEventListener('DOMContentLoaded', function () {
        //se crea un objeto con los id de los input para mapear los valores
        const proyecto = {
            //tienen que coicidir con el mismo id de cada campo
            claveProyecto_new: '',
            nombre_new: '',
            // descripcion_new: '',
            nombreEncargado_new: '',
            ubicacion_new: '',
            cantParticipantes_new: '',
            presupuestoN: '',

        };
        let formularioValido = false;


        //se obtienen los id de cada input 
        const claveProyecto = document.querySelector('#claveProyecto_new');
        const nombreNew = document.querySelector('#nombre_new');
        // const descripcionNew = document.querySelector('#descripcion_new');
        const nombreEncargadonew = document.querySelector('#nombreEncargado_new');
        const ubicacionNew = document.querySelector('#ubicacion_new');
        const cantParticipantesN = document.querySelector('#cantParticipantes_new');
        const presupuestoNew = document.querySelector('#presupuestoN');

        const formulario = document.querySelector('#form-proyecto');
        const btnSubmit = document.querySelector('#btn_save');
        const btnCancelar = document.querySelector('#limpiar');

        // Deshabilitar el botón de submit al inicio
        // btnSubmit.disabled = true;
        btnSubmit.disabled = true;

        // agrega validarformulario
        claveProyecto.addEventListener('input', validarFormulario);
        nombreNew.addEventListener('input', validarFormulario);
        // descripcionNew.addEventListener('input', validarFormulario);
        nombreEncargadonew.addEventListener('input', validarFormulario);
        ubicacionNew.addEventListener('input', validarFormulario);
        cantParticipantesN.addEventListener('input', validarFormulario);
        presupuestoNew.addEventListener('input', validarFormulario);

        btnCancelar.addEventListener('click', (e) => {
            e.preventDefault();
            proyecto.claveProyecto_new = '';
            proyecto.nombre_new = '';
            // proyecto.descripcion_new = '';
            proyecto.nombreEncargado_new = '';
            proyecto.ubicacion_new = '';
            proyecto.cantParticipantes_new = '';
            proyecto.presupuestoN = '';
            formulario.reset();
            limpiarAlerta(claveProyecto.parentElement);
            limpiarAlerta(nombreNew.parentElement);
            // limpiarAlerta(descripcionNew.parentElement);
            limpiarAlerta(nombreEncargadonew.parentElement);
            limpiarAlerta(ubicacionNew.parentElement);
            limpiarAlerta(cantParticipantesN.parentElement);
            limpiarAlerta(presupuestoNew.parentElement);
            comprobarFormulario();
        });



        // valida el formulario
        function validarFormulario(e) {
            const referencia = e.target.parentElement;

            // console.log(`Campo ${e.target.id}: ${e.target.value.trim()}`);
            // console.log('Estado actual del proyecto:', proyecto);

            if (e.target.value.trim() === '') {
                mostrarAlerta(`El campo es obligatorio`, referencia);
                proyecto[e.target.id] = '';
                comprobarFormulario();
                return;
            }

            limpiarAlerta(referencia);

            proyecto[e.target.id] = e.target.value.trim();
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

        presupuestoNew.addEventListener('input', function (e) {
            // Obtener el valor actual del campo
            let valor = e.target.value;

            // Quitar cualquier coma existente
            valor = valor.replace(/,/g, '');

            // Formatear el número con comas cada 3 dígitos
            valor = Number(valor).toLocaleString();

            // Actualizar el valor del campo
            e.target.value = valor;
        });

        // Agregar el evento input para la validación
        cantParticipantesN.addEventListener('input', function (e) {
            // Obtener el valor del campo y asegurarse de que sea un número
            let valor = parseInt(e.target.value, 10);

            // Si no es un número válido o es menor que 1, establecer el valor a 1
            if (isNaN(valor) || valor < 1) {
                e.target.value = '';
            }
        });

        function comprobarFormulario() {
            // console.log("Comprobando formulario...");
            // ... (resto del código)

            if (Object.values(proyecto).includes('')) {
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
                    saveproyecto();
                });
            }
        });



        async function saveproyecto() {
            const url = $('#url').val();
            try {
                // Elimina las comas del valor de presupuesto antes de enviarlo
                const presupuestoValue = presupuestoNew.value.replace(/,/g, '');
                // Crea un objeto FormData y agrega los datos
                const formData = new FormData($('#form-proyecto')[0]);
                formData.set('presupuestoN', presupuestoValue);
                const response = await fetch(url + '/proyectos/save', {
                    method: 'POST',
                    mode: 'cors',
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
                // console.log(error);
            }
        }
    });
}

