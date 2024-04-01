<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Carts extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_ordered')->default(false);
            $table->uuid('user_id')->nullable();
            $table->uuid('discount_rule_id')->nullable();
            $table->boolean('use_points')->default(false);
            $table->string('session_id')->nullable();
            $table->uuid('coupon_id')->nullable();
            $table->json('coupon_info')->nullable();
            $table->json('shipping_info')->nullable();
            $table->uuid('payment_method_id')->nullable();
            $table->uuid('shipping_method_id')->nullable();
            $table->timestamp('reminder_notified_date')->nullable();
            $table->timestamps();
        });

        Schema::create('cart_product', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cart_id');
            $table->uuid('product_id');
            $table->uuid('product_info_id');
            $table->integer('quantity')->default(1);
            $table->uuid('variation_id')->nullable();
            $table->double('variation_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cart_product');
    }
}
