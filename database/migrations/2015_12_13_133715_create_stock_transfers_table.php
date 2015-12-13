<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_outlet_id')->unsigned()->index();
            $table->integer('destination_outlet_id')->unsigned()->index();
            $table->integer('stock_id')->unsigned()->index();
            $table->integer('variant_id')->unsigned()->index();
            $table->integer('total');
            $table->timestamps();
            
            $table->foreign('source_outlet_id')
               ->references('id')
               ->on('outlets')
               ->onDelete('cascade');
            
            $table->foreign('destination_outlet_id')
               ->references('id')
               ->on('outlets')
               ->onDelete('cascade');
             
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
        Schema::drop('stock_transfers');
    }
}
