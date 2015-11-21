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
        Schema::create('business_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

        });

        Schema::create('outlets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned()->index();
            $table->unsignedInteger('business_field_id')->index();
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

          $table->foreign('business_field_id')
                ->references('id')
                ->on('business_fields')
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
        Schema::drop('business_fields');
    }
}
