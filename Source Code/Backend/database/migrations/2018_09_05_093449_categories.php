<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->unsignedInteger('_lft');
            $table->unsignedInteger('_rgt');
            $table->uuid('parent_id')->nullable();
            $table->string('slug');
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->integer('sort_order')->nullable();
            $table->uuid('user_id')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categorisables', function (Blueprint $table) {
            $table->uuid('category_id');
            $table->uuid('categorisable_id');
            $table->string('categorisable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('categorisables');
    }
}
