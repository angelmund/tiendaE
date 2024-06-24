<x-app-layout>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-center">Categorias</h1>
    <button type="button" id="editButton" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
      data-bs-toggle="modal" data-bs-target="#categoria" data-remote="{{route('categorias.create')}}"><i
        class="fas fa-plus"></i> Agregar Categoría</button>
  </div>

  <div class="container ">
    <div class="row d-flex justify-content-center">
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table table-hover table-bordered" style="width: 100%;">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @php $count = 1; @endphp
              @foreach ($categorias as $categoria)
              <tr>
                <td>{{ $count++ }}</td>
                <td>{{$categoria->categoria}}</td>
                <td class="text-center">
                  <button type="button" data-func="dt-add" class="btn btn-success btn-xs dt-add" data-bs-toggle="modal"
                    data-bs-target="#editCategoria{{$categoria->id}}" data-id="{{$categoria->id}}"
                    id="btn_delete_{{$categoria->id}}"
                    data-remote="{{route('categorias.edit', ['id' => $categoria->id])}}">
                    <i class='right fas fa-pen'></i>
                  </button>
                  <button type="button" data-func="dt-add" class="btn btn-danger btn-xs dt-add eliminarCategoria"
                    data-id="{{$categoria->id}}" id="btn_delete_{{$categoria->id}}">
                    <i class='right fas fa-trash'></i>
                  </button>
                </td>
  
              </tr>
              @include('categorias.create')
              @include('categorias.edit')
              @endforeach
  
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
  <script src="{{asset('assets/js/categoria.js')}}"></script>
</x-app-layout>
