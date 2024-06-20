import { confirSave, eliminar, alertaInfo } from "./alertas";
import Swal from 'sweetalert2';
document.addEventListener('DOMContentLoaded', function () {

    if ($('#form-editincripcion').length > 0) {

        // $('.select2').select2();
        // $('#claveProyecto').select2();


        //se crea un objeto con los id de los input para mapear los valores
        const inscripcion = {
            //tienen que coicidir con el mismo id de cada campo
            nombre: '',
            direccion: '',
            claveProyecto: '',
            nombreProyecto_n: '',
            comite: '',
            alcaldia: '',
            telefono: '',
            concepto: '',
            importeInscripcion: '',
            noSolicitud: '',
            fechaDeposito: '',
            // fotoCliente: '',
            // Ine: '',

        };


        const nombreProyectoInput = document.querySelector('#nombreProyecto_n');
        const telefonoN = document.querySelector('#telefono');
        const importeinscripcionN = document.querySelector('#importeInscripcion');

        const btnSubmit = document.querySelector('.btn_actualizar');
        // const fotoclienteN = document.querySelector('#fotoCliente');
        // const ineN = document.querySelector('#Ine');


        const formulario = document.querySelector('#form-editincripcion');

        const btnCancelar = document.querySelector('#limpiar');

        btnCancelar.addEventListener('click', (e) => {
            e.preventDefault();
            formulario.reset();
        });

        // Escucha cambios en el elemento select
        $('#claveProyecto').on('change', function () {
            var claveProyecto = $(this).val();
            var nombreProyectoSeleccionado = this.options[this.selectedIndex].text; // Obtiene el texto de la opción seleccionada
            console.log("Has seleccionado: " + nombreProyectoSeleccionado);

            $.get('/inscripciones/relacion/' + claveProyecto, function (data) {
                if (data && data.clave_proyecto) {
                    // Actualiza el valor del campo en el objeto inscripcion
                    inscripcion.claveProyecto = data.clave_proyecto; // Actualiza la clave del proyecto
                    inscripcion.nombreProyecto_n = data.nombre_proyecto; // Actualiza el nombre del proyecto

                    var nombresProyectos = '';

                    //  actualizar el valor de nombreProyectoInput si tienes un nombre
                    if (data.nombre_proyecto) {
                        nombresProyectos = data.nombre_proyecto;
                    }

                    nombreProyectoInput.value = nombresProyectos;

                } else {
                    nombreProyectoInput.value = '';
                    // Si no hay datos válidos, limpia el campo en el objeto inscripcion
                    inscripcion.claveProyecto = '';
                    inscripcion.nombreProyecto_n = '';
                }

                comprobarFormulario(); // Asegura que se compruebe el formulario después del cambio
            }).fail(function () {
                // console.log('Error al obtener la relación del proyecto.');
            });
        });

        importeinscripcionN.addEventListener('input', function (e) {
            // Obtener el valor actual del campo
            let valor = this.value.trim();

            if (!/^[0-9,]+$/.test(valor)) {
                alertaInfo('Por favor, ingresa solo números, los puedes separar por una coma.');
                this.value = valor.replace(/[^0-9,]/g, ''); // Elimina caracteres no numéricos
            }
        });

        telefonoN.addEventListener('input', function (e) {
            let valor = this.value.trim(); // Obtener el valor actual del campo y eliminar espacios en blanco

            // Eliminar caracteres no numéricos
            valor = valor.replace(/\D/g, '');

            // Limitar la longitud a 12 caracteres
            if (valor.length > 12) {
                valor = valor.substring(0, 12);
            }

            // Formatear el valor para separar en grupos de cuatro
            let formattedValue = '';
            for (let i = 0; i < valor.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' '; // Agregar espacio después de cada grupo de cuatro dígitos
                }
                formattedValue += valor.charAt(i);
            }

            // Actualizar el valor del campo de entrada
            this.value = formattedValue;
        });



        // Evento para abrir el modal y cargar los datos
        $('#example').on('click', '.abrir-inscripcion', function (event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var ruta = $('#url').val();
            var url = ruta + '/inscripciones/edit/' + id;
            // console.log(url);
            consultarInscripcion(url);
        });

        // Función para convertir y formatear la fecha en el formato esperado por un input de tipo date
        function formatearFecha(fechaISO) {
            const date = new Date(fechaISO);
            const day = ('0' + date.getDate()).slice(-2);
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            return `${year}-${month}-${day}`; // Formato YYYY-MM-DD
        }


        // Función para consultar la inscripción
        function consultarInscripcion(url) {
            fetch(url)
                .then(respuesta => {
                    if (!respuesta.ok) {
                        throw new Error('Error');
                    }
                    return respuesta.json();
                })
                .then(datos => {
                    if (datos.error) {
                        console.error('Error:', datos.error);
                        return;
                    }
                    mostrarDatos(datos);

                    // Verifica si el modal se abre correctamente
                    $('#EditInscripcion').modal('show');

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function mostrarDatos(datos) {
            // Obtener los datos de mi json enviado desde el back
            const inscripcion = datos.inscripcion;
            const selectclaveproyecto = Object.entries(datos.selectclaveproyecto);
            const proyecto = datos.proyecto;
        
            // Asignar valores a los campos del formulario
            $('#nombre').val(inscripcion.nombre_completo);
            $('#id').val(inscripcion.id);
            $('#direccion').val(inscripcion.direccion);
            $('#comite').val(inscripcion.comite);
            $('#alcaldia').val(inscripcion.alcaldia);
            $('#telefono').val(inscripcion.telefono);
            $('#concepto').val(inscripcion.concepto);
            $('#importeInscripcion').val(inscripcion.importe);
            // Asignar el nombre del proyecto, o una cadena vacía si no hay proyecto
            $('#nombreProyecto_n').val(proyecto ? proyecto.nombre : '');
            $('#noSolicitud').val(inscripcion.numero_solicitud);
        
            // Convertir y asignar la fecha formateada
            const fechaFormateada = formatearFecha(inscripcion.fecha_deposito);
            $('#fechaDeposito').val(fechaFormateada);
        
            $('#observaciones').val(inscripcion.observaciones);
        
            // Llenar el select y seleccionar la clave del proyecto
            const select = document.getElementById('claveProyecto');
            select.innerHTML = ''; // Limpiar opciones existentes
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'No Asignado';
            select.appendChild(defaultOption);
        
            selectclaveproyecto.forEach(([id, clave]) => {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = clave;
                if (clave === inscripcion.clave_proyecto) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        
            // Inicializar Tom Select después de llenar el select
            new TomSelect("#claveProyecto", {
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }
        

        var form = document.getElementById('form-editincripcion');

        $('#EditInscripcion').on('shown.bs.modal', function () {
            // Remove validation classes
            $('.mayuscula').removeClass('is-valid is-invalid');

            form.addEventListener('submit', function (event) {
                var inputs = this.getElementsByTagName('input');
                var isValid = true;

                for (var i = 0; i < inputs.length; i++) {
                    if (!inputs[i].checkValidity()) {
                        inputs[i].classList.add('is-invalid');
                        isValid = false;
                    } else {
                        inputs[i].classList.remove('is-invalid');
                        inputs[i].classList.add('is-valid');
                    }
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });

        $('.mayuscula').on('input', function () {
            var input = $(this);
            var is_name = input.val();
            if (is_name) {
                input.removeClass("is-invalid").addClass("is-valid");
            } else {
                input.removeClass("is-valid").addClass("is-invalid");
            }
        });

        btnSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            if (form.checkValidity()) { // Verifica si el formulario es válido
                confirSave("¿Los datos capturados, son correctos?", function () {
                    updateinscripcion();
                });
            }
        });

        async function updateinscripcion() {
            const url = $('#url').val();
            // console.log(url);
            const id = $('#id').val();
            // console.log(id);
            try {
                const formData = new FormData($('#form-editincripcion')[0]);
                const claveProyectoValue = $('#claveProyecto').val();
                const claveProyectoText = $('#claveProyecto option:selected').text();
                const claveProyectoFinalValue = claveProyectoText === 'Seleccione una opción' ? '' : claveProyectoText;
                const telefonoValue = $('#telefono').val().replace(/\s/g, '');

                formData.append('claveProyecto', claveProyectoFinalValue);
                formData.append('telefono', telefonoValue);
                // console.log(formData);

                const response = await fetch(url + '/inscripciones/update/' + id, {
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
    ///inscripciones/delete/

    // const btnEliminar = document.querySelectorAll('.eliminar-inscripcion');

    $('#example').on('click', '.eliminar-inscripcion', function (event) {
        eliminarInscripcion(event);
    });

    function eliminarInscripcion(event) {
        const id = event.currentTarget.getAttribute('data-id'); // Obtener el ID del botón
        const url = `/inscripciones/delete/${id}`; // Construir la URL con el ID

        eliminar("¿Seguro que quiere eliminar la inscripción?", function () {
            enviarSolicitudDelete(url); // Llamar a la función que envía la solicitud DELETE
        });
    }


    async function enviarSolicitudDelete(url) {
        try {
            const response = await fetch(url, {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });

            const data = await response.json();

            if (data.idnotificacion == 1) {
                Swal.fire({
                    title: "Cancelado con éxito",
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
                    text: "Ocurrió un error al cancelar"
                });
            }
        } catch (error) {
            console.error('Error en try-catch:', error);
        }
    }

    //  if($('.table_inscripcion').length >0){

    //  }

});

