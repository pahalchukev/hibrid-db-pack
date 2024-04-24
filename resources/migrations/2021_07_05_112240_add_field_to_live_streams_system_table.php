<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldToLiveStreamsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('live_streams', function (Blueprint $table) {
            $table->integer('port')->after('mpd_link')->nullable();
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
            $table->dropColumn(['port']);
        });
    }
}
