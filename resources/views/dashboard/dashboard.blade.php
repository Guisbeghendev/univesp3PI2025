@extends('layouts.app')

@section('title', 'Dashboard')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="dash-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Meu Painel Dashboard</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <!-- Saudações com dados direto do user -->
                <div class="titulo-box mx-auto mb-6 text-center">
                    <h2 class="text-xl font-bold text-verde">
                        Bem-vindo(a) {{ strtolower($user->tipo) === 'profissional' ? 'Profissional' : 'Aluno' }} {{ $user->name }}!
                    </h2>
                </div>

                <!-- Cards dos módulos -->
                <div class="dash-box mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @include('dashboard.partials.card-busca')
                        @include('dashboard.partials.card-contratacoes')
                        @include('dashboard.partials.card-chat')
                        @include('dashboard.partials.card-agendamentos')
                        @include('dashboard.partials.card-avaliacoes')
                        @include('dashboard.partials.card-curtidas')
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
