<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMejabiliardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mejabiliard', function (Blueprint $table) {
            $table->id('id_meja_biliard')->unique();
            $table->string('namameja', 30);
            $table->string('jammulai', 30);
            $table->string('durasi', 30);
            $table->string('sisadurasi', 30);
            $table->string('jamselesai', 30);
            $table->integer('id_order_biliard');
            $table->string('status', 30);
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
        Schema::dropIfExists('mejabiliard');
    }
}
