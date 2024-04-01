<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->double('regular_price')->nullable();
            $table->double('sale_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
        Schema::create('variation_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('variation_id');
            $table->uuid('option_id');
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
        Schema::dropIfExists('variations');
    }
}
