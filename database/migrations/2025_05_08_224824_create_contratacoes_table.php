<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contratacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Necessário para suportar chaves estrangeiras

            $table->id();

            $table->unsignedBigInteger('aluno_id');
            $table->unsignedBigInteger('profissional_id');

            $table->text('mensagem')->nullable();
            $table->enum('status', ['pendente', 'aceita', 'recusada', 'finalizada'])->default('pendente');
            $table->timestamp('data_contratacao')->nullable();
            $table->timestamps();

            $table->foreign('aluno_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('profissional_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contratacoes');
    }
};
