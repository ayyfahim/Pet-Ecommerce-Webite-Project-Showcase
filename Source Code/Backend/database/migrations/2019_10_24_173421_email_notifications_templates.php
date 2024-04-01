<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailNotificationsTemplates extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('email_notification_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_id')->unsigned();
            $table->foreign('notification_id')->references('id')->on('notifications');
            $table->string('subject');
            $table->text('body');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('email_notification_templates');
    }
}
