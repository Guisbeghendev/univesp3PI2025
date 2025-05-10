<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Conversa;
use App\Models\Avaliacao;
use App\Models\Especialidades;  // Correção na importação de Especialidades (plural)

class ProfileController extends Controller
{
    // Método para exibir as informações do perfil do usuário
    public function show(): View
    {
        $user = User::with('perfil')->findOrFail(Auth::id());
        $curtidasRecebidas = \App\Models\Curtida::with('profissional.perfil')
            ->where('aluno_id', $user->id)
            ->get();

        return view('profile.showprofile', [
            'layout' => 'layouts.app',
            'user' => $user,
            'curtidasRecebidas' => $curtidasRecebidas,
        ]);
    }

    // Método para exibir o perfil de outro usuário
    public function verPerfilResultado($id): View
    {
        $usuario = User::with('perfil')->findOrFail($id);

        $totalPontos = Avaliacao::where('profissional_id', $usuario->id)->sum('nota');
        $quantidadeAvaliacoes = Avaliacao::where('profissional_id', $usuario->id)->count();
        $mediaAvaliacoes = $quantidadeAvaliacoes > 0 ? round($totalPontos / $quantidadeAvaliacoes, 1) : 'Sem avaliações';

        return view('pesquisa.perfilresult', [
            'layout' => 'layouts.app',
            'usuario' => $usuario,
            'perfil' => $usuario->perfil,
            'totalPontos' => $totalPontos,
            'quantidadeAvaliacoes' => $quantidadeAvaliacoes,
            'mediaAvaliacoes' => $mediaAvaliacoes,
        ]);
    }

    // Método para iniciar um chat com outro usuário
    public function iniciarChat($id): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuarioLogado = Auth::user();
        $outroUsuarioId = intval($id);

        if ($usuarioLogado->id === $outroUsuarioId) {
            return redirect()->back()->with('error', 'Você não pode iniciar um chat consigo mesmo.');
        }

        $ids = [$usuarioLogado->id, $outroUsuarioId];
        sort($ids);

        $conversa = Conversa::where(function ($query) use ($ids) {
            $query->where('usuario1_id', $ids[0])
                ->where('usuario2_id', $ids[1]);
        })->first();

        if (!$conversa) {
            $conversa = Conversa::create([
                'usuario1_id' => $ids[0],
                'usuario2_id' => $ids[1],
                'data_criacao' => now(),
            ]);
        }

        return redirect()->route('chat.index', ['conversa_id' => $conversa->id]);
    }

    // Método para exibir a página de edição da conta
    public function edit(Request $request): View
    {
        $user = $request->user();
        $perfil = $user->perfil;

        return view('profile.editperfil', [
            'user' => $user,
            'perfil' => $perfil,
            'layout' => 'layouts.app',
        ]);
    }

    // Método para atualizar informações da conta
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->fill($request->validated());
        $request->user()->save();

        return Redirect::route('perfil.edit')->with('status', 'profile-updated');
    }

    // Método para excluir a conta
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Método para exibir a edição de detalhes do perfil
    public function editPerfil(): View
    {
        $user = Auth::user();
        $perfil = $user->perfil;

        // Carregando as especialidades para os profissionais
        $especialidades = Especialidades::all();  // Corrigido aqui para o plural

        return view('profile.editperfil', [
            'layout' => 'layouts.app',
            'perfil' => $perfil,
            'especialidades' => $especialidades,  // Passando as especialidades para a view
        ]);
    }

    // Método para atualizar os detalhes do perfil (com especialidades para profissionais)
    public function atualizarPerfil(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $perfil = $user->perfil;

        // Validação dos campos
        $data = $request->validate([
            'nome' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'data_nascimento' => 'nullable|date',
            'biografia' => 'nullable|string',
            'foto_perfil' => 'nullable|image|max:2048',
            'especialidade_id' => 'nullable|exists:especialidades,id',  // Valida a especialidade apenas se existir no banco
        ]);

        // Atualização da foto de perfil, se enviada
        if ($request->hasFile('foto_perfil')) {
            if ($perfil->foto_perfil) {
                Storage::disk('public')->delete($perfil->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('fotos_perfil', 'public');
        }

        // Se o usuário for profissional, ele pode ter uma especialidade associada
        if ($user->tipo === 'profissional' && $request->has('especialidade_id')) {
            $data['especialidade_id'] = $request->input('especialidade_id');
        }

        // Atualizando o perfil com os dados validados
        $perfil->update($data);

        return redirect()->route('perfil.index')->with('success', 'Perfil atualizado com sucesso!');
    }
}
