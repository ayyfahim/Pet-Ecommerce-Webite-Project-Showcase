<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('name');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->boolean('product')->default(true);
            $table->boolean('category')->default(true);
            $table->boolean('configured')->default(true);
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
        Schema::dropIfExists('attributes');
    }
}
