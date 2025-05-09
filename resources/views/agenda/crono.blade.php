@extends('layouts.app')

@section('title', 'Configurar Agenda')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Configurar Minha Agenda</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="bg-white rounded-lg shadow p-6">
                    {{-- Exibindo mensagens de erro ou sucesso --}}
                    @if(session('error'))
                        <div class="bg-red-500 text-white p-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @elseif(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Formulário para salvar horário --}}
                    <form action="{{ route('agenda.salvarCrono') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="data" class="block text-gray-700">Data</label>
                            <input type="date" id="data" name="data" class="border border-gray-300 p-2 w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="hora" class="block text-gray-700">Hora</label>
                            <input type="time" id="hora" name="hora" class="border border-gray-300 p-2 w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Status</label>
                            <select name="status" id="status" class="border border-gray-300 p-2 w-full" required>
                                <option value="disponivel">Disponível</option>
                                <option value="indisponivel">Indisponível</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-padrao">
                            Salvar Horário
                        </button>
                    </form>
                </div>

                <!-- Exibindo os horários já definidos -->
                <div class="mt-6">
                    <h3 class="text-xl font-bold text-verde">Horários Cadastrados</h3>
                    <ul class="list-disc pl-5 mt-4">
                        @foreach ($horariosDisponiveis as $horario)
                            <li class="mb-2">
                                <p>{{ $horario->data }} - {{ $horario->hora }} - Status: {{ ucfirst($horario->status) }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Botão para voltar para a agenda -->
                <div class="mt-6 text-center">
                    <a href="{{ route('agenda.index') }}" class="btn-padrao">
                        Voltar para a Agenda
                    </a>
                </div>


            </div>

        </div>
    </div>
@endsection
