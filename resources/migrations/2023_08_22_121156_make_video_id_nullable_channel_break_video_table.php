<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class MakeVideoIdNullableChannelBreakVideoTable extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'sqlite') {
            $this->table('channel_break_video', function (Blueprint $table) {
                $table->uuid('video_id')->nullable()->change();
            });
        }
    }
}
