<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Avaliacao;
use App\Models\Especializacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesquisaController extends Controller
{
    public function pesquisar(Request $request)
    {
        // Obtém o usuário logado
        $usuario = Auth::user();

        // Define o tipo de perfil que será buscado com base no tipo do usuário logado
        $tipoAlvo = $usuario->tipo === 'aluno' ? 'profissional' : 'aluno';

        // Captura os filtros opcionais
        $cidade = $request->input('cidade');
        $estado = $request->input('estado');
        $especializacao_id = $request->input('especializacao_id');  // Novo campo de especialização

        // Inicia a query filtrando pelo tipo do usuário relacionado (profissional ou aluno)
        $query = Perfil::whereHas('usuario', function ($q) use ($tipoAlvo) {
            $q->where('tipo', $tipoAlvo);
        });

        // Aplica filtros opcionais
        if ($cidade) {
            $query->where('cidade', 'like', "%{$cidade}%");
        }

        if ($estado) {
            $query->where('estado', 'like', "%{$estado}%");
        }

        if ($especializacao_id) {  // Filtro por especialização
            $query->where('especializacao_id', $especializacao_id);
        }

        // Executa a query para buscar os resultados, carregando o relacionamento com o usuário
        $resultados = $query->with('usuario', 'especializacao')->get();

        // Para cada resultado, calcula os dados de avaliação
        foreach ($resultados as $resultado) {
            $totalPontos = Avaliacao::where('profissional_id', $resultado->usuario->id)->sum('nota');
            $quantidadeAvaliacoes = Avaliacao::where('profissional_id', $resultado->usuario->id)->count();

            // Calcula a média das avaliações
            $mediaAvaliacoes = $quantidadeAvaliacoes > 0
                ? round($totalPontos / $quantidadeAvaliacoes, 1)
                : 'Sem avaliações';

            // Armazena os dados de avaliação
            $resultado->totalPontos = $totalPontos;
            $resultado->quantidadeAvaliacoes = $quantidadeAvaliacoes;
            $resultado->mediaAvaliacoes = $mediaAvaliacoes;
        }

        // Passando para a view apenas os resultados
        return view('pesquisa.resultados', compact('resultados'));
    }

    // Página de detalhes do perfil
    public function exibirPerfil($id)
    {
        $usuario = Perfil::where('usuario_id', $id)->firstOrFail();

        // Calcula o total de pontos, a quantidade de avaliações e a média de avaliações para o perfil
        $totalPontos = Avaliacao::where('profissional_id', $usuario->usuario_id)->sum('nota');
        $quantidadeAvaliacoes = Avaliacao::where('profissional_id', $usuario->usuario_id)->count();
        $mediaAvaliacoes = $quantidadeAvaliacoes > 0
            ? round($totalPontos / $quantidadeAvaliacoes, 1)
            : 'Sem avaliações';

        return view('pesquisa.perfilresult', [
            'perfil' => $usuario,
            'totalPontos' => $totalPontos,
            'quantidadeAvaliacoes' => $quantidadeAvaliacoes,
            'mediaAvaliacoes' => $mediaAvaliacoes,
        ]);
    }
}
