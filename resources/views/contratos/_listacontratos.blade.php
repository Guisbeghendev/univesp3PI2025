@foreach ($contratos as $contrato)
    @php
        $outroUsuario = auth()->id() === $contrato->aluno_id ? $contrato->Profissional : $contrato->aluno;
        $isSelected = isset($contratoSelecionado) && $contratoSelecionado->id === $contrato->id;
    @endphp

    <a href="{{ route('contratos.index', ['contrato_id' => $contrato->id]) }}"
       class="block p-3 rounded {{ $isSelected ? 'bg-blue-100' : 'hover:bg-blue-100' }} transition">
        <div class="font-semibold text-gray-800">{{ $outroUsuario->name }}</div>
        <div class="text-sm text-gray-500 truncate">
            {{ Str::limit($contrato->mensagem, 50) }}
        </div>
        <div class="text-xs text-gray-400">
            Status: <span class="capitalize">{{ $contrato->status }}</span>
        </div>
    </a>
@endforeach
