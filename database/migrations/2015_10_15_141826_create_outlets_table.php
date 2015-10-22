<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlets', function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('owner_id', 32)->index();
            $table->text('name');
            $table->text('address');
            $table->string('province');
            $table->string('city');
            $table->string('pos_code');
            $table->string('phone1');
            $table->string('phone2');
            $table->text('icon');
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
        Schema::drop('outlets');
    }
}
