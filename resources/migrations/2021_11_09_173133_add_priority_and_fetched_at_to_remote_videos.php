<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPriorityAndFetchedAtToRemoteVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->table('remote_videos', function (Blueprint $table) {
            $table->integer('priority')->default(2);
            $table->index('priority');
            $table->timestamp('fetched_at')
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
        $this->table('remote_videos', function (Blueprint $table) {
            $table->dropColumn(['priority', 'fetched_at']);
        });
    }
}
