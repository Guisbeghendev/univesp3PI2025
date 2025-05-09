<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunoController extends Controller
{
    // Agendar uma aula
    public function agendarAula(Request $request, $ProfissionalId, $horarioId)
    {
        // Validação dos dados
        $validated = $request->validate([
            'descricao' => 'nullable|string',
        ]);

        // Pegando o usuário autenticado
        $user = Auth::user();

        // Encontrando o horário selecionado
        $horario = Horario::findOrFail($horarioId);

        // Verifica se o horário está disponível
        if ($horario->status !== 'disponivel') {
            return redirect()->route('aluno.horarios', $ProfissionalId)
                             ->with('error', 'Este horário já foi reservado ou não está disponível.');
        }

        // Criando o agendamento
        Agenda::create([
            'aluno_id' => $user->id, // Agora o usuário é claramente definido
            'Profissional_id' => $ProfissionalId,
            'hora_oferecida' => $horario->hora, // Hora oferecida (horário do Profissional)
            'hora_escolhida' => $horario->hora, // Hora escolhida (horário selecionado pelo aluno)
            'status' => 'pendente',
            'descricao' => $validated['descricao'],
            'horario_id' => $horarioId,
        ]);

        // Atualizando o status do horário para "indisponível"
        $horario->status = 'indisponivel';
        $horario->save();

        return redirect()->route('aluno.horarios', $ProfissionalId)->with('success', 'Aula agendada com sucesso!');
    }
}
