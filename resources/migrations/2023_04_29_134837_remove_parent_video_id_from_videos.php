<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveParentVideoIdFromVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('videos', 'parent_video_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->dropColumn('parent_video_id');
            });
        }

        if (Schema::hasColumn('videos', 'trailer_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->dropColumn('trailer_id');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('parent_video_id')->nullable();
            $table->string('trailer_id')->nullable();
        });
    }
}
