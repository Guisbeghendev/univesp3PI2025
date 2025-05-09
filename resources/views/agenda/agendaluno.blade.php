@extends('layouts.app')

@section('title', 'Agendar Aula')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Escolher Horário para Aula</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold">Horários Disponíveis</h3>

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

                    <ul class="list-disc pl-5 mt-4">
                        @foreach ($horarios as $horario)
                            <li class="mb-4">
                                <p>{{ $horario->data }} - {{ $horario->hora }} - Status: {{ ucfirst($horario->status) }}</p>

                                @if ($horario->status == 'disponivel')
                                    <button
                                        onclick="confirmarAgendamento('{{ $horario->id }}', '{{ $horario->data }}', '{{ $horario->hora }}', '{{ $Profissional->name }}', '{{ auth()->user()->name }}')"
                                        class="btn-padrao"
                                    >
                                        Agendar Aula
                                    </button>

                                    <!-- Formulário escondido que será enviado por JavaScript -->
                                    <form id="form-agendar-{{ $horario->id }}"
                                        action="{{ route('aluno.agendar', ['ProfissionalId' => $ProfissionalId, 'horarioId' => $horario->id]) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <span class="text-red-600">Este horário já foi reservado.</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>


            </div>

        </div>
    </div>
@endsection

@section('scripts')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmarAgendamento(horarioId, data, hora, ProfissionalNome, alunoNome) {
            Swal.fire({
                title: 'Confirmar Agendamento?',
                html: `
                    <p><strong>Aluno:</strong> ${alunoNome}</p>
                    <p><strong>Profissional:</strong> ${ProfissionalrNome}</p>
                    <p><strong>Horário:</strong> ${data} às ${hora}</p>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Agendar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-agendar-' + horarioId).submit();
                }
            });
        }
    </script>
@endsection

