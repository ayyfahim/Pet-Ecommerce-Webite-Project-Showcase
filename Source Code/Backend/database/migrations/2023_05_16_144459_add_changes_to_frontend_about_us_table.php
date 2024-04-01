<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangesToFrontendAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frontend_about_us', function (Blueprint $table) {
            $table->text('our_story_title')->nullable();
            $table->text('our_story_description')->nullable();
            $table->text('about_company_title')->nullable();
            $table->text('about_company_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frontend_about_us', function (Blueprint $table) {
            //
        });
    }
}
