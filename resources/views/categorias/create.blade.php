<div id="categoria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="title">Nueva Categoría</h5>
                <button type="button" class="btn-close dark-x" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('categorias.store')}}" method="POST" id="Form-categorias" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" value="{{ url('/') }}" id="url">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-primary" type="button" id="guardarCategoria">Registrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>