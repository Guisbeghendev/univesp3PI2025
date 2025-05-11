<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Especializacao extends Model
{
    use HasFactory;

    protected $table = 'especializacao';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    // ✅ Relacionamento com usuários
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_especializacao');
    }
}
