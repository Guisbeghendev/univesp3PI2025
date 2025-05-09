<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensagensTable extends Migration
{
    public function up()
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remetente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destinatario_id')->constrained('users')->onDelete('cascade');
            $table->text('mensagem');
            $table->string('status')->default('enviada');
            $table->boolean('lida')->default(false);
            $table->timestamp('enviada_em')->nullable();
            $table->foreignId('conversa_id')->constrained('conversas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensagens');
    }
}
