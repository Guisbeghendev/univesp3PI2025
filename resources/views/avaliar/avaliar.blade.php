@extends('layouts.app')

@section('title', 'Avaliar Profissional')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Escolha um Profissional para Avaliar</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                    <!-- Exibição da mensagem de sucesso -->
                    @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($contratos->isEmpty())
                    <p class="text-gray-600">Você ainda não tem profissionais disponíveis para avaliação.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($contratos as $contrato)
                            <div class="p-4 border rounded-md shadow-sm bg-white flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-semibold">{{ $contrato->Profissional->name }}</p>
                                    <p class="text-sm text-gray-600">Status do contrato: <strong>{{ ucfirst($contrato->status) }}</strong></p>
                                </div>

                                @php
                                    // Verifica se já existe uma avaliação para o contrato
                                    $avaliacao = $contrato->avaliacoes->firstWhere('aluno_id', Auth::id());
                                @endphp

                                @if ($avaliacao)
                                    <div class="text-sm text-gray-600">
                                        <p>Avaliação: <strong>{{ $avaliacao->nota }} / 5</strong></p>
                                        <p>Comentário: {{ $avaliacao->comentario ?? 'Nenhum comentário' }}</p>
                                    </div>
                                    <!-- Botão para avaliar (quando ainda não há avaliação) -->
                                    <a href="{{ route('avaliar.show', $contrato->id) }}"
                                        class="btn-padrao">
                                        Avaliar
                                    </a>
                                @else
                                    <a href="{{ route('avaliar.show', $contrato->id) }}" class="btn-padrao">
                                        Avaliar
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif


            </div>

        </div>
    </div>
@endsection
