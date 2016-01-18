<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opnames', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('outlet_id')->unsigned()->index();
            $table->string('note');
            $table->boolean('status');
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
        
        Schema::create('opname_stockdetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('opname_id')->unsigned()->index();
            $table->integer('stock_detail_id')->unsigned()->index();
            $table->integer('total');
            
            $table->foreign('opname_id')
                ->references('id')
                ->on('opnames')
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
        Schema::drop('opname_stockdetail');
        Schema::drop('opnames');
    }
}