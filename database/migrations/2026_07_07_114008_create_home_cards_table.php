<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sindaut_home_cards', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('titulo');
            $table->mediumText('conteudo')->nullable();
            $table->integer('imagem_id')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('ordem')->default(0);
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
        Schema::dropIfExists('tbl_sindaut_home_cards');
    }
}
