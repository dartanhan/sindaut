<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdemToTblSindautConvencao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_sindaut_convencao', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_sindaut_convencao', 'ordem')) {
                $table->integer('ordem')->default(0)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_sindaut_convencao', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_sindaut_convencao', 'ordem')) {
                $table->dropColumn('ordem');
            }
        });
    }
}
