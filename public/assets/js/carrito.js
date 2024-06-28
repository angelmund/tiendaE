document.addEventListener('DOMContentLoaded', function() {
    cargarProductosDelCarrito();
});

function cargarProductosDelCarrito() {
    const productos = JSON.parse(localStorage.getItem('productosCarrito')) || [];
    const tbody = document.getElementById('tblCarrito');
    const productosAgrupados = productos.reduce((cantipro, producto) => {
        if (!cantipro[producto.id]) {
            cantipro[producto.id] = {...producto, cantidad: 1, subtotal: producto.precio};
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

    if(Object.keys(productosAgrupados).length > 0){
        $('#btnContinuar').prop('disabled', false);
    }

    document.getElementById('total_pagar').textContent = totalAcumulado.toLocaleString("en-US");

    // Devolver los productos agrupados y el total acumulado
    return {
        productos: Object.values(productosAgrupados), // Convertir el objeto de productos agrupados a un array
        total: totalAcumulado
    };
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