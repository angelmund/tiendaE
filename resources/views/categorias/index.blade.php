<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800 text-center">Categorias</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirProducto"><i
          class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
    </div>
  
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover table-bordered" style="width: 100%;">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
              @foreach ($categorias as $categoria)
              <tr>
                <td>{{ $count++ }}</td>
                <td>{{$categoria->categoria}}</td>
                <td>
                  <button type="button" data-func="dt-add" class="btn btn-danger btn-xs dt-add eliminarsala"
                    data-id="{{$categoria->id}}" id="btn_delete_{{$categoria->id}}">
                    <i class='right fas fa-trash'></i>
                  </button>
                </td>
  
              </tr>
              @endforeach
  
            </tbody>
          </table>
        </div>
      </div>
    </div>
  
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
  </x-app-layout>