<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlaylistVideosSystemPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('playlist_video', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('playlist_id');
            $table->uuid('video_id');
            $table->timestamps();

            $table->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->onDelete('cascade');

            $table->foreign('video_id')
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
    public function down(): void
    {
        $this->dropIfExists('playlist_video');
    }
}
