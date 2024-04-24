<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLiveStreamsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('live_streams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_name');
            $table->string('password')->nullable();
            $table->string('stream_name');
            $table->string('wms_prefix');
            $table->boolean('recording_status')->default(false);
            $table->boolean('enable_transcoding')->default(false);
            $table->uuid('created_by')->nullable();
            $table->uuid('tenant_id');
            $table->timestamp('last_recorded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
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
        $this->dropIfExists('live_streams');
    }
}
