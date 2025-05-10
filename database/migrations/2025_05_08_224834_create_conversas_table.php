<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversasTable extends Migration
{
    public function up()
    {
        Schema::create('conversas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('usuario2_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('data_criacao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversas');
    }
}
