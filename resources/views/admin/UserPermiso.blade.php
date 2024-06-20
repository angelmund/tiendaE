
<x-app-layout>
    <h1 class="text-center mt-2">Roles que puedes asignar a <p>{{$user->name}}</p></h1>
    <div class="card mt-5">
        <div class="card-header">
            <a href="{{route('usuarios.index')}}" type="button" class="btn btn-primary">Volver</a>
        </div>
        <div class="card-body">
            <h5>Lista de roles</h5>
            
            {!! Form::model($user, ['route'=> ['usuario.RolAsignado.update', $user], 'method' => 'put']) !!}
                @foreach ($roles as $role)
                @if ($role)
                <div>
                    <label>
                        {{ Form::checkbox('roles[]', $role->id, $user->hasAnyRole($role->id) ? true : false, ['class'=>'mr-1']) }}
                        {{$role->name}}
                    </label>
                </div>
            @endif
                @endforeach
                {!! Form::submit('Asignar Rol', ['class'=>'btn btn-primary mt-3']) !!}
            {!! Form::close() !!}
            
            
            
            
        </div>
    
    </div>


</x-app-layout>