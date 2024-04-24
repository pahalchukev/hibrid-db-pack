<?php

use HibridVod\Database\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class AddRecordedAtToVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('videos', function (Blueprint $table) {
            $table->timestamp('recorded_at')
                ->after('synced_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('videos', function (Blueprint $table) {
            $table->dropColumn('recorded_at');
        });
    }
}
