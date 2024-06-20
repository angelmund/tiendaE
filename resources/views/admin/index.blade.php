<x-app-layout>
    <h1 class="text-center mt-2">Tabla de Usuarios</h1>
    <div class="card mt-5">
        <div class="card-body">
            <div class="text-center mb-3">
                <input type="hidden" value="{{ url('/') }}" id="url">
                <a href="{{route('usuarios.create')}}" type="button" class="btn btn-primary"><i
                        class='bx bx-user-plus'></i> Nuevo Usuario</a>
                <a type="button" href="{{route('usuarios.roles.index')}}" class="btn btn-warning"><i
                        class='bx bxs-user-check'></i>
                    Nuevo Rol</a>
                {{-- <button id="excelButton" class="btn btn-success"><i class="fas fa-file-excel"></i> Exportar a
                    Excel</button>
                <button id="pdfButton" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Exportar a PDF</button>
                <button id="printButton" class="btn btn-info"><i class="fas fa-print"></i> Imprimir</button> --}}
            </div>
            {{-- <div class="row mb-3 ">
                <div class="col-md-4 fechaDivs">
                    <label for="fechainicio">Fecha Inicio</label>
                    <input type="text" id="fechaIncio" name="fechaInicio" class="form-control fechaInicio" readonly />
                </div>

                <div class="col-md-4 fechaDivs">
                    <label for="fechafinal">Fecha Final</label>
                    <input type="text" name="fechaFinal" id="fechaFinal" class="form-control fechaFinal" readonly />
                </div>
                <div class="col-md-2 folioDivs">
                    <label for="folioI">Desde Folio</label>
                    <input type="text" name="folioI" id="folioI" class="form-control folioI" />
                </div>
                <div class="col-md-2 folioDivs">
                    <label for="folioF">Hasta Folio</label>
                    <input type="text" name="folioF" id="folioF" class="form-control folioF" />
                </div>

                <div class="col-md-2 col-sm-6">
                    <label for="Estado">Buscar por:</label>
                    <select name="estatus_id" class="form-control status_id select2">
                        <option value="seleccione">Seleccione una opción</option>
                        <option value="Inscripcion">Buscar inscripción</option>
                        <option value="Fecha">Rango de Fechas</option>
                        <option value="Folio">Folio</option>
                    </select>
                </div>

                <div class="col-md-1 mt-4">
                    <button id="filtrar" class="btn btn-danger"><i class="fas fa-filter"></i> Filtrar</button>
                </div>
            </div> --}}


            <table id="example" class="table table-striped responsive" style="width:100%">
                <thead>
                    <tr>
                        <th class="centrar">#</th>
                        <th class="centrar">Nombre</th>
                        <th class="centrar">Correo</th>
                        <th class="centrar">Rol</th>
                        <th class="centrar">Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $counter = 1;
                    @endphp
                    @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>
                            @foreach($usuario->roles as $rol)
                            <span class="badge rounded-pill"
                                style="background-color: {{ $rol->name == 'Administrador' ? 'green' : 'purple' }}; color: white;">
                                {{ $rol->name }}
                            </span>
                            @endforeach
                        </td>

                        <td>
                            <span class="badge rounded-pill"
                                style="background-color: {{ $usuario->estado == 1 ? 'green' : 'red' }}; color: white;">
                                {{ $usuario->estado == 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{route('usuario.RolAsignado.show', $usuario->id)}}" type="button"
                                class="btn btn-warning"><i class='bx bxs-user-check'></i>
                                Editar Rol</a>
                            <button type="button" id="btn_delete" class="btn btn-danger eliminar-user"
                                data-target="#DeleteModal" data-toggle="modal" data-id="{{ $usuario->id}}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>


            </table>
        </div>
        {{-- @include('incripciones.edit'); --}}
    </div>



</x-app-layout>