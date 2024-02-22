<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvencaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sindaut_convencao', function (Blueprint $table) {
            $table->id()->autoIncrement();;
            $table->string("titulo_cct",500);
            $table->string("data_cct",10);
            $table->longText("descricao_cct");
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('tbl_sindaut_galeria_imagems');
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
        Schema::dropIfExists('convencao');
    }
}
