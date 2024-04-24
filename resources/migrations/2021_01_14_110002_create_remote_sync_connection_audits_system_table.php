<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRemoteSyncConnectionAuditsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('remote_sync_connection_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('state')->default(false);
            $table->json('context')->nullable();
            $table->uuid('connection_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('connection_id', 'remote_sync_con_id')
                ->references('id')
                ->on('remote_sync_connections')
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
        $this->dropIfExists('remote_sync_connection_audits');
    }
}
