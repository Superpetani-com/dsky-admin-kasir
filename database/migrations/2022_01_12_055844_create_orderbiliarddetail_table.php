<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderbiliarddetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderbiliarddetail', function (Blueprint $table) {
            $table->id('id_order_biliard_detail')->unique();
            $table->integer('id_order_biliard');
            $table->integer('id_paket_biliard');
            $table->integer('harga');
            $table->decimal('jumlah', 10,2);
            $table->decimal('subtotal', 10,2);
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
        Schema::dropIfExists('orderbiliarddetail');
    }
}
