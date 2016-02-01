<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('outlet_id')->index();
            $table->string('name');
            $table->string('code');
            $table->text('address');
            $table->string('info');
            $table->string('footer_note');
            $table->integer('size');
            $table->text('logo');
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
        Schema::drop('printers');
    }
}
