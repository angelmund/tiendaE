<x-guest-layout>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Restablecer Contraseña</title>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/sb-admin-2.min.css')}}">
        <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background: linear-gradient(to right, #212529, #d90429);
            }
            .card {
                border-radius: 15px;
                overflow: hidden;
            }
            .bg-login-image {
                background: url('{{asset('images/logoASP.png')}}') center center no-repeat;
                background-size: contain;
            }
            .text-center h1 {
                font-size: 2rem;
                font-weight: bold;
                color: #4a4a4a;
            }
            .text-gray-900 {
                color: #4a4a4a !important;
            }
            .form-control {
                border-radius: 50px;
            }
            .form-group {
                margin-bottom: 1.5rem;
            }
            .alert {
                border-radius: 50px;
            }
            .block label {
                color: #4a4a4a;
            }
            .text-sm {
                font-size: 0.875rem;
            }
        </style>
    </head>
    
    <body>
    
        <div class="container">
    
            <!-- Outer Row -->
            <div class="row justify-content-center">
    
                <div class="col-xl-10 col-lg-12 col-md-9">
    
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Restablecer Contraseña</h1>
                                        </div>
                                        <div class="mb-4 text-sm text-gray-600">
                                            {{ __('¿Olvidaste tu contraseña? Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace para restablecer su contraseña que le permitirá elegir una nueva.') }}
                                        </div>
    
                                        <!-- Session Status -->
                                        <x-auth-session-status class="mb-4" :status="session('status')" />
    
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf
    
                                            <!-- Email Address -->
                                            <div class="form-group">
                                                <x-input-label for="email" :value="__('Email')" />
                                                <x-text-input id="email" class="form-control form-control-user" type="email" name="email" :value="old('email')" required autofocus />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>
    
                                            <div class="d-flex justify-content-center">
                                                <x-primary-button class="btn btn-primary">
                                                    {{ __('Enviar enlace') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
    
            </div>
    
        </div>
    
        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    
        <!-- Core plugin JavaScript-->
        <script src="{{asset('assets/js/jquery.easing.min.js')}}"></script>
    
        <!-- Custom scripts for all pages-->
        <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    
    </body>
    
    </html>
    </x-guest-layout>
    