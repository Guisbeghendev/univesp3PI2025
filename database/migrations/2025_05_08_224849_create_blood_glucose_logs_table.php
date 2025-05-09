<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodGlucoseLogsTable extends Migration
{
    public function up()
    {
        Schema::create('blood_glucose_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('value', 5, 2); // Valor da glicemia
            $table->string('unit')->default('mg/dL'); // Unidade de medida
            $table->timestamp('timestamp'); // Momento da leitura
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_glucose_logs');
    }
}
