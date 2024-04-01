<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToVendors020422 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('categories')->nullable();
            $table->string('address')->nullable();
            $table->string('cc')->nullable();
            $table->string('aba_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('paypal')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->string('designation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            //
        });
    }
}
