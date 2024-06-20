<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Carrito de Compras</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/estilos.css')}}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

</head>

<body>

    <!-- Navigation-->
    <nav id="header" class="navbar navbar-expand-lg bg-body-tertiary sticky-top " data-bs-spy="scroll">
        <div class="container">
            <a id="logo-nav" class="navbar-brand " href="index.php?page=shop" target="_self"><img src="images/logoASP.png" alt="" class="nav-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex justify-content-around align-items-center">
                    <form id="cliente" class="container-fluid d-flex justify-content-around align-items-center">
                        <a class="nav-link" href="index.php?page=shop" target="_self" id="btnVolverTienda">
                            <button class="btn btn-outline-dark me-2" type="button">Tienda</button>
                        </a>
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">MI CARRITO</h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0">Tus Productos Agregados.</p> -->
            </div>
        </div>
    </header>

    <section class="container-fluid ">
        <div class="row d-flex justify-content-center">
            <div class="col col-lg-6 col-md-6 col-sm-12 altaCliente card bg-dark text-dark" style="transform: none; transition: none;">
                <form action="" id="Datos" method="POST" enctype="multipart/form-data">
                    <div class="subtitulo pt-3">
                        <h3 style="color: #e0e1dd">Ingresa tus datos</h3>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombre" name="nombre_completo" placeholder="Direccion" required>
                        <label for="direccion">Nombre</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="numeric" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                        <label for="telefono">Teléfono</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingresa a la direccion donde hará la entrega del pedido" required>
                        <label for="nombre">Dirreci&oacute;n de entrega</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="micorreo@hotmail.com" required>
                        <label for="email">Correo Electrónico</label>
                    </div>

                    <div class="row pb-2">
                        <div class="col-6  d-flex justify-content-center">
                            <button class="btn btn-success" type="submit" id="btnFinalizar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M0 8a8 8 0 1 0 16 0A8 8 0 0 0 0 8m5.904 2.803a.5.5 0 1 1-.707-.707L9.293 6H6.525a.5.5 0 1 1 0-1H10.5a.5.5 0 0 1 .5.5v3.975a.5.5 0 0 1-1 0V6.707z" />
                                </svg>
                                Realizar pedido
                            </button>
                        </div>
                        <div class="col-6  d-flex justify-content-center">
                            <button class="btn btn-danger" type="button" id="btnCancelar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                                </svg>
                                Cancelar pedido
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <div class="col col-lg-6 col-md-6 col-sm-12 tabla  card bg-dark text-dark" style="transform: none; transition: none;">
                <div class="subtitulo pt-3">
                    <h3 style="color: #e0e1dd">Mi Carrito</h3>
                </div>
                <div class="">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Imagen</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblCarrito">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-5 ms-auto ">
                                <h4 style="color: #e0e1dd">Total a Pagar: <span id="total_pagar">0.00</span></h4>
                                <div class="row pb-2">
                                    <div class="col col-md-6 col-sm-12">
                                        <button class="btn btn-secondary" type="button" id="btnVaciar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                            </svg>
                                            Vaciar Carrito
                                        </button>
                                    </div>
                                    <div class="col col-md-6 col-sm-12">
                                        <button class="btn btn-success" type="button" id="btnContinuar" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1" />
                                            </svg>
                                            Realizar pedido
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container py-5">
            <p class="m-0 text-center text-white">Copyright &copy; ASP Publicidad 2024</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <!-- Core theme JS-->
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>

    

</body>

</html>