<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendRewardProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontend_reward_programs', function (Blueprint $table) {
            $table->id();

            $table->text('reward_program_banner_title')->nullable();
            $table->text('reward_program_banner_description')->nullable();
            $table->text('how_it_works_section_title')->nullable();
            $table->text('how_it_works_section_description')->nullable();
            $table->text('how_it_works_1_title')->nullable();
            $table->text('how_it_works_1_description')->nullable();
            $table->text('how_it_works_2_title')->nullable();
            $table->text('how_it_works_2_description')->nullable();
            $table->text('how_it_works_3_title')->nullable();
            $table->text('how_it_works_3_description')->nullable();
            $table->text('how_to_collect_title')->nullable();
            $table->text('how_to_collect_description')->nullable();
            $table->text('how_to_collect_1_title')->nullable();
            $table->text('how_to_collect_1_point')->nullable();
            $table->text('how_to_collect_2_title')->nullable();
            $table->text('how_to_collect_2_point')->nullable();
            $table->text('how_to_collect_3_title')->nullable();
            $table->text('how_to_collect_3_point')->nullable();
            $table->text('how_to_collect_4_title')->nullable();
            $table->text('how_to_collect_4_point')->nullable();
            $table->text('how_to_collect_5_title')->nullable();
            $table->text('how_to_collect_5_point')->nullable();
            $table->text('how_to_collect_6_title')->nullable();
            $table->text('how_to_collect_6_point')->nullable();

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
        Schema::dropIfExists('frontend_reward_programs');
    }
}
