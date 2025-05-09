<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    protected $table = 'mensagens';

    protected $fillable = [
        'remetente_id',
        'destinatario_id',
        'mensagem',
        'status',
        'lida',
        'enviada_em',
        'conversa_id',
    ];

    public $timestamps = true;

    protected $casts = [
        'enviada_em' => 'datetime',
    ];

    public function remetente()
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    public function conversa()
    {
        return $this->belongsTo(Conversa::class, 'conversa_id');
    }
}
