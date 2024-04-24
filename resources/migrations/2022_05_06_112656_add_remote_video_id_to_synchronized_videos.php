<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemoteVideoIdToSynchronizedVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remote_sync_synchronized_videos', function (Blueprint $table) {
            $table->uuid('remote_video_id')->nullable();

            $table->foreign('remote_video_id')
                ->references('id')
                ->on('remote_videos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remote_sync_synchronized_videos', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('remote_sync_synchronized_videos_remote_video_id_foreign');
            }
            $table->dropColumn('remote_video_id');
        });
    }
}
