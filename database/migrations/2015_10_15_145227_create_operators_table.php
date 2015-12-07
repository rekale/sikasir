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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->integer('owner_id')->unsigned()->index()->nullable();
            $table->string('name');
            $table->string('gender');
            $table->string('title');
            $table->string('phone');
            $table->text('address');
            $table->boolean('void_access', 0);
            $table->text('icon')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')
                  ->references('id')
                  ->on('owners')
                  ->onDelete('cascade');
            
             $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
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
        Schema::drop('employees');
    }
}
