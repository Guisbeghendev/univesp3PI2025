<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosSaude extends Model
{
    use HasFactory;

    // Nome da tabela associada ao modelo
    protected $table = 'dados_saude';

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'peso',
        'altura',
        'pressao_sistolica',
        'pressao_diastolica',
        'frequencia_cardiaca',
        'tipo_sanguineo',
        'imc',
        'glicemia',
        'temperatura',
        'colesterol_total',
        'colesterol_ldl',
        'colesterol_hdl',
        'historico_doencas',
        'alergias',
        'medicamentos',
        'historico_cirurgias',
        'idade_metabolica',
        'grau_atividade',
        'percentual_gordura',
        'frequencia_respiratoria',
    ];

    // Relacionamento com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
