
<x-app-layout>

    <div class="container">
        <div class="row mt-6">
            <div class="card mt-5 ">
                <div class="card-body ">
                    <h1 class="text-center">Formulario de Inscripción</h1>
                    <input type="hidden" value="{{ url('/') }}" id="url">
                    <form id="form-usuario" action="#" method="POST" enctype="multipart/form-data"
                        class="bg-Light p-4 rounded">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">
                                Por favor agregue un nombre.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">
                                Por favor agregue un correo.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">
                                Por favor agregue un nombre.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol:</label>
                            <select id="rol" class="form-control" name="rol" required>
                                <option value="">Selecciona un rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor selecciona una opción.
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn_save"><i
                                    class="fas fa-save"></i> Guardar Usuario</button>
                            <button type="button" class="btn btn-danger ms-2" id="limpiar" data-bs-dismiss="modal"><i
                                    class="fas fa-trash"></i> Limpiar formulario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
</x-app-layout>