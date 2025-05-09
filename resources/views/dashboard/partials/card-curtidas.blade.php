<!-- Card de Curtidas -->
<div class="partials-box">
    <div class="grid grid-cols-1 gap-4 w-full">
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-verde">CURTIDAS</h2>
        </div>

        <div class="space-y-2">
            @if (auth()->user()->tipo === 'Profissional')
                @if ($curtidasFeitas->isEmpty())
                    <p class="text-gray-600">Você ainda não curtiu nenhum aluno.</p>
                @else
                    <div class="space-y-2 text-gray-800">
                        <p><strong>Total de curtidas feitas:</strong> {{ $curtidasFeitas->count() }}</p>
                    </div>
                @endif

            @elseif (auth()->user()->tipo === 'aluno')
                @if ($curtidasRecebidas->isEmpty())
                    <p class="text-gray-600">Você ainda não recebeu nenhuma curtida.</p>
                @else
                    <div class="space-y-2 text-gray-800">
                        <p><strong>Total de curtidas recebidas:</strong> {{ $curtidasRecebidas->count() }}</p>
                    </div>
                @endif
            @endif
        </div>

        <!-- Botão para acessar a página de curtidas -->
        <div class="text-center">
            <a href="{{ route('curtidas.index') }}" class="btn-padrao">
                Ver todas as Curtidas
            </a>
        </div>
    </div>
</div>
