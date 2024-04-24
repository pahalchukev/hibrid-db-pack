<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlaylistTagsSystemPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('playlist_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('playlist_id');
            $table->uuid('tag_id');
            $table->timestamps();

            $table->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        $this->dropIfExists('playlist_tag');
    }
}
