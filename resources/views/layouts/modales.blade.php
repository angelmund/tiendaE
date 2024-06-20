{{--  <div class="modal fade" id="ModalCreate" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Crear</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn_update"><i class="fas fa-save"></i> Actualizar</button>
                <button type="button" class="btn btn-danger ms-2" id="btn_cerrar" data-bs-dismiss="modal"><i class="fas fa-times"></i>Cerrar</button>
            </div>
        </div>
    </div>
</div>  --}}

<!-- createModal -->
{{--  <div class="modal fade" id="editModali" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="miModalLabel">Editar Proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body pb-2 px-sm-2 pt-50">
                <form id="formedit-proyecto" action="/proyectos/update" method="POST" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @csrf
    
                    <div class="mb-3">
                        <label for="claveProyecto_edit" class="form-label">Clave Proyecto:</label>
                        <input type="hidden" id="idproyectos" >
                        <input type="text" class="form-control" id="claveProyecto_edit" name="claveProyecto_edit"
                            >
                            
                    </div>
                    <div class="mb-3">
                        <label for="nombreProyecto_edit" class="form-label">Nombre Proyecto:</label>
                        <input type="text" class="form-control" id="nombreProyecto_edit" name="nombreProyecto_edit"
                            >
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_edit" class="form-label">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion_edit" name="descripcion_edit"
                            >
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion_edit" class="form-label">Ubicación:</label>
                        <input type="text" class="form-control" id="ubicacion_edit" name="ubicacion_edit"
                            >
                    </div>
                    <div class="mb-3">
                        <label for="encargado_edit" class="form-label">Encargado:</label>
                        <input type="text" class="form-control" id="encargado_edit" name="encargado_edit"
                            >
                    </div>
                    <div class="mb-3">
                        <label for="presupuesto_edit" class="form-label">Presupuesto:</label>
                        <input type="text" class="form-control" id="presupuesto_edit" name="presupuesto_edit"
                            >
                    </div>
                    <div class="mb-3">
                        <label for="cantMaxParticipantes_edit" class="form-label">Cantidad Máxima de
                            participantes:</label>
                        <input type="text" class="form-control" id="cantMaxParticipantes_edit"
                            name="cantMaxParticipantes_edit" >
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn_update"><i class="fas fa-save"></i>
                    Actualizar</button>
                <button type="button" class="btn btn-danger ms-2" id="btn_cerrar" data-bs-dismiss="modal"><i
                        class="fas fa-times"></i>Cerrar</button>
            </div>
        </div>
    </div>
</div>  --}}

{{--  
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Crear</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal -->
                <input type="hidden" value="{{ url('/') }}" id="url">
                <form id="formedit-proyecto" action="/proyectos/update" method="POST" enctype="multipart/form-data">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @csrf
                 
                    <div class="mb-3">
                        <label for="claveProyecto_edit" class="form-label">Clave Proyecto:</label>
                        <input type="hidden" id="idproyectos" value="">
                        <input type="text" class="form-control" id="claveProyecto_edit" name="claveProyecto_edit" value="">
                    </div>
                    <div class="mb-3">
                        <label for="nombreProyecto_edit" class="form-label">Nombre Proyecto:</label>
                        <input type="text" class="form-control" id="nombreProyecto_edit" name="nombreProyecto_edit" value="">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_edit" class="form-label">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion_edit" name="descripcion_edit" value="">
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion_edit" class="form-label">Ubicación:</label>
                        <input type="text" class="form-control" id="ubicacion_edit" name="ubicacion_edit" value="">
                    </div>
                    <div class="mb-3">
                        <label for="encargado_edit" class="form-label">Encargado:</label>
                        <input type="text" class="form-control" id="encargado_edit" name="encargado_edit" value="">
                    </div>
                    <div class="mb-3">
                        <label for="presupuesto_edit" class="form-label">Presupuesto:</label>
                        <input type="text" class="form-control" id="presupuesto_edit" name="presupuesto_edit" value="">
                    </div>
                    <div class="mb-3">
                        <label for="cantMaxParticipantes_edit" class="form-label">Cantidad Máxima de participantes:</label>
                        <input type="text" class="form-control" id="cantMaxParticipantes_edit" name="cantMaxParticipantes_edit" value="">
                    </div>
                    
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_update"><i class="fas fa-save"></i> Actualizar</button>
                        <button type="button" class="btn btn-danger ms-2" id="btn_cerrar" data-bs-dismiss="modal"><i class="fas fa-times"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  --}}