<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_icons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('icon_id');
            $table->uuid('product_id');
            $table->string('label')->nullable();
            $table->string('helper')->nullable();
            $table->boolean('listing')->default(false);
            $table->boolean('enabled')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_icons');
    }
}
