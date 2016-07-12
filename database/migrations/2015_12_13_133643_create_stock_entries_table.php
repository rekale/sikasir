<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('outlet_id')->unsigned()->index();
            $table->string('note');
            $table->date('input_at');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('outlet_id')
                ->references('id')
                ->on('outlets')
                ->onDelete('cascade');
        });

        Schema::create('entry_variant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id')->unsigned()->index();
            $table->integer('variant_id')->unsigned()->index();
            $table->integer('total');

            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
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
        Schema::drop('entry_variant');
        Schema::drop('entries');
    }
}
