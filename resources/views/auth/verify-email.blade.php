@extends('layouts.guest')

@section('title', 'Verificação de E-mail')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Verificação de E-mail</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="mb-4 text-sm text-gray-600">
                    Obrigado por se inscrever! Antes de começar, poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, ficaremos felizes em enviar outro.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o registro.
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-padrao">
                            Reenviar E-mail de Verificação
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-padrao">
                            Sair
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection
