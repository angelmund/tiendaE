<!-- Modal -->
<div class="modal fade" id="permiso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content ">
      <div class="modal-header ">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar nuevo permiso</h1>
        <button type="button" class="btn-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-teal-500">
        <form id="form-permiso" action="#" method="POST" entype="multipart/form-data">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          @csrf

          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control  @error ('nombre') border-red-500 @enderror" id="nombre"
              name="nombre" required>
            @error('nombre')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"> {{$message}} </p>
            @enderror

            @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
            @endif
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_save"><i class="fas fa-save"></i> Guardar</button>
            <button type="button" class="btn btn-danger ms-2" id="limpiar" data-bs-dismiss="modal"><i
                class="fas fa-close"></i> Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>