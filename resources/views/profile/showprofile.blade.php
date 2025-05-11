@extends($layout)

@section('title', 'Meu Perfil')

{{-- conteúdo da página --}}
@section('content')

    {{-- flexbox para centralizar o conteúdo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as páginas --}}
        <div class="card-box">

            {{-- título da página --}}
            <h2 class="titulo-principal">Meu Perfil</h2>

            {{-- container que encapsula o conteúdo --}}
            <div class="container">

                <div class="grid grid-cols-1 gap-4">

                    <!-- Dados da Conta -->
                    <section>
                        <ul class="space-y-1 text-gray-700">
                            <li><strong>Nome:</strong> {{ $user->name }}</li>
                            <li><strong>Email:</strong> {{ $user->email }}</li>
                            <li><strong>Tipo de usuário:</strong> {{ ucfirst($user->tipo) }}</li>
                            <li><strong>Registrado em:</strong>
                                {{ $user->data_cadastro ? \Carbon\Carbon::parse($user->data_cadastro)->format('d/m/Y') : 'Não informado' }}
                            </li>
                        </ul>
                    </section>

                    <!-- Dados Pessoais (Perfil) -->
                    @if($user->perfil)
                        <section class="mt-6">
                            <ul class="space-y-1 text-gray-700">
                                <li><strong>Cidade:</strong> {{ $user->perfil->cidade ?? 'Não preenchido' }}</li>
                                <li><strong>Estado:</strong> {{ $user->perfil->estado ?? 'Não preenchido' }}</li>
                                <li><strong>Data de nascimento:</strong>
                                    {{ $user->perfil->data_nascimento ? \Carbon\Carbon::parse($user->perfil->data_nascimento)->format('d/m/Y') : 'Não preenchido' }}
                                </li>
                                <li><strong>Biografia:</strong> {{ $user->perfil->biografia ?? 'Não preenchido' }}</li>

                                <!-- Alteração condicional para a legenda de especialização -->
                                <li>
                                    <strong>
                                        @if($user->tipo === 'aluno')
                                            Especialidade buscada:
                                        @elseif($user->tipo === 'profissional')
                                            Especialidade oferecida:
                                        @else
                                            Especialização:
                                        @endif
                                    </strong>
                                    {{ $user->perfil->especializacao ? $user->perfil->especializacao->nome : 'Não preenchido' }}
                                </li>

                                <li><strong>Foto de perfil:</strong>
                                    @if($user->perfil->foto_perfil)
                                        <img src="{{ asset('storage/' . $user->perfil->foto_perfil) }}" alt="Foto de Perfil" class="w-24 h-24 rounded-full mt-2">
                                    @else
                                        <span>Não enviada</span>
                                    @endif
                                </li>
                            </ul>
                        </section>
                    @else
                        <p class="text-red-600 mt-4">Perfil ainda não preenchido.</p>
                    @endif



                    <!-- Profissionais que curtiram -->
                    @if($curtidasRecebidas->isNotEmpty())
                        <section class="mt-8">
                            <h3 class="text-xl font-semibold text-blue-500 mb-2">Profissionais que curtiram você:</h3>
                            <ul class="space-y-2">
                                @foreach($curtidasRecebidas as $curtida)
                                    <li class="flex items-center space-x-2">
                                        @if($curtida->Profissional->perfil && $curtida->Profissional->perfil->foto_perfil)
                                            <img src="{{ asset('storage/' . $curtida->Profissional->perfil->foto_perfil) }}" alt="Foto do Profissional" class="w-10 h-10 rounded-full">
                                        @else
                                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white">
                                                ?
                                            </div>
                                        @endif
                                        <span>{{ $curtida->Profissional->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    @else
                        <p class="text-gray-500 mt-6">Nenhum profissional curtiu você ainda.</p>
                    @endif

                    <!-- Botão de Edição -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('perfil.edit') }}" class="btn-padrao">
                            Editar Perfil
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
