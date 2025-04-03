<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sindaut_noticias', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('titulo');
            $table->string('subtitulo');
            $table->text('conteudo');
            $table->integer('imagem_id');
            $table->boolean('status');
            $table->timestamp('data');
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
        Schema::dropIfExists('tbl_sindaut_noticias');
    }
}
