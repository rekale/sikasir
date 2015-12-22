<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockOutsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('note');
            $table->date('input_at');
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
        });
        
        Schema::create('out_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('out_id')->unsigned()->index();
            $table->integer('stock_id')->unsigned()->index();
            $table->integer('total');
            
            $table->foreign('out_id')
                ->references('id')
                ->on('outs')
                ->onDelete('cascade');
            
            $table->foreign('stock_id')
                ->references('id')
                ->on('stocks')
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
        Schema::drop('out_stock');
        Schema::drop('outs');
    }
}
