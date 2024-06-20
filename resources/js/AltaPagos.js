import { alertaInfo, confirSave } from "./alertas";
// import Swal from 'sweetalert2';

// Declaración de la variable btnSubmit*

// const btnSubmit = document.querySelector('#btn_save');*

// let formularioValido;*

document.addEventListener('DOMContentLoaded', function () {
    if ($('#formAlta-pagos').length > 0) {

        const formulario = document.querySelector('#formAlta-pagos');

        const limpiar = document.querySelector('#limpiar');

        limpiar.addEventListener('click', (e) => {
            e.preventDefault();
            formulario.reset();
        });

        formulario.addEventListener('submit', async function (event) {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente

            if (!formulario.checkValidity()) {
                event.stopPropagation();
                alertaInfo("Faltan datos por completar");
                formulario.classList.add('was-validated'); // Marcar campos inválidos
                return;
            }

            var conceptoSeleccionado = $('#concepto_pago').val();

            if (conceptoSeleccionado === 'cheque') {
                confirSave("¿Los datos capturados son correctos?", function () {
                    saveCheque();
                });
            } else if (conceptoSeleccionado === 'pago') {
                confirSave("¿Los datos capturados son correctos?", function () {
                    savePago();
                });
            }
        });
    }
});

async function saveCheque() {
    const url = $('#url').val();
    const formData = new FormData($('#formAlta-pagos')[0]);
    formData.append('id_proyecto', $('#id_proyecto').val());
    // console.log(formData);
    try {
        const response = await fetch(url + '/listaPagos/ingreso', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
        });
        const data = await response.json();
        handleResponse(data, 'cheque');
    } catch (error) {
        console.error("Error al procesar la solicitud:", error);
    }
}

async function savePago() {
    const url = $('#url').val();
    const formData = new FormData($('#formAlta-pagos')[0]);
    formData.append('referencia', $('#referencia').val());
    formData.append('monto', $('#monto').val());
    formData.append('observaciones', $('#observaciones').val());
    formData.append('id_cliente', $('#id_cliente').val());
    formData.append('id_proyecto', $('#id_proyecto').val());
    // console.log(formData);
    try {
        const response = await fetch(url + '/listaPagos/ingreso', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
        });
        const data = await response.json();
        handleResponse(data, 'pago');
    } catch (error) {
        console.error("Error al procesar la solicitud:", error);
    }
}

function handleResponse(data, tipo) {
    switch (data.idnotificacion) {
        case 1:
            const url = $('#url').val();
            if (tipo === 'pago') {
                // Abre la URL de la vista en una nueva pestaña
                const vistaUrl = url + '/formatoPago/' + data.pagoId;
                window.open(vistaUrl, '_blank');
            } else if (tipo === 'cheque') {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: data.mensaje,
                });
                // Esperar un breve período de tiempo antes de recargar la página
                setTimeout(function () {
                    document.getElementById('formAlta-pagos').reset();
                    window.location.reload();
                }, 1000); // Espera 1 segundo
            }


            break;
        case 2:
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.mensaje,
            });
            break;
        case 3:
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.mensaje,
            });
            break;
        case 4:
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.mensaje,
            });
            break;
        default:
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.mensaje,
            });
            break;
    }
}


// Escucha cambios en el elemento select de clientes para cargar los nombres de cada cliente 
$('#id_cliente').change(function () {
    var idSeleccionado = $(this).val();
    if (idSeleccionado) {
        $.get('/inscripciones/relacion/nombre/' + idSeleccionado, function (data) {
            if (data && data.nombre_completo) {
                // console.log(data);
                $('#nombre').val(data.nombre_completo);
                $('#id_proyecto').val(data.id_proyecto || '');
                $('#acumulado').val(data.monto || '0');
                // Asignar el valor del ID seleccionado al botón
                $('.abrir-id').val(idSeleccionado);
            } else {
                $('#nombre').val('');
                $('#id_proyecto').val('');
                $('#acumulado').val('');
                // Limpiar el valor del botón si no hay datos
                $('.abrir-id').val('');
            }
        }).fail(function () {
            $('#nombre').val('');
            $('#id_proyecto').val('');
            $('#acumulado').val('');
            // Limpiar el valor del botón si la solicitud falla
            $('.abrir-id').val('');
        });
    } else {
        $('#nombre').val('');
        $('#id_proyecto').val('');
        $('#acumulado').val('');
        // Limpiar el valor del botón si no se selecciona un ID
        $('.abrir-id').val('');
    }
});

$(document).ready(function () {
    // Evento para abrir el modal y cargar los datos
    $('.abrir-id').click(function () {
        // Obtener el ID del botón que ha sido clicado
        var id = $(this).val();
        // console.log(id);
        var ruta = $('#url').val();
        var url = ruta + '/pago/alta/' + id;
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
                $('#ConsultInscripcion').modal('show');

            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Función para mostrar los datos en el formulario del modal
    function mostrarDatos(datos) {
        //obtener los datos de mi json enviado desde el back
        const inscripcion = datos.inscripcion;
        const selectclaveproyecto = Object.entries(datos.selectclaveproyecto);
        const proyecto = datos.proyecto;

        // Asignar valores a los campos del formulario
        $('#nombre_completo').val(inscripcion.nombre_completo);
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

        $('#observaciones_consulta').val(inscripcion.observaciones);

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



        // console.log(datos);
    }
});

