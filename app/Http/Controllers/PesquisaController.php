<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Avaliacao;
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
        $idioma = $request->input('idioma');

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

        if ($idioma) {
            $query->where('idiomas', 'like', "%{$idioma}%");
        }

        // Executa a query para buscar os resultados, carregando o relacionamento com o usuário
        $resultados = $query->with('usuario')->get();

        // Para cada resultado, calcula os dados de avaliação
        foreach ($resultados as $resultado) {
            // Calcula a soma das notas (total de pontos recebidos)
            $totalPontos = Avaliacao::where('profissional_id', $resultado->usuario->id)->sum('nota');
            // Conta a quantidade de avaliações (total de votos recebidos)
            $quantidadeAvaliacoes = Avaliacao::where('profissional_id', $resultado->usuario->id)->count();

            // Calcula a média das avaliações
            $mediaAvaliacoes = $quantidadeAvaliacoes > 0 ? round($totalPontos / $quantidadeAvaliacoes, 1) : 'Sem avaliações';

            // Armazena os dados de avaliação
            $resultado->totalPontos = $totalPontos;             // Total de pontos
            $resultado->quantidadeAvaliacoes = $quantidadeAvaliacoes; // Quantidade de avaliações
            $resultado->mediaAvaliacoes = $mediaAvaliacoes;     // Média das avaliações
        }

        // Passando para a view os resultados já calculados
        return view('pesquisa.resultados', compact('resultados'));
    }

    // Página de detalhes do perfil
    public function exibirPerfil($id)
    {
        $usuario = Perfil::where('usuario_id', $id)->firstOrFail();

        // Calcula o total de pontos, a quantidade de avaliações e a média de avaliações para o perfil
        $totalPontos = Avaliacao::where('profissional_id', $usuario->usuario_id)->sum('nota');
        $quantidadeAvaliacoes = Avaliacao::where('profissional_id', $usuario->usuario_id)->count();
        $mediaAvaliacoes = $quantidadeAvaliacoes > 0 ? round($totalPontos / $quantidadeAvaliacoes, 1) : 'Sem avaliações';

        // Passando os dados para a view do perfil
        return view('pesquisa.perfilresult', [
            'perfil' => $usuario,
            'totalPontos' => $totalPontos,  // Total de pontos recebidos
            'quantidadeAvaliacoes' => $quantidadeAvaliacoes, // Total de votos recebidos
            'mediaAvaliacoes' => $mediaAvaliacoes, // Média das avaliações
        ]);
    }
}
