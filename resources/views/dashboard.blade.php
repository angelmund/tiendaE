<x-app-layout>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-center">Productos</h1>

    <button type="button" id="editButton" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
      data-bs-toggle="modal" data-bs-target="#productos" data-remote="{{route('productos.create')}}"><i
        class="fas fa-plus"></i> Nuevo</button>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-hover table-bordered" style="width: 100%;">
          <thead class="thead-dark">
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio Normal</th>
              <th>Precio con descuento</th>
              <th>Cantidad</th>
              <th>Categoria</th>
              <th>Imagen</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($productos as $producto)
            <tr>
              <td>{{$producto->nombre}}</td>
              <td>{{$producto->descripcion}}</td>
              <td>{{$producto->precio_normal}}</td>
              <td>{{$producto->precio_rebajado}}</td>
              <td>{{$producto->cantidad}}</td>
              <td>{{$producto->categoria->categoria}}</td>
              <td>
                @if ($producto->foto)
                <img src="{{ asset('storage/' . $producto->foto) }}" width="100" height="100">
            @else
                Sin imagen
            @endif
              </td>
              <td>
                <button type="button" data-func="dt-add" class="btn btn-success btn-xs dt-add"
                  data-id="{{$producto->id}}" id="btn_delete_{{$producto->id}}">
                  <i class='right fas fa-pen'></i>
                </button>
                <button type="button" data-func="dt-add" class="btn btn-danger btn-xs dt-add eliminarsala"
                  data-id="{{$producto->id}}" id="btn_delete_{{$producto->id}}">
                  <i class='right fas fa-trash'></i>
                </button>
              </td>

            </tr>
            @include('productos.create')
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>


  {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
  <script src="{{asset('assets/js/producto.js')}}"></script>
</x-app-layout>