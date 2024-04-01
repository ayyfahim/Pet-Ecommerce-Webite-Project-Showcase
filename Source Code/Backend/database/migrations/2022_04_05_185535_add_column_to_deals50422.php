<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDeals50422 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->boolean('is_active')->default(false);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('deal_from');
            $table->dropColumn('deal_to');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('deal_from')->nullable();
            $table->timestamp('deal_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            //
        });
    }
}
