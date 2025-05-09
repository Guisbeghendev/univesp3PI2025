@extends('layouts.app')

@section('title', 'Agenda')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Agenda</h2>

            {{-- container que encapsula o conteudo --}}
            <div class="container">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Coluna da esquerda: Lista de usuários -->
                    <div class="md:col-span-1 bg-white rounded-lg shadow p-4 overflow-y-auto max-h-[600px]">
                        @include('agenda._listaagendar') <!-- Inclui a lista de usuários -->
                    </div>

                    <!-- Coluna da direita: Grade de horários -->
                    <div class="md:col-span-2 bg-white rounded-lg shadow p-4 h-auto"> <!-- Classe h-auto adicionada -->
                        @include('agenda._disponibilidade') <!-- Inclui a grade de horários -->
                    </div>
                </div>

                <!-- Botão para Meus Agendamentos -->
                <div class="text-center mt-6">
                    <a href="{{ route('agenda.meus') }}" class="btn-padrao">
                        Meus Agendamentos
                    </a>
                </div>

                <!-- Botão para configurar a agenda (visível apenas para o Profissional) -->
                @if(Auth::user()->tipo === 'Profissional')
                    <div class="text-center mt-6">
                        <a href="{{ route('agenda.crono') }}" class="btn-padrao">
                            Configurar Minha Agenda
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection
