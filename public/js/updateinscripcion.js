import { confirSave, eliminar } from "./alertas";

document.addEventListener('DOMContentLoaded', function () {
    if ($('#formedit-incripcion').length > 0) {
        document.addEventListener('DOMContentLoaded', function () {
            $('.select2').select2();
            $('#claveProyecto').select2();
            let nombreProyectoSeleccionado = '';
            //se crea un objeto con los id de los input para mapear los valores
            const inscripcion = {
                //tienen que coicidir con el mismo id de cada campo
                nombre: '',
                direccion: '',
                // claveProyecto: '',
                // nombreProyecto_n: '',
                // comite: '',
                alcaldia: '',
                telefono: '',
                concepto: '',
                importeInscripcion: '',
                noSolicitud: '',
                fechaDeposito: '',
                // fotoCliente: '',
                // Ine: '',
    
            };
            let formularioValido = false;
    
    
            //se obtienen los id de cada input 
            const nombreNew = document.querySelector('#nombre');
            const direccion = document.querySelector('#direccion');
    
            const selectClaveProyecto = document.querySelector('#claveProyecto');
            const nombreProyectoInput = document.querySelector('#nombreProyecto_n');
    
            const comite = document.querySelector('#comite'); //no es obligatorio
            const alcaldiaN = document.querySelector('#alcaldia');
            const telefonoN = document.querySelector('#telefono');
            const conceptoN = document.querySelector('#concepto');
            const importeinscripcionN = document.querySelector('#importeInscripcion');
            const nosolicitudN = document.querySelector('#noSolicitud');
            const fechadepositoN = document.querySelector('#fechaDeposito');
            // const fotoclienteN = document.querySelector('#fotoCliente');
            // const ineN = document.querySelector('#Ine');
    
    
    
            const formulario = document.querySelector('#formedit-incripcion');
            
            const btnCancelar = document.querySelector('#limpiar');
    
            // Deshabilitar el botón de submit al inicio
            // btnSubmit.disabled = true;
            btnSubmit.disabled = true;
    
            // agrega validarformulario
            // comite.addEventListener('input', validarFormulario);
            nombreNew.addEventListener('input', validarFormulario);
            direccion.addEventListener('input', validarFormulario);
    
            alcaldiaN.addEventListener('input', validarFormulario);
            telefonoN.addEventListener('input', validarFormulario);
            conceptoN.addEventListener('input', validarFormulario);
            importeinscripcionN.addEventListener('input', validarFormulario);
            nosolicitudN.addEventListener('input', validarFormulario);
            fechadepositoN.addEventListener('input', validarFormulario);
            // fotoclienteN.addEventListener('input', validarFormulario);
            // ineN.addEventListener('input', validarFormulario);
    
    
            btnCancelar.addEventListener('click', (e) => {
                e.preventDefault();
                inscripcion.nombre = '';
                inscripcion.direccion = '';
                // inscripcion.claveProyecto = '';
                // inscripcion.nombreProyecto_n = '';
                // proyecto.comite = '';
                inscripcion.alcaldia = '';
                inscripcion.telefono = '';
                inscripcion.concepto = '';
                inscripcion.importeInscripcion = '';
                inscripcion.noSolicitud = '';
                inscripcion.fechaDeposito = '';
                // inscripcion.fotoCliente = '';
                // inscripcion.Ine = '';
                formulario.reset();
                limpiarAlerta(nombreNew.parentElement);
                limpiarAlerta(direccion.parentElement);
                // limpiarAlerta(selectClaveProyecto.parentElement);
                // limpiarAlerta(nombreProyectoInput.parentElement);
                // limpiarAlerta(comite.parentElement);
                limpiarAlerta(alcaldiaN.parentElement);
                limpiarAlerta(telefonoN.parentElement);
                limpiarAlerta(conceptoN.parentElement);
                limpiarAlerta(importeinscripcionN.parentElement);
                limpiarAlerta(nosolicitudN.parentElement);
                limpiarAlerta(fechadepositoN.parentElement);
                // limpiarAlerta(fotoclienteN.parentElement);
                // limpiarAlerta(ineN.parentElement);
                comprobarFormulario();
            });
    
    
    
            // valida el formulario
            function validarFormulario(e) {
                const referencia = e.target.parentElement;
    
                // Ignorar validación para claveProyecto y nombreProyecto_n
                if (e.target.id === 'claveProyecto' || e.target.id === 'nombreProyecto_n') {
                    limpiarAlerta(referencia);
                    inscripcion[e.target.id] = e.target.value.trim();
                    comprobarFormulario();
                    return;
                }
    
                if (e.target.value.trim() === '') {
                    mostrarAlerta(`El campo es obligatorio`, referencia);
                    inscripcion[e.target.id] = '';
                    comprobarFormulario();
                    return;
                }
    
                limpiarAlerta(referencia);
    
                inscripcion[e.target.id] = e.target.value.trim();
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
    
            function comprobarFormulario() {
    
    
                if (Object.values(inscripcion).includes('')) {
                    // console.log("Formulario no válido");
                    btnSubmit.disabled = true;
                    formularioValido = false; // El formulario no es válido
                } else {
                    // console.log("Formulario válido");
                    btnSubmit.disabled = false;
                    formularioValido = true; // El formulario es válido
    
                }
            }
    
    
            // Función para inicializar los valores de inscripcion con los del formulario
            function inicializarValoresInscripcion() {
                inscripcion.concepto = conceptoN.value.trim();
                inscripcion.importeInscripcion = importeinscripcionN.value.trim();
    
    
                // Disparar manualmente el evento input en los campos que ya tienen valores
                validarFormulario({ target: conceptoN });
                validarFormulario({ target: importeinscripcionN });
    
                comprobarFormulario(); // Verificar el estado del formulario
            }
    
            inicializarValoresInscripcion();
            // comprueba si todos los campos estan llenos para habilitar boton de enviar o no
           
            const btnSubmit = document.querySelector('.btn_save');
            btnSubmit.addEventListener("click", (e) => {
                
            });
            $('#btn_actualizar').click(function () {
                e.preventDefault();
                alert("¡Hiciste clic en el botón!");
                 // if (formularioValido) { // Verifica si el formulario es válido
                //     confirSave("¿Los datos capturados, son correctos?", function () {
                //         updateinscripcion();
                //     });
                // }
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
    
    
            async function updateinscripcion() {
                const url = $('#url').val();
                const id = $('#idInscripcion').val();
                try {
                    const formData = new FormData($('#formedit-incripcion')[0]);
                    var nombreProyectoSeleccionado = $('#claveProyecto option:selected').text(); // Obtener el texto de la opción seleccionada
                    formData.append('claveProyecto', nombreProyectoSeleccionado); // Agregar el texto al formData
                    // console.log(nombreProyectoSeleccionado);
                    const response = await fetch(url + '/inscripciones/update/' + id, {
                        method: 'POST',
                        mode: 'cors',
                        redirect: 'manual', // Desactiva las redirecciones automáticas
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: formData
                    });
                    const data = await response.json();
                    // console.log(data); // Muestra los datos recibidos en la consola
                    if (data.idnotificacion == 1) {
                        Swal.fire({
                            title: "Inscripción realizada con éxito",
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
                    console.error("Error al procesar la solicitud:", error);
                }
            }
    
    
        });;



       
        ///inscripciones/delete/

        const btnEliminar = document.querySelectorAll('.eliminar-inscripcion');

        btnEliminar.forEach(btn => {
            btn.addEventListener('click', eliminarTipoPago);
        });

        function eliminarTipoPago(event) {
            const id = event.target.dataset.id; // Obtener el ID
            // const tipo = event.target.dataset.tipo; // Obtener el tipo (cheque o pago)
            const url = `/inscripciones/delete/${id}`; // Construir la URL con el tipo y el ID

            eliminar("¿Seguro que quiere eliminar la inscripción?", function () {
                console.log(id);
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
    }
});

