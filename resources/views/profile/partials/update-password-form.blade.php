<section>
    <header>
        <p class="mt-1 mb-4 text-sm text-gray-600">
            Garanta que sua conta esteja usando uma senha longa e aleatória para se manter segura.
        </p>
    </header>

    <form method="POST" action="{{ route('perfil.updatePassword') }}" class="mt-6 space-y-6">

        @csrf
        @method('PATCH')

        <!-- Senha atual -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Senha atual</label>
            <input
                id="current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                autocomplete="current-password"
            >
            @if ($errors->updatePassword->has('current_password'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <!-- Nova senha -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nova senha</label>
            <input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                autocomplete="new-password"
            >
            @if ($errors->updatePassword->has('password'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <!-- Confirmação de senha -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar nova senha</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                autocomplete="new-password"
            >
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <!-- Botão -->
        <div class="flex items-center gap-4 mt-2 mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Salvar
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600">Senha atualizada com sucesso.</p>
            @endif
        </div>
    </form>
</section>
