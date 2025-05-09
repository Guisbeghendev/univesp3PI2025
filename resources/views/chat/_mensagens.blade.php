@if ($mensagens)
    <div id="mensagens" class="space-y-2 max-h-[500px] overflow-y-auto mb-4">
        @foreach ($mensagens as $mensagem)
            <div class="p-2 rounded-lg {{ $mensagem->remetente_id === auth()->id() ? 'bg-blue-100 text-right' : 'bg-gray-100 text-left' }}">
                <div class="text-sm">{{ $mensagem->mensagem }}</div>
                <div class="text-xs text-gray-500">
                    {{ $mensagem->enviada_em->format('d/m/Y H:i') }} —
                    <span class="italic text-{{ $mensagem->status === 'lida' ? 'green' : ($mensagem->status === 'entregue' ? 'yellow' : 'gray') }}-600">
                        {{ ucfirst($mensagem->status) }}
                    </span>
                </div>

            </div>
        @endforeach
    </div>

    <form id="formMensagem" method="GET" class="flex gap-2">
        <input type="hidden" name="conversa_id" value="{{ $conversaSelecionada->id }}">
        <input type="text" name="mensagem" class="flex-1 border rounded px-3 py-2" placeholder="Digite sua mensagem...">
        <button type="submit" class="btn-padrao">Enviar</button>
    </form>
@else
    <p class="text-gray-500">Selecione uma conversa para começar.</p>
@endif
