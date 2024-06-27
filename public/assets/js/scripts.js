$(document).ready(function () {
    let productos = [];
    let items = {
        id: 0
    }

    $('.navbar-nav .nav-link[category="all"]').addClass('active');

    $('.nav-link').click(function () {
        let productos = $(this).attr('category');

        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        $('.productos').css('transform', 'scale(0)');

        function ocultar() {
            $('.productos').hide();
        }
        setTimeout(ocultar, 400);

        function mostrar() {
            $('.productos[category="' + productos + '"]').show();
            $('.productos[category="' + productos + '"]').css('transform', 'scale(1)');
        }
        setTimeout(mostrar, 400);
    });

    $('.nav-link[category="all"]').click(function () {
        function mostrarTodo() {
            $('.productos').show();
            $('.productos').css('transform', 'scale(1)');
        }
        setTimeout(mostrarTodo, 400);
    });


  

    $('#btnVolverTienda').click(function () {
        localStorage.removeItem('productosCarrito');
    });

});



// Inicializar el contador del carrito
let contadorCarrito = 0;

document.querySelectorAll('.btn-agregar-carrito').forEach(button => {
    button.addEventListener('click', function () {
        contadorCarrito++;
        document.getElementById('carrito').textContent = contadorCarrito; // Actualizar contador de carrito

        // Obtener información del producto
        const card = button.closest('.card');
        const nombreProducto = card.querySelector('.fw-bolder').textContent;
        const precioProducto = card.querySelector('.text-muted').textContent.replace('$', '').replace(',', ''); // Remover símbolo de moneda y comas
        const imagenProducto = card.querySelector('img').src;
        const idProducto = card.querySelector('.idProducto').value; // Obtener el valor del input oculto

        // Crear objeto de producto
        const producto = {
            id: idProducto,
            nombre: nombreProducto,
            precio: parseFloat(precioProducto), // Convertir a número
            imagen: imagenProducto
        };

        console.log(nombreProducto, precioProducto, imagenProducto, idProducto);
        // Agregar producto al carrito
        guardarProductoEnLocalStorage(producto); 
    });
});

function guardarProductoEnLocalStorage(producto) {
    let productos = JSON.parse(localStorage.getItem('productosCarrito')) || [];
    productos.push(producto);
    localStorage.setItem('productosCarrito', JSON.stringify(productos));
}

$(".altaCliente").hide();
// mostrarCarrito();


$('#btnContinuar').on('click', function () {
    // localStorage.removeItem('productos');
    $(".altaCliente").show();
    $(".tabla").hide();
});
$('#btnCancelar').on('click', function () {
    // localStorage.removeItem('productos');
    $(".altaCliente").hide();
    $(".tabla").show();
});

if ($('#btnFinalizar').length > 0) {
    document.querySelector('#btnFinalizar').addEventListener("click", function (event) {
        event.preventDefault();
        const formData = new FormData(document.getElementById('Datos'));

        // Obtener los datos del carrito desde el localStorage
        const datosCarrito = obtenerDatosCarrito();
        console.log(datosCarrito);
        if (!datosCarrito || datosCarrito.productos.length === 0) {
            Swal.fire({
                title: "Error",
                text: "No hay productos en el carrito o los datos están corruptos.",
                icon: "error"
            });
            return;
        }
        let productosContados = {};
        res.datos.forEach(element => {
            // Si el producto ya está en el objeto, incrementa la cantidad
            if (productosContados[element.id]) {
                productosContados[element.id].cantidad += 1;
            } else {
                // Si no, agrega el producto al objeto con cantidad inicial de 1
                productosContados[element.id] = {
                    ...element,
                    cantidad: 1
                };
            }
        });

        const datosCarritoJSON = JSON.stringify(datosCarrito.productos);

        // Añadir los datos del carrito al FormData
        formData.append('productos', datosCarritoJSON);
        formData.append('total', datosCarrito.total); // Añadir total al FormData
        console.log(formData);

        enviar(formData);
    });
}




function enviar(formData) {
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
            fetch('', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Pedido realizado",
                            text: "Su pedido ha sido realizado con éxito",
                            icon: "success"
                        });
                        setTimeout(() => {
                            localStorage.removeItem('productos'); // Limpiar el carrito después de realizar el pedido
                            //window.location.href = "http://localhost/tiendaDemo/index.php?page=shop";
                        }, 3000);


                        localStorage.removeItem('productos'); // Limpiar el carrito después de realizar el pedido
                        console.log(data);
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: data.message,
                            icon: "error"
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