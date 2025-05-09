@extends('layouts.app')

@section('title', 'Perfil do Usuário na Pesquisa')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">{{ $perfil->usuario->name }}</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><strong>Tipo:</strong> {{ ucfirst($perfil->usuario->tipo) }}</p>
                    <p><strong>Email:</strong> {{ $perfil->usuario->email }}</p>
                    <p><strong>Cidade:</strong> {{ $perfil->cidade ?? 'Não informado' }}</p>
                    <p><strong>Estado:</strong> {{ $perfil->estado ?? 'Não informado' }}</p>
                    <p><strong>Idiomas:</strong> {{ $perfil->idiomas ?? 'Não informado' }}</p>
                    <p><strong>Data de Nascimento:</strong>
                        @if(!empty($perfil->data_nascimento) && strtotime($perfil->data_nascimento))
                            {{ \Carbon\Carbon::parse($perfil->data_nascimento)->format('d/m/Y') }}
                        @else
                            Não informada
                        @endif
                    </p>
                </div>

                <div class="mt-4">
                    <p><strong>Biografia:</strong></p>
                    <p class="text-gray-700 whitespace-pre-line">{{ $perfil->biografia ?? 'Sem biografia' }}</p>
                </div>

                @if($perfil->foto_perfil)
                    <div class="mt-6">
                        <p><strong>Foto de Perfil:</strong></p>
                        <img src="{{ asset('storage/' . $perfil->foto_perfil) }}" alt="Foto de Perfil" class="w-40 h-40 object-cover rounded-full">
                    </div>
                @else
                    <div class="mt-6">
                        <p><strong>Foto de Perfil:</strong></p>
                        <p>Foto não disponível</p>
                    </div>
                @endif

                <!-- Exibindo as informações da avaliação -->
                <div class="mt-6">
                    <p><strong>Avaliações:</strong></p>
                    <p><strong>Total de Votos Recebidos:</strong> {{ $quantidadeAvaliacoes }}</p>
                    <p><strong>Total de Pontos Recebidos:</strong> {{ $totalPontos }}</p>
                    <p><strong>Média das Avaliações:</strong>
                        @if($mediaAvaliacoes != 'Sem avaliações')
                            {{ $mediaAvaliacoes }} / 5
                        @else
                            {{ $mediaAvaliacoes }}
                        @endif
                    </p>
                </div>

                @if(auth()->id() != $perfil->usuario->id)
                <div class="mt-6 text-center space-x-4">
                    <!-- Iniciar Chat -->
                    <a href="{{ route('chat.iniciar', ['id' => $perfil->usuario->id]) }}" class="btn-padrao">
                        Iniciar Chat
                    </a>

                    <!-- Iniciar Contrato -->
                    <form action="{{ route('contratos.criar') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="destinatario_id" value="{{ $perfil->usuario->id }}">
                        <button type="submit" class="btn-padrao">
                            Iniciar Contrato
                        </button>
                    </form>
                </div>
                @endif

                <div class="mt-6 text-center space-x-4">
                    <!-- Voltar aos Resultados -->
                    <a href="{{ route('pesquisa.resultados') }}" class="btn-padrao">
                        Voltar aos Resultados
                    </a>
                </div>


            </div>

        </div>
    </div>
@endsection
