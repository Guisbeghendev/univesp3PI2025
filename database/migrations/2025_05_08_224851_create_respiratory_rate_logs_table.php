<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespiratoryRateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('respiratory_rate_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('value', 5, 2); // Valor da frequência respiratória
            $table->string('unit')->default('rpm'); // Unidade de medida (respirações por minuto)
            $table->timestamp('timestamp'); // Momento da leitura
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('respiratory_rate_logs');
    }
}
