<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curtida extends Model
{
    use HasFactory;

    protected $table = 'curtidas';

    protected $fillable = [
        'aluno_id',
        'profissional_id',  // Corrigido para 'profissional_id' com 'p' minúsculo
        'data_curtida',
    ];

    public $timestamps = true; // Permite que o Laravel gerencie os timestamps (created_at, updated_at)

    public function aluno()
    {
        return $this->belongsTo(User::class, 'aluno_id');
    }

    public function profissional()  // Corrigido para 'profissional'
    {
        return $this->belongsTo(User::class, 'profissional_id');  // Corrigido para 'profissional_id'
    }
}
