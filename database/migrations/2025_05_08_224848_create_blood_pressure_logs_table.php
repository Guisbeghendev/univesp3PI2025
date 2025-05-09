<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodPressureLogsTable extends Migration
{
    public function up()
    {
        Schema::create('blood_pressure_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('systolic', 5, 2); // Pressão sistólica
            $table->decimal('diastolic', 5, 2); // Pressão diastólica
            $table->string('unit')->default('mmHg'); // Unidade de medida
            $table->timestamp('timestamp'); // Momento da leitura
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_pressure_logs');
    }
}
