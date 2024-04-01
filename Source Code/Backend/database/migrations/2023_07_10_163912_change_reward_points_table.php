<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRewardPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `reward_points` MODIFY points float(8)');
        DB::statement('ALTER TABLE `reward_points` MODIFY exchange float(8)');
        // Schema::table('reward_points', function (Blueprint $table) {
        //     $table->float('points')->change();
        //     $table->string('exchange')->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
