<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('prestador_id')->nullable();
            $table->foreign('prestador_id')->references('id')->on('prestador');
            $table->enum('tipo',['E','S']);
            $table->date('dia');
            $table->dateTime('data_hora');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('accuracy');
            $table->string('endereco_completo')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('cep')->nullable();
            $table->string('tempo_trabalho')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ponto');
    }
};
