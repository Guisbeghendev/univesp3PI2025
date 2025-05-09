<!-- Card com classe reutilizável -->
<div class="partials-box">
    <!-- grid padrão -->
    <div class="grid grid-cols-1 gap-4 w-full">
        <!-- Linha padrão dos títulos -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-verde">AVALIAÇÃO</h2>
        </div>

        <!-- Conteúdo dependendo do tipo de usuário -->
        <div class="space-y-2">
            @if (auth()->user()->tipo === 'aluno')
                @if ($avaliacoesFeitas->isEmpty())
                    <p class="text-gray-600">Você ainda não fez nenhuma avaliação.</p>
                @else
                    @foreach ($avaliacoesFeitas as $avaliacao)
                        <div class="p-3 bg-gray-100 rounded flex justify-between items-center">
                            <span><strong>{{ $avaliacao->Profissional->name }}</strong></span>
                            <span class="text-sm text-gray-700">Nota: <strong>{{ $avaliacao->nota }}</strong></span>
                        </div>
                    @endforeach
                @endif

                <!-- Botão para avaliar profissionais (apenas para alunos) -->
                <div class="text-center">
                    <a href="{{ route('avaliar.index') }}" class="btn-padrao">
                        Ver Profissionais para Avaliar
                    </a>
                </div>

            @elseif (auth()->user()->tipo === 'Profissional')
                @if ($avaliacoesRecebidas->isEmpty())
                    <p class="text-gray-600">Você ainda não recebeu nenhuma avaliação.</p>
                @else
                    <div class="space-y-2 text-gray-800">
                        <p><strong>Total de avaliações recebidas:</strong> {{ $avaliacoesRecebidas->count() }}</p>
                        <p><strong>Soma total de pontos:</strong> {{ $totalNotasRecebidas }}</p>
                        <p><strong>Média das notas:</strong> {{ $mediaNotasRecebidas }}</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
