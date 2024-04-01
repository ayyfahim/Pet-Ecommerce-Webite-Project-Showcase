<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendHomepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontend_homepages', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('banner_section_header')->nullable();
            $table->text('banner_section_header_formatted_text')->nullable();
            $table->text('banner_section_description')->nullable();
            $table->text('banner_button_1_text')->nullable();
            $table->text('banner_button_1_link')->nullable();
            $table->text('banner_button_2_text')->nullable();
            $table->text('banner_button_2_link')->nullable();
            $table->text('sub_banner_1_text')->nullable();
            $table->text('sub_banner_2_text')->nullable();
            $table->text('sub_banner_3_text')->nullable();
            $table->text('sub_banner_4_text')->nullable();
            $table->text('concern_section_header')->nullable();
            $table->text('concern_section_description')->nullable();
            $table->text('top_selling_section_header')->nullable();
            $table->text('top_selling_section_description')->nullable();
            $table->text('quality_ingredients_section_header')->nullable();
            $table->text('quality_ingredients_section_description')->nullable();
            $table->text('ingr_1_header')->nullable();
            $table->text('ingr_1_description')->nullable();
            $table->text('ingr_2_header')->nullable();
            $table->text('ingr_2_description')->nullable();
            $table->text('ingr_3_header')->nullable();
            $table->text('ingr_3_description')->nullable();
            $table->text('ingr_4_header')->nullable();
            $table->text('ingr_4_description')->nullable();
            $table->text('ingr_5_header')->nullable();
            $table->text('ingr_5_description')->nullable();
            $table->text('ingr_6_header')->nullable();
            $table->text('ingr_6_description')->nullable();
            $table->text('why_us_section_header')->nullable();
            $table->text('why_us_section_description')->nullable();
            $table->text('why_us_1_header')->nullable();
            $table->text('why_us_1_text')->nullable();
            $table->text('why_us_2_header')->nullable();
            $table->text('why_us_2_text')->nullable();
            $table->text('why_us_3_header')->nullable();
            $table->text('why_us_3_text')->nullable();
            $table->text('why_us_4_header')->nullable();
            $table->text('why_us_4_text')->nullable();
            $table->text('why_us_5_header')->nullable();
            $table->text('why_us_5_text')->nullable();
            $table->text('why_us_6_header')->nullable();
            $table->text('why_us_6_text')->nullable();
            $table->text('review_section_header')->nullable();
            $table->text('review_section_description')->nullable();
            $table->integer('review_1_star')->nullable();
            $table->text('review_1_header')->nullable();
            $table->text('review_1_description')->nullable();
            $table->text('review_1_author_name')->nullable();
            $table->integer('review_2_star')->nullable();
            $table->text('review_2_header')->nullable();
            $table->text('review_2_description')->nullable();
            $table->text('review_2_author_name')->nullable();
            $table->integer('review_3_star')->nullable();
            $table->text('review_3_header')->nullable();
            $table->text('review_3_description')->nullable();
            $table->text('review_3_author_name')->nullable();
            $table->text('how_it_works_section_header')->nullable();
            $table->text('how_it_works_section_description')->nullable();
            $table->text('how_it_works_1_header')->nullable();
            $table->text('how_it_works_1_description')->nullable();
            $table->text('how_it_works_2_header')->nullable();
            $table->text('how_it_works_2_description')->nullable();
            $table->text('how_it_works_3_header')->nullable();
            $table->text('how_it_works_3_description')->nullable();
            $table->text('blogs_section_header')->nullable();
            $table->text('blogs_section_desctiption')->nullable();
            $table->text('instagram_section_text')->nullable();
            $table->text('instagram_section_username')->nullable();
            $table->text('instagram_section_profile_link')->nullable();

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
        Schema::dropIfExists('frontend_homepages');
    }
}
