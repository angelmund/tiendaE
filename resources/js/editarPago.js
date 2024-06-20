import { alertaInfo, confirSave, eliminar } from "./alertas";
import Swal from 'sweetalert2';

/***************************Cancelar un cheque o pago ******************************/
// const btnEliminar = document.querySelectorAll('.eliminartipoPago');

// Actualiza la selección de botones de eliminar para delegar el evento clic al contenedor de la tabla
$('#example').on('click', '.eliminartipoPago', function(event) {
    eliminarTipoPago(event);
});

function eliminarTipoPago(event) {
    const id = event.target.dataset.id; // Obtener el ID del cheque o pago
    const tipo = event.target.dataset.tipo; // Obtener el tipo (cheque o pago)
    const url = `/cancelar/${tipo}/${id}`; // Construir la URL con el tipo y el ID

    eliminar("¿Seguro que quiere cancelar?", function () {
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

        if (data.idnotificacion == 5) {
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
/***************************Termina Cancelar un cheque o pago ******************************/

