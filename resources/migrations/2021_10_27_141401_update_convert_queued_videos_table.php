<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateConvertQueuedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->table('convert_queued_videos', function (Blueprint $table) {
            $table->boolean('is_downloading')->default(false);
            $table->timestamp('downloaded_at')->nullable();
            $table->boolean('is_storing')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->table('convert_queued_videos', function (Blueprint $table) {
            $table->dropColumn(['is_downloading', 'downloaded_at', 'is_storing']);
        });
    }
}
