$(document).ready(function () {
    
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
        const precioProducto = card.querySelector('.text-muted').textContent.replace('$', '').replace(',', '');
        const imagenProducto = card.querySelector('img').src;
        const idProducto = card.querySelector('.idProducto').value; // Obtener el valor del input oculto

        // Crear objeto de producto
        const producto = {
            id: idProducto,
            nombre: nombreProducto,
            precio: parseFloat(precioProducto), // Convertir a número
            imagen: imagenProducto
        };
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
    $(".altaCliente").show();
    $(".tabla").hide();
});

$('#btnCancelar').on('click', function () {
    // localStorage.removeItem('productos');
    $(".altaCliente").hide();
    $(".tabla").show();
});

