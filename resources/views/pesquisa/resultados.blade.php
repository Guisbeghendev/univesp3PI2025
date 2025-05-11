@extends('layouts.app')

@section('title', 'Resultados da Pesquisa')

{{-- Conteúdo da página --}}
@section('content')

    {{-- Flexbox para centralizar o conteúdo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- Card comum que envolve todas as páginas --}}
        <div class="card-box">

            {{-- Título da página --}}
            <h2 class="titulo-principal">Resultados da Pesquisa</h2>

            {{-- Container que encapsula o conteúdo --}}
            <div class="container">

                <!-- Filtros aplicados -->
                <div class="flex justify-between items-center mb-4">
                    <p class="text-lg text-gray-700">Filtros aplicados:</p>
                    <div>
                        <span class="font-bold">Cidade:</span> {{ request('cidade') ?? 'Não especificada' }}
                        <span class="ml-4"><span class="font-bold">Estado:</span> {{ request('estado') ?? 'Não especificado' }}</span>
                    </div>
                </div>

                <!-- Botão para nova pesquisa -->
                <div class="mb-6 text-center">
                    <a href="{{ route('dashboard') }}" class="btn-padrao">
                        Fazer Nova Pesquisa
                    </a>
                </div>

                <!-- Resultados -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($resultados as $index => $resultado)
                        <div class="partials-box p-4 relative">
                            <h3 class="text-lg font-semibold text-blue-600">{{ $resultado->usuario->name }}</h3>
                            <p><strong>Cidade:</strong> {{ $resultado->cidade }}</p>
                            <p><strong>Estado:</strong> {{ $resultado->estado }}</p>

                            <!-- Exibindo a Especialização -->
                            <p><strong>Especialização:</strong> {{ $resultado->especializacao->nome ?? 'Não especificada' }}</p>

                            <!-- Exibindo a média de avaliações -->
                            <p><strong>Avaliações:</strong>
                                @if($resultado->mediaAvaliacoes != 'Sem avaliações')
                                    {{ $resultado->mediaAvaliacoes }} / 5
                                @else
                                    {{ $resultado->mediaAvaliacoes }}
                                @endif
                            </p>

                            <!-- Link para abrir o perfil na mesma aba -->
                            <div class="mt-4 text-right">
                                <a href="{{ route('perfil.resultado', $resultado->usuario->id) }}" class="btn-padrao">
                                    Ver Perfil
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Sem resultados -->
                @if($resultados->isEmpty())
                    <p class="text-center text-gray-500">Nenhum resultado encontrado.</p>
                @endif

            </div>

        </div>
    </div>

@endsection
