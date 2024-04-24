<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartSecondAndFinishTimeToScheduleVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('schedule_videos', function (Blueprint $table) {
            $table->time('finish_time')->nullable()->after('start_time');
            $table->integer('start_second')->nullable()->after('finish_time');
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
            $table->dropColumn(['finish_time', 'start_second']);
        });
    }
}
