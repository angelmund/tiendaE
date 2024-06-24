<x-guest-layout>
  
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Iniciar Sesión</title>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/sb-admin-2.min.css')}}">
        <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background: linear-gradient(to right, #2c3e50, #e0e1dd);
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
                border-radius: 1.2rem;
            }
            .block label {
                color: #4a4a4a;
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
                                            <!-- Session Status -->
                                            <x-auth-session-status class="mb-4" :status="session('status')" />
                                        
                                            <!-- Error Message -->
                                            @if(session('error'))
                                                <div class="alert alert-danger" role="alert">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                            <h1 class="h4 text-gray-900 mb-4">Iniciar Sesión</h1>
                                            
                                        </div>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                    
                                            <!-- Email Address -->
                                            <div class="form-group">
                                                <x-input-label for="email" :value="__('Email')" />
                                                <x-text-input id="email" class="form-control form-control-user" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                                {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                                            </div>
                                    

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <!-- Password -->
                                            <div class="form-group mt-4">
                                                <x-input-label for="password" :value="__('Password')" />
                                                <x-text-input id="password" class="form-control form-control-user" type="password" name="password" required autocomplete="current-password" />
                                                {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                                            </div>
                                    
                                            <!-- Remember Me -->
                                            <div class="block mt-4">
                                                <label for="remember_me" class="inline-flex items-center">
                                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                                    <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                                                </label>
                                            </div>
                                    
                                            <div class="flex items-center justify-end mt-4">
                                                @if (Route::has('password.request'))
                                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                                        {{ __('¿Olvidó su contraseña?') }}
                                                    </a>
                                                @endif
                                    
                                                <x-primary-button class="btn btn-primary ms-3">
                                                    {{ __('Iniciar Sesión') }}
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
    