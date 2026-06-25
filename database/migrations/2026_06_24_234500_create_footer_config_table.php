<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_sindaut_footer', function (Blueprint $table) {
            $table->id();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('cidade_estado')->nullable();
            $table->string('copyright')->nullable();
            $table->text('redes_sociais')->nullable(); // JSON: facebook, instagram, twitter, youtube, whatsapp
            $table->timestamps();
        });

        // Insere registro padrão com os dados atuais
        DB::table('tbl_sindaut_footer')->insert([
            'telefone'     => '(21) 3077-2700 / 2242-1202',
            'email'        => 'sindautrj@gmail.com',
            'endereco'     => 'Rua Andre Cavalcante 128',
            'cep'          => 'CEP: 20231-050',
            'cidade_estado'=> 'Rio de Janeiro - RJ',
            'copyright'    => 'SINDAUT-RIO',
            'redes_sociais'=> json_encode([
                'facebook'  => '',
                'instagram' => '',
                'twitter'   => '',
                'youtube'   => '',
                'whatsapp'  => '',
            ]),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sindaut_footer');
    }
};
