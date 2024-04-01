<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('address_id');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('business_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('street_address')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
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
        Schema::dropIfExists('address_infos');
    }
}
