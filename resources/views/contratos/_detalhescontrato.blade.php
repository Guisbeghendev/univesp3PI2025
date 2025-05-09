<div class="space-y-3">
    <h3 class="text-lg font-semibold text-verde">Detalhes do Contrato</h3>

    <p><strong>Status:</strong> <span class="capitalize">{{ $contrato->status }}</span></p>
    <p><strong>Aluno:</strong> {{ $contrato->aluno->name }}</p>
    <p><strong>Profissional:</strong> {{ $contrato->Profissional->name }}</p>
    <p><strong>Data:</strong> {{ $contrato->data_contratacao->format('d/m/Y H:i') }}</p>
    <p><strong>Mensagem:</strong> {{ $contrato->mensagem }}</p>

    <h3 class="text-lg font-semibold text-verde mt-4">Avaliações</h3>
    <p><strong>Total de pontos recebidos:</strong> {{ $totalNotas }}</p>
    <p><strong>Total de avaliações recebidas:</strong> {{ $quantidadeAvaliacoes }}</p>
    <p><strong>Média das avaliações:</strong> {{ $mediaAvaliacoes }}</p>

    @php
        $userId = auth()->id();
        $isProfissional = $userId === $contrato->Profissional_id;
        $isAluno = $userId === $contrato->aluno_id;

        // Verifica se o usuário já curtiu o contrato
        $curtidaExistente = App\Models\Curtida::where('Profissional_id', $userId)
                                              ->where('aluno_id', $contrato->aluno_id)
                                              ->first();
    @endphp

    <div class="flex flex-wrap gap-2 mt-4">
        @if ($isAluno)
            <a href="{{ route('chat.iniciar', $contrato->Profissional_id) }}" class="btn-padrao">
                Abrir Chat com Profissional
            </a>
        @endif

        @if ($contrato->status === 'pendente')
            @if ($isProfissional)
                <form action="{{ route('contratos.aceitar', $contrato->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Aceitar</button>
                </form>
                <form action="{{ route('contratos.recusar', $contrato->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Recusar</button>
                </form>
            @elseif ($isAluno)
                <form action="{{ route('contratos.recusar', $contrato->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Cancelar</button>
                </form>
            @endif
        @elseif ($contrato->status === 'aceita')
            @if ($isAluno)
                <!-- Botão para Desistir do Contrato -->
                <form action="{{ route('contratos.desistir', $contrato->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Desistir do Contrato</button>
                </form>

                <!-- Botão para Agendar Aula (apenas redireciona agora) -->
                <a href="{{ route('agenda.index', ['usuario_id' => $contrato->Profissional_id]) }}" class="btn-padrao">
                    Agendar Aula
                </a>
            @elseif ($isProfissional)
                <form action="{{ route('contratos.finalizar', $contrato->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-padrao">Finalizar</button>
                </form>
            @endif
        @endif

        <!-- Botão de Curtir -->
        <form method="POST" action="{{ route('curtidas.curtir', $contrato->aluno->id) }}">
            @csrf
            @if($curtidaExistente)
                <!-- Se o Profissional já curtiu, o botão vai ficar vermelho com "Curtido" -->
                <button type="submit" class="py-1 px-3 bg-red-500 text-white font-semibold rounded-full hover:bg-red-600 focus:outline-none text-sm">
                    Curtido
                </button>
            @else
                <!-- Se o Profissional não curtiu, o botão vai ficar cinza claro com "Curtir" -->
                <button type="submit" class="py-1 px-3 bg-gray-300 text-black font-semibold rounded-full hover:bg-gray-400 focus:outline-none text-sm">
                    Curtir
                </button>
            @endif
        </form>
    </div>
</div>
