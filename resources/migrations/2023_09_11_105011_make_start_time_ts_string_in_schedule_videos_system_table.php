<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeStartTimeTsStringInScheduleVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('schedule_videos', function (Blueprint $table) {
            $table->string('start_time_ts')->nullable()->change();
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
            $table->time('start_time_ts')->nullable()->change();
        });
    }
}