
<x-app-layout>
    <h1 class="text-center mt-2">Permisos asignados a <p>{{$role->name}}</p></h1>
    <div class="card mt-5">
        <div class="card-header">
            <a href="{{route('usuarios.roles.index')}}" type="button" class="btn btn-primary">Volver</a>
        </div>
        <div class="card-body">
            <h5>Lista de permisos</h5>
            
            {!! Form::model($role, ['route'=> ['usuarios.roles.update', $role], 'method' => 'put']) !!}
                @foreach ($permisos as $permiso)
                @if ($permiso)
                <div>
                    <label>
                        {{ Form::checkbox('permisos[]', $permiso->id, $role->hasPermissionTo($permiso->name) ? true : false, ['class'=>'mr-1']) }}
                        {{$permiso->name}}
                    </label>
                </div>
            @endif
                @endforeach
                {!! Form::submit('Asignar Permisos', ['class'=>'btn btn-primary mt-3']) !!}
            {!! Form::close() !!}
            
            
            
            
        </div>
    
    </div>


</x-app-layout>