<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'aluno_id',
        'Profissional_id',
        'contratacao_id',  // Adicionando o campo contratacao_id
        'nota',
        'comentario',
        'data_avaliacao',
    ];

    public $timestamps = true; // Permite que o Laravel gerencie os timestamps (created_at, updated_at)

    // Relacionamento com o aluno
    public function aluno()
    {
        return $this->belongsTo(User::class, 'aluno_id');
    }

    // Relacionamento com o Profissional
    public function Profissional()
    {
        return $this->belongsTo(User::class, 'Profissional_id');
    }

    // Relacionamento com a contratacao
    public function contratacao()
    {
        return $this->belongsTo(Contratacao::class, 'contratacao_id');
    }
}
