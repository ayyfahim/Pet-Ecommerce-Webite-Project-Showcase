<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToProductInfos120321 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_infos', function (Blueprint $table) {
            $table->string('region')->nullable();
            $table->integer('country_id')->nullable();
            $table->json('cities')->nullable();
            $table->text('address')->nullable();
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
            $table->dropColumn(['region','country_id','cities']);
        });
    }
}
