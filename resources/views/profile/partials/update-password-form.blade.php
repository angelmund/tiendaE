<section class="container bg-white rounded-lg shadow-md p-6">
    <header>
        <h2 class="text-xl font-medium text-gray-900 mb-4">{{ __('Actualizar Contraseña') }}</h2>
        <p class="text-sm text-gray-600 mb-6">{{ __('Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="mb-4" style="max-width: 300px">
            <label for="current_password" class="form-label">{{ __('Contraseña actual') }}</label>
            <input id="current_password" name="current_password" type="password" class="form-control mt-1 block w-full" autocomplete="current-password" />
            @if ($errors->updatePassword->has('current_password'))
                <div class="text-sm text-red-600 mt-2">
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <div class="mb-4" style="max-width: 300px">
            <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
            <input id="password" name="password" type="password" class="form-control mt-1 block w-full" autocomplete="new-password" />
            @if ($errors->updatePassword->has('password'))
                <div class="text-sm text-red-600 mt-2">
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <div class="mb-6" style="max-width: 300px">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Nueva Contraseña') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control mt-1 block w-full" autocomplete="new-password" />
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="text-sm text-red-600 mt-2">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between mt-3">
            <button type="submit" class="btn btn-dark">{{ __('Guardar') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:leave="transition ease-in duration-200"
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Contraseña actualizada.') }}</p>
            @endif
        </div>
    </form>
</section>
