import { alertaInfo, confirSave } from "./alertas";
import Swal from 'sweetalert2';
// import 'select2'; // Importa Select2
if ($('#form-inscripciones').length > 0) {
    document.addEventListener('DOMContentLoaded', function () {
        // $('.select2').select2();
        // $('#claveProyecto').select2();
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



        const formulario = document.querySelector('#form-inscripciones');
        const btnSubmit = document.querySelector('#btn_save');
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

        // function mostrarImagen(inputId, contenedorId) {
        //     const fileInput = document.getElementById(inputId);
        //     const contenedor = document.getElementById(contenedorId);

        //     fileInput.addEventListener('change', function (e) {
        //         const file = e.target.files[0];

        //         if (file) {
        //             const reader = new FileReader();

        //             reader.onload = function (e) {
        //                 contenedor.innerHTML = ''; // Limpiar el contenido anterior

        //                 const img = document.createElement('img');
        //                 img.src = e.target.result;
        //                 img.alt = 'Imagen seleccionada';
        //                 img.classList.add('img-thumbnail'); // Agregar clases de Bootstrap si es necesario

        //                 // Establecer estilos para tamaño y centrado
        //                 img.style.width = '40%'; // Ajusta el ancho al 100% del contenedor
        //                 img.style.height = 'auto'; // Ajusta la altura automáticamente para mantener la proporción

        //                 // Aplicar borderRadius solo a #fotoCliente
        //                 if (contenedorId === 'fotocliente') {
        //                     img.style.borderRadius = '50%';
        //                 }

        //                 contenedor.style.textAlign = 'center'; // Centra la imagen en el contenedor
        //                 contenedor.appendChild(img);
        //             };

        //             reader.readAsDataURL(file);
        //         }
        //     });
        // }

        // Llamar a la función para cada par de input y contenedor
        // mostrarImagen('fotoCliente', 'fotocliente');
        // mostrarImagen('Ine', 'fotoIne');


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
        btnSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            if (formularioValido) { // Verifica si el formulario es válido
                confirSave("¿Los datos capturados, son correctos?", function () {
                    saveinscripcion();
                });
            }
        });

        telefonoN.addEventListener('input', function (e) {
            let valor = this.value.trim(); // Obtener el valor actual del campo y eliminar espacios en blanco

            // Eliminar caracteres no numéricos
            valor = valor.replace(/\D/g, '');

            // Limitar la longitud a 10 caracteres (para aceptar solo 10 dígitos)
            if (valor.length > 10) {
                valor = valor.substring(0, 10);
            }

            // Formatear el valor para separar en grupos de 2, 4 y 4
            let formattedValue = '';
            for (let i = 0; i < valor.length; i++) {
                if (i === 2 || i === 6) {
                    formattedValue += ' '; // Agregar espacio después de los primeros 2 y luego de los siguientes 4 dígitos
                }
                formattedValue += valor.charAt(i);
            }

            // Actualizar el valor del campo de entrada
            this.value = formattedValue;
        });

       

        nosolicitudN.addEventListener('input', function (e) {
            let valor = this.value.trim(); // Obtener el valor actual del campo y eliminar espacios en blanco
        
            // Eliminar caracteres no deseados (todo excepto números y letras)
            valor = valor.replace(/[^a-zA-Z0-9]/g, '');
        
            // Limitar la longitud a 14 caracteres
            if (valor.length > 14) {
                valor = valor.substring(0, 14);
            }
        
            // Formatear el valor para separar en grupos de cuatro
            let formattedValue = '';
            for (let i = 0; i < valor.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' '; // Agregar espacio después de cada grupo de cuatro caracteres
                }
                formattedValue += valor.charAt(i);
            }
        
            // Actualizar el valor del campo de entrada
            this.value = formattedValue;
        });



        async function saveinscripcion() {
            const url = $('#url').val();
            try {
                const formData = new FormData($('#form-inscripciones')[0]);
                // Obtener el valor seleccionado y el texto de la opción
                const claveProyectoValue = $('#claveProyecto').val();
                const claveProyectoText = $('#claveProyecto option:selected').text();

                // Reemplazar "Seleccione una opción" con una cadena vacía si es la opción seleccionada
                const claveProyectoFinalValue = claveProyectoText === 'Seleccione una opción' ? '' : claveProyectoText;
                console.log(claveProyectoValue); ///id 
                console.log(claveProyectoText);//CLAVE

                // Eliminar espacios en blanco del campo de teléfono
                const telefonoValue = $('#telefono').val().replace(/\s/g, '');
                const solicitud = $('#noSolicitud').val().replace(/\s/g, '');

                // Agregar los valores al FormData
                formData.append('claveProyecto', claveProyectoFinalValue);
                formData.append('telefono', telefonoValue);
                formData.append('noSolicitud', solicitud);
                // console.log(formData);

                const response = await fetch(url + '/inscripciones/nuevo', {
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
                        // Abre la URL de la vista en una nueva pestaña
                        const vistaUrl = url + '/inscripciones/formato/' + data.inscripcionId;
                        window.open(vistaUrl, '_blank');

                        // Esperar un breve período de tiempo antes de recargar la página
                        setTimeout(function () {
                            document.getElementById('form-inscripciones').reset();
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
                            text: "Error desconocido"
                        });
                }

            } catch (error) {
                console.error("Error al procesar la solicitud:", error);
            }
        }


    });
}
