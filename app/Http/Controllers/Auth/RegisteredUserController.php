<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        event(new Registered($user));

        // Criação automática do perfil
        $user->perfil()->create([
            'tipo' => $user->tipo, // Reaproveita o tipo já atribuído ao usuário
            'especialidade_id' => null, // ou algum valor padrão que você quiser
        ]);

        // Realiza login automaticamente após o registro
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
