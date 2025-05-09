@foreach ($conversas as $conversa)
    @php
        $outro = $conversa->outroUsuario;
    @endphp
    <div class="cursor-pointer p-3 rounded hover:bg-blue-100 transition"
         data-conversa-id="{{ $conversa->id }}">
        <div class="font-semibold text-gray-800">{{ $outro->name }}</div>
        <div class="text-sm text-gray-500 truncate">
            {{ optional($conversa->mensagens->last())->mensagem ?? 'Sem mensagens ainda' }}
        </div>
    </div>
@endforeach
