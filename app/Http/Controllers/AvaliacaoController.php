<?php

namespace App\Http\Controllers;

use App\Models\Contratacao;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    // Exibe os contratos avaliáveis do aluno
    public function index()
    {
        // Recupera os contratos do aluno, com as avaliações associadas
        $contratos = Contratacao::where('aluno_id', Auth::id())
            ->whereIn('status', ['aceita', 'finalizada']) // Contratos aceitos ou finalizados
            ->with(['Profissional', 'avaliacoes'])  // Inclui as avaliações associadas ao contrato
            ->get();

        return view('avaliar.avaliar', compact('contratos')); // Passa os contratos para a view
    }

    // Exibe o formulário de avaliação ou edição, dependendo se já existe uma avaliação
    public function show($contratoId)
    {
        $contrato = Contratacao::with('Profissional')->findOrFail($contratoId); // Recupera o contrato com o Profissional

        // Verifica se já existe uma avaliação para este contrato pelo aluno
        $avaliacao = $contrato->avaliacoes->firstWhere('aluno_id', Auth::id());

        // Se já existir uma avaliação, redireciona para a página de edição
        if ($avaliacao) {
            return view('avaliar.edit', compact('contrato', 'avaliacao'));
        }

        // Verifica se o contrato é válido para avaliação
        if ($contrato->aluno_id != Auth::id() || !$contrato->isAvaliavel() || $contrato->alunoJaAvaliou()) {
            return redirect()->route('avaliar.index')->with('error', 'Você não pode avaliar esse Profissional.');
        }

        // Caso não exista avaliação, exibe a página de avaliação
        return view('avaliar.show', compact('contrato'));
    }

    // Salva a avaliação
    public function store(Request $request, $contratoId)
    {
        $contrato = Contratacao::findOrFail($contratoId);

        // Verificação se o aluno pode avaliar esse Profissional
        if ($contrato->aluno_id != Auth::id() || !$contrato->isAvaliavel() || $contrato->alunoJaAvaliou()) {
            return redirect()->route('avaliar.index')->with('error', 'Você não pode avaliar esse Profissional.');
        }

        // Validação dos dados de avaliação
        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        // Criação da avaliação
        Avaliacao::create([
            'aluno_id' => Auth::id(),
            'Profissional_id' => $contrato->Profissional_id,
            'contratacao_id' => $contrato->id, // Garantindo que o ID da contratação seja passado corretamente
            'nota' => $request->nota,
            'comentario' => $request->comentario,
            'data_avaliacao' => now(), // Atribuindo a data atual
        ]);

        // Retorna com sucesso
        return redirect()->route('avaliar.index')->with('success', 'Avaliação registrada com sucesso!');
    }

    // Editar a avaliação existente
    public function edit($avaliacaoId)
    {
        $avaliacao = Avaliacao::where('aluno_id', Auth::id())->findOrFail($avaliacaoId);

        // Verifica se a avaliação realmente pertence ao aluno
        return view('avaliar.edit', compact('avaliacao'));
    }

    // Atualizar a avaliação
    public function update(Request $request, $avaliacaoId)
    {
        $avaliacao = Avaliacao::where('aluno_id', Auth::id())->findOrFail($avaliacaoId);

        // Validação dos dados
        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        // Atualiza a avaliação
        $avaliacao->update([
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        // Retorna com sucesso
        return redirect()->route('avaliar.index')->with('success', 'Avaliação atualizada com sucesso!');
    }

    // Método para calcular a média de avaliações de um Profissional
    public function calcularMediaAvaliacoes($ProfissionalId)
    {
        $avaliacoes = Avaliacao::where('Profissional_id', $ProfissionalId)->get(); // Obtém as avaliações do Profissional

        if ($avaliacoes->isNotEmpty()) {
            $media = $avaliacoes->avg('nota'); // Calcula a média das notas
            return round($media, 1); // Retorna a média arredondada para 1 casa decimal
        }

        return null; // Retorna null se não houver avaliações
    }
}
