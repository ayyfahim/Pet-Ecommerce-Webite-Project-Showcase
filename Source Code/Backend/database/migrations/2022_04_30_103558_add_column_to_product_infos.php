<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToProductInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_infos', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });
        Schema::table('product_infos', function (Blueprint $table) {
            $table->double('supplier_regular_price')->nullable();
            $table->double('supplier_sale_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_infos', function (Blueprint $table) {
        });
    }
}
