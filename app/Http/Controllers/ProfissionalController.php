<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class ProfissionalController extends Controller
{
    // Exibe os horários já configurados pelo profissional
    public function showCronograma($profissionalId)
    {
        $horarios = Horario::where('profissional_id', $profissionalId)->get();
        return view('crono', compact('horarios', 'profissionalId'));
    }

    // Método para salvar os horários configurados pelo profissional
    public function saveHorario(Request $request, $profissionalId)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'status' => 'required|in:disponivel,indisponivel',
        ]);

        Horario::create([
            'profissional_id' => $profissionalId,
            'data' => $validated['data'],
            'hora' => $validated['hora'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('profissional.crono', $profissionalId)->with('success', 'Horário atualizado com sucesso!');
    }
}
