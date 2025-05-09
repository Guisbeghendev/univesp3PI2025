@extends('layouts.guest')

@section('title', 'Confirmar Senha')


{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Confirmar Senha</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="mb-4 text-sm text-gray-600 text-center">
                    Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="px-4 pb-4">
                    @csrf

                    <!-- Senha -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                               type="password" name="password" required autocomplete="current-password" />
                        @error('password')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="btn-padrao">
                            Confirmar
                        </button>
                    </div>

                </form>


            </div>

        </div>
    </div>
@endsection
