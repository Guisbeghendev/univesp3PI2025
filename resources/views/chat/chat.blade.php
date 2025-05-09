@extends('layouts.app')

@section('title', 'Chat')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Conversas</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Lista de conversas (coluna esquerda) -->
                    <div class="md:col-span-1 bg-white rounded-lg shadow p-4 overflow-y-auto max-h-[600px]">
                        @foreach ($conversas as $conversa)
                            @php
                                $outro = $conversa->outroUsuario;
                            @endphp
                            <a href="{{ route('chat.index', ['conversa_id' => $conversa->id]) }}"
                               class="block p-3 rounded hover:bg-blue-100 transition">
                                <div class="font-semibold text-gray-800">{{ $outro->name }}</div>
                                <div class="text-sm text-gray-500 truncate">
                                    {{ optional($conversa->mensagens->last())->mensagem ?? 'Sem mensagens ainda' }}
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Área da conversa aberta (coluna direita) -->
                    <div class="md:col-span-2 bg-white rounded-lg shadow p-4">
                        @if ($mensagens)
                            <div id="mensagens" class="space-y-2 max-h-[500px] overflow-y-auto mb-4">
                                @foreach ($mensagens as $mensagem)
                                    <div class="p-2 rounded-lg
                                        {{ $mensagem->remetente_id === auth()->id() ? 'bg-blue-100 text-right' : 'bg-gray-100 text-left' }}">
                                        <div class="text-sm">{{ $mensagem->mensagem }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $mensagem->enviada_em->format('d/m/Y H:i') }}
                                        </div>

                                        <!-- Exibição do Status da Mensagem -->
                                        <div class="text-xs text-gray-400 mt-1">
                                            Status:
                                            @if($mensagem->status === 'enviada')
                                                <span class="text-yellow-500">Enviada</span>
                                            @elseif($mensagem->status === 'entregue')
                                                <span class="text-blue-500">Entregue</span>
                                            @elseif($mensagem->status === 'lida')
                                                <span class="text-green-500">Lida</span>
                                            @else
                                                <span class="text-gray-500">Desconhecido</span>
                                            @endif
                                        </div>

                                        @if ($mensagem->remetente_id === auth()->id())
                                            <form action="{{ route('chat.excluir.mensagem', $mensagem->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 text-xs">Excluir</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <form id="formMensagem" method="GET" action="{{ route('chat.enviar') }}" class="flex gap-2">
                                <input type="hidden" name="conversa_id" value="{{ $conversaSelecionada->id }}">
                                <input type="text" name="mensagem" class="flex-1 border rounded px-3 py-2" placeholder="Digite sua mensagem..." required>
                                <button type="submit" class="btn-padrao">Enviar</button>
                            </form>
                        @else
                            <p class="text-gray-500">Selecione uma conversa para começar.</p>
                        @endif
                    </div>
                </div>

                <!-- Excluir conversa -->
                @if ($conversaSelecionada)
                    <form action="{{ route('chat.excluir.conversa', $conversaSelecionada->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded mt-4">Excluir Conversa</button>
                    </form>
                @endif

            </div>

        </div>
    </div>
@endsection
