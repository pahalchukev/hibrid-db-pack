<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateLiveStreamsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('live_streams', function (Blueprint $table) {
            $table->boolean('enabled_status')->after('last_recorded_at')->default(false);
            $table->string('hls_link')->after('last_recorded_at')->nullable();
            $table->string('mpd_link')->after('last_recorded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('live_streams', function (Blueprint $table) {
            $table->dropColumn(['enabled_status', 'hls_link', 'mpd_link']);
        });
    }
}
