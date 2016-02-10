<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_order');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('outlet_id')->unsigned()->index();
            $table->integer('tax_id')->unsigned()->index();
            $table->integer('payment_id')->unsigned()->index();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('discount_id')->unsigned()->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('outlet_id')
                ->references('id')
                ->on('outlets')
                ->onDelete('cascade');
            
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts')
                ->onDelete('cascade');
            
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
                ->onDelete('cascade');
            
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
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
        Schema::drop('orders');
    }
}
