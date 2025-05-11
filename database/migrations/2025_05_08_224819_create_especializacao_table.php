<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEspecializacaoTable extends Migration
{
    public function up()
    {
        // Criando a tabela 'especializacao'
        Schema::create('especializacao', function (Blueprint $table) {
            $table->id();
            $table->string('nome');  // Nome da especializacao
            $table->text('descricao')->nullable();  // Descricao da especializacao
            $table->timestamps();
        });

        // Inserindo os dados na tabela 'especializacao'
        DB::table('especializacao')->insert([
            ['nome' => 'Nutrição Esportiva', 'descricao' => 'Especializacao focada em nutricao para atletas e praticantes de atividades fisicas.'],
            ['nome' => 'Personal Trainer', 'descricao' => 'Especializacao em treinamento personalizado para individuos ou grupos.'],
            ['nome' => 'Musculacao', 'descricao' => 'Focada no treinamento de forca e aumento de massa muscular.'],
            ['nome' => 'Fisioterapia Esportiva', 'descricao' => 'Tratamento e prevencao de lesoes relacionadas a pratica de esportes.'],
            ['nome' => 'Treinamento Funcional', 'descricao' => 'Especializacao em treinos que visam a funcionalidade do corpo no dia a dia.'],
            ['nome' => 'Ginastica Artistica', 'descricao' => 'Treinamento especializado em movimentos acrobaticos e ginasticos.'],
            ['nome' => 'Yoga', 'descricao' => 'Focada em tecnicas de respiracao, alongamento e meditacao.'],
            ['nome' => 'Pilates', 'descricao' => 'Exercicios para o fortalecimento da musculatura e equilibrio corporal.'],
            ['nome' => 'Treinamento de Flexibilidade', 'descricao' => 'Especializacao focada no aumento da flexibilidade muscular.'],
            ['nome' => 'Treinamento de Alta Performance', 'descricao' => 'Treinamento especializado para otimizacao de desempenho em atletas.'],
        ]);
    }

    public function down()
    {
        // Deletando a tabela 'especializacao' caso o migration seja revertido
        Schema::dropIfExists('especializacao');
    }
}
