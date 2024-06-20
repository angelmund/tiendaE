$(document).ready(function () {
    let productos = [];
    let items = {
        id: 0
    }
    mostrar();
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

    $('.agregar').click(function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        items = {
            id: id
        }
        productos.push(items);
        localStorage.setItem('productos', JSON.stringify(productos));
        mostrar();
    });

    $('#btnCarrito').click(function (e) {
        $('#btnCarrito').attr('href', 'carrito.php');
    });

    $('#btnVaciar').click(function () {
        localStorage.removeItem("productos");
        $('#tblCarrito').html('');
        $('#total_pagar').text('0.00');
        //se agrega el disable para  que no tenga funcionalidad
        $("#btnContinuar").attr('disabled', 'disabled');
    });

    $('#btnVolverTienda').click(function () {
        localStorage.removeItem("productos");
    });

    //categoria
    $('#abrirCategoria').click(function () {
        $('#categorias').modal('show');
    });

    //productos
    $('#abrirProducto').click(function () {
        $('#productos').modal('show');
    });

    $('.eliminar').click(function (e) {
        e.preventDefault();
        if (confirm('Esta seguro de eliminar?')) {
            this.submit();
        }
    });
});

function mostrar() {
    if (localStorage.getItem("productos") != null) {
        let array = JSON.parse(localStorage.getItem('productos'));
        if (array) {
            $('#carrito').text(array.length);
        }
    }
}



$(".altaCliente").hide();
mostrarCarrito();

function mostrarCarrito() {
    if (localStorage.getItem("productos") != null) {
        let array = JSON.parse(localStorage.getItem('productos'));
        if (array.length > 0) {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: true,
                data: {
                    action: 'buscar',
                    data: array
                },
                success: function (response) {
                    console.log(response);
                    const res = JSON.parse(response);
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

                    let html = '';
                    Object.values(productosContados).forEach(prod => {
                        html += `
                <tr>
                    <td>${prod.nombre}</td>
                    <td><img class="img-thumbnail" src="./assets/img/${prod.imagen}" width="100"></td>
                    <td>${prod.precio}</td>
                    <td>${prod.cantidad}</td>
                    <td>${prod.precio * prod.cantidad}</td>
                </tr>
                `;
                    });

                    if (res.datos.length > 0) {
                        $("#btnContinuar").removeAttr('disabled');
                    } else {
                        $("#btnContinuar").attr('disabled', 'disabled');
                    }
                    $('#tblCarrito').html(html);
                    $('#total_pagar').text(res.total);

                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }
    }
}

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


function obtenerDatosCarrito() {
    const datosCarritoJSON = localStorage.getItem("productos");
    if (datosCarritoJSON) {
        try {
            const datosCarrito = JSON.parse(datosCarritoJSON);
            let total = 0; // Inicializar total
            const productosConCantidadPrecio = datosCarrito.map(producto => {
                const cantidad = producto.cantidad || 1; // Default to 1 if not provided
                const precio = producto.precio || 0; // Default to 0 if not provided
                total += cantidad * precio; // Calcular total
                return {
                    ...producto,
                    cantidad,
                    precio
                };
            });
            return { productos: productosConCantidadPrecio, total }; // Devolver productos y total
        } catch (error) {
            console.error('Error al parsear JSON de productos:', error);
            return null;
        }
    } else {
        return { productos: [], total: 0 }; // Devolver productos vacíos y total 0 si no hay datos
    }
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
            fetch('./controller/Pedido.php', {
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
                            window.location.href = "http://localhost/tiendaDemo/index.php?page=shop";
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