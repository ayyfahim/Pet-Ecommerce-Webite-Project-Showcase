<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id')->nullable();
            $table->uuid('category_id')->nullable();
            $table->uuid('attribute_id');
            $table->json('value')->nullable();
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
        Schema::dropIfExists('related_attributes');
    }
}
