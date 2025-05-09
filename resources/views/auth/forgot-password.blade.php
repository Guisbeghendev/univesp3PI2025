@extends('layouts.guest')

@section('title', 'Esqueci a Senha')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Esqueci a Senha</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="mb-4 text-sm text-gray-600 text-center">
                    Esqueceu sua senha? Sem problemas. Informe seu endereço de email e enviaremos um link para redefinir sua senha, permitindo que você escolha uma nova.
                </div>

                @if (session('status'))
                    <div class="p-4 mb-4 bg-green-100 text-green-700 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="px-4 pb-4">
                    @csrf

                    <!-- Endereço de Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                               type="email" name="email" value="{{ old('email') }}" required autofocus />
                        @error('email')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="btn-padrao">
                            Enviar Link para Redefinir Senha
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
