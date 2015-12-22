<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('outlet_id')->unsigned()->index();
            $table->integer('variant_id')->unsigned()->index();
            $table->integer('total')->default(0);
            $table->timestamps();
            
            $table->foreign('outlet_id')
                ->references('id')
                ->on('variants')
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
        Schema::drop('stocks');
    }
}
