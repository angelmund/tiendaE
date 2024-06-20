

<x-app-layout>
    <h1 class="text-center mt-2">Tabla de Permisos</h1>
    <div class="card mt-5">
        <div class="card-body">
            <div class="text-center mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#permiso">
                    <i class='fas fa-key'></i> Nuevo Permiso
                </button>
            </div>
           


            <table id="example" class="table table-striped responsive" style="width:100%">
                <thead>
                    <tr>
                        <th class="centrar">#</th>
                        <th class="centrar">Nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $key => $permiso)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{$permiso->name}}</td>
                       

                        <td>
                            <button type="button" class="btn btn-primary abrir-inscripcion" data-bs-toggle="modal"
                                data-bs-target="#" data-remote="#"><i
                                    class="fas fa-pen"></i></button>
                            <button type="button" id="btn_delete" class="btn btn-danger eliminar-modal"
                                data-target="#DeleteModal" data-toggle="modal" data-idcategoria="#">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    @endforeach

                </tbody>

            </table>
        </div>
        @include('admin.NuevoPermiso')
    </div>


</x-app-layout>