<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodyTemperatureLogsTable extends Migration
{
    public function up()
    {
        Schema::create('body_temperature_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('value', 4, 2); // Valor da temperatura
            $table->string('unit')->default('°C'); // Unidade de medida
            $table->timestamp('timestamp'); // Momento da leitura
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('body_temperature_logs');
    }
}
