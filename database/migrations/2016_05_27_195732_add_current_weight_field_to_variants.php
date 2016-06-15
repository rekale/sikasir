<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrentWeightFieldToVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('variants', function (Blueprint $table) {
    		$table->float('current_weight');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('variants', function (Blueprint $table) {
    		$table->dropColumn('current_weight');
    	});
    }
}
