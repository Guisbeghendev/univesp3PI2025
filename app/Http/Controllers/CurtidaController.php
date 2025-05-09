<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curtida;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CurtidaController extends Controller
{
    public function index()
    {
        $profissional = User::find(Auth::id());

        // Pega alunos com quem o profissional tem contrato aceito/finalizado
        $alunos = User::where('id', '!=', $profissional->id)
            ->whereHas('contratacoesFeitas', function ($query) use ($profissional) {
                $query->where('profissional_id', $profissional->id)
                      ->whereIn('status', ['aceita', 'finalizada']);
            })
            ->get();

        foreach ($alunos as $aluno) {
            // Verifica se o profissional já curtiu esse aluno
            $aluno->curtido = $profissional->curtidasRecebidas()
                                    ->where('aluno_id', $aluno->id)
                                    ->exists();
        }

        return view('curtidas.curtidas', compact('alunos'));
    }

    public function curtir($alunoId)
    {
        $profissionalId = Auth::id();

        // Verifica se a curtida já existe
        $curtidaExistente = Curtida::where('profissional_id', $profissionalId)
                                   ->where('aluno_id', $alunoId)
                                   ->first();

        if ($curtidaExistente) {
            // Se a curtida já existe, remove
            $curtidaExistente->delete();
            return redirect()->route('curtidas.index')->with('success', 'Descurtido com sucesso!');
        } else {
            // Caso contrário, cria uma nova curtida
            Curtida::create([
                'profissional_id' => $profissionalId,
                'aluno_id' => $alunoId,
                'data_curtida' => now(),
            ]);
            return redirect()->route('curtidas.index')->with('success', 'Curtida registrada com sucesso!');
        }
    }
}
