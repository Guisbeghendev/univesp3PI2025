@extends('layouts.app')

@section('title', 'Avaliar Profissional')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Avaliar Profissional</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                @if ($contrato->isAvaliavel())
                <form action="{{ route('avaliar.store', $contrato->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nota" class="block text-sm font-medium text-gray-700">Nota (1 a 5)</label>
                        <input type="number" id="nota" name="nota" min="1" max="5" value="{{ old('nota') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nota')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="comentario" class="block text-sm font-medium text-gray-700">Comentário (opcional)</label>
                        <textarea id="comentario" name="comentario" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('comentario') }}</textarea>
                        @error('comentario')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-padrao">Enviar Avaliação</button>
                </form>
            @else
                <p class="text-red-500">Você não pode avaliar esse Profissional no momento.</p>
            @endif

            </div>

        </div>
    </div>
@endsection

