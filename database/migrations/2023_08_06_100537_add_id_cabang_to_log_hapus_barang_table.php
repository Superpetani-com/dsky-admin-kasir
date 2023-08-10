<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCabangToLogHapusBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_hapus_barang', function (Blueprint $table) {
            $table->text('cabang_id', 100);
            $table->text('user_id', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_hapus_barang', function (Blueprint $table) {
            $table->dropColumn('cabang_id', 100);
            $table->dropColumn('user_id', 100);
        });
    }
}
