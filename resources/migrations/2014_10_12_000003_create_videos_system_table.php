<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('videos', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('file_name');
            $table->string('original_file_name');

            $table->string('path')->nullable();
            $table->string('content_path')->nullable();

            $table->integer('size')->default(0);
            $table->integer('duration')->default(0);

            $table->string('mime')->nullable();
            $table->string('extension');
            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();

            $table->integer('likes_count')->default(0);
            $table->integer('dislikes_count')->default(0);
            $table->integer('played_count')->default(0);

            $table->string('smil_file')->nullable();
            $table->string('embed_url')->nullable();

            $table->json('meta_info')->nullable();
            $table->string('reference_id')->index();

            $table->boolean('is_ready')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('svod_status')->default(false);

            $table->uuid('created_by')->nullable();
            $table->uuid('tenant_id');

            $table->timestamp('converted_at')->nullable();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')
                ->on('users')
                ->references('id')
                ->onDelete('set null');

            $table->foreign('tenant_id')
                ->on('tenants')
                ->references('id')
                ->onDelete('cascade');

            $table->index(['converted_at', 'synced_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->dropIfExists('videos');
    }
}
