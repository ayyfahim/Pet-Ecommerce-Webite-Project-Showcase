<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_feeds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('enabled')->default(true);
            $table->string('title');
            $table->integer('frequency');
            $table->timestamp('next_run_at');
            $table->string('file_name')->nullable();
            $table->json('excluded_categories')->nullable();
            $table->json('excluded_products')->nullable();
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
        Schema::dropIfExists('social_feeds');
    }
}
