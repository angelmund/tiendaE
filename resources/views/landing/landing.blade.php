
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ASP PUBLICIDAD</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/estilos.css')}}" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<style>
    .text-justify{
        text-align: justify
    }
</style>
<body>

    <nav id="header" class="navbar navbar-expand-lg bg-body-tertiary sticky-top " data-bs-spy="scroll">
        <div class="container">
            <a id="logo-nav" class="navbar-brand " href="#"><img src="images/logoASP.png" alt="" class="nav-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex justify-content-around align-items-center">
                    <li id="nosotrosNav" class="nav-item d-none d-md-block">
                        <a class="nav-link " href="#nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#nuestroTrabajo">Conócenos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                    <form class="container-fluid d-flex justify-content-around align-items-center">
                        <a class="nav-link" href="{{route('tienda')}}" target="_blank">
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
                <h1 class="display-4 fw-bolder">ASP PUBLICIDAD</h1>
                <p class="lead fw-normal text-white-50 mb-0">¡Confía en ASP Publicidad y lleva tu marca al siguiente nivel!</p>
            </div>
        </div>
    </header>

    <section id="nosotros" class="container-fluid mt-4" data-aos="fade-up"  data-aos-duration="1000" >
        <div class="section-title">
            <h2>Nosotros</h2>
        </div>

        <div class="row ">
            <div class="col-12 col-md-4  d-flex justify-content-center align-items-center"  data-aos="fade-right"  data-aos-duration="1000">
                <div class="container">
                    <div class=" subtitulo">
                        <h6>¿Quienes somos?</h6>
                    </div>
                    <p class="fs-5 text-justify">En ASP Publicidad, somos especialistas en brindar soluciones innovadoras y de alta calidad para todas tus necesidades de rotulación, estampados, cerigrafía y publicidad. Con años de experiencia en el sector, nos hemos consolidado como un referente en la impresión de lonas y folletos, ofreciendo a nuestros clientes productos y servicios que destacan por su excelencia y atención al detalle.</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center"  data-aos="fade-up"  data-aos-duration="1000">

                <div class="container">
                    <div class="text-center mb-2">
                        <img src="{{asset('images/logoASP.png')}}" alt="" class="logo-img">
                    </div>
                    <div class=" subtitulo mt-5">
                        <h6>Nuestro equipo</h6>
                    </div>
                    <p class="fs-5 text-justify"> Nuestro equipo de profesionales apasionados y dedicados trabaja con tecnología de vanguardia para asegurarse de que cada proyecto cumpla con los más altos estándares de calidad. Desde la conceptualización hasta la entrega final, nos esforzamos por superar las expectativas de nuestros clientes, proporcionando resultados que no solo satisfacen sus necesidades, sino que también potencian la visibilidad y el impacto de sus marcas.</p>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center"  data-aos="fade-left"  data-aos-duration="1000">

                <div class="container">
                    <div class=" subtitulo">
                        <h6>Nuestro servicio</h6>
                    </div>
                    <p class="fs-5 text-justify">En ASP Publicidad, entendemos que cada cliente es único, por eso ofrecemos soluciones personalizadas y asesoramiento experto para ayudarte a elegir las mejores opciones para tu negocio. Ya sea que necesites rotulación creativa, estampados personalizados, impresiones precisas o campañas publicitarias efectivas, estamos aquí para ayudarte a destacar y alcanzar tus objetivos.</p>
                </div>
            </div>
        </div>
    </section>


    <section id="servicios" class="container marketing">

        <div class="section-title">
            <h2>Nuestros servicios</h2>
        </div>

        <div class="row  d-flex justify-content-center align-items-center">

            <div class="col-lg-4"  data-aos="fade-down">
                <div class="rounded-container container">
                    <img src="{{asset('images/impresion.png')}}" alt="">
                </div>
                <h2 class="fw-normal">Impresiones</h2>
                <p>Ofrecemos servicios de impresión de alta calidad para todas sus necesidades, desde folletos y tarjetas de presentación hasta posters y materiales promocionales.</p>
            </div>

            <div class="col-lg-4" data-aos="fade-down"  data-aos-duration="1000">
                <div class="rounded-container container" >
                    <img src="{{asset('images/rotulo.png')}}" alt="">
                </div>
                <h2 class="fw-normal">Rótulos</h2>
                <p>Diseñamos y fabricamos rótulos personalizados para negocios y eventos, utilizando materiales duraderos y técnicas de impresión avanzadas para garantizar una excelente visibilidad.</p>
            </div>

            <div class="col-lg-4" data-aos="fade-down"  data-aos-duration="1000">
                <div class="rounded-container container" >
                    <img src="{{asset('images/folleto.png')}}" alt="">
                </div>
                <h2 class="fw-normal">Folletos</h2>
                <p>Creación de folletos atractivos y profesionales que capturan la esencia de su mensaje y ayudan a promocionar sus productos o servicios de manera efectiva.</p>
            </div>

            <div class="col-lg-4" data-aos="fade-up"  data-aos-duration="1000">
                <div class="rounded-container container">
                    <img src="{{asset('images/camisetas.png')}}" alt="">
                </div>
                <h2 class="fw-normal">Camisetas Personalizadas</h2>
                <p>Creamos camisetas personalizadas con serigrafía de alta calidad, ideales para promocionar su marca o evento especial.</p>
            </div>

            <div class="col-lg-4" data-aos="fade-up"  data-aos-duration="1000">
                <div class="rounded-container container">
                    <img src="{{asset('images/vinilos.png')}}" alt="">
                </div>
                <h2 class="fw-normal">Vinilos Decorativos</h2>
                <p>Diseñamos y producimos vinilos decorativos para paredes, ventanas y vehículos, ofreciendo soluciones creativas para su espacio.</p>
            </div>

            <div class="col-lg-4" data-aos="fade-up"  data-aos-duration="1000">
                <div class="rounded-container container">
                    <img src="{{asset('images/mas_servicios.png')}}" alt="">
                </div>
                <h2 class="fw-normal">Y Más Servicios</h2>
                <p>Además, ofrecemos una amplia gama de servicios adicionales como tarjetas de presentación, lonas, sublimado de tazas, gorras, termos, y mucho más. ¡Contáctenos para personalizar cualquier proyecto!</p>
            </div>


        </div>
    </section>

    <section id="nuestroTrabajo" class="container" data-aos="fade-up"  data-aos-duration="1000">
        <div class="row">
            <div class="col-12 col-md-12 gallery-hover">
                <div class="gallery row">
                    <div class="text-center section-title">
                        <h2>Conoce nuestro trabajo</h2>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 mb-3">
                        <a href="{{asset('images/galeria1.png')}}" data-lightbox="mygallery" data-title="Imagen 1">
                            <img src="{{asset('images/galeria1.png')}}" class="img-thumbnail">
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 mb-3">
                        <a href="{{asset('images/galeria2.png')}}" data-lightbox="mygallery" data-title="Imagen 2">
                            <img src="{{asset('images/galeria2.png')}}" class="img-thumbnail">
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 mb-3">
                        <a href="{{asset('images/galeria3.png')}}" data-lightbox="mygallery" data-title="Imagen 3">
                            <img src="{{asset('images/galeria3.png')}}" class="img-thumbnail">
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 mb-3">
                        <a href="{{asset('images/galeria4.png')}}" data-lightbox="mygallery" data-title="Imagen 4">
                            <img src="{{asset('images/galeria4.png')}}" class="img-thumbnail">
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 mb-3">
                        <a href="{{asset('images/galeria5.png')}}" data-lightbox="mygallery" data-title="Imagen 5">
                            <img src="{{asset('images/galeria5.png')}}" class="img-thumbnail">
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 mb-3">
                        <a href="{{asset('images/galeria6.png')}}" data-lightbox="mygallery" data-title="Imagen 6">
                            <img src="{{asset('images/galeria6.png')}}" class="img-thumbnail">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="container" data-aos="fade-up"  data-aos-duration="1000">

        <div class="section-title">
            <h2>Contacto</h2>
        </div>

        <div class="row d-flex justify-content-center">
            <div id="direccion" class="col-12 col-md-4 mx-2 d-flex flex-column justify-content-center align-items-center card text-bg-dark" style="transform: none; transition: none;">
                <div class="contact-info text-center">
                    <h3>Dirección</h3>
                    <p>Av. Américas 35, Aguacatal, 91133 Xalapa-Enríquez, Veracruz</p>
                </div>
            </div>

            <a href="https://wa.me/2281940164" target="_blank" class="card-link col-12 col-md-4 mx-2 d-flex flex-column justify-content-center align-items-center card text-bg-dark">
                <div class="contact-info text-center fs-3">
                    <p class="mt-3">
                        <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
                    </p>
                </div>
            </a>


            <div class="col-12 col-md-12 mt-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3820.285866168434!2d-96.92607378465383!3d19.529600686845275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85db31f8d50cf30f%3A0x4b5f67c5b7459c13!2sAv.%20Am%C3%A9ricas%2035%2C%20Aguacatal%2C%2091133%20Xalapa-Enr%C3%ADquez%2C%20Ver.%2C%20Mexico!5e0!3m2!1sen!2sus!4v1622905581819!5m2!1sen!2sus" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; ASP Publicidad 2024</p>
        </div>
    </footer>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Core theme JS-->
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>

    <script>
        AOS.init();
    </script>

    
</body>

</html>
