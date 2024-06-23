<div id="productosEdit{{$producto->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="title">Editar Producto</h5>
                <button type="button" class="btn-close dark-x" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="edit-productos" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" value="{{ url('/') }}" id="url">
                    <input type="hidden" value="{{$producto->id}}" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" value="{{$producto->nombre}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Cantidad" value="{{$producto->cantidad}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción" rows="3"  required>{{$producto->descripcion}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_normal">Precio Normal</label>
                                <input id="p_normal" class="form-control" type="text" name="p_normal" placeholder="Precio Normal" value="{{$producto->precio_normal}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_rebajado">Precio Rebajado</label>
                                <input id="p_rebajado" class="form-control" type="text" name="p_rebajado" placeholder="Precio Rebajado" value="{{$producto->precio_rebajado}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <select id="categoria" class="form-select" name="categoria" required>
                                    <option value="">Seleccione una categoria</option>
                                    @foreach ($categorias as $categoria)
                                    <option value="{{$categoria->id}}" @if($categoria->id == $producto->id_categoria) selected @endif>{{$categoria->categoria}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="imagen">Foto:</label>
                                @if ($producto->foto)
                                <img src="{{ asset('/' . $producto->foto) }}" width="90" height="90">
                                @else
                                Sin imagen
                                @endif
                                <button type="button" id="btnMostrar" class="btn btn-primary"><i class="fas fa-plus"></i>Cambiar</button>
                                
                               
                            </div>
                        </div>
                        <div class="mostrar">
                            <input type="file" class="form-control subirImg" name="foto" id="foto" accept="image/png, image/jpeg">
                            <button type="button" id="btnCancelar" class="btn btn-danger"><i class="fas fa-times"></i>Cancelar</button>
                        </div>
                    </div>
                    <button class="btn btn-primary actualizar" type="button" id="actualizarProducto" data-id="{{$producto->id}}">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    {{--  $(document).ready(function () {
        $('.mostrar').show();
        $('#btnMostrar').click(function () {
            $('.mostrar').show(); 
            $('#btnMostrar').hide();
        });
        
        $('#btnCancelar').click(function () {
            $('.mostrar').hide(); 
            $('#btnMostrar').show();
        });
        
    });  --}}
    $(document).on('click', '.actualizar', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        //console.log(id);
        confirSave("¿Los datos capturados, son correctos?", function () {
            // Encuentra el formulario más cercano al botón que se presionó
            const formElement = $(this).closest('.modal').find('form')[0];
            updateProducto(id, formElement); // Pasar el ID y el formulario como argumentos a la función
        }.bind(this)); // Enlazar el botón que se presionó con la función de confirmación
    });
    
    async function updateProducto(id,formElement) {
        const url = $('#url').val();
        try {
            const formData = new FormData(formElement);
    
            const response = await fetch(url + '/productos/update/' + id, {
                method: 'POST',
                mode: 'cors',
                redirect: 'manual',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: formData
            });
    
            const data = await response.json();
            switch (data.idnotificacion) {
                case 1:
                    Swal.fire({
                        title: data.mensaje,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });
                    // Esperar un breve período de tiempo antes de recargar la página
                    setTimeout(function () {
                        document.getElementById('edit-productos').reset();
                        window.location.reload();
                    }, 1000); // Espera 1 segundo
    
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