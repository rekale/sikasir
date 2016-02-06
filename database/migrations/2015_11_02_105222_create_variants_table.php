<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantsTable extends Migration
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
            $table->string('name')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('price_init')->unsigned()->default(0);
            $table->integer('price')->unsigned()->default(0);
            $table->integer('stock')->unsigned()->default(0);
            $table->boolean('countable')->default(true);
            $table->boolean('track_stock')->default(false);
            $table->boolean('alert')->default(false);
            $table->integer('alert_at')->unsigned()->default(0);
            $table->text('icon')->nullable();
            
            $table->timestamps();
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
