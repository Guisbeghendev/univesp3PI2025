@extends('layouts.guest')

@section('title', 'Login')


{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Login</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="mb-4">
                    @if (session('status'))
                        <div class="p-4 mb-4 bg-green-100 text-green-700 rounded">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                {{-- form login --}}
                <form method="POST" action="{{ route('login') }}" class="px-8 pb-8">
                    @csrf

                    <!-- Tipo -->
                    <div class="mb-4">
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de usuário</label>
                        <select name="tipo" id="tipo" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Selecione...</option>
                            <option value="aluno" {{ old('tipo') == 'aluno' ? 'selected' : '' }}>Aluno</option>
                            <option value="Profissional" {{ old('tipo') == 'Profissional' ? 'selected' : '' }}>Profissional</option>
                        </select>
                        @error('tipo')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                               type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Senha -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                               type="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lembrar de mim -->
                    <div class="block mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">Lembrar de mim</span>
                        </label>
                    </div>

                    {{-- esqueceu senha --}}
                    <div class="flex items-center justify-end">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                Esqueceu sua senha?
                            </a>
                        @endif

                        {{-- botão entrar --}}
                        <button type="submit" class="btn-padrao">
                            Entrar
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection
