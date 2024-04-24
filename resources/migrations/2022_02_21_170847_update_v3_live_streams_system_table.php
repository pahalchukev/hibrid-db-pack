<?php

use HibridVod\Database\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdateV3LiveStreamsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (Schema::hasColumn('live_streams', 'user_name')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('user_name');
            });
        }

        if (Schema::hasColumn('live_streams', 'password')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('password');
            });
        }

        if (Schema::hasColumn('live_streams', 'stream_name')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('stream_name');
            });
        }

        if (Schema::hasColumn('live_streams', 'wms_prefix')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('wms_prefix');
            });
        }

        if (Schema::hasColumn('live_streams', 'recording_status')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('recording_status');
            });
        }

        if (Schema::hasColumn('live_streams', 'enable_transcoding')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('enable_transcoding');
            });
        }

        if (Schema::hasColumn('live_streams', 'mpd_link')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('mpd_link');
            });
        }

        if (Schema::hasColumn('live_streams', 'port')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('port');
            });
        }

        if (Schema::hasColumn('live_streams', 'hls_link')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('hls_link');
            });
        }

        if (Schema::hasColumn('live_streams', 'enabled_status')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('enabled_status');
            });
        }


        $this->table('live_streams', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('dvr_server_id')->nullable()->after('title');
            $table->string('dvr_server_ip')->nullable()->after('dvr_server_id');
            $table->string('dvr_id')->nullable()->after('dvr_server_ip');
            $table->text('dvr_options')->nullable()->after('dvr_id');
            $table->text('nimble_secret')->nullable()->after('dvr_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasColumn('live_streams', 'title')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('title');
            });
        }

        if (Schema::hasColumn('live_streams', 'dvr_server_id')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('dvr_server_id');
            });
        }

        if (Schema::hasColumn('live_streams', 'dvr_server_ip')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('dvr_server_ip');
            });
        }

        if (Schema::hasColumn('live_streams', 'dvr_id')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('dvr_id');
            });
        }

        if (Schema::hasColumn('live_streams', 'dvr_options')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('dvr_options');
            });
        }

        if (Schema::hasColumn('live_streams', 'nimble_secret')) {
            Schema::table('live_streams', function (Blueprint $table)
            {
                $table->dropColumn('nimble_secret');
            });
        }

        $this->table('live_streams', function (Blueprint $table) {
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('stream_name')->nullable();
            $table->string('wms_prefix')->nullable();
            $table->boolean('recording_status')->default(false);
            $table->boolean('enable_transcoding')->default(false);
            $table->boolean('enabled_status')->default(false);
            $table->string('hls_link')->nullable();
            $table->string('mpd_link')->nullable();
            $table->string('port')->nullable();
        });
    }
}
