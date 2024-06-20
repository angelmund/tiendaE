
<x-app-layout>
    <h1 class="text-center mt-2">Tabla de Roles</h1>
    <div class="card mt-5">
        <div class="card-body">
            <div class="text-center mb-3">
                {{-- <a href="{{route('usuarios.create')}}" type="button" class="btn btn-primary "><i
                        class='bx bx-user-plus'></i> Nuevo Usuario</a> --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class='fas fa-key'></i> Nuevo Rol
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
                    @foreach ($roles as $key => $rol)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{$rol->name}}</td>

                        <td>

                            <a type="button" href="{{route('usuarios.roles.edit', $rol)}}" class="btn btn-primary abrir-inscripcion" ><i class="fas fa-pen"></i></a>


                            <button type="button" id="btn_delete" class="btn btn-danger eliminar-rol"
                                data-target="#DeleteModal" data-toggle="modal" data-id="{{$rol->id}}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    {{-- @include('incripciones.edit')
                    @yield('pagos.altaPagos') --}}
                    {{-- @include('admin.NuevoRol') --}}
                    @endforeach

                </tbody>

            </table>
        </div>
        @include('admin.NuevoRol')
        {{-- @include('incripciones.edit'); --}}
    </div>


</x-app-layout>