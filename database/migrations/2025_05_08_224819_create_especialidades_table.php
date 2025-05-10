<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEspecialidadesTable extends Migration
{
    public function up()
    {
        // Criando a tabela 'especialidades'
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');  // Nome da especialização
            $table->text('descricao')->nullable();  // Descrição da especialização
            $table->timestamps();
        });

        // Inserindo os dados na tabela 'especialidades'
        DB::table('especialidades')->insert([
            ['nome' => 'Nutrição Esportiva', 'descricao' => 'Especialização focada em nutrição para atletas e praticantes de atividades físicas.'],
            ['nome' => 'Personal Trainer', 'descricao' => 'Especialização em treinamento personalizado para indivíduos ou grupos.'],
            ['nome' => 'Musculação', 'descricao' => 'Focada no treinamento de força e aumento de massa muscular.'],
            ['nome' => 'Fisioterapia Esportiva', 'descricao' => 'Tratamento e prevenção de lesões relacionadas à prática de esportes.'],
            ['nome' => 'Treinamento Funcional', 'descricao' => 'Especialização em treinos que visam a funcionalidade do corpo no dia a dia.'],
            ['nome' => 'Ginástica Artística', 'descricao' => 'Treinamento especializado em movimentos acrobáticos e ginásticos.'],
            ['nome' => 'Yoga', 'descricao' => 'Focada em técnicas de respiração, alongamento e meditação.'],
            ['nome' => 'Pilates', 'descricao' => 'Exercícios para o fortalecimento da musculatura e equilíbrio corporal.'],
            ['nome' => 'Treinamento de Flexibilidade', 'descricao' => 'Especialização focada no aumento da flexibilidade muscular.'],
            ['nome' => 'Treinamento de Alta Performance', 'descricao' => 'Treinamento especializado para otimização de desempenho em atletas.'],
        ]);
    }

    public function down()
    {
        // Deletando a tabela 'especialidades' caso o migration seja revertido
        Schema::dropIfExists('especialidades');
    }
}
