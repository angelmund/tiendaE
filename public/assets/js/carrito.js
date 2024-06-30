document.addEventListener('DOMContentLoaded', function () {
    cargarProductosDelCarrito();
});


document.querySelector('#btnFinalizar').addEventListener("click", function (event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('Datos'));

    // Obtener los datos del carrito desde el localStorage
    const datosCarrito = cargarProductosDelCarrito();
    if (!datosCarrito || datosCarrito.productos.length === 0) {
        Swal.fire({
            title: "Error",
            text: "No hay productos en el carrito o los datos están corruptos.",
            icon: "error"
        });
        return;
    }

    const datosCarritoJSON = JSON.stringify(datosCarrito.productos);

    // Añadir los datos del carrito al FormData
    formData.append('productos', datosCarritoJSON);
    formData.append('total', datosCarrito.total);

    enviar(formData);
});


function enviar(formData) {
    const url = $('#url').val();
    let contador = 0;
    Swal.fire({
        title: "¿Desea realizar el pedido?",
        text: "Asegúrese de que sus datos sean correctos",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Realizar pedido!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(url +'/ASP/pedido/pedido', {
                method: 'POST',
                mode: 'cors',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
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
                                document.getElementById('Datos').reset();
                                window.location.reload();
                                localStorage.removeItem('productosCarrito');
                                // document.getElementById('carrito').textContent = contador; // Actualizar contador de carrito marca error xd
                                location.href = 'http://localhost/TiendaEcom/public/ASP/tienda#';
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
                                icon: "info",
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
                })
                .catch(error => console.error('Error:', error));
        } else {
            Swal.fire({
                title: "Cancelado",
                text: "El pedido ha sido cancelado",
                icon: "error"
            });
        }
    });
}

function cargarProductosDelCarrito() {
    const productos = JSON.parse(localStorage.getItem('productosCarrito')) || [];
    const tbody = document.getElementById('tblCarrito');
    tbody.innerHTML = ''; // Limpiar contenido anterior

    const productosAgrupados = productos.reduce((cantipro, producto) => {
        if (!cantipro[producto.id]) {
            cantipro[producto.id] = { ...producto, cantidad: 1, subtotal: producto.precio };
        } else {
            cantipro[producto.id].cantidad++;
            cantipro[producto.id].subtotal = cantipro[producto.id].cantidad * cantipro[producto.id].precio;
        }
        return cantipro;
    }, {});

    let totalAcumulado = 0;
    Object.values(productosAgrupados).forEach(producto => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${producto.nombre}</td>
            <td><img src="${producto.imagen}" width="50" height="50"></td>
            <td>${producto.precio}</td>
            <td>${producto.cantidad}</td>
            <td>${producto.subtotal}</td>
        `;
        tbody.appendChild(tr);
        totalAcumulado += producto.subtotal;
    });

    if (Object.keys(productosAgrupados).length > 0) {
        $('#btnContinuar').prop('disabled', false);
    }

    document.getElementById('total_pagar').textContent = totalAcumulado.toLocaleString("en-US");

    return { productos: Object.values(productosAgrupados), total: totalAcumulado };
}



$('#btnVaciar').click(function () {
    $('#btnContinuar').prop('disabled', true); //desactiva el botón
    borrarProductosDelCarrito();
    setTimeout(() => {
        window.location.reload();
    }, 1000);
});
function borrarProductosDelCarrito() {
    localStorage.removeItem('productosCarrito'); // Borrar solo los productos del carrito
    // localStorage.clear(); 
    contadorCarrito = 0; // Restablecer el contador del carrito a 0
    // document.getElementById('carrito').textContent = contadorCarrito; // Actualizar el texto del contador en la interfaz
    cargarProductosDelCarrito(); // Recargar los productos del carrito 
}


