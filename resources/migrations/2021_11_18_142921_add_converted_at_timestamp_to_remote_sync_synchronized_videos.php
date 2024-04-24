<?php
use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddConvertedAtTimestampToRemoteSyncSynchronizedVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->table('remote_sync_synchronized_videos', function (Blueprint $table) {
            $table->timestamp('converted_at')
                ->index()
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->table('remote_sync_synchronized_videos', function (Blueprint $table) {
            $table->removeColumn('converted_at');
        });
    }
}
