<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->string('name');
            $table->string('code');
            $table->integer('price')->unsigned();
            $table->boolean('track_stock')->default(false);
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('alert')->default(false);
            $table->integer('alert_at')->unsigned();
            $table->timestamps();
            
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
        Schema::drop('variants');
    }
}
