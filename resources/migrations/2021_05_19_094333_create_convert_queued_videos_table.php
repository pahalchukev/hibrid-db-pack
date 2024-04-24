<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConvertQueuedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create('convert_queued_videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('video_id')->index()->nullable();
            $table->uuid('tenant_id');
            $table->boolean('is_converting')->default(false);
            $table->longText('failed_exception')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

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
    public function down()
    {
        $this->dropIfExists('convert_queued_videos');
    }
}
