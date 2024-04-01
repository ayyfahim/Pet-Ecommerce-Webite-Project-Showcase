<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Statuses extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wait_for')->default(12); // in hours
            $table->string('model_name');
            $table->string('group_name');
            $table->integer('order')->default(1);
            $table->string('color')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('title');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
