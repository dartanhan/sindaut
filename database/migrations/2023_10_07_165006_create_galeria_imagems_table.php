<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaleriaImagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sindaut_galeria_imagens', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('path',255);
            //$table->unsignedBigInteger('file_id');           
            //$table->foreign('file_id')->references('id')->on('tbl_sindaut_convencao');
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
        Schema::dropIfExists('galeria_imagems');
    }
}
