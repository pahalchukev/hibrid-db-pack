<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRemoteSyncSynchronizedVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('remote_sync_synchronized_videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('path');
            $table->string('file_name');
            $table->string('full_path');
            $table->bigInteger('size');
            $table->string('extension');
            $table->string('reference_id');

            $table->uuid('tenant_id');
            $table->uuid('connection_id')->nullable();
            $table->uuid('video_id')->nullable();

            $table->timestamp('last_modified')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')
                ->on('tenants')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('connection_id', 'remote_sync_sync_video_con_id')
                ->references('id')
                ->on('remote_sync_connections')
                ->onDelete('cascade');

            $table->foreign('video_id', 'remote_sync_sync_vid_id')
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
        $this->dropIfExists('remote_sync_synchronized_videos');
    }
}
