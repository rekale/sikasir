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
            $table->integer('company_id')->unsigned()->index();
            $table->unsignedInteger('business_field_id')->index();
            $table->unsignedInteger('tax_id')->index()->nullable();
            $table->string('code');
            $table->text('name');
            $table->text('address')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('pos_code')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->text('icon')->nullable();
            $table->timestamps();

            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');

            $table->foreign('business_field_id')
                ->references('id')
                ->on('business_fields')
                ->onDelete('cascade');

            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
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
