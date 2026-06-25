<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_sindaut_footer', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('id');
            $table->text('fale_conosco')->nullable()->after('redes_sociais'); // JSON: [{setor, telefone}]
            $table->string('sede_telefone')->nullable()->after('fale_conosco');
            $table->string('sede_email')->nullable()->after('sede_telefone');
            $table->text('sede_endereco')->nullable()->after('sede_email');
            $table->string('subsede_telefone')->nullable()->after('sede_endereco');
            $table->text('subsede_endereco')->nullable()->after('subsede_telefone');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_sindaut_footer', function (Blueprint $table) {
            $table->dropColumn([
                'logo_path', 'fale_conosco',
                'sede_telefone', 'sede_email', 'sede_endereco',
                'subsede_telefone', 'subsede_endereco',
            ]);
        });
    }
};
