<?php

namespace App\Http\Controllers;

use App\Models\Contratacao;
use App\Models\Avaliacao;
use App\Models\Curtida;  // Adicionado para incluir o modelo Curtida
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContratacaoController extends Controller
{
    // Exibe a lista de contratos
    public function index(Request $request)
    {
        $userId = Auth::id();

        $contratos = Contratacao::with(['aluno', 'profissional'])
            ->where(function ($query) use ($userId) {
                $query->where('aluno_id', $userId)
                      ->orWhere('profissional_id', $userId);
            })
            ->get();

        $contratoSelecionado = null;
        $totalNotas = null;
        $quantidadeAvaliacoes = null;
        $mediaAvaliacoes = null;

        if ($request->has('contrato_id')) {
            $contratoSelecionado = Contratacao::findOrFail($request->contrato_id);

            // Cálculo das informações de avaliação associadas ao contrato
            $totalNotas = Avaliacao::where('contratacao_id', $contratoSelecionado->id)->sum('nota');
            $quantidadeAvaliacoes = Avaliacao::where('contratacao_id', $contratoSelecionado->id)->count();
            $mediaAvaliacoes = $quantidadeAvaliacoes > 0
                ? round($totalNotas / $quantidadeAvaliacoes, 1)
                : 'Sem avaliações';
        }

        return view('contratos.contratos', [
            'contratos' => $contratos,
            'contratoSelecionado' => $contratoSelecionado,
            'userId' => $userId,
            'totalNotas' => $totalNotas,
            'quantidadeAvaliacoes' => $quantidadeAvaliacoes,
            'mediaAvaliacoes' => $mediaAvaliacoes,
        ]);
    }

    // Cria um novo contrato ou redireciona se já existir pendente
    public function criar(Request $request)
    {
        $userId = Auth::id();
        $destinatarioId = $request->input('destinatario_id');

        // Verifica se já existe um contrato pendente entre o aluno e o profissional
        $existeContrato = Contratacao::where(function ($query) use ($userId, $destinatarioId) {
            $query->where('aluno_id', $userId)->where('profissional_id', $destinatarioId);
        })->orWhere(function ($query) use ($userId, $destinatarioId) {
            $query->where('profissional_id', $userId)->where('aluno_id', $destinatarioId);
        })->where('status', 'pendente')->first();

        if ($existeContrato) {
            return redirect()->route('contratos.index', ['contrato_id' => $existeContrato->id]);
        }

        $usuario = Auth::user();
        $alunoId = $usuario->tipo === 'aluno' ? $userId : $destinatarioId;
        $profissionalId = $usuario->tipo === 'profissional' ? $userId : $destinatarioId;

        // Criação do contrato com a mensagem de solicitação de contrato enviada
        $contrato = Contratacao::create([
            'aluno_id' => $alunoId,
            'profissional_id' => $profissionalId,
            'mensagem' => 'Solicitação de contrato enviada',
            'status' => 'pendente',
            'data_contratacao' => now(),
        ]);

        return redirect()->route('contratos.index', ['contrato_id' => $contrato->id])
                         ->with('success', 'Contrato iniciado com sucesso.');
    }

    // Exibe os detalhes do contrato
    public function verDetalhesContrato($id)
    {
        $contrato = Contratacao::with('aluno', 'profissional')->findOrFail($id);

        $totalNotas = Avaliacao::where('contratacao_id', $id)->sum('nota');
        $quantidadeAvaliacoes = Avaliacao::where('contratacao_id', $id)->count();
        $mediaAvaliacoes = $quantidadeAvaliacoes > 0
            ? round($totalNotas / $quantidadeAvaliacoes, 1)
            : 'Sem avaliações';

        return view('contratos.detalhes', [
            'contrato' => $contrato,
            'totalNotas' => $totalNotas,
            'quantidadeAvaliacoes' => $quantidadeAvaliacoes,
            'mediaAvaliacoes' => $mediaAvaliacoes,
        ]);
    }

    // Aceita o contrato
    public function aceitar($id)
    {
        $contrato = Contratacao::findOrFail($id);
        $contrato->status = 'aceita';
        $contrato->marcarComoLido();
        $contrato->save();

        return redirect()->route('contratos.index')->with('success', 'Contrato aceito com sucesso.');
    }

    // Recusa o contrato (geral)
    public function recusar($id)
    {
        $contrato = Contratacao::findOrFail($id);
        $contrato->status = 'recusada';
        $contrato->marcarComoLido();
        $contrato->save();

        return redirect()->route('contratos.index')->with('success', 'Contrato recusado.');
    }

    // Método de desistência específico para o aluno
    public function desistir($id)
    {
        $contrato = Contratacao::findOrFail($id);

        if (Auth::id() !== $contrato->aluno_id) {
            return redirect()->route('contratos.index')->with('error', 'Você não tem permissão para desistir deste contrato.');
        }

        $contrato->status = 'recusada';
        $contrato->mensagem = 'Desistência do contrato';
        $contrato->save();

        return redirect()->route('contratos.index')->with('success', 'Você desistiu do contrato.');
    }

    // Finaliza o contrato
    public function finalizar($id)
    {
        $contrato = Contratacao::findOrFail($id);
        $contrato->status = 'finalizada';
        $contrato->save();

        return redirect()->route('contratos.index')->with('success', 'Contrato finalizado.');
    }

    // Exclui o contrato
    public function excluir($id)
    {
        $contrato = Contratacao::findOrFail($id);
        $contrato->delete();

        return redirect()->route('contratos.index')->with('success', 'Contrato excluído.');
    }

    // Adiciona ou remove uma curtida para o contrato
    public function curtirContrato($contratoId)
    {
        $userId = Auth::id();
        $contrato = Contratacao::findOrFail($contratoId);

        // Verifica se já existe uma curtida do usuário
        $curtidaExistente = Curtida::where('profissional_id', $userId)
                                   ->where('aluno_id', $contrato->aluno_id)
                                   ->first();

        if ($curtidaExistente) {
            // Se já existe, remove a curtida
            $curtidaExistente->delete();
        } else {
            // Caso contrário, cria uma nova curtida
            Curtida::create([
                'profissional_id' => $userId,
                'aluno_id' => $contrato->aluno_id,
                'data_curtida' => now(),
            ]);
        }

        return redirect()->route('contratos.index', ['contrato_id' => $contratoId]);
    }
}
