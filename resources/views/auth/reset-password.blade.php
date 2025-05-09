@extends('layouts.guest')

@section('title', 'Redefinir Senha')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Redefinir Senha</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <form method="POST" action="{{ route('password.store') }}" class="px-4 pb-4">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                               type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                        @error('email')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Senha -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                               type="password" name="password" required autocomplete="new-password" />
                        @error('password')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmar Senha -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                        <input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                               type="password" name="password_confirmation" required autocomplete="new-password" />
                        @error('password_confirmation')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="btn-padrao">
                            Redefinir Senha
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
