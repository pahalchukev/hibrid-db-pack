<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlaylistCategoriesSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('playlist_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('playlist_id');
            $table->uuid('category_id');
            $table->timestamps();

            $table->foreign('playlist_id')
                ->references('id')
                ->on('playlists')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
