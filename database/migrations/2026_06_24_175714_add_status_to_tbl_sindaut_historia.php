<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTblSindautHistoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_sindaut_historia', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_sindaut_historia', 'status')) {
                $table->boolean('status')->default(true);
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
        Schema::table('tbl_sindaut_historia', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_sindaut_historia', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
