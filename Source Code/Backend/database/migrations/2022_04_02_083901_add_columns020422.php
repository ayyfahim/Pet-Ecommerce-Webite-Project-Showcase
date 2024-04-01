<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumns020422 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('banner_title')->nullable();
            $table->string('banner_description')->nullable();
            $table->string('keywords')->nullable();
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->string('keywords')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('supplier_code')->nullable();
            $table->string('google_category')->nullable();
            $table->string('additional_categories')->nullable();
            $table->string('affiliate_link')->nullable();
            $table->boolean('show_brand')->nullable();
            $table->text('notes')->nullable();
            $table->string('keywords')->nullable();
            $table->double('shipping_cost')->nullable();
            $table->integer('shipping_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('banner_title');
            $table->dropColumn('banner_description');
            $table->dropColumn('keywords');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });
    }
}
