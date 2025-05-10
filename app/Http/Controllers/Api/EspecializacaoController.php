<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Especializacao;
use Illuminate\Http\Request;

class EspecializacaoController extends Controller
{
    // Método para listar todas as especializações
    public function index()
    {
        $especializacoes = Especializacao::all();
        return response()->json($especializacoes);
    }

    // Método para exibir uma especialização específica
    public function show($id)
    {
        $especializacao = Especializacao::findOrFail($id);
        return response()->json($especializacao);
    }

    // Método para criar uma nova especialização
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $especializacao = Especializacao::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return response()->json($especializacao, 201);
    }

    // Método para atualizar uma especialização
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $especializacao = Especializacao::findOrFail($id);
        $especializacao->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return response()->json($especializacao);
    }

    // Método para excluir uma especialização
    public function destroy($id)
    {
        $especializacao = Especializacao::findOrFail($id);
        $especializacao->delete();

        return response()->json(null, 204);
    }
}
