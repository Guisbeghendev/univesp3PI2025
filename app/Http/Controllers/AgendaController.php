<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AgendaController extends Controller
{
    // Exibe os agendamentos do aluno ou Profissional
    public function index(Request $request)
    {
        $user = Auth::user();

        $usuarioSelecionadoId = $request->get('usuario_id');
        $dataFiltro = $request->get('data');

        $usuariosRelacionados = Agenda::where(function ($query) use ($user) {
                $query->where('aluno_id', $user->id)
                      ->orWhere('Profissional_id', $user->id);
            })
            ->with(['aluno', 'Profissional'])
            ->get()
            ->map(function ($agenda) use ($user) {
                return $user->id === $agenda->aluno_id ? $agenda->Profissional : $agenda->aluno;
            })
            ->unique('id')
            ->values();

        $horarios = collect();
        $usuarioSelecionado = null;

        if ($usuarioSelecionadoId) {
            $usuarioSelecionado = User::find($usuarioSelecionadoId);

            if ($usuarioSelecionado) {
                $query = Horario::where('Profissional_id', $usuarioSelecionado->id)
                                ->where('status', 'disponivel');

                if ($dataFiltro) {
                    try {
                        $data = Carbon::parse($dataFiltro)->format('Y-m-d');
                        $query->whereDate('data', $data);
                    } catch (\Exception $e) {
                        // Ignora data inválida
                    }
                }

                $horarios = $query->orderBy('hora')->get();
            }
        }

        return view('agenda.agenda', compact('usuariosRelacionados', 'horarios', 'usuarioSelecionado'));
    }

    // Agendar uma aula
    public function agendarAula(Request $request, $ProfissionalId, $horarioId = null)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'descricao' => 'nullable|string',
        ]);

        // Verificar se o aluno já possui agendamento ativo com o Profissional
        $jaAgendado = Agenda::where('aluno_id', $user->id)
                            ->where('Profissional_id', $ProfissionalId)
                            ->exists();

        if ($jaAgendado) {
            return redirect()->route('agenda.meus')->with('error', 'Você já possui um agendamento ativo com este Profissional.');
        }

        // Verifica se o horário está disponível
        $horario = Horario::findOrFail($horarioId);

        if ($horario->status !== 'disponivel') {
            return redirect()->route('agenda.index', ['usuario_id' => $ProfissionalId])
                             ->with('error', 'Este horário já foi reservado.');
        }

        // Cria o agendamento
        Agenda::create([
            'aluno_id' => $user->id,
            'Profissional_id' => $ProfissionalId,
            'hora_escolhida' => $horario->hora,
            'hora_oferecida' => $horario->hora,
            'status' => 'pendente',
            'descricao' => $validated['descricao'] ?? null,
            'horario_id' => $horario->id,
        ]);

        // Marca o horário como indisponível
        $horario->status = 'indisponivel';
        $horario->save();

        return redirect()->route('agenda.meus')->with('success', 'Agendamento realizado com sucesso!');
    }

    // Meus agendamentos
    public function meusAgendamentos()
    {
        $user = Auth::user();

        $meusAgendamentos = Agenda::where('aluno_id', $user->id)
            ->orWhere('Profissional_id', $user->id)
            ->with(['aluno', 'Profissional', 'horario'])
            ->get()
            ->sortBy(function ($agenda) {
                return $agenda->horario->data . ' ' . $agenda->horario->hora;
            });

        return view('agenda.meus-agendamentos', compact('meusAgendamentos'));
    }

    // Método para excluir agendamento e atualizar o status do horário
    public function excluirAgendamento($id)
    {
        // Encontra o agendamento
        $agendamento = Agenda::find($id);

        if (!$agendamento) {
            return redirect()->route('agenda.meus')->with('error', 'Agendamento não encontrado.');
        }

        // Obtém o horário do agendamento
        $horario = $agendamento->horario;

        // Apaga o agendamento
        $agendamento->delete();

        // Verifica se o horário tem outros agendamentos. Se não tiver, altera o status para 'disponivel'
        $temOutroAgendamento = Agenda::where('horario_id', $horario->id)->exists();

        if (!$temOutroAgendamento) {
            $horario->status = 'disponivel';
            $horario->save();
        }

        return redirect()->route('agenda.meus')->with('success', 'Agendamento excluído com sucesso e horário disponível novamente!');
    }

    // Iniciar novo agendamento
    public function iniciar(Request $request)
    {
        $request->validate([
            'Profissional_id' => 'required|exists:users,id',
        ]);

        $alunoId = Auth::id();
        $ProfissionalId = $request->Profissional_id;

        $existe = Agenda::where('aluno_id', $alunoId)
                        ->where('Profissional_id', $ProfissionalId)
                        ->exists();

        if (!$existe) {
            Agenda::create([
                'aluno_id' => $alunoId,
                'Profissional_id' => $ProfissionalId,
                'status' => 'pendente',
            ]);
        }

        return redirect()->route('agenda.index', ['usuario_id' => $ProfissionalId]);
    }

    // Exibir cronograma do Profissional
    public function crono()
    {
        $user = Auth::user();

        $horariosDisponiveis = Horario::where('Profissional_id', $user->id)->get();

        return view('agenda.crono', compact('user', 'horariosDisponiveis'));
    }

    // Salvar novo horário no cronograma
    public function salvarCrono(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'status' => 'required|in:disponivel,indisponivel',
        ]);

        $user = Auth::user();

        $horarioExistente = Horario::where('Profissional_id', $user->id)
                                    ->where('data', $request->data)
                                    ->where('hora', $request->hora)
                                    ->exists();

        if ($horarioExistente) {
            return redirect()->route('agenda.crono')->with('error', 'Já existe um horário configurado para esta data e hora.');
        }

        Horario::create([
            'Profissional_id' => $user->id,
            'data' => $request->data,
            'hora' => $request->hora,
            'status' => $request->status,
        ]);

        return redirect()->route('agenda.crono')->with('success', 'Horário adicionado com sucesso!');
    }
}
