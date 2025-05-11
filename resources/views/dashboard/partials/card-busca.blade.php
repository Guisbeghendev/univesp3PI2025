<!-- Card com classe reutilizável -->
<div class="partials-box">
    <!-- grid padrão -->
    <div class="grid grid-cols-1 gap-4 w-full">
        <!-- Linha padrão dos títulos -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-verde">PESQUISA</h2>
        </div>

        <!-- Linha padrão dos conteúdos -->
        <div>
            {{-- Formulário de Pesquisa --}}
            <form method="GET" action="{{ route('pesquisa.resultados') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Campo Cidade --}}
                    <div>
                        <label for="cidade" class="block font-semibold text-gray-700">Cidade</label>
                        <input type="text" name="cidade" id="cidade"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                               placeholder="Digite a cidade">
                    </div>

                    {{-- Campo Estado --}}
                    <div>
                        <label for="estado" class="block font-semibold text-gray-700">Estado</label>
                        <input type="text" name="estado" id="estado"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                               placeholder="Digite o estado">
                    </div>

                    {{-- Campo Especialização --}}
                    <div>
                        <label for="especializacao_id" class="block font-semibold text-gray-700">Especialização</label>
                        <select name="especializacao_id" id="especializacao_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                            <option value="">Selecione uma especialização</option>
                            @foreach(\App\Models\Especializacao::all() as $especializacao)
                                <option value="{{ $especializacao->id }}" {{ old('especializacao_id') == $especializacao->id ? 'selected' : '' }}>
                                    {{ $especializacao->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Botão de pesquisa --}}
                <div class="text-center">
                    <button type="submit" class="btn-padrao">
                        Pesquisar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
