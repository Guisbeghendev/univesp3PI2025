<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDadosSaudeTable extends Migration
{
    public function up()
    {
        Schema::create('dados_saude', function (Blueprint $table) {
            $table->id();  // Cria a chave primária auto-incrementável
            $table->unsignedBigInteger('user_id');  // Chave estrangeira para a tabela de usuários
            $table->decimal('peso', 5, 2)->nullable();  // Peso (kg)
            $table->decimal('altura', 4, 2)->nullable();  // Altura (m)
            $table->decimal('pressao_sistolica', 5, 2)->nullable();  // Pressão sistólica
            $table->decimal('pressao_diastolica', 5, 2)->nullable();  // Pressão diastólica
            $table->integer('frequencia_cardiaca')->nullable();  // Frequência cardíaca (batimentos por minuto)
            $table->string('tipo_sanguineo', 3)->nullable();  // Tipo sanguíneo (ex: O+, A-)
            $table->decimal('imc', 5, 2)->nullable();  // Índice de Massa Corporal
            $table->decimal('glicemia', 5, 2)->nullable();  // Glicemia
            $table->decimal('temperatura', 4, 2)->nullable();  // Temperatura corporal
            $table->decimal('colesterol_total', 5, 2)->nullable();  // Colesterol total
            $table->decimal('colesterol_ldl', 5, 2)->nullable();  // Colesterol LDL
            $table->decimal('colesterol_hdl', 5, 2)->nullable();  // Colesterol HDL
            $table->text('historico_doencas')->nullable();  // Histórico de doenças
            $table->text('alergias')->nullable();  // Alergias
            $table->text('medicamentos')->nullable();  // Medicamentos em uso
            $table->text('historico_cirurgias')->nullable();  // Histórico de cirurgias
            $table->decimal('idade_metabolica', 5, 2)->nullable();  // Idade metabólica
            $table->string('grau_atividade')->nullable();  // Grau de atividade física
            $table->decimal('percentual_gordura', 5, 2)->nullable();  // Percentual de gordura corporal
            $table->decimal('frequencia_respiratoria', 5, 2)->nullable();  // Frequência respiratória
            $table->timestamps();

            // Definir a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Método para reverter a criação da tabela
        Schema::dropIfExists('dados_saude');
    }
}
