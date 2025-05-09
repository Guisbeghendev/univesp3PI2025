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
        'Profissional_id',
        'data_curtida',
    ];

    public $timestamps = true; // Permite que o Laravel gerencie os timestamps (created_at, updated_at)

    public function aluno()
    {
        return $this->belongsTo(User::class, 'aluno_id');
    }

    public function Profissional()
    {
        return $this->belongsTo(User::class, 'Profissional_id');
    }
}
