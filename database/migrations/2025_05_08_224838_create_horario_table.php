<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioTable extends Migration
{
    public function up()
    {
        Schema::create('horario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Profissional_id')->constrained('users')->onDelete('cascade');
            $table->date('data');
            $table->time('hora');
            $table->enum('status', ['disponivel', 'indisponivel'])->default('disponivel');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('horario');
    }
}
