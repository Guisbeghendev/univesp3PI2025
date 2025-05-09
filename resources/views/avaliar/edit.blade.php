@extends('layouts.app')

@section('title', 'Edit Avaliar Profissional')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Editar Avaliação</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <form method="POST" action="{{ route('avaliar.update', $avaliacao->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nota" class="block text-sm font-medium text-gray-700">Nota</label>
                        <input type="number" name="nota" id="nota" value="{{ old('nota', $avaliacao->nota) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" min="1" max="5" required>
                    </div>

                    <div class="mb-4">
                        <label for="comentario" class="block text-sm font-medium text-gray-700">Comentário</label>
                        <textarea name="comentario" id="comentario" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded">{{ old('comentario', $avaliacao->comentario) }}</textarea>
                    </div>

                    <button type="submit" class="btn-padrao">
                        Atualizar Avaliação
                    </button>
                </form>


            </div>

        </div>
    </div>
@endsection
