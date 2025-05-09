@extends('layouts.app')

@section('title', 'Curtidas')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">Alunos disponíveis para curtir</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">

                <div class="row">
                    @foreach($alunos as $aluno)
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $aluno->name }}</h5>
                                    <p class="card-text">Email: {{ $aluno->email }}</p>

                                    <div class="d-flex align-items-center">
                                        <!-- O botão vai sempre ficar visível, mudando de cor conforme o estado -->
                                        <form method="POST" action="{{ route('curtidas.curtir', $aluno->id) }}">
                                            @csrf
                                            @if($aluno->curtido)
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
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>

        </div>
    </div>
@endsection
