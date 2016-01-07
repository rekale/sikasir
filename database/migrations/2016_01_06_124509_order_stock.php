<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_stockdetail', function (Blueprint $table) {
            $table->integer('order_id')->unsigned()->index();
            $table->integer('stock_detail_id')->unsigned()->index();
            $table->integer('total')->default(1);
            
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            
            $table->foreign('stock_detail_id')
                ->references('id')
                ->on('stock_details')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_stockdetail');
    }
}
