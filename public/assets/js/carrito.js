document.addEventListener('DOMContentLoaded', function() {
    cargarProductosDelCarrito();
});

function cargarProductosDelCarrito() {
    const productos = JSON.parse(localStorage.getItem('productosCarrito')) || [];
    const tbody = document.getElementById('tblCarrito');

    // Agrupar productos por ID y sumar cantidades y subtotales
    const productosAgrupados = productos.reduce((cantipro, producto) => {
        if (!cantipro[producto.id]) {
            cantipro[producto.id] = {...producto, cantidad: 1, subtotal: producto.precio};
        } else {
            cantipro[producto.id].cantidad++;
            cantipro[producto.id].subtotal = cantipro[producto.id].cantidad * cantipro[producto.id].precio;
        }
        return cantipro;
    }, {});

    let totalAcumulado = 0; // Inicializar total acumulado

    // Iterar sobre productos agrupados para crear elementos tr
    Object.values(productosAgrupados).forEach(producto => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${producto.nombre}</td>
            <td><img src="${producto.imagen}" width="50" height="50"></td>
            <td>${producto.precio}</td>
            <td>${producto.cantidad}</td>
            <td>${producto.subtotal}</td> <!-- Corregido para mostrar el subtotal -->
        `;
        tbody.appendChild(tr);
        totalAcumulado += producto.subtotal; // Sumar al total acumulado
    });

    // Mostrar el total acumulado en la consola o en la tabla
    console.log(totalAcumulado);
    document.getElementById('total_pagar').textContent = totalAcumulado.toFixed(2);
}

$('#btnVaciar').click(function () {
    console.log('Borrando productos del carrito...');
    borrarProductosDelCarrito();
    setTimeout(() => {
        window.location.reload();
    }, 1000);
});
function borrarProductosDelCarrito() {
    localStorage.removeItem('productosCarrito'); // Borrar solo los productos del carrito
    // localStorage.clear(); // si deseas borrar todo el localStorage
    contadorCarrito = 0; // Restablecer el contador del carrito a 0
    // document.getElementById('carrito').textContent = contadorCarrito; // Actualizar el texto del contador en la interfaz
    cargarProductosDelCarrito(); // Recargar los productos del carrito para actualizar la interfaz
}