<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('Id_pesanan')->unique();
            $table->integer('Id_meja');
            $table->integer('TotalItem');
            $table->integer('TatalHarga');
            $table->integer('Diskon');
            $table->integer('TotalBayar');
            $table->integer('Diterima');
            $table->integer('Kembali');
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
        Schema::dropIfExists('pesanan');
    }
}
