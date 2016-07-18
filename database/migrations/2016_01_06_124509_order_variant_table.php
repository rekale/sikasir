 <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_variant', function (Blueprint $table) {
            $table->integer('order_id')->unsigned()->index();
            $table->integer('variant_id')->unsigned()->index();
            $table->float('weight');
            $table->unsignedInteger('price');
            $table->unsignedInteger('total')->default(0);
            $table->unsignedInteger('nego')->default(0);
            $table->unsignedInteger('discount_by_product')->default(0);
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
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
        Schema::drop('order_variant');
    }
}
