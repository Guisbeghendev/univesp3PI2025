<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Perfil; // Certifique-se de importar o model Perfil
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Log::debug('Requisição recebida para registro:', $request->all());

        // Validação dos dados recebidos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => ['required', 'in:aluno,Profissional'],
        ]);

        Log::debug('Validação passou! Criando usuário...');

        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => $request->tipo,
            'data_cadastro' => Carbon::now(),
        ]);

        Log::debug('Usuário criado:', [
            'id' => $user->id,
            'email' => $user->email,
            'tipo' => $user->tipo,
        ]);

        // Criação do perfil automaticamente após a criação do usuário
        Perfil::create([
            'usuario_id' => $user->id,  // Vincula o perfil ao usuário recém-criado
            'tipo' => $user->tipo,       // Tipo de usuário (Aluno ou Profissional)
            'nome' => $user->name,       // Nome do usuário no perfil
            // Adicione mais campos do perfil se necessário, como cidade, estado, etc.
        ]);

        // Dispara o evento de registrado
        event(new Registered($user));

        // Realiza login automaticamente após o registro
        Auth::login($user);

        // Redireciona para o dashboard
        return redirect(route('dashboard', absolute: false));
    }
}
