<div id="productosEdit{{$producto->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="title">Editar Producto</h5>
                <button type="button" class="btn-close dark-x" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="edit-productos-{{$producto->id}}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" value="{{ url('/') }}" id="url-{{$producto->id}}">
                    <input type="hidden" value="{{$producto->id}}" id="id-{{$producto->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre-{{$producto->id}}" class="form-control" type="text" name="nombre" placeholder="Nombre" value="{{$producto->nombre}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input id="cantidad-{{$producto->id}}" class="form-control" type="text" name="cantidad" placeholder="Cantidad" value="{{$producto->cantidad}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion-{{$producto->id}}" class="form-control" name="descripcion" placeholder="Descripción" rows="3" required>{{$producto->descripcion}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_normal">Precio Normal</label>
                                <input id="p_normal-{{$producto->id}}" class="form-control" type="text" name="p_normal" placeholder="Precio Normal" value="{{$producto->precio_normal}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_rebajado">Precio Rebajado</label>
                                <input id="p_rebajado-{{$producto->id}}" class="form-control" type="text" name="p_rebajado" placeholder="Precio Rebajado" value="{{$producto->precio_rebajado}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <select id="categoria-{{$producto->id}}" class="form-select" name="categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                    <option value="{{$categoria->id}}" @if($categoria->id == $producto->id_categoria) selected @endif>{{$categoria->categoria}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="imagen">Foto:</label>
                                <br>
                                @if ($producto->foto)
                                <img src="{{ asset('/' . $producto->foto) }}" width="90" height="90">
                                @else
                                Sin imagen
                                @endif
                                <button type="button" id="btnMostrar-{{$producto->id}}" class="btn btn-dark mt-2"><i class="fas fa-plus"></i> Cambiar</button>
                                <div class="mostrar-{{$producto->id}}" style="display:none;">
                                    <input type="file" class="form-control subirImg mt-2" name="foto" id="foto-{{$producto->id}}" accept="image/png, image/jpeg">
                                    <button type="button" id="btnCancelar-{{$producto->id}}" class="btn btn-danger mt-2"><i class="fas fa-times"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <button class="btn btn-primary actualizar" type="button" id="actualizarProducto-{{$producto->id}}" data-id="{{$producto->id}}">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('[id^=btnMostrar]').off('click').on('click', function () {
        var id = $(this).attr('id').split('-')[1];
        console.log('Botón "Cambiar" clicado para el producto ' + id);
        $('.mostrar-' + id).show();  
        $('#btnMostrar-' + id).hide();  
    });

    $('[id^=btnCancelar]').off('click').on('click', function () {
        var id = $(this).attr('id').split('-')[1];
        console.log('Botón "Cancelar" clicado para el producto ' + id);
        $('.mostrar-' + id).hide();  
        $('#btnMostrar-' + id).show();  
    });

    $('[id^=actualizarProducto]').off('click').on('click', function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        confirSave("¿Los datos capturados son correctos?", function () {
            var formElement = $('#edit-productos-' + id)[0];
            updateProducto(id, formElement);
        });
    });
});

async function updateProducto(id, formElement) {
    var url = $('#url-' + id).val();
    try {
        var formData = new FormData(formElement);

        var response = await fetch(url + '/productos/update/' + id, {
            method: 'POST',
            mode: 'cors',
            redirect: 'manual',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
        });

        var data = await response.json();
        switch (data.idnotificacion) {
            case 1:
                Swal.fire({
                    title: data.mensaje,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                });
                setTimeout(function () {
                    document.getElementById('edit-productos-' + id).reset();
                    window.location.reload();
                }, 1000);
                break;

            case 2:
            case 3:
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: data.mensaje
                });
                break;

            default:
                Swal.fire({
                    icon: "info",
                    title: "Info...",
                    text: "Error desconocido"
                });
        }

    } catch (error) {
        console.error("Error al procesar la solicitud:", error);
    }
}
</script>
