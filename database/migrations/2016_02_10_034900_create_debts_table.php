<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('total');
            $table->date('due_date');
            $table->date('paid_at')->nullable();
            $table->timestamps();
            
            $table->foreign('order_id')
            ->references('id')
            ->on('orders')
            ->onDelete('cascade');
            
            $table->unique('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('debts');
    }
}
