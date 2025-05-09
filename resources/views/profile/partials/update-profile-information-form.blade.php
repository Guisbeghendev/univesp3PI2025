<section>
    <!-- Form principal de atualização -->
    <form method="post" action="{{ route('perfil.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Campo de Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 ">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                value="{{ old('email', auth()->user()->email) }}"
                required
                autocomplete="username"
            >
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botão salvar -->
        <div class="flex items-center gap-4 mt-4 mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Salvar
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600">Alterações salvas.</p>
            @endif
        </div>
    </form>
</section>
