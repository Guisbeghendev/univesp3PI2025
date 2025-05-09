<?php

namespace App\Http\Controllers;

use App\Models\Conversa;
use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $conversas = Conversa::where('usuario1_id', $userId)
            ->orWhere('usuario2_id', $userId)
            ->with(['usuario1', 'usuario2', 'mensagens'])
            ->get();

        $conversaSelecionada = null;
        $mensagens = null;

        if ($request->has('conversa_id')) {
            $conversaSelecionada = Conversa::with('mensagens')->findOrFail($request->conversa_id);
            $mensagens = $conversaSelecionada->mensagens()->orderBy('enviada_em')->get();

            // Atualizar status das mensagens para 'lida' se o usuário for o destinatário
            foreach ($mensagens as $mensagem) {
                if ($mensagem->destinatario_id == Auth::id() && !$mensagem->lida) {
                    $mensagem->update([
                        'status' => 'lida',
                        'lida' => true
                    ]);
                }
            }
        }

        return view('chat.chat', compact('conversas', 'conversaSelecionada', 'mensagens'));
    }

    public function enviarMensagem(Request $request)
    {
        // Usando GET para pegar os parâmetros
        $conversa_id = $request->query('conversa_id');
        $mensagem = $request->query('mensagem');

        if (!$mensagem || !$conversa_id) {
            return redirect()->route('chat.index')->with('error', 'Mensagem ou conversa não fornecida!');
        }

        $conversa = Conversa::findOrFail($conversa_id);

        // A mensagem é registrada com status 'enviada'
        Mensagem::create([
            'remetente_id' => Auth::id(),
            'destinatario_id' => $conversa->outroUsuario->id,
            'mensagem' => $mensagem,
            'conversa_id' => $conversa->id,
            'status' => 'enviada', // Mensagem é 'enviada' inicialmente
            'enviada_em' => now(),
        ]);

        // Redireciona para o chat com a conversa selecionada
        return redirect()->route('chat.index', ['conversa_id' => $conversa->id]);
    }

    public function iniciar($id)
    {
        $usuarioLogadoId = Auth::id();
        $usuarioDestinoId = $id;

        $conversa = Conversa::where(function ($query) use ($usuarioLogadoId, $usuarioDestinoId) {
            $query->where('usuario1_id', $usuarioLogadoId)
                  ->where('usuario2_id', $usuarioDestinoId);
        })->orWhere(function ($query) use ($usuarioLogadoId, $usuarioDestinoId) {
            $query->where('usuario1_id', $usuarioDestinoId)
                  ->where('usuario2_id', $usuarioLogadoId);
        })->first();

        if (!$conversa) {
            $conversa = Conversa::create([
                'usuario1_id' => $usuarioLogadoId,
                'usuario2_id' => $usuarioDestinoId,
            ]);
        }

        return redirect()->route('chat.index', ['conversa_id' => $conversa->id]);
    }

    // Método para excluir a mensagem
    public function excluirMensagem($id)
    {
        $mensagem = Mensagem::findOrFail($id);

        // Verifica se o usuário tem permissão para excluir a mensagem
        if ($mensagem->remetente_id === Auth::id() || $mensagem->destinatario_id === Auth::id()) {
            $mensagem->delete();
            return redirect()->back()->with('success', 'Mensagem excluída com sucesso.');
        }

        return redirect()->back()->with('error', 'Você não tem permissão para excluir esta mensagem.');
    }

    // Método para excluir a conversa
    public function excluirConversa($id)
    {
        $conversa = Conversa::findOrFail($id);

        // Verifica se o usuário está participando da conversa
        if ($conversa->usuario1_id === Auth::id() || $conversa->usuario2_id === Auth::id()) {
            $conversa->mensagens()->delete();
            $conversa->delete();
            return redirect()->route('chat.index')->with('success', 'Conversa excluída com sucesso.');
        }

        return redirect()->route('chat.index')->with('error', 'Você não tem permissão para excluir esta conversa.');
    }
}
