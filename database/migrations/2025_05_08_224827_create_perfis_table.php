<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfisTable extends Migration
{
    public function up()
    {
        Schema::create('perfis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['aluno', 'profissional']);
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->text('biografia')->nullable();
            $table->string('idiomas')->nullable();
            $table->string('foto_perfil')->nullable();

            // Cria a coluna, mas sem definir a foreign ainda
            $table->unsignedBigInteger('especialidade_id')->nullable();

            $table->timestamps();
        });

        // Define a foreign key separadamente, após a criação da tabela
        Schema::table('perfis', function (Blueprint $table) {
            $table->foreign('especialidade_id')
                ->references('id')
                ->on('especialidades')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfis');
    }
}
