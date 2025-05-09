<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agenda;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horario'; // Nome da tabela

    protected $fillable = [
        'Profissional_id',
        'data',
        'hora',
        'status',
    ];

    // Relacionamento com o Profissional
    public function Profissional()
    {
        return $this->belongsTo(User::class, 'Profissional_id');
    }

    // Relacionamento com a agenda
    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'horario_id');
    }

    // Verifica se o horário está disponível
    public function isDisponivel()
    {
        return $this->status === 'disponivel';
    }

    // Verifica se está indisponível
    public function isIndisponivel()
    {
        return $this->status === 'indisponivel';
    }

    // Mutator para garantir a hora no formato correto
    public function setHoraAttribute($value)
    {
        $this->attributes['hora'] = \Carbon\Carbon::parse($value)->format('H:i:s');
    }

    // Marca o horário como "indisponível"
    public static function marcarIndisponivel($horarioId)
    {
        $horario = self::find($horarioId);
        if ($horario && $horario->isDisponivel()) {
            $horario->status = 'indisponivel';
            $horario->save();
        }
    }

    // Marca o horário como "disponível"
    public static function marcarDisponivel($horarioId)
    {
        $horario = self::find($horarioId);
        if ($horario && $horario->isIndisponivel()) {
            $horario->status = 'disponivel';
            $horario->save();
        }
    }

    // Sincroniza status automaticamente ao carregar o modelo
    protected static function booted()
    {
        static::retrieved(function ($horario) {
            // Se estiver como indisponível mas não tiver nenhum agendamento, corrige
            if ($horario->isIndisponivel() && !$horario->agenda()->exists()) {
                $horario->status = 'disponivel';
                $horario->save();
            }

            // Se estiver como disponível mas tiver agendamento, corrige
            if ($horario->isDisponivel() && $horario->agenda()->exists()) {
                $horario->status = 'indisponivel';
                $horario->save();
            }
        });
    }

    // Método manual caso queira chamar de fora
    public static function atualizarStatusHorariosIndisponiveis()
    {
        $horarios = self::all();

        foreach ($horarios as $horario) {
            if ($horario->isIndisponivel() && !$horario->agenda()->exists()) {
                $horario->status = 'disponivel';
                $horario->save();
            }

            if ($horario->isDisponivel() && $horario->agenda()->exists()) {
                $horario->status = 'indisponivel';
                $horario->save();
            }
        }
    }
}
