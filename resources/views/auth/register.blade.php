@extends('layouts.guest')

@section('title', 'Registro')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Cadastre-se</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <form method="POST" action="{{ route('register') }}" class="px-8 pb-8">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Senha <br>
                            <span class="text-xs text-gray-500">A senha deve ter pelo menos 8 caracteres, incluindo letras e números</span>
                        </label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de usuário</label>
                        <select id="tipo" name="tipo" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="aluno" {{ old('tipo') == 'aluno' ? 'selected' : '' }}>Aluno</option>
                            <option value="Profissional" {{ old('tipo') == 'Profissional' ? 'selected' : '' }}>Profissional</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-padrao">
                        Registrar
                    </button>
                </form>

            </div>

        </div>
    </div>
@endsection
