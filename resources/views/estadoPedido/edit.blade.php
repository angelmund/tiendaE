<div id="editEstado{{$pedido->id_detalles_pedido}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="title">Editar Estado del Pedido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-actualizarEstado">
                    @csrf
                    <input type="hidden" value="{{ url('/') }}" id="url">
                    <input type="hidden" name="idDetallePedido" value="{{$pedido->id_detalles_pedido}}" id="idDetallePedido">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nombre">Estado</label>
                                <select name="idEstado" class="form-control">
                                    @foreach($estados as $estado)
                                        <option value="{{$estado->idEstado}}" {{$pedido->idEstado == $estado->idEstado ? 'selected' : ''}}>{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary actualizar" type="button" id="actualizar" data-id="{{$pedido->id_detalles_pedido}}">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('assets/js/detallePedidos.js')}}"></script>