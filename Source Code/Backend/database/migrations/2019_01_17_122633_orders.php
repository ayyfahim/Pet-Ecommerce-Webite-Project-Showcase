<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('delivery_time_id')->unsigned()->nullable();
            $table->foreign('delivery_time_id')->references('id')->on('statuses');
            $table->integer('payment_method_id')->unsigned()->nullable();
            $table->foreign('payment_method_id')->references('id')->on('statuses');
            $table->uuid('cart_id');
            $table->uuid('address_info_id');
            $table->boolean('is_temp')->default(false);
            $table->json('payment_info')->nullable();
            $table->json('totals_info')->nullable();
            $table->integer('shipping_method_id')->unsigned()->nullable();
            $table->foreign('shipping_method_id')->references('id')->on('statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
