<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacoesTable extends Migration
{
    public function up()
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('Profissional_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('contratacao_id')->nullable()->constrained('contratacoes')->onDelete('set null');
            $table->tinyInteger('nota');
            $table->text('comentario')->nullable();
            $table->timestamp('data_avaliacao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliacoes');
    }
}
