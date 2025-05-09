<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurtidasTable extends Migration
{
    public function up()
    {
        Schema::create('curtidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('Profissional_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('data_curtida')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curtidas');
    }
}
