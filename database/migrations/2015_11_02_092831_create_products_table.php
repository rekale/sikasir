<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->integer('outlet_id')->unsigned()->index()->nullable();
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('price_init')->unsigned()->default(0);
            $table->integer('price')->unsigned()->default(0);
            $table->integer('stock')->unsigned()->default(0);
            $table->boolean('countable')->default(true);
            $table->boolean('track_stock')->default(false);
            $table->boolean('alert')->default(false);
            $table->integer('alert_at')->unsigned()->default(0);
            $table->string('unit')->nullable();
            $table->text('icon')->nullable();
            $table->timestamps();
            
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
            
            $table->foreign('outlet_id')
                  ->references('id')
                  ->on('outlets')
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
        Schema::drop('products');
    }
}
