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
    ];

    public $timestamps = true; // Permite que o Laravel gerencie os timestamps (created_at, updated_at)

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
