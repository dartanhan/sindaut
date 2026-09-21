<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_sindaut_outros')) {
            Schema::create('tbl_sindaut_outros', function (Blueprint $table) {
                $table->id()->autoIncrement();
                $table->string('tipo', 50)->index();
                $table->integer('tipo_id')->nullable()->index();
                $table->string('titulo')->nullable();
                $table->longText('conteudo');
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_sindaut_outros');
    }
}