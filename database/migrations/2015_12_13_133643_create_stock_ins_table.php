<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('stock_id')->unsigned()->index();
            $table->integer('variant_id')->unsigned()->index();
            $table->string('note');
            $table->integer('total');
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('stock_ins');
    }
}