@extends($layout)

@section('title', 'Editar Perfil e Conta')

@section('content')
<div class="w-full flex justify-center items-center py-10">
    <div class="card-box">
        <h2 class="titulo-principal">Editar Perfil</h2>
        <div class="container space-y-10">

            {{-- Grid com 1 coluna e 6 linhas --}}
            <div class="grid grid-cols-1 gap-4">

                <div class="bg-gray-200 p-4">
                    {{-- FORMULÁRIO 1: INFORMAÇÕES DO PERFIL --}}
                    <form action="{{ route('perfil.updatePerfil') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <h3 class="text-lg font-semibold text-verde">Informações do Perfil</h3>
                        <div>
                            <label class="block font-semibold">Nome</label>
                            <input type="text" name="nome" value="{{ old('nome', $perfil->nome) }}" class="input w-full">
                        </div>
                        <div>
                            <label class="block font-semibold">Estado</label>
                            <select id="estado" name="estado" class="input w-full">
                                <option value="">Selecione um estado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold">Cidade</label>
                            <select id="cidade" name="cidade" class="input w-full">
                                <option value="">Selecione uma cidade</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $perfil->data_nascimento) }}" class="input w-full">
                        </div>
                        <div>
                            <label class="block font-semibold">Biografia</label>
                            <textarea name="biografia" rows="4" class="input w-full">{{ old('biografia', $perfil->biografia) }}</textarea>
                        </div>
                        <div>
                            <label class="block font-semibold">Foto de Perfil</label>
                            <input type="file" name="foto_perfil" class="input w-full">
                            @if($perfil->foto_perfil)
                                <img src="{{ asset('storage/' . $perfil->foto_perfil) }}" alt="Foto atual" class="w-20 h-20 mt-2 rounded-full">
                            @endif
                        </div>
                        <button type="submit" class="btn-padrao">Salvar Informações do Perfil</button>
                    </form>
                </div>

                <div class="bg-gray-200 p-4">
                    {{-- FORMULÁRIO 3: INFORMAÇÕES DA CONTA --}}
                    <form action="{{ route('perfil.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <h3 class="text-lg text-verde font-semibold pt-4">Informações da Conta</h3>
                        @include('profile.partials.update-profile-information-form')
                        <button type="submit" class="btn-padrao">Salvar Informações da Conta</button>
                    </form>
                </div>

                <div class="bg-gray-200 p-4">
                    {{-- FORMULÁRIO 4: SENHA --}}
                    <form action="{{ route('perfil.updatePassword') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <h3 class="text-lg text-verde font-semibold pt-4">Alterar Senha</h3>
                        @include('profile.partials.update-password-form')
                        <button type="submit" class="btn-padrao">Alterar Senha</button>
                    </form>
                </div>

                <div class="bg-gray-200 p-4">
                    {{-- FORMULÁRIO 5: DELETAR CONTA --}}
                    <form action="{{ route('perfil.destroy') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('DELETE')
                        <h3 class="text-lg font-semibold pt-4 text-red-600">Deletar Conta</h3>
                        @include('profile.partials.delete-user-form')
                        <button type="submit" class="btn-padrao bg-red-600 hover:bg-red-700">Deletar Conta</button>
                    </form>
                </div>

                <div class="bg-gray-200 p-4">
                    {{-- BOTÃO CANCELAR --}}
                    <div class="pt-4">
                        <a href="{{ route('perfil.index') }}" class="btn-padrao">Voltar</a>
                    </div>
                </div>
            </div>
            {{-- Fim da grid --}}

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');
    const estadoSelecionado = "{{ old('estado', $perfil->estado) }}";
    const cidadeSelecionada = "{{ old('cidade', $perfil->cidade) }}";

    fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
        .then(response => response.json())
        .then(estados => {
            estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.nome;
                option.text = estado.nome;
                option.dataset.id = estado.id;
                if (estado.nome === estadoSelecionado) {
                    option.selected = true;
                    carregarCidades(estado.id);
                }
                estadoSelect.appendChild(option);
            });
        });

    estadoSelect.addEventListener('change', function () {
        const estadoId = this.options[this.selectedIndex].dataset.id;
        carregarCidades(estadoId);
    });

    function carregarCidades(estadoId) {
        cidadeSelect.innerHTML = '<option value="">Carregando cidades...</option>';

        fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`)
            .then(response => response.json())
            .then(cidades => {
                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                cidades.forEach(cidade => {
                    const option = document.createElement('option');
                    option.value = cidade.nome;
                    option.text = cidade.nome;
                    if (cidade.nome === cidadeSelecionada) {
                        option.selected = true;
                    }
                    cidadeSelect.appendChild(option);
                });
            });
    }
});
</script>
@endsection
