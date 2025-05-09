@extends('layouts.app')

@section('title', 'Contratos')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Contratos</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Coluna esquerda: Lista de contratos -->
                    <div class="md:col-span-1 bg-white rounded-lg shadow p-4 overflow-y-auto max-h-[600px]">
                        @include('contratos._listacontratos', ['contratos' => $contratos, 'contratoSelecionado' => $contratoSelecionado ?? null])
                    </div>

                    <!-- Coluna direita: Detalhes do contrato -->
                    <div class="md:col-span-2 bg-white rounded-lg shadow p-4">
                        @if (isset($contratoSelecionado))
                            @include('contratos._detalhescontrato', ['contrato' => $contratoSelecionado])
                        @else
                            <p class="text-center text-gray-500">Selecione um contrato para ver mais detalhes.</p>
                        @endif
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection
