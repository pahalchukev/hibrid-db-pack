<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CleanAndUpdateLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('live_streams', 'created_by')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                if (DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign('live_streams_created_by_foreign');
                }
                $table->dropColumn('created_by');
            });
        }

        if(Schema::hasColumn('live_streams', 'last_recorded_at')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('last_recorded_at');
            });
        }

        Schema::table('live_streams', function (Blueprint $table)
        {
            $table->boolean('is_catchup')->nullable();
            $table->integer('max_editing_duration')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->dropColumn(['is_catchup', 'max_editing_duration']);
        });
    }
}
