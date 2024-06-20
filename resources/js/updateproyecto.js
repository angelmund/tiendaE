import { confirSave, eliminar } from "./alertas";
import Swal from 'sweetalert2';
let formularioValido = false;
// Verifica si hay elementos que requieren form-proyecto en la página actual
if ($('#formedit-proyecto').length > 0) {
    document.addEventListener('DOMContentLoaded', function () {

        //se crea un objeto con los id de los input para mapear los valores
        const proyecto = {
            //tienen que coicidir con el mismo id de cada campo
            claveProyecto_edit: '',
            nombreProyecto_edit: '',
            descripcion_new: '',
            encargado_edit: '',
            ubicacion_edit: '',
            cantMaxParticipantes_edit: '',
            presupuesto_edit: '',

        };



        //se obtienen los id de cada input 
        const claveProyecto = document.querySelector('#claveProyecto_edit');
        const nombreEdit = document.querySelector('#nombreProyecto_edit');
        const descripcionNew = document.querySelector('#descripcion_new');
        const nombreEncargadoEdit = document.querySelector('#encargado_edit');
        const ubicacionEdit = document.querySelector('#ubicacion_edit');
        const cantParticipantesEdit = document.querySelector('#cantMaxParticipantes_edit');
        const presupuestoEdit = document.querySelector('#presupuesto_edit');

        const formulario = document.querySelector('#formedit-proyecto');
        const btnSubmit = document.querySelector('#btn_update');
        const btnCancelar = document.querySelector('#btn_cerrar');
        const btnEquis = document.querySelector('.btn-close');
        const btnabrirModal = document.querySelectorAll('.abrir-modal');
        const btnEliminar = document.querySelectorAll('.eliminar-modal');

        // Deshabilitar el botón de submit al inicio
        // btnSubmit.disabled = true;
        // btnSubmit.disabled = true;


        // agrega validarformulario
        claveProyecto.addEventListener('input', validarFormulario);
        nombreEdit.addEventListener('input', validarFormulario);
        nombreEncargadoEdit.addEventListener('input', validarFormulario);
        ubicacionEdit.addEventListener('input', validarFormulario);
        cantParticipantesEdit.addEventListener('input', validarFormulario);
        presupuestoEdit.addEventListener('input', validarFormulario);


        btnCancelar.addEventListener('click', (e) => {
            e.preventDefault();

            limpiarAlerta(claveProyecto.parentElement);
            limpiarAlerta(nombreEdit.parentElement);
            // limpiarAlerta(descripcionNew.parentElement);
            limpiarAlerta(nombreEncargadoEdit.parentElement);
            limpiarAlerta(ubicacionEdit.parentElement);
            limpiarAlerta(cantParticipantesEdit.parentElement);
            limpiarAlerta(presupuestoEdit.parentElement);
            comprobarFormulario();
        });

        // valida el formulario
        function validarFormulario() {
            formularioValido = true; // Inicializa en true antes de las validaciones

            // Validar cada campo
            if (claveProyecto.value.trim() === '') {
                mostrarAlerta('El campo es obligatorio', claveProyecto.parentElement);
                formularioValido = false;
            } else {
                limpiarAlerta(claveProyecto.parentElement);
            }

            if (nombreEdit.value.trim() === '') {
                mostrarAlerta('El campo es obligatorio', nombreEdit.parentElement);
                formularioValido = false;
            } else {
                limpiarAlerta(nombreEdit.parentElement);
            }

            if (nombreEncargadoEdit.value.trim() === '') {
                mostrarAlerta('El campo es obligatorio', nombreEncargadoEdit.parentElement);
                formularioValido = false;
            } else {
                limpiarAlerta(nombreEncargadoEdit.parentElement);
            }

            if (ubicacionEdit.value.trim() === '') {
                mostrarAlerta('El campo es obligatorio', ubicacionEdit.parentElement);
                formularioValido = false;
            } else {
                limpiarAlerta(ubicacionEdit.parentElement);
            }

            if (cantParticipantesEdit.value.trim() === '') {
                mostrarAlerta('El campo es obligatorio', cantParticipantesEdit.parentElement);
                formularioValido = false;
            } else {
                limpiarAlerta(cantParticipantesEdit.parentElement);
            }

            if (presupuestoEdit.value.trim() === '') {
                mostrarAlerta('El campo es obligatorio', presupuestoEdit.parentElement);
                formularioValido = false;
            } else {
                limpiarAlerta(presupuestoEdit.parentElement);
            }

            // Actualizar el estado del formulario
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

        presupuestoEdit.addEventListener('input', function (e) {
            // Obtener el valor actual del campo
            let valor = e.target.value;

            // Quitar cualquier coma existente
            valor = valor.replace(/,/g, '');

            // Formatear el número con comas cada 3 dígitos
            valor = Number(valor).toLocaleString();

            // Actualizar el valor del campo
            e.target.value = valor;
            //console.log("Agregaste:" + valor);

            // Validar el formulario después de formatear
            validarFormulario();
        });


        // Agregar el evento input para la validación
        cantParticipantesEdit.addEventListener('input', function (e) {
            // Obtener el valor del campo y asegurarse de que sea un número
            let valor = parseInt(e.target.value, 10);

            // Si no es un número válido o es menor que 1, establecer el valor a 1
            if (isNaN(valor) || valor < 1) {
                e.target.value = '';
            }
        });

        function comprobarFormulario() {
            // console.log("Comprobando formulario...");

            if (formularioValido) {
                // console.log("Formulario válido");
                btnSubmit.disabled = false;
            } else {
                // console.log("Formulario no válido");
                btnSubmit.disabled = true;
            }
        }


        btnSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            if (formularioValido) { // Verifica si el formulario es válido
                confirSave("¿Los datos capturados, son correctos?", function () {
                    updateproyecto();
                });
            }
        });

        // Evento para abrir el modal y cargar los datos
        $('#example').on('click', '.abrir-proyecto', function (event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var ruta = $('#url').val();
            var url = ruta + '/proyectos/edit/' + id;
            consultarproyecto(url);
        });

        function consultarproyecto(url) {
            fetch(url)
                .then(respuesta => respuesta.json())
                .then(resultado => {
                    // Verifica si el modal se abre correctamente
                    $('#editModal').modal('show');

                    // Llenar el modal con los datos obtenidos
                    llenarModal(resultado);
                    validarFormulario(); // Llamar a validarFormulario después de llenar el modal
                })
                .catch(error => console.error('Error:', error));
        }

        function llenarModal(data) {
            //  selectores en el DOM

            $('#claveProyecto_edit').val(data.clave_proyecto);
            $('#nombreProyecto_edit').val(data.nombre);
            $('#descripcion_edit').val(data.descripcion);
            $('#ubicacion_edit').val(data.ubicacion);
            $('#encargado_edit').val(data.encargado);
            $('#presupuesto_edit').val(data.presupuesto);
            $('#cantMaxParticipantes_edit').val(data.cantMaxParticipantes);

            // ID del registro actual sea correcto
            const idproyecto = data.id;

            // Modificar la acción del formulario para que apunte al ID específico
            const formedit = document.querySelector('#formedit-proyecto');
            formedit.action = '/proyectos/update/' + idproyecto;

            //  ID en algún lugar accesible para su posterior uso
            formedit.dataset.proyectoId = idproyecto;
        }

        async function updateproyecto() {
            const id = document.querySelector('#formedit-proyecto').dataset.proyectoId;
            const url = $('#url').val();
            try {
                // Elimina las comas del valor de presupuesto antes de enviarlo
                const presupuestoValue = presupuestoEdit.value.replace(/,/g, '');
                // Crea un objeto FormData y agrega los datos
                const formData = new FormData($('#formedit-proyecto')[0]);
                formData.set('presupuestoN', presupuestoValue);
                // console.log(formData);
                const response = await fetch(url + '/proyectos/update/' + id, {
                    method: 'POST',
                    mode: 'cors',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: formData
                });
                const data = await response.json();
                // console.log(data); // Muestra los datos recibidos en la consola

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



        $('#example').on('click', '.eliminar', function (event) {
            event.preventDefault();
            // Obtener el id del botón que ha sido clicado
            var id = $(this).data('id');
            eliminar("¿Está seguro de eliminar el proyecto?", function () {
                deleteProyecto(id);
            });
        });

        async function deleteProyecto(id) {
            const url = $('#url').val();
            try {
                const response = await fetch(url + '/proyectos/delete/' + id, {
                    method: 'POST',
                    mode: 'cors',
                    redirect: 'manual',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
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
                console.error("Error al procesar la solicitud:", error);
            }
        }
    });
}