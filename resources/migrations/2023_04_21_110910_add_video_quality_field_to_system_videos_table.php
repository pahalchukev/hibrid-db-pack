<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddVideoQualityFieldToSystemVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('videos', function (Blueprint $table) {
            $table->integer('video_quality')->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('videos', function (Blueprint $table) {
            $table->dropColumn(['video_quality']);
        });
    }
}
