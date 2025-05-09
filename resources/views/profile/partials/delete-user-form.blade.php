<section class="space-y-6">
    <header>
        <p class="mt-1 text-sm text-gray-600">
            Uma vez que sua conta for excluída, todos os seus dados e recursos serão permanentemente apagados. Antes de excluir sua conta, baixe qualquer informação que deseja guardar.
        </p>
    </header>

    <!-- Botão de abrir modal -->
    <button
        type="button"
        onclick="document.getElementById('confirm-user-deletion').classList.remove('hidden'); document.getElementById('confirm-user-deletion').classList.add('flex')"
        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
    >
        Excluir Conta
    </button>

    <!-- Modal -->
    <div
        id="confirm-user-deletion"
        class="{{ $errors->userDeletion->isEmpty() ? 'hidden' : 'flex' }} fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <form method="POST" action="{{ route('perfil.destroy') }}">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                    Tem certeza que deseja excluir sua conta?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Após a exclusão, todos os dados serão permanentemente apagados. Por favor, insira sua senha para confirmar a exclusão definitiva.
                </p>

                <div class="mt-6">
                    <label for="password" class="sr-only">Senha</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-red-200"
                        placeholder="Senha"
                    >
                    @if ($errors->userDeletion->has('password'))
                        <p class="text-sm text-red-600 mt-2">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        onclick="document.getElementById('confirm-user-deletion').classList.remove('flex'); document.getElementById('confirm-user-deletion').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="ml-3 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                    >
                        Confirmar Exclusão
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
