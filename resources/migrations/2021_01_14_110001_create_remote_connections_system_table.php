<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRemoteConnectionsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('remote_sync_connections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('alias');
            $table->string('adapter');
            $table->json('adapter_config')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->integer('fetched_videos')->default(0);
            $table->integer('fetched_size')->default(0);
            $table->uuid('created_by')->nullable();
            $table->uuid('tenant_id');
            $table->timestamp('last_connected_at')->nullable();
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
        $this->dropIfExists('remote_sync_connections');
    }
}
