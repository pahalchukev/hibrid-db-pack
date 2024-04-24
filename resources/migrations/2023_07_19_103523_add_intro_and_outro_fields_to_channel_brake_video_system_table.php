<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntroAndOutroFieldsToChannelBrakeVideoSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_break_video', function (Blueprint $table) {
            $table->uuid('intro_id')->nullable()->after('video_id');
            $table->uuid('outro_id')->nullable()->after('video_id');

            $table->foreign('intro_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

            $table->foreign('outro_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel_break_video', function (Blueprint $table) {
            $table->dropColumn(['intro_id', 'outro_id']);
        });
    }
}
