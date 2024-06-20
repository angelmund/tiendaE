if ($('.consulta').length > 0) {


    // Evento para abrir el modal y cargar los datos
    $('#example').on('click', '.abrir-inscripcion', function (event) {
        event.preventDefault();
        // Obtener la url del botón que ha sido clicado
        var url = $(this).data('remote');
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



        // console.log(datos);
    }

    var form = document.getElementById('form-consultform');

    $('#VerInscripcion').on('shown.bs.modal', function () {
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


}
