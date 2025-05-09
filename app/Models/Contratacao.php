<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Avaliacao;
use Carbon\Carbon;

class Contratacao extends Model
{
    use HasFactory;

    protected $table = 'contratacoes';

    protected $fillable = [
        'aluno_id',
        'Profissional_id',
        'mensagem',
        'status',
        'data_contratacao',
    ];

    protected $casts = [
        'data_contratacao' => 'datetime',
    ];

    /**
     * Relacionamento com o aluno (usuário que contratou)
     */
    public function aluno()
    {
        return $this->belongsTo(User::class, 'aluno_id');
    }

    /**
     * Relacionamento com o Profissional (usuário contratado)
     */
    public function Profissional()
    {
        return $this->belongsTo(User::class, 'Profissional_id');
    }

    /**
     * Formata a data da contratação
     */
    public function getDataContratacaoFormatadaAttribute()
    {
        return $this->data_contratacao
            ? $this->data_contratacao->format('d/m/Y H:i')
            : null;
    }

    /**
     * Marca o contrato como lido (usado por notificações ou alertas)
     */
    public function marcarComoLido()
    {
        $this->mensagem = 'Contrato lido';
        $this->save();
    }

    /**
     * Verifica se o contrato pode ser avaliado pelo aluno
     */
    public function isAvaliavel()
    {
        return in_array($this->status, ['aceita', 'finalizada']);
    }

    /**
     * Verifica se o aluno já avaliou esse contrato
     */
    public function alunoJaAvaliou()
    {
        return $this->avaliacoes()
            ->where('aluno_id', $this->aluno_id)
            ->exists();
    }

    /**
     * Relacionamento com avaliações (de um contrato)
     */
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'contratacao_id');
    }

    /**
     * Acesso direto à avaliação feita pelo aluno neste contrato
     */
    public function avaliacaoDoAluno()
    {
        return $this->hasOne(Avaliacao::class, 'contratacao_id')
            ->where('aluno_id', $this->aluno_id);
    }

    /**
     * Status formatado para exibição (opcional, se quiser usar em views)
     */
    public function getStatusFormatadoAttribute()
    {
        switch ($this->status) {
            case 'aceita':
                return 'Aceita';
            case 'recusada':
                return 'Recusada';
            case 'finalizada':
                return 'Finalizada';
            case 'pendente':
            default:
                return 'Pendente';
        }
    }

    /**
     * Retorna se o contrato está ativo (pode ser útil em filtros)
     */
    public function estaAtivo()
    {
        return $this->status === 'aceita';
    }
}
