<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Execute as migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Relacionamento correto
            $table->longText('payload');
            $table->integer('last_activity');
            $table->string('ip_address', 45)->nullable(); // Para armazenar o endereço IP (IPv4/IPv6)
            $table->string('user_agent')->nullable(); // Para armazenar o user agent
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
