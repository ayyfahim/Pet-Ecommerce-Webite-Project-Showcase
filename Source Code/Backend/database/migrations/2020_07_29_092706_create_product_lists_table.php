<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->uuid('user_id')->nullable();
            $table->uuid('product_id');
            $table->string('session_id')->nullable();
            $table->boolean('out_of_stock_notified')->default(false);
            $table->uuid('product_info_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_lists');
    }
}
