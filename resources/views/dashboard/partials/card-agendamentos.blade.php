<!-- Card com classe reutilizável -->
<div class="partials-box">
    <!-- grid padrão -->
    <div class="grid grid-cols-1 gap-4 w-full">
        <!-- Linha padrão dos títulos -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-verde">AGENDA</h2>
        </div>

        <!-- Linha padrão dos conteúdos -->
        <div>
            @if($meusAgendamentosFuturos->count())
                <ul class="divide-y divide-gray-200">
                    @foreach($meusAgendamentosFuturos as $agenda)
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
                <p class="text-gray-500">Você não tem agendamentos futuros.</p>
            @endif
        </div>

        <!-- Botão para ir para "Meus Agendamentos" -->
        <div class="text-center">
            <a href="{{ route('agenda.meus') }}" class="btn-padrao">
                Ver todos meus agendamentos
            </a>
        </div>
    </div>
</div>
