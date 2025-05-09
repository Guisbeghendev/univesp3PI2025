<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Horario;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda'; // Nome da tabela

    protected $fillable = [
        'aluno_id',        // ID do aluno
        'Profissional_id',        // ID do Profissional
        'hora_escolhida',  // Hora escolhida pelo aluno
        'horario_id',      // Relacionamento com a tabela Horario
    ];

    protected $casts = [
        'horario_id' => 'integer',
    ];

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

    // Relacionamento com o horário
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id')->withDefault();
    }

    // Mutator para garantir a hora escolhida no formato correto
    public function setHoraEscolhidaAttribute($value)
    {
        $this->attributes['hora_escolhida'] = \Carbon\Carbon::parse($value)->format('H:i:s');
    }

    // Método para gerenciar eventos quando um agendamento for deletado
    protected static function boot()
    {
        parent::boot();

        // Evento para quando o agendamento for deletado
        static::deleted(function ($agenda) {
            // Verifica se o agendamento tem um horário associado
            if ($agenda->horario_id) {
                $horario = Horario::find($agenda->horario_id);

                if ($horario) {
                    // Verifica se há outros agendamentos para o mesmo horário
                    $agendamentos = Agenda::where('horario_id', $horario->id)->count();

                    // Se não houver mais agendamentos, o status do horário será alterado para "disponivel"
                    if ($agendamentos === 0) {
                        $horario->status = 'disponivel';
                        $horario->save();
                    }
                }
            }
        });
    }

    // Método para validar se o aluno já agendou este horário
    public static function validarAgendamento($alunoId, $horarioId)
    {
        // Verifica se o aluno já agendou esse horário
        $agendamentoExistente = self::where('aluno_id', $alunoId)
                                   ->where('horario_id', $horarioId)
                                   ->exists();

        if ($agendamentoExistente) {
            return response()->json(['error' => 'Você já agendou este horário.']);
        }

        return true;
    }

    // Método para agendar uma aula
    public static function agendar($alunoId, $ProfissionalId, $horarioId)
    {
        // Validar agendamento duplicado
        $validacao = self::validarAgendamento($alunoId, $horarioId);
        if ($validacao !== true) {
            return $validacao;  // Retorna o erro se a validação falhar
        }

        // Verifica se o horário está disponível
        $horario = Horario::find($horarioId);
        if (!$horario || !$horario->isDisponivel()) {
            return response()->json(['error' => 'Este horário não está disponível.']);
        }

        // Marca o horário como indisponível
        Horario::marcarIndisponivel($horarioId);

        // Cria o agendamento
        return self::create([
            'aluno_id' => $alunoId,
            'Profissional_id' => $ProfissionalId,
            'horario_id' => $horarioId,
            'hora_escolhida' => $horario->hora,
        ]);
    }
}
