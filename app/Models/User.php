<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne; // Importando o tipo de relacionamento correto
use App\Models\DadosSaude; // Importando a classe DadosSaude
use Illuminate\Database\Eloquent\Relations\HasMany; // Importando HasMany

/**
 * @property-read \App\Models\DadosSaude|null $dadosSaude
 * @method static \Illuminate\Database\Eloquent\Builder|static dadosSaude()
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
        'data_cadastro',
        'chave_acesso', // ✅ Adicionado o campo chave_acesso ao $fillable
    ];

    public $timestamps = true;

    // 🔁 Relacionamentos

    public function perfil(): HasOne
    {
        return $this->hasOne(Perfil::class, 'usuario_id');
    }

    public function curtidasFeitas(): HasMany
    {
        return $this->hasMany(Curtida::class, 'aluno_id');
    }

    public function curtidasRecebidas(): HasMany
    {
        return $this->hasMany(Curtida::class, 'Profissional_id');
    }

    public function avaliacoesFeitas(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'aluno_id');
    }

    public function avaliacoesRecebidas(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'Profissional_id');
    }

    public function contratacoesFeitas(): HasMany
    {
        return $this->hasMany(Contratacao::class, 'aluno_id');
    }

    public function contratacoesRecebidas(): HasMany
    {
        return $this->hasMany(Contratacao::class, 'Profissional_id');
    }

    public function conversasIniciadas(): HasMany
    {
        return $this->hasMany(Conversa::class, 'usuario1_id');
    }

    public function conversasRecebidas(): HasMany
    {
        return $this->hasMany(Conversa::class, 'usuario2_id');
    }

    public function mensagensEnviadas(): HasMany
    {
        return $this->hasMany(Mensagem::class, 'remetente_id');
    }

    public function mensagensRecebidas(): HasMany
    {
        return $this->hasMany(Mensagem::class, 'destinatario_id');
    }

    public function dadosSaude(): HasOne
    {
        return $this->hasOne(DadosSaude::class, 'user_id'); // Explicitamente declara a chave estrangeira 'user_id'
    }
}
