<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'cidade',
        'estado',
        'data_nascimento',
        'biografia',
        'idiomas',
        'foto_perfil',
        'especializacao_id',  // Corrigido: de especialidade_id para especializacao_id
    ];

    public $timestamps = true;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function especializacao()
    {
        return $this->belongsTo(Especializacao::class, 'especializacao_id'); // Corrigido relacionamento
    }
}
