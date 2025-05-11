<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContratacaoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\CurtidaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SaudeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui estão registradas todas as rotas web para a aplicação.
|
*/

// Página inicial
Route::get('/', function () {
    $layout = Auth::check() ? 'layouts.app' : 'layouts.guest';
    return view('home', compact('layout'));
});

// Página Sobre
Route::get('/sobre', function () {
    $layout = Auth::check() ? 'layouts.app' : 'layouts.guest';
    return view('sobre', compact('layout'));
})->name('sobre');

// Exibir perfil pessoal
Route::get('/meu-perfil', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile.show');

// Grupo de rotas que exigem autenticação
Route::middleware('auth')->group(function () {

    /*
    |----------------------------------------------------------------------
    | Perfil
    |----------------------------------------------------------------------
    */
    Route::prefix('perfil')->name('perfil.')->group(function () {
        // Exibir o perfil
        Route::get('/', [ProfileController::class, 'show'])->name('index');

        // Formulário único de edição do perfil e conta
        Route::get('/editar', [ProfileController::class, 'editPerfil'])->name('edit');

        // Atualizar dados do perfil (bio, cidade, etc.)
        Route::patch('/editar', [ProfileController::class, 'atualizarPerfil'])->name('updatePerfil');

        // Atualizar informações da conta (nome, email)
        Route::patch('/atualizar-conta', [ProfileController::class, 'update'])->name('update');

        // Atualizar senha
        Route::patch('/atualizar-senha', [ProfileController::class, 'updatePassword'])->name('updatePassword');

        // Excluir conta
        Route::delete('/excluir', [ProfileController::class, 'destroy'])->name('destroy');

    });



    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Pesquisa
    |--------------------------------------------------------------------------
    */
    Route::get('/pesquisa', [PesquisaController::class, 'pesquisar'])->name('pesquisa.resultados');
    Route::get('/perfil-resultado/{id}', [PesquisaController::class, 'exibirPerfil'])->name('perfil.resultado');


    /*
    |--------------------------------------------------------------------------
    | Chat
    |--------------------------------------------------------------------------
    */
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/enviar', [ChatController::class, 'enviarMensagem'])->name('enviar');
        Route::get('/iniciar/{id}', [ChatController::class, 'iniciar'])->name('iniciar');
        Route::delete('/mensagem/{id}', [ChatController::class, 'excluirMensagem'])->name('excluir.mensagem');
        Route::delete('/conversa/{id}', [ChatController::class, 'excluirConversa'])->name('excluir.conversa');
    });

    /*
    |--------------------------------------------------------------------------
    | Contratos
    |--------------------------------------------------------------------------
    */
    Route::prefix('contratos')->name('contratos.')->group(function () {
        Route::get('/', [ContratacaoController::class, 'index'])->name('index');
        Route::post('/iniciar', [ContratacaoController::class, 'criar'])->name('criar');
        Route::post('/{id}/aceitar', [ContratacaoController::class, 'aceitar'])->name('aceitar');
        Route::post('/{id}/recusar', [ContratacaoController::class, 'recusar'])->name('recusar');
        Route::post('/{id}/finalizar', [ContratacaoController::class, 'finalizar'])->name('finalizar');
        Route::delete('/{id}', [ContratacaoController::class, 'excluir'])->name('excluir');
        Route::post('/{id}/desistir', [ContratacaoController::class, 'desistir'])->name('desistir');
    });

    /*
    |--------------------------------------------------------------------------
    | Agenda
    |--------------------------------------------------------------------------
    */
    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/', [AgendaController::class, 'index'])->name('index');
        Route::post('/agendar/{agendaId}', [AgendaController::class, 'agendar'])->name('agendar');
        Route::get('/meus-agendamentos', [AgendaController::class, 'meusAgendamentos'])->name('meus');
        Route::get('/crono', [AgendaController::class, 'crono'])->name('crono');
        Route::post('/salvar-crono', [AgendaController::class, 'salvarCrono'])->name('salvarCrono');
        Route::post('/iniciar', [AgendaController::class, 'iniciar'])->name('iniciar');
        Route::get('/profissional/{profissionalId}/horarios', [AgendaController::class, 'showHorarios'])->name('horarios');
        Route::post('/profissional/{profissionalId}/horario/{horarioId}/agendar', [AgendaController::class, 'agendarAula'])->name('agendarAula');
    });

    /*
    |--------------------------------------------------------------------------
    | Avaliações
    |--------------------------------------------------------------------------
    */
    Route::prefix('avaliar')->name('avaliar.')->group(function () {
        Route::get('/', [AvaliacaoController::class, 'index'])->name('index');
        Route::get('/{contratoId}', [AvaliacaoController::class, 'show'])->name('show');
        Route::post('/{contratoId}', [AvaliacaoController::class, 'store'])->name('store');
        Route::get('/editar/{avaliacaoId}', [AvaliacaoController::class, 'edit'])->name('edit');
        Route::put('/editar/{avaliacaoId}', [AvaliacaoController::class, 'update'])->name('update');
    });

    /*
    |--------------------------------------------------------------------------
    | Curtidas
    |--------------------------------------------------------------------------
    */
    Route::prefix('curtidas')->name('curtidas.')->group(function () {
        Route::get('/', [CurtidaController::class, 'index'])->name('index');
        Route::post('/curtir/{alunoId}', [CurtidaController::class, 'curtir'])->name('curtir');
    });

        /*
    |--------------------------------------------------------------------------
    | Saúde e Bem-Estar (Chave de Acesso)
    |--------------------------------------------------------------------------
    */
    Route::prefix('saude')->name('saude.')->group(function () {
        Route::get('/', [SaudeController::class, 'index'])->name('index');
        Route::post('/gerar-chave', [SaudeController::class, 'gerarChaveAcesso'])->name('gerar');
    });

});

// Rotas de autenticação (login, registro, etc.)
require __DIR__.'/auth.php';
