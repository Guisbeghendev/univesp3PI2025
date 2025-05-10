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
        'especialidade_id',  // Campo especialidade_id adicionado
    ];

    public $timestamps = true;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id'); // Relacionamento com especialidade
    }
}
