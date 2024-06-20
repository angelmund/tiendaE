
document.addEventListener('DOMContentLoaded', function () {
    //se crea un objeto con los id de los input para mapear los valores
    const proyecto = {
        //tienen que coicidir con el mismo id de cada campo
        claveProyecto_edit: '',
        nombreProyecto_edit: '',
        // descripcion_new: '',
        encargado_edit: '',
        ubicacion_edit: '',
        cantMaxParticipantes_edit: '',
        presupuesto_edit: '',

    };
    let formularioValido = false;


    //se obtienen los id de cada input 
    const claveProyecto = document.querySelector('#claveProyecto_edit');
    const nombreEdit = document.querySelector('#nombreProyecto_edit');
    // const descripcionNew = document.querySelector('#descripcion_new');
    const nombreEncargadoEdit = document.querySelector('#encargado_edit');
    const ubicacionEdit = document.querySelector('#ubicacion_edit');
    const cantParticipantesEdit = document.querySelector('#cantMaxParticipantes_edit');
    const presupuestoEdit = document.querySelector('#presupuesto_edit');

    const formulario = document.querySelector('#formedit-proyecto');
    const btnSubmit = document.querySelector('#btn_update');
    const btnCancelar = document.querySelector('#btn_cerrar');

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
        proyecto.claveProyecto_edit = '';
        proyecto.nombreProyecto_edit = '';
        // proyecto.descripcion_new = '';
        proyecto.encargado_edit = '';
        proyecto.ubicacion_edit = '';
        proyecto.cantMaxParticipantes_edit = '';
        proyecto.presupuesto_edit = '';
        formulario.reset();
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

    presupuestoEdit.addEventListener('input', function (e) {
        // Obtener el valor actual del campo
        let valor = e.target.value;
    
        // Quitar cualquier coma existente
        valor = valor.replace(/,/g, '');
    
        // Formatear el número con comas cada 3 dígitos
        valor = Number(valor).toLocaleString();
    
        // Actualizar el valor del campo
        e.target.value = valor;
        console.log("Agregaste:" + valor);
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
            const presupuestoValue = presupuestoEdit.value.replace(/,/g, '');
            // Crea un objeto FormData y agrega los datos
            const formData = new FormData($('#formedit-proyecto')[0]);
            formData.set('presupuestoN', presupuestoValue);
            const response = await fetch(url + '/proyectos/update', {
                method: 'POST',
                mode: 'cors',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: formData
            });
            const data = await response.json();
            // console.log(data); // Muestra los datos recibidos en la consola

            if (data.idnotificacion == 1) {
                Swal.fire({
                    title: "Proyecto actualizado con éxito",
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
            // console.log(response);
            // console.log($('#formcreate-medida').serialize());

        } catch (error) {
            // console.log(error);
        }
    }
    console.log("Holaaaaa")
});