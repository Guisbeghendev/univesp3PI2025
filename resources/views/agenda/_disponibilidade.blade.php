@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    $dias = collect($horarios)->pluck('data')->unique()->sort()->values();
    $horas = collect($horarios)->pluck('hora')->unique()->sort()->values();

    $horariosMap = [];
    foreach ($horarios as $horario) {
        $horariosMap[$horario->data][$horario->hora] = $horario;
    }

    $usuarioId = Auth::id();
    $jaAgendado = \App\Models\Agenda::where('aluno_id', $usuarioId)->exists();
@endphp

@if ($dias->count() && $horas->count())
    <table class="min-w-full border border-gray-300 text-sm text-center">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Horário</th>
                @foreach ($dias as $dia)
                    <th class="px-4 py-2">{{ Carbon::parse($dia)->format('d/m/Y') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($horas as $hora)
                <tr>
                    <td class="border px-4 py-2">{{ $hora }}</td>
                    @foreach ($dias as $dia)
                        @php
                            $horario = $horariosMap[$dia][$hora] ?? null;
                            $agenda = $horario ? \App\Models\Agenda::where('horario_id', $horario->id)->first() : null;
                            $cor = 'bg-gray-100';
                            $statusTexto = '';
                            if ($horario) {
                                if ($agenda) {
                                    // Exibe se o agendamento é seu ou de outra pessoa
                                    if ($agenda->aluno_id === $usuarioId) {
                                        $cor = 'bg-blue-200'; // Seu agendamento
                                        $statusTexto = 'Agendado por você';
                                    } else {
                                        $cor = 'bg-red-200'; // Agendado por outro aluno
                                        $statusTexto = 'Indisponível';
                                    }
                                } elseif ($horario->status === 'disponivel') {
                                    $cor = 'bg-green-200 hover:bg-green-300 cursor-pointer';
                                    $statusTexto = 'Disponível';
                                } elseif ($horario->status === 'indisponivel') {
                                    $cor = 'bg-gray-300'; // Quando o horário está indisponível
                                    $statusTexto = 'Indisponível';
                                }
                            }
                        @endphp
                        <td class="border border-gray-300 p-2 {{ $cor }}">
                            @if ($horario)
                                @if ($horario->status === 'disponivel' && !$agenda && !$jaAgendado)
                                    <form id="form-{{ $horario->id }}" method="POST"
                                          action="{{ route('agenda.agendarAula', ['ProfissionalId' => $horario->Profissional_id, 'horarioId' => $horario->id]) }}">
                                        @csrf
                                    </form>
                                    <div onclick="document.getElementById('form-{{ $horario->id }}').submit();"
                                         class="cursor-pointer text-green-800 hover:underline font-semibold">
                                        Agendar
                                    </div>
                                @elseif ($agenda)
                                    <span class="text-gray-600">
                                        {{ $statusTexto }}
                                    </span>
                                @else
                                    <span class="text-gray-600">{{ $statusTexto }}</span>
                                @endif
                            @else
                                —
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Nenhum horário disponível no momento.</p>
@endif
