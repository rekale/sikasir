<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id')->unsigned()->index();
            $table->integer('variant_id')->unsigned()->index();
            $table->integer('total');
            $table->timestamps();
            
            $table->foreign('stock_id')
                ->references('id')
                ->on('stocks')
                ->onDelete('cascade');
            
            $table->foreign('variant_id')
                ->references('id')
                ->on('variants')
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
        Schema::drop('stock_details');
    }
}
