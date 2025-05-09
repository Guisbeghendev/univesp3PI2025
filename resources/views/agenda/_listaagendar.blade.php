@foreach ($usuariosRelacionados as $usuario)
    <div class="cursor-pointer p-3 rounded hover:bg-blue-100 transition"
         data-usuario-id="{{ $usuario->id }}">
        <div class="font-semibold text-gray-800">{{ $usuario->name }}</div>
        <div class="text-sm text-gray-500">
            {{ $usuario->tipo === 'Profissional' ? 'Profissional' : 'Aluno' }}
        </div>
    </div>
@endforeach
