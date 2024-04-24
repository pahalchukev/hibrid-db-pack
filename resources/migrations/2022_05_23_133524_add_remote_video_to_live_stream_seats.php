<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemoteVideoToLiveStreamSeats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_stream_seats', function (Blueprint $table) {
            $table->uuid('remote_video_id')->nullable();
            $table->foreign('remote_video_id')
                ->references('id')
                ->on('remote_videos')
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_stream_seats', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('live_stream_seats_remote_video_id_foreign');
            }
            $table->dropColumn('remote_video_id');
        });
    }
}
