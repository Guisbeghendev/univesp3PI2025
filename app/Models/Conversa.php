<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversa extends Model
{
    use HasFactory;

    protected $table = 'conversas';

    protected $fillable = [
        'usuario1_id',
        'usuario2_id',
        'data_criacao',
    ];

    public $timestamps = true; // Permite que o Laravel gerencie os timestamps (created_at, updated_at)

    public function usuario1()
    {
        return $this->belongsTo(User::class, 'usuario1_id');
    }

    public function usuario2()
    {
        return $this->belongsTo(User::class, 'usuario2_id');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'conversa_id');
    }

    // 🔹 Acessor para obter o outro usuário da conversa com base no auth()
    public function getOutroUsuarioAttribute()
    {
        return $this->usuario1_id === Auth::id() ? $this->usuario2 : $this->usuario1;
    }
}
