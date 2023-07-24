<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBiliardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_biliard', function (Blueprint $table) {
            $table->id('id_order_biliard')->unique();
            $table->integer('id_meja_biliard');
            $table->decimal('totaljam');
            $table->integer('diskon');
            $table->decimal('totalharga');
            $table->decimal('totalbayar', 10,2);
            $table->integer('diterima');
            $table->decimal('kembali', 10,2);
            $table->string('status', 15);
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
        Schema::dropIfExists('order_biliard');
    }
}
