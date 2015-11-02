<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('outlet_id')->unsigned()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('sex');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('pos_code');
            $table->timestamps();
            
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
        Schema::drop('customers');
    }
}
