<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable050422 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('deals');
        Schema::create('deals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('variation_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('discount_type');
            $table->double('discount_amount');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('deal_from');
            $table->timestamp('deal_to');
            $table->boolean('deal_show_counter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
