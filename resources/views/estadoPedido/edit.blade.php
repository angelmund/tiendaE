<div id="editEstado{{$pedido->idPedido}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="title">Editar Estado del Pedido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pedidos.update', $pedido->idPedido) }}" method="POST" id="form-actualizarEstado">
                    @csrf
                    @method('PUT')
                    <input type="hidden" value="{{ url('/') }}" id="url">
                    <input type="hidden" name="idPedido" value="{{$pedido->idPedido}}" id="id">
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
                    <button class="btn btn-primary actualizar" type="submit" id="actualizar">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>


