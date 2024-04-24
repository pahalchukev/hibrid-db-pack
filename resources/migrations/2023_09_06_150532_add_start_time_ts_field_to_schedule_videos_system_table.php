<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartTimeTSFieldToScheduleVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('schedule_videos', function (Blueprint $table) {
            $table->timestamp('start_time_ts')->nullable()->after('start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('schedule_videos', function (Blueprint $table) {
            $table->dropColumn(['start_time_ts']);
        });
    }
}
