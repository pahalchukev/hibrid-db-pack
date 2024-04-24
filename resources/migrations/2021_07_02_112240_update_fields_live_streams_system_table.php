<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateFieldsLiveStreamsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('live_streams', function (Blueprint $table) {
//            $table->string('user_name')->nullable()->change();
//            $table->string('wms_prefix')->nullable()->change();
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
//            $table->string('user_name')->nullable(false)->change();
//            $table->string('wms_prefix')->nullable(false)->change();
        });
    }
}
