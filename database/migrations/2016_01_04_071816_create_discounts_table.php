<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->index();
            $table->string('name');
            $table->integer('amount');
            $table->timestamps();
            
            $table->foreign('owner_id')
                  ->references('id')
                  ->on('owners')
                  ->onDelete('cascade');
        });
        
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->index();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            
            $table->foreign('owner_id')
                  ->references('id')
                  ->on('owners')
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
        Schema::drop('discounts');
        Schema::drop('payments');
    }
}
