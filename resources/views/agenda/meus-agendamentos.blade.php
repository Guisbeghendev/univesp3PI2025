@extends('layouts.app')

@section('title', 'Meus agendamentos')

@section('content')
    <div class="w-full flex justify-center items-center py-10">
        <div class="card-box">
            <h2 class="titulo-principal">Meus Agendamentos</h2>

            <div class="container">

                @php
                    $userId = auth()->id();
                @endphp

                @if($meusAgendamentos->count())
                    <ul class="divide-y divide-gray-200">
                        @foreach($meusAgendamentos as $agenda)
                            <li class="py-4">
                                <div>
                                    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($agenda->horario->data ?? null)->format('d/m/Y') }}</p>
                                    <p><strong>Hora:</strong> {{ $agenda->horario->hora ?? '-' }}</p>
                                    <p><strong>Aluno:</strong> {{ $agenda->aluno->name ?? '—' }}</p>
                                    <p><strong>Profissional:</strong> {{ $agenda->Profissional->name ?? '—' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Você ainda não tem agendamentos.</p>
                @endif

                <div class="mt-6 mb-6">
                    <a href="{{ route('dashboard') }}" class="btn-padrao">
                        ← Voltar para a Dashboard
                    </a>

                    {{-- Mostra botão apenas se o usuário for um Profissional --}}
                    @if(auth()->user()->tipo === 'Profissional')
                        <div class="mb-6 mt-6">
                            <a href="{{ route('agenda.crono') }}" class="btn-padrao">
                                🗓️ Editar Disponibilidade
                            </a>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection
