<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeartRateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('heart_rate_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('value'); // Valor da frequência cardíaca (bpm)
            $table->string('unit')->default('bpm'); // Unidade de medida
            $table->timestamp('timestamp'); // Momento da leitura
            $table->timestamps(); // created_at e updated_at

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('heart_rate_logs');
    }
}
