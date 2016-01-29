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
            $table->integer('outlet_id')->unsigned()->index();
            $table->string('note');
            $table->date('input_at');
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('outlet_id')
                ->references('id')
                ->on('outlets')
                ->onDelete('cascade');
            
        });
        
        Schema::create('out_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('out_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->integer('total');
            
            $table->foreign('out_id')
                ->references('id')
                ->on('outs')
                ->onDelete('cascade');
            
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::drop('out_product');
        Schema::drop('outs');
    }
}
