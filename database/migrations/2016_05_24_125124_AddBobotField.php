<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBobotField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	\Schema::table('order_variant', function (Blueprint $table) {
    		$table->float('bobot');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	\Schema::table('order_variant', function (Blueprint $table) {
    		$table->dropColumn('bobot');
    	});
    }
}
