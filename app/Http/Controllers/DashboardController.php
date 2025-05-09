<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Mensagem;
use App\Models\Contratacao;
use App\Models\Agenda;
use App\Models\Avaliacao;
use App\Models\Curtida; // <-- adicionado
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Exibe a dashboard do usuário autenticado.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Últimas mensagens não lidas
        $ultimasMensagensNaoLidas = Mensagem::where('destinatario_id', $user->id)
            ->where('lida', false)
            ->orderBy('enviada_em', 'desc')
            ->limit(5)
            ->get();

        // Contratos pendentes do usuário
        $contratosPendentes = Contratacao::with(['aluno', 'profissional'])
            ->where(function ($query) use ($user) {
                $query->where('aluno_id', $user->id)
                      ->orWhere('profissional_id', $user->id);
            })
            ->where('status', 'pendente')
            ->get();

        // Agendamentos
        $meusAgendamentos = Agenda::where('aluno_id', $user->id)
            ->orWhere('profissional_id', $user->id)
            ->with(['horario', 'aluno', 'profissional'])
            ->get()
            ->sortBy(function ($agenda) {
                return $agenda->horario->data . ' ' . $agenda->horario->hora;
            });

        // Agendamentos futuros
        $meusAgendamentosFuturos = $meusAgendamentos->filter(function ($agenda) {
            $dataHoraAgendamento = Carbon::parse($agenda->horario->data . ' ' . $agenda->horario->hora);
            return $dataHoraAgendamento->isFuture();
        });

        // Avaliações feitas e recebidas
        $avaliacoesFeitas = [];
        $avaliacoesRecebidas = collect();
        $totalNotasRecebidas = 0;
        $mediaNotasRecebidas = 0;

        if ($user->tipo === 'aluno') {
            $avaliacoesFeitas = Avaliacao::with('profissional')
                ->where('aluno_id', $user->id)
                ->get();
        }

        if ($user->tipo === 'profissional') {
            $avaliacoesRecebidas = Avaliacao::where('profissional_id', $user->id)->get();
            $totalNotasRecebidas = $avaliacoesRecebidas->sum('nota');
            $mediaNotasRecebidas = $avaliacoesRecebidas->count() > 0
                ? round($totalNotasRecebidas / $avaliacoesRecebidas->count(), 2)
                : 0;
        }

        // Curtidas feitas e recebidas
        $curtidasFeitas = collect();
        $curtidasRecebidas = collect();

        if ($user->tipo === 'profissional') {
            $curtidasFeitas = Curtida::with('aluno')
                ->where('profissional_id', $user->id)
                ->get();
        }

        if ($user->tipo === 'aluno') {
            $curtidasRecebidas = Curtida::where('aluno_id', $user->id)->get();
        }

        return view('dashboard.dashboard', compact(
            'user',
            'ultimasMensagensNaoLidas',
            'contratosPendentes',
            'meusAgendamentosFuturos',
            'avaliacoesFeitas',
            'avaliacoesRecebidas',
            'totalNotasRecebidas',
            'mediaNotasRecebidas',
            'curtidasFeitas', // <-- adicionado
            'curtidasRecebidas' // <-- adicionado
        ));
    }
}
