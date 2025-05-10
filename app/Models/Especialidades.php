<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model  // Mantido no plural conforme você pediu
{
    use HasFactory;

    // O nome da tabela continua 'especialidades', já que você quer usar no plural
    protected $table = 'especialidades';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    // Caso você queira usar os timestamps de maneira personalizada, pode desabilitar com:
    // public $timestamps = false;
}
