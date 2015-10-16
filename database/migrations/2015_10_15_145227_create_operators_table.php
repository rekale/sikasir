<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned()->index();
            $table->integer('outlet_id')->unsigned()->index();
            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->boolean('void_access', 0);
            $table->text('icon');
            $table->timestamps();
            
            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')
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
        Schema::drop('operators');
    }
}
