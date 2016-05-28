<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWieghtFieldToAllInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('opname_variant', function (Blueprint $table) {
    		$table->float('weight');
    	});
        \Schema::table('entry_variant', function (Blueprint $table) {
    		$table->float('weight');
    	});
        \Schema::table('out_variant', function (Blueprint $table) {
    		$table->float('weight');
    	});
        \Schema::table('purchase_order_variant', function (Blueprint $table) {
    		$table->float('weight');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('opname_variant', function (Blueprint $table) {
    		$table->dropColumn('weight');
    	});
        \Schema::table('entry_variant', function (Blueprint $table) {
    		$table->dropColumn('weight');
    	});
        \Schema::table('out_variant', function (Blueprint $table) {
    		$table->dropColumn('weight');
    	});
        \Schema::table('purchase_order_variant', function (Blueprint $table) {
    		$table->dropColumn('weight');
    	});
    }
}
