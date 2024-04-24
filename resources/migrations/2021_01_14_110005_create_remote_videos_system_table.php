<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRemoteVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('remote_videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('video_url')->index();
            $table->string('webhook_url')->nullable();
            $table->json('tags_ids')->nullable();
            $table->boolean('should_activate')->nullable();

            $table->uuid('tenant_id');
            $table->uuid('video_id')->nullable();
            $table->uuid('api_client_id')->nullable();
            $table->string('reference_id')->index();
            $table->timestamps();
            $table->timestamp('processed_at')
                ->index()
                ->nullable();

            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

            $table->foreign('api_client_id')
                ->on('tenant_api_clients')
                ->references('id')
                ->onDelete('set null');

            $table->foreign('tenant_id')
                ->on('tenants')
                ->references('id')
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
        $this->dropIfExists('remote_videos');
    }
}
