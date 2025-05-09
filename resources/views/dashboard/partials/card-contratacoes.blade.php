<!-- Card com classe reutilizável -->
<div class="partials-box">
    <!-- Grid padrão -->
    <div class="grid grid-cols-1 gap-4 w-full">
        <!-- Linha padrão dos títulos -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-verde">CONTRATOS PENDENTES</h2>
        </div>

        <!-- Linha padrão dos conteúdos -->
        <div>
            @if ($contratosPendentes->isEmpty())
                <p class="text-gray-500">Você não tem contratos pendentes no momento.</p>
            @else
                <ul class="space-y-3">
                    @foreach ($contratosPendentes as $contrato)
                        <li class="flex items-center justify-between p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
                            <div>
                                <p><strong>Status:</strong> {{ ucfirst($contrato->status) }}</p>
                                <p><strong>Aluno:</strong> {{ $contrato->aluno->name }}</p>
                                <p><strong>Profissional:</strong> {{ $contrato->Profissional->name }}</p>
                                <p><strong>Data:</strong> {{ $contrato->data_contratacao->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="space-x-2">
                                <a href="{{ route('contratos.index', ['contrato_id' => $contrato->id]) }}" class="text-blue-600 hover:underline">Ver contrato</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Botão para ver todos os contratos -->
        <div class="text-center">
            <a href="{{ route('contratos.index') }}" class="btn-padrao">
                Ver meus contratos
            </a>
        </div>
    </div>
</div>
