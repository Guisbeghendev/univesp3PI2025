<!-- Card com classe reutilizável -->
<div class="partials-box">
    <!-- grid padrão -->
    <div class="grid grid-cols-1 gap-4 w-full">
        <!-- Linha padrão dos títulos -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-verde">Últimas Mensagens Não Lidas</h2>
        </div>

        <!-- Linha padrão dos conteúdos -->
        <div>
            <!-- Exibe as últimas 5 mensagens não lidas -->
            @if ($ultimasMensagensNaoLidas->isNotEmpty())
                <ul class="space-y-2">
                    @foreach ($ultimasMensagensNaoLidas as $mensagem)
                        <li class="p-3 bg-gray-100 rounded-md hover:bg-gray-200">
                            <!-- Tornando a mensagem clicável para abrir a conversa -->
                            <a href="{{ route('chat.index', ['conversa_id' => $mensagem->conversa_id]) }}" class="block">
                                <div class="font-semibold text-gray-800">
                                    {{ $mensagem->remetente->name }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ Str::limit($mensagem->mensagem, 40) }} <!-- Exibe as primeiras 40 caracteres -->
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $mensagem->enviada_em->format('d/m/Y H:i') }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Nenhuma mensagem não lida.</p>
            @endif
        </div>

        <!-- Botão para abrir a interface do chat -->
        <div class="text-center">
            <a href="{{ route('chat.index') }}" class="btn-padrao">Ir para o Chat</a>
        </div>
    </div>
</div>
