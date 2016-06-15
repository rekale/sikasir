<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCalculationTypeToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('products', function (Blueprint $table) {
    		$table->integer('calculation_type');
            $table->boolean('for_all_outlets');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('products', function (Blueprint $table) {
    		$table->dropColumn('calculation_type');
            $table->dropColumn('for_all_outlets');
    	});
    }
}
