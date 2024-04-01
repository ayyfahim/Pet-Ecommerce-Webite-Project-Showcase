<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontend_about_us', function (Blueprint $table) {
            $table->id();

            $table->text('banner_section_title')->nullable();
            $table->text('banner_section_description')->nullable();
            $table->text('our_mission_title')->nullable();
            $table->text('our_mission_description')->nullable();
            $table->text('customised_options_section_title')->nullable();
            $table->text('customised_options_section_description')->nullable();
            $table->text('why_section_title')->nullable();
            $table->text('why_section_description')->nullable();
            $table->text('options_title')->nullable();
            $table->text('options_description')->nullable();

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
        Schema::dropIfExists('frontend_about_us');
    }
}
